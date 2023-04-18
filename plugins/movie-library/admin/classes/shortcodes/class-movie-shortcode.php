<?php
/**
 * This file is used to create movie shortcode.
 *
 * @package MovieLib\admin\classes\shortcodes
 */

namespace MovieLib\admin\classes\shortcodes;

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\admin\classes\taxonomies\Movie_Genre;
use MovieLib\admin\classes\taxonomies\Movie_Label;
use MovieLib\admin\classes\taxonomies\Movie_Language;
use MovieLib\admin\classes\taxonomies\Movie_Person;
use MovieLib\includes\Singleton;
use WP_Query;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\shortcodes\Movie_Shortcode' ) ) {

	/**
	 * This class is used to create movie shortcode.
	 */
	class Movie_Shortcode {

		use Singleton;

		/**
		 * Movie_Shortcode init method.
		 *
		 * @return void
		 */
		protected function init(): void {

			add_action( 'init', array( $this, 'register' ) );

		}

		/**
		 * This function is used to register movie shortcode.
		 *
		 * @return void
		 */
		public function register(): void {

			add_shortcode( 'movie', array( $this, 'movie_library_movie_shortcode' ) );

		}

		/**
		 * This function is callback function for the movie shortcode.
		 * It will be executed when the movie shortcode is used.
		 * and it will replace the shortcode with the provided HTML.
		 *
		 * @param array  $attributes attributes from the shortcode.
		 * @param string $content content from the shortcode.
		 * @param string $tag shortcode name.
		 *
		 * @return string|false
		 */
		public function movie_library_movie_shortcode( $attributes = array(), $content = null, $tag = '' ) {

			$attributes = array_change_key_case( (array) $attributes );

			$attributes = shortcode_atts(
				array(
					'person'   => '',
					'genre'    => '',
					'label'    => '',
					'language' => '',
				),
				$attributes,
				$tag
			);

			$search_query = array();

			if ( ! empty( $attributes['person'] ) ) {

				$name = sanitize_text_field( $attributes['person'] );

				$person = new Wp_Query(
					array(
						'post_type' => RT_Person::SLUG,
						'title'     => $name,
						'fields'    => 'ids',
					)
				);

				if ( ! $person->have_posts() ) {

					$person = new Wp_Query(
						array(
							'post_type' => RT_Person::SLUG,
							'name'      => $name,
							'fields'    => 'ids',
						)
					);

					if ( ! $person->have_posts() ) {

						return $this->show_no_movies_found_message();

					}
				}

				$search_query[] = array(
					'taxonomy' => Movie_Person::SLUG,
					'field'    => 'slug',
					'terms'    => $person->get_posts(),
				);

				wp_reset_postdata();

			}

			if ( ! empty( $attributes['genre'] ) ) {

				$terms          = sanitize_text_field( $attributes['genre'] );
				$search_query[] = $this->get_search_query( $terms, Movie_Genre::SLUG );

			}

			if ( ! empty( $attributes['label'] ) ) {

				$terms          = sanitize_text_field( $attributes['label'] );
				$search_query[] = $this->get_search_query( $terms, Movie_Label::SLUG );

			}

			if ( ! empty( $attributes['language'] ) ) {

				$terms          = sanitize_text_field( $attributes['language'] );
				$search_query[] = $this->get_search_query( $terms, Movie_Language::SLUG );

			}

			if ( ! empty( $search_query ) ) {

				if ( count( $search_query ) > 1 ) {

					$search_query['relation'] = 'AND';

				}

				$query = new WP_Query(
					array(
						'post_type' => RT_Movie::SLUG,
						'tax_query' => $search_query, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					)
				);

			} else {

				$query = new WP_Query(
					array(
						'post_type' => RT_Movie::SLUG,
					)
				);

			}

			$movie_details = array();

			if ( $query->have_posts() ) {

				while ( $query->have_posts() ) {

					$movie_detail = array();

					$query->the_post();

					$movie_id              = get_the_ID();
					$movie_title           = get_the_title();
					$movie_detail['Title'] = $movie_title;

					if ( has_post_thumbnail( $movie_id ) ) {

						$movie_poster           =
							wp_get_attachment_image_src( get_post_thumbnail_id( $movie_id ), 'full' );
						$movie_poster           = $movie_poster[0];
						$movie_detail['Poster'] = $movie_poster;

					} else {

						$movie_detail['Poster'] =
							'https://via.placeholder.com/600';

					}

					$movie_runtime_meta = get_movie_meta( $movie_id, 'rt-movie-meta-basic-runtime', true );

					if ( ! empty( $movie_runtime_meta ) ) {

						$movie_detail['Runtime'] = $movie_runtime_meta;

					}

					$movie_crew_director = get_movie_meta( $movie_id, 'rt-movie-meta-crew-director' );

					if ( ! empty( $movie_crew_director ) && ! empty( $movie_crew_director[0] ) ) {

						if ( is_array( $movie_crew_director[0] ) ) {

							$directors = array();

							foreach ( $movie_crew_director[0] as $value ) {

								$directors[] = get_the_title( $value['person_id'] );

							}

							$movie_detail['Director'] = implode( ', ', $directors );

						} else {

							$movie_detail['Director'] = get_the_title( $movie_crew_director[0]['person_id'] );

						}
					}

					$movie_crew_actor = get_movie_meta( $movie_id, 'rt-movie-meta-crew-actor' );

					if ( ! empty( $movie_crew_actor ) && ! empty( $movie_crew_actor[0] ) ) {

						if ( is_array( $movie_crew_actor[0] ) ) {

							$actors = array();

							if ( count( $movie_crew_actor[0] ) > 2 ) {

								$movie_crew_actor[0] = array_slice( $movie_crew_actor[0], 0, 2 );

							}

							foreach ( $movie_crew_actor[0] as $value ) {

								$actors[] = get_the_title( $value['person_id'] );

							}

							$movie_detail['Actor'] = implode( ', ', $actors );

						} else {

							$movie_detail['Actor'] = get_the_title( $movie_crew_actor[0]['person_id'] );

						}
					}

					$movie_details[] = $movie_detail;
				}
			} else {

				return $this->show_no_movies_found_message();

			}

			wp_reset_postdata();
			ob_start();

			?>

			<div class="movie-list-container">

				<?php $this->display_movies( $movie_details ); ?>

			</div>

			<?php

			return ob_get_clean();

		}

		/**
		 * This function is used to provide the HTML for the movie list.
		 *
		 * @param array $movie_details Movie details.
		 */
		private function display_movies( array $movie_details ): void {
			foreach ( $movie_details as $movie_detail ) {
				?>

				<div class="movie-list-item">

					<div class="movie-list-item-image">

						<img class="movie-image"
							src="<?php echo esc_url( $movie_detail['Poster'] ); ?>"
							alt="<?php echo esc_attr( $movie_details['Title'] ); ?>">

					</div>

					<div class="movie-list-item-details">

						<div class="movie-list-item-title">

							<?php

							// translators: %1$s is the movie title.
							printf( esc_html__( 'Title: %1$s', 'movie-library' ), esc_html( $movie_detail['Title'] ) );

							?>

						</div>

						<?php if ( isset( $movie_detail['Director'] ) ) : ?>

							<div class="movie-list-item-director">

								<?php

								// translators: %1$s is the movie director.
								printf( esc_html__( 'Director: %1$s', 'movie-library' ), esc_html( $movie_detail['Director'] ) );

								?>

							</div>

						<?php endif; ?>

						<?php if ( isset( $movie_detail['Actor'] ) ) : ?>

							<div class="movie-list-item-actor">

								<?php

								// translators: %1$s is the movie actor.
								printf( esc_html__( 'Actor: %1$s', 'movie-library' ), esc_html( $movie_detail['Actor'] ) );

								?>

							</div>

						<?php endif; ?>

						<?php if ( isset( $movie_detail['Runtime'] ) ) : ?>

							<div class="movie-list-item-runtime">

								<?php

								// translators: %1$s is the movie runtime.
								printf( esc_html__( 'Runtime: %1$s Minutes', 'movie-library' ), esc_html( $movie_detail['Runtime'] ) );

								?>

							</div>

						<?php endif; ?>

					</div>

				</div>

				<?php

			}

		}

		/**
		 * This function will display the message when no movies are found.
		 *
		 * @return string|false
		 */
		private function show_no_movies_found_message() {

			ob_start();

			?>

			<p>

				<?php esc_html_e( 'No movies found.', 'movie-library' ); ?>

			</p>

			<?php

			return ob_get_clean();

		}

		/**
		 * This function is used to return the search query for the taxonomy.
		 *
		 * @param array|string $terms    Terms.
		 * @param string       $taxonomy Taxonomy.
		 * @return array
		 */
		private function get_search_query( $terms, $taxonomy ): array {

			return array(
				'relation' => 'OR',
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'terms'    => $terms,
				),
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $terms,
				),
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'name',
					'terms'    => $terms,
				),
			);

		}
	}
}
