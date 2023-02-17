<?php
/**
 * This file is used to create the meta boxes for the plugin.
 *
 * @package MovieLib\admin\classes
 */

namespace MovieLib\admin\classes;

use WP_Post;
use WP_Query;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\Movie_Library_Meta_Boxes' ) ) {

	/**
	 * @class Movie_Library_Meta_Boxes
	 *        This class is used to create the meta boxes for the plugin.
	 */
	class Movie_Library_Meta_Boxes {

		/**
		 * @function add_meta_boxes
		 *           This function is used to add the meta boxes for the plugin.
		 * @return void
		 */
		public function add_meta_boxes(): void {

			$meta_boxes_args = $this->get_meta_boxes_args();
			foreach ( $meta_boxes_args as $meta_box_id => $meta_box_args ) {
				add_meta_box(
					$meta_box_id,
					$meta_box_args[ 'title' ],
					$meta_box_args[ 'callback' ],
					$meta_box_args[ 'screen' ],
					$meta_box_args[ 'context' ],
					$meta_box_args[ 'priority' ]
				);
			}
		}

		/**
		 * @function get_meta_boxes_args
		 *           This function is used to get the meta boxes arguments.
		 * @return array The meta boxes arguments.
		 */
		private function get_meta_boxes_args(): array {
			return array(
				'rt-movie-meta-basic'   => array(
					'title'    => __( 'Basic', 'movie-library' ),
					'callback' => array( $this, 'rt_movie_meta_basic' ),
					'screen'   => [ 'rt-movie' ],
					'context'  => 'side',
					'priority' => 'high',
				),
				'rt-movie-meta-crew'    => array(
					'title'    => __( 'Crew', 'movie-library' ),
					'callback' => array( $this, 'rt_movie_meta_crew' ),
					'screen'   => [ 'rt-movie' ],
					'context'  => 'side',
					'priority' => 'high',
				),
				'rt-person-meta-basic'  => array(
					'title'    => __( 'Basic', 'movie-library' ),
					'callback' => array( $this, 'rt_person_meta_basic' ),
					'screen'   => [ 'rt-person' ],
					'context'  => 'side',
					'priority' => 'high',
				),
				'rt-person-meta-social' => array(
					'title'    => __( 'Basic', 'movie-library' ),
					'callback' => array( $this, 'rt_person_meta_social' ),
					'screen'   => [ 'rt-person' ],
					'context'  => 'side',
					'priority' => 'high',
				),
			);
		}

		/**
		 * @function rt_movie_meta_basic
		 *           This function is used to create the meta box for the person social details.
		 *
		 * @param WP_Post $post The post object.
		 *
		 * @return void
		 */
		public function rt_person_meta_social( WP_Post $post ): void {
			$rt_person_meta_social_data = get_post_meta( $post->ID );

			$rt_person_meta_social_key = array(
				'twitter'   => 'rt-person-meta-social-twitter',
				'facebook'  => 'rt-person-meta-social-facebook',
				'instagram' => 'rt-person-meta-social-instagram',
				'website'   => 'rt-person-meta-social-web',
			);
			wp_nonce_field( 'rt_person_meta_nonce', 'rt_person_meta_nonce' );
			?>

			<div class="rt-person-meta-fields rt-person-meta-social-fields">
				<div class="rt-person-meta-container rt-person-meta-social-container rt-person-meta-social-twitter-container">
					<label class="rt-person-meta-label rt-person-meta-social-label rt-person-meta-social-twitter-label" for="<?php echo esc_attr( $rt_person_meta_social_key[ 'twitter' ] ); ?>">
						<?php esc_html_e( 'Twitter', 'movie-library' ); ?>
					</label>
					<input type="text"
							value="<?php echo esc_url( $rt_person_meta_social_data[ $rt_person_meta_social_key[ 'twitter' ] ][ 0 ] ) ?>"
							class="rt-person-meta-field rt-person-meta-social-field rt-person-meta-social-twitter-field"
							name="<?php echo esc_attr( $rt_person_meta_social_key[ 'twitter' ] ); ?>"
							id="<?php echo esc_attr( $rt_person_meta_social_key[ 'twitter' ] ); ?>"
					/>
				</div>
				<div class="rt-person-meta-container rt-person-meta-social-container rt-person-meta-social-facebook-container">
					<label class="rt-person-meta-label rt-person-meta-social-label rt-person-meta-social-facebook-label" for="<?php echo esc_attr( $rt_person_meta_social_key[ 'facebook' ] ); ?>">
						<?php esc_html_e( 'Facebook', 'movie-library' ); ?>
					</label>
					<input type="text"
							value="<?php echo esc_url( $rt_person_meta_social_data[ $rt_person_meta_social_key[ 'facebook' ] ][ 0 ] ) ?>"
							class="rt-person-meta-field rt-person-meta-social-field rt-person-meta-social-facebook-field"
							name="<?php echo esc_attr( $rt_person_meta_social_key[ 'facebook' ] ); ?>"
							id="<?php echo esc_attr( $rt_person_meta_social_key[ 'facebook' ] ); ?>"
					/>
				</div>
				<div class="rt-person-meta-container rt-person-meta-social-container rt-person-meta-social-instagram-container">
					<label class="rt-person-meta-label rt-person-meta-social-label rt-person-meta-social-instagram-label" for="<?php echo esc_attr( $rt_person_meta_social_key[ 'instagram' ] ); ?>">
						<?php esc_html_e( 'Instagram', 'movie-library' ); ?>
					</label>
					<input type="text"
							value="<?php echo esc_url( $rt_person_meta_social_data[ $rt_person_meta_social_key[ 'instagram' ] ][ 0 ] ) ?>"
							class="rt-person-meta-field rt-person-meta-social-field rt-person-meta-social-instagram-field"
							name="<?php echo esc_attr( $rt_person_meta_social_key[ 'instagram' ] ); ?>"
							id="<?php echo esc_attr( $rt_person_meta_social_key[ 'instagram' ] ); ?>"
					/>
				</div>
				<div class="rt-person-meta-container rt-person-meta-social-container rt-person-meta-social-website-container">
					<label class="rt-person-meta-label rt-person-meta-social-label rt-person-meta-social-website-label" for="<?php echo esc_attr( $rt_person_meta_social_key[ 'Website' ] ); ?>">
						<?php esc_html_e( 'Website', 'movie-library' ); ?>
					</label>
					<input type="text"
							value="<?php echo esc_url( $rt_person_meta_social_data[ $rt_person_meta_social_key[ 'website' ] ][ 0 ] ) ?>"
							class="rt-person-meta-field rt-person-meta-social-field rt-person-meta-social-website-field"
							name="<?php echo esc_attr( $rt_person_meta_social_key[ 'website' ] ); ?>"
							id="<?php echo esc_attr( $rt_person_meta_social_key[ 'website' ] ); ?>"/>
				</div>
			</div>
			<?php
		}

		/**
		 * @function rt_movie_meta_crew
		 *           This function is used to display the meta box for the person basic details.
		 *
		 * @param WP_Post $post The post object.
		 *
		 * @return void
		 */
		public function rt_person_meta_basic( WP_Post $post ): void {
			$rt_person_meta_basic_data = get_post_meta( $post->ID );

			$rt_person_meta_basic_key = array(
				'birth-date'  => 'rt-person-meta-basic-birth-date',
				'birth-place' => 'rt-person-meta-basic-birth-place',
			);
			wp_nonce_field( 'rt_person_meta_nonce', 'rt_person_meta_nonce' );
			?>

			<div class="rt-person-meta-fields rt-person-meta-basic-fields">
				<div class="rt-person-meta-container rt-person-meta-basic-container rt-person-meta-basic-birth-date-container">
					<label class="rt-person-meta-label rt-person-meta-basic-label rt-person-meta-basic-birth-date-label" for="<?php echo esc_attr( $rt_person_meta_basic_key[ 'birth-date' ] ); ?>">
						<?php esc_html_e( 'Birth Date', 'movie-library' ); ?>
					</label>
					<input type="date"
							value="<?php echo esc_attr( $rt_person_meta_basic_data[ $rt_person_meta_basic_key[ 'birth-date' ] ][ 0 ] ) ?>"
							class="rt-person-meta-field rt-person-meta-basic-field rt-person-meta-basic-birth-date-field"
							name="<?php echo esc_attr( $rt_person_meta_basic_key[ 'birth-date' ] ); ?>"
							id="<?php echo esc_attr( $rt_person_meta_basic_key[ 'birth-date' ] ); ?>"/>
				</div>
				<div class="rt-person-meta-container rt-person-meta-basic-container rt-person-meta-basic-birth-place-container">
					<label class="rt-person-meta-label rt-person-meta-basic-label rt-person-meta-basic-birth-place-label" for="<?php echo esc_attr( $rt_person_meta_basic_key[ 'birth-place' ] ); ?>">
						<?php esc_html_e( 'Birth Place', 'movie-library' ); ?>
					</label>
					<input type="text"
							value="<?php echo esc_attr( $rt_person_meta_basic_data[ $rt_person_meta_basic_key[ 'birth-place' ] ][ 0 ] ) ?>"
							class="rt-person-meta-field rt-person-meta-basic-field rt-person-meta-basic-birth-place-field"
							name="<?php echo esc_attr( $rt_person_meta_basic_key[ 'birth-place' ] ); ?>"
							id="<?php echo esc_attr( $rt_person_meta_basic_key[ 'birth-place' ] ); ?>"/>
				</div>


			</div>

			<?php
		}

		/**
		 * @function rt_movie_meta_basic
		 *           This function is used to display the meta box for the movie details.
		 *
		 * @param WP_Post $post The post object.
		 *
		 * @return void
		 */
		public function rt_movie_meta_basic( WP_Post $post ): void {
			$rt_movie_meta_basic_data = get_post_meta( $post->ID );

			$rt_movie_meta_basic_key = array(
				'rating'       => 'rt-movie-meta-basic-rating',
				'runtime'      => 'rt-movie-meta-basic-runtime',
				'release-date' => 'rt-movie-meta-basic-release-date',
			);
			wp_nonce_field( 'rt_movie_meta_nonce', 'rt_movie_meta_nonce' );
			?>

			<div class="rt-movie-meta-fields rt-movie-meta-basic-fields">
				<div class="rt-movie-meta-container rt-movie-meta-basic-container rt-movie-meta-basic-rating-container">
					<label class="rt-movie-meta-label rt-movie-meta-basic-label rt-movie-meta-basic-rating-label" for="<?php echo esc_attr( $rt_movie_meta_basic_key[ 'rating' ] ); ?>">
						<?php esc_html_e( 'Rating (Between 1-5)', 'movie-library' ); ?>
					</label>
					<input type="number"
							value="<?php echo esc_attr( $rt_movie_meta_basic_data[ $rt_movie_meta_basic_key[ 'rating' ] ][ 0 ] ) ?>"
							class="rt-movie-meta-field rt-movie-meta-basic-field rt-movie-meta-basic-rating-field"
							name="<?php echo esc_attr( $rt_movie_meta_basic_key[ 'rating' ] ); ?>"
							id="<?php echo esc_attr( $rt_movie_meta_basic_key[ 'rating' ] ); ?>"
							max="5"
							min="1"/>
				</div>
				<div class="rt-movie-meta-container rt-movie-meta-basic-container rt-movie-meta-basic-runtime-container">
					<label class="rt-movie-meta-label rt-movie-meta-basic-label rt-movie-meta-basic-runtime-label" for="<?php echo esc_attr( $rt_movie_meta_basic_key[ 'runtime' ] ); ?>">
						<?php esc_html_e( 'Runtime (Minutes)', 'movie-library' ); ?>
					</label>
					<input type="number"
							value="<?php echo esc_attr( $rt_movie_meta_basic_data[ $rt_movie_meta_basic_key[ 'runtime' ] ][ 0 ] ) ?>"
							class="rt-movie-meta-field rt-movie-meta-basic-field rt-movie-meta-basic-runtime-field"
							name="<?php echo esc_attr( $rt_movie_meta_basic_key[ 'runtime' ] ); ?>"
							id="<?php echo esc_attr( $rt_movie_meta_basic_key[ 'runtime' ] ); ?>"
							min="1"
							max="1000"/>

				</div>
				<div class="rt-movie-meta-container rt-movie-meta-basic-container rt-movie-meta-basic-release-date-container">
					<label class="rt-movie-meta-label rt-movie-meta-basic-label rt-movie-meta-basic-release-date-label" for="<?php echo esc_attr( $rt_movie_meta_basic_key[ 'release-date' ] ); ?>">
						<?php esc_html_e( 'Release Date', 'movie-library' ); ?>
					</label>
					<input type="date"
							value="<?php echo esc_attr( $rt_movie_meta_basic_data[ $rt_movie_meta_basic_key[ 'release-date' ] ][ 0 ] ) ?>"
							class="rt-movie-meta-field rt-movie-meta-basic-field rt-movie-meta-basic-release-date-field"
							name="<?php echo esc_attr( $rt_movie_meta_basic_key[ 'release-date' ] ); ?>"
							id="<?php echo esc_attr( $rt_movie_meta_basic_key[ 'release-date' ] ); ?>"/>
				</div>

			</div>

			<?php
		}

		/**
		 * @function rt_movie_meta_crew
		 *           This function is used to display the meta box for the movie crew.
		 *
		 * @param WP_Post $post The post object.
		 *
		 * @return void
		 */
		public function rt_movie_meta_crew( WP_Post $post ): void {
			$rt_career_terms = get_terms(
				[
					'taxonomy'   => 'rt-person-career',
					'hide_empty' => false,
				]
			);

			$rt_people_data          = array();
			$rt_movie_meta_crew_data = array();
			foreach ( $rt_career_terms as $rt_career_term ) {
				$key                                     = 'rt-movie-meta-crew-' . $rt_career_term->slug;
				$crew_data                               = get_post_meta( $post->ID, $key );
				$rt_movie_meta_crew_data[ $key ]         = $crew_data;
				$rt_person_data                          = $this->get_person_data( $rt_career_term );
				$rt_people_data[ $rt_career_term->name ] = $rt_person_data;
			}
			wp_nonce_field( 'rt_movie_meta_nonce', 'rt_movie_meta_nonce' );

			?>

			<div class="rt-movie-meta-fields rt-movie-meta-crew-fields">
				<?php
				foreach ( $rt_people_data as $key => $data ) {
					if ( empty( $data ) ) {
						continue;
					}
					?>
					<div class="rt-movie-meta-container rt-movie-meta-crew-container <?php echo esc_attr( strtolower( 'rt-movie-meta-crew-' . $key . '-container' ) ) ?>">
						<label class="rt-movie-meta-label rt-movie-meta-crew-label <?php echo esc_attr( strtolower( 'rt-movie-meta-crew-' . $key . '-label' ) ) ?>" for="<?php echo esc_attr( strtolower( str_replace( '-', '_', 'rt-movie-meta-crew-' . $key ) ) ) ?>">
							<?php esc_html_e( $key, 'movie-library' ); ?>
						</label>
						<select class="rt-movie-meta-field rt-movie-meta-crew-field <?php echo esc_attr( strtolower( 'rt-movie-meta-crew-' . $key . '-field' ) ) ?>"
								name="<?php echo esc_attr( strtolower( 'rt-movie-meta-crew-' . $key ) . '[]' ); ?>"
								id="<?php echo esc_attr( strtolower( str_replace( '-', '_', 'rt-movie-meta-crew-' . $key ) ) ) ?>" multiple="multiple">

							<option value="" disabled> <?php echo esc_html__( "Select" ) . esc_html( $key ); ?></option>
							<?php

							foreach ( $data as $rt_p ) {
								if ( empty( $rt_movie_meta_crew_data[ strtolower( 'rt-movie-meta-crew-' . $key ) ] ) ) {
									printf(
										'<option value="%1$d">%2$s</option>',
										esc_attr( $rt_p[ 'id' ] ),
										esc_html( $rt_p[ 'name' ] )
									);
								} else {
									$selected = in_array( $rt_p[ 'id' ], $rt_movie_meta_crew_data[ strtolower( 'rt-movie-meta-crew-' . $key ) ][ 0 ] ) ? 'selected' : '';
									printf(
										'<option value="%1$d" "%2$s">%3$s</option>',
										esc_attr( $rt_p[ 'id' ] ),
										$selected,
										esc_html( $rt_p[ 'name' ] ),

									);
								}
							} ?>
						</select>
					</div>
					<?php
				}
				?>
			</div>

			<?php
		}

		/**
		 * @function get_person_data
		 *           This function is used to get the person data.
		 *
		 * @param object $rt_career_term The career term object.
		 *
		 * @return array
		 */
		private function get_person_data( $rt_career_term ): array {
			$rt_person_data  = array();
			$rt_person_query = new WP_Query(
				[
					'post_type' => 'rt-person',
					'per_page'  => 10,
					'tax_query' => array(
						array(
							'taxonomy' => 'rt-person-career',
							'field'    => 'term_id',
							'terms'    => $rt_career_term->term_id,
						),
					),
				]
			);

			if ( $rt_person_query->have_posts() ) {
				while ( $rt_person_query->have_posts() ) {
					$rt_person_query->the_post();
					$rt_person_data[] = array(
						'id'   => get_the_ID(),
						'name' => get_the_title(),
					);
				}
			}
			$rt_person_query->reset_postdata();

			return $rt_person_data;
		}
	}
}

