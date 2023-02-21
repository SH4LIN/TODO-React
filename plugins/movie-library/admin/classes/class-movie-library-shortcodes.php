<?php
/**
 * This file is used to register shortcodes for the plugin.
 *
 * @package MovieLib\admin\classes
 */

namespace MovieLib\admin\classes;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

use WP_Query;

if ( ! class_exists( 'MovieLib\admin\classes\Movie_Library_Shortcodes' ) ) {
	/**
	 * @class   Movie_Library_Shortcodes
	 *          This class is used to register shortcodes for the plugin.
	 * @version 1.0.0
	 */
	class Movie_Library_Shortcodes {

		public function register_shortcodes(): void {
			$shortcodes = $this->get_shortcodes();
			foreach ( $shortcodes as $shortcode => $data ) {
				if ( ! shortcode_exists( $shortcode ) ) {
					add_shortcode( $shortcode, $data[ 'callback' ] );
				}
			}
		}

		private function get_shortcodes(): array {
			return array(
				'movie' => array(
					'callback' => array( $this, 'movie_library_movie_shortcode' ),
				),
				'person' => array(
					'callback' => array( $this, 'movie_library_person_shortcode' ),
				),
			);
		}

		public function movie_library_movie_shortcode( $attributes = array(), $content = null, $tag = '' ) {
			$attributes = array_change_key_case( (array)$attributes );
			$attributes = shortcode_atts(
				array(
					'person' => '',
					'genre' => '',
					'label' => '',
					'language' => '',
				), $attributes, $tag
			);

			$search_query = array();
			if ( ! empty( $attributes[ 'person' ] ) ) {
				$name   = sanitize_text_field( $attributes[ 'person' ] );
				$person = new Wp_Query(
					array(
						'post_type' => 'rt-person',
						'title' => $name,
						'fields' => 'ids',
					)
				);
				if ( ! $person->have_posts() ) {
					$person = new Wp_Query(
						array(
							'post_type' => 'rt-person',
							'name' => $name,
							'fields' => 'ids',
						)
					);
					if( ! $person->have_posts() ){
						return $this->show_no_movies_found_message();
					}
				}

				$search_query[] = array(
					'taxonomy' => '_rt-movie-person',
					'field' => 'slug',
					'terms' => $person->get_posts(),
				);
				$person->reset_postdata();
			}

			if ( ! empty( $attributes[ 'genre' ] ) ) {
				$terms   = sanitize_text_field( $attributes[ 'genre' ] );
				$term_id = term_exists( $terms, 'rt-movie-genre' );
				if ( $term_id ) {
					$search_query[] =
						array(
							'taxonomy' => 'rt-movie-genre',
							'field' => 'term_id',
							'terms' => $term_id[ 'term_id' ],
						);
				}else{
					return $this->show_no_movies_found_message();
				}
			}

			if ( ! empty( $attributes[ 'label' ] ) ) {
				$terms          = sanitize_text_field( $attributes[ 'label' ] );
				$term_id = term_exists( $terms, 'rt-movie-label' );
				if ( $term_id ) {
					$search_query[] =
						array(
							'taxonomy' => 'rt-movie-label',
							'field' => 'term_id',
							'terms' => $term_id[ 'term_id' ],
						);
				}else{
					return $this->show_no_movies_found_message();
				}
			}

			if ( ! empty( $attributes[ 'language' ] ) ) {
				$terms          = sanitize_text_field( $attributes[ 'language' ] );
				$term_id = term_exists( $terms, 'rt-movie-language' );
				if ( $term_id ) {
					$search_query[] =
						array(
							'taxonomy' => 'rt-movie-language',
							'field' => 'term_id',
							'terms' => $term_id[ 'term_id' ],
						);
				}else{
					return $this->show_no_movies_found_message();
				}
			}

			if ( ! empty( $search_query ) ) {
				if ( count( $search_query ) > 1 ) {
					$search_query[ 'relation' ] = 'AND';
				}
				$query = new WP_Query(
					array(
						'post_type' => 'rt-movie',
						'tax_query' => $search_query,
					)
				);
			} else {
				$query = new WP_Query(
					array(
						'post_type' => 'rt-movie',
					)
				);
			}

			$movie_details = array();
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$movie_detail = [];
					$query->the_post();
					$movie_id                = get_the_ID();
					$movie_title             = get_the_title();
					$movie_detail[ 'Title' ] = $movie_title;
					if ( has_post_thumbnail( $movie_id ) ) {
						$movie_poster             = wp_get_attachment_image_src( get_post_thumbnail_id( $movie_id ), 'full' );
						$movie_poster             = $movie_poster[ 0 ];
						$movie_detail[ 'Poster' ] = $movie_poster;
					} else {
						$movie_detail[ 'Poster' ] = 'https://movie-library-assignment.lndo.site/wp-content/uploads/2023/02/dummy-image.jpg';
					}
					$movie_runtime_meta = get_post_meta( $movie_id, 'rt-movie-meta-basic-runtime', true );
					if ( ! empty( $movie_runtime_meta ) ) {
						$movie_detail[ 'Runtime' ] = $movie_runtime_meta;
					}
					$movie_crew_director = get_post_meta( $movie_id, 'rt-movie-meta-crew-director' );
					if ( ! empty( $movie_crew_director ) && ! empty( $movie_crew_director[ 0 ] ) ) {
						if ( is_array( $movie_crew_director[ 0 ] ) ) {
							$directors = array();
							foreach ( $movie_crew_director[ 0 ] as $value ) {
								$directors[] = get_the_title( $value );
							}
							$movie_detail[ 'Director' ] = implode( ', ', $directors );
						} else {
							$movie_detail[ 'Director' ] = get_the_title( $movie_crew_director[ 0 ] );
						}
					}
					$movie_crew_actor = get_post_meta( $movie_id, 'rt-movie-meta-crew-actor' );
					if ( ! empty( $movie_crew_actor ) && ! empty( $movie_crew_actor[ 0 ] ) ) {
						if ( is_array( $movie_crew_actor[ 0 ] ) ) {
							$actors = array();
							if ( count( $movie_crew_actor[ 0 ] ) > 2 ) {
								$movie_crew_actor[ 0 ] = array_slice( $movie_crew_actor[ 0 ], 0, 2 );
							}
							foreach ( $movie_crew_actor[ 0 ] as $value ) {
								$actors[] = get_the_title( $value );
							}
							$movie_detail[ 'Actor' ] = implode( ', ', $actors );
						} else {
							$movie_detail[ 'Actor' ] = get_the_title( $movie_crew_actor[ 0 ] );
						}
					}
					$movie_details[] = $movie_detail;
				}
			} else {
				?>
				<p><?php esc_html_e( 'No movies found.', 'movie-library' ); ?></p>
				<?php
			}
			$query->reset_postdata();
			ob_start();
			?>
			<div class="movie-list-container">
			<?php
			foreach ( $movie_details as $movie_detail ) {
				?>

				<div class="movie-list-item">
					<div class="movie-list-item-image">
						<img class="movie-image" src="<?php echo esc_url( $movie_detail[ 'Poster' ] ); ?>" alt="<?php echo esc_attr( $movie_details[ 'Title' ] ); ?>">
					</div>
					<div class="movie-list-item-details">
						<div class="movie-list-item-title">
							<?php printf( esc_html__( 'Title: %1$s', 'movie-library' ), $movie_detail[ 'Title' ] ); ?>
						</div>
						<?php if ( isset( $movie_detail[ 'Director' ] ) ): ?>
							<div class="movie-list-item-director">
								<?php printf( esc_html__( 'Director: %1$s', 'movie-library' ), $movie_detail[ 'Director' ] ); ?>
							</div>
						<?php endif; ?>
						<?php if ( isset( $movie_detail[ 'Actor' ] ) ): ?>
							<div class="movie-list-item-actor">
								<?php printf( esc_html__( 'Actor: %1$s', 'movie-library' ), $movie_detail[ 'Actor' ] ); ?>
							</div>
						<?php endif; ?>
						<?php if ( isset( $movie_detail[ 'Runtime' ] ) ): ?>
							<div class="movie-list-item-runtime">
								<?php printf( esc_html__( 'Runtime: %1$s Minutes', 'movie-library' ), $movie_detail[ 'Runtime' ] ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>


				<?php
			}
			?></div><?php

			return ob_get_clean();
		}

		private function show_no_movies_found_message():string|false{
			ob_start();
			?>
			<p><?php esc_html_e( 'No movies found.', 'movie-library' ); ?></p>
			<?php
			return ob_get_clean();
		}

		private function show_no_people_found_message():string|false{
			ob_start();
			?>
			<p><?php esc_html_e( 'No people found.', 'movie-library' ); ?></p>
			<?php
			return ob_get_clean();
		}

		public function movie_library_person_shortcode( $attributes = array(), $content = null, $tag = '' ):string|false {
			$attributes = array_change_key_case( (array)$attributes );
			$attributes = shortcode_atts(
				array(
					'career' => '',
				), $attributes, $tag
			);

			if ( ! empty( $attributes[ 'career' ] ) ) {
				$terms          = sanitize_text_field( $attributes[ 'career' ] );
				$term_id = term_exists( $terms, 'rt-person-career' );
				if ( $term_id ) {
					$search_query[] =
						array(
							'taxonomy' => 'rt-person-career',
							'field' => 'term_id',
							'terms' => $term_id[ 'term_id' ],
						);
				}else{
					return $this->show_no_people_found_message();
				}
			}

			if ( ! empty( $search_query ) ) {
				$search_query[ 'relation' ] = 'AND';
				$query                      = new WP_Query(
					array(
						'post_type' => 'rt-person',
						'tax_query' => $search_query,
					)
				);
			} else {
				$query = new WP_Query(
					array(
						'post_type' => 'rt-person',
					)
				);
			}

			$people_details = array();
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$person_details = array();
					$query->the_post();
					$person_id                = get_the_ID();
					$person_name              = get_the_title();
					$person_details[ 'Name' ] = $person_name;
					if ( has_post_thumbnail( $person_id ) ) {
						$person_poster                       = wp_get_attachment_image_src( get_post_thumbnail_id( $person_id ), 'full' );
						$person_poster                       = $person_poster[ 0 ];
						$person_details[ 'Profile Picture' ] = $person_poster;
					} else {
						$person_details[ 'Profile Picture' ] = 'https://movie-library-assignment.lndo.site/wp-content/uploads/2023/02/dummy-image.jpg';
					}
					$person_career_details = get_the_terms( $person_id, 'rt-person-career' );
					if ( ! empty( $person_career_details ) ) {
						if ( is_array( $person_career_details ) ) {
							$careers = array();
							foreach ( $person_career_details as $value ) {
								$careers[] = $value->name;
							}
							$person_details[ 'Career' ] = implode( ', ', $careers );
						} else {
							$person_details[ 'Career' ] = $person_career_details->name;
						}
					}
					$people_details[] = $person_details;
				}
			} else {
				return $this->show_no_people_found_message();
			}
			$query->reset_postdata();
			ob_start();
			?>
			<div class="movie-list-container">
			<?php
			foreach ( $people_details as $person_detail ) {

				?>

				<div class="movie-list-item">
					<div class="movie-list-item-image">
						<img class="movie-image" src="<?php echo esc_url( $person_detail[ 'Profile Picture' ] ); ?>" alt="<?php echo esc_attr( $person_detail[ 'Name' ] ); ?>">
					</div>
					<div class="movie-list-item-details">
						<div class="movie-list-item-title">
							<?php printf( esc_html__( 'Name: %1$s', 'movie-library' ), $person_detail[ 'Name' ] ); ?>
						</div>
						<?php if ( isset( $movie_detail[ 'Director' ] ) ): ?>
							<div class="movie-list-item-director">
								<?php printf( esc_html__( 'Career: %1$s', 'movie-library' ), $movie_detail[ 'Career' ] ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>


				<?php
			}
			?></div><?php

			return ob_get_clean();
		}

	}
}
