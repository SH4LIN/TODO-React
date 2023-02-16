<?php
/**
 * This file is used to create the meta boxes for the plugin.
 *
 * @package MovieLib\admin\classes
 */

namespace MovieLib\admin\classes;

use WP_Query;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\Movie_Library_Meta_Boxes' ) ) {

	/**
	 * @class Movie_Library_Meta_Boxes
	 * This class is used to create the meta boxes for the plugin.
	 */
	class Movie_Library_Meta_Boxes {

		/**
		 * This function is used to add the meta boxes for the plugin.
		 */
		public function add_meta_boxes(): void {
			$screens = array( 'rt-movie' );
			foreach ( $screens as $screen ) {
				$meta_boxes_args = $this->get_meta_boxes_args( $screen );
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
		}

		private function get_meta_boxes_args( $screen ): array {
			return array(
				'rt-movie-meta-basic' => array(
					'title'    => __( 'Basic', 'movie-library' ),
					'callback' => array( $this, 'rt_movie_meta_basic' ),
					'screen'   => $screen,
					'context'  => 'side',
					'priority' => 'high',
				),
				'rt-movie-meta-crew'  => array(
					'title'    => __( 'Crew', 'movie-library' ),
					'callback' => array( $this, 'rt_movie_meta_crew' ),
					'screen'   => $screen,
					'context'  => 'side',
					'priority' => 'high',
				),
			);
		}

		/**
		 * This function is used to display the meta box for the movie details.
		 *
		 * @param object $post The post object.
		 */
		public function rt_movie_meta_basic( $post ): void {
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
						<?php esc_html_e( 'Rating', 'movie-library' ); ?>
					</label>
					<input type="number"
							value="<?php echo esc_attr( $rt_movie_meta_basic_data[ $rt_movie_meta_basic_key[ 'rating' ] ][ 0 ] ) ?>"
							class="rt-movie-meta-basic-field rt-movie-meta-basic-rating-field"
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
							class="rt-movie-meta-basic-field rt-movie-meta-basic-runtime-field"
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
							class="rt-movie-meta-basic-field rt-movie-meta-basic-release-date-field"
							name="<?php echo esc_attr( $rt_movie_meta_basic_key[ 'release-date' ] ); ?>"
							id="<?php echo esc_attr( $rt_movie_meta_basic_key[ 'release-date' ] ); ?>"/>
				</div>

			</div>

			<?php
		}

		private function get_person_data( $rt_career_term ): array {
			$rt_person_data  = array();
			$rt_person_query = new WP_Query(
				[
					'post_type' => 'rt-person',
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

		public function rt_movie_meta_crew( $post ): void {
			$rt_career_terms = get_terms(
				[
					'taxonomy'   => 'rt-person-career',
					'hide_empty' => false,
				]
			);

			$rt_people_data = array();
			foreach ( $rt_career_terms as $rt_career_term ) {
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
						<select class="rt-movie-meta-crew-field <?php echo esc_attr( strtolower( 'rt-movie-meta-crew-' . $key . '-field' ) ) ?>"
								name="<?php echo esc_attr( strtolower( 'rt-movie-meta-crew-' . $key ) ); ?>"
								id="<?php echo esc_attr( strtolower( str_replace( '-', '_', 'rt-movie-meta-crew-' . $key ) ) ) ?>">
							<?php
							foreach ( $data as $rt_p ) { ?>
								<option value="<?php echo esc_attr( $rt_p[ 'id' ] . '-' . $rt_p[ 'name' ] ); ?>">
									<?php echo esc_html( $rt_p[ 'name' ] ); ?>
								</option>
								<?php
							} ?>
						</select>
					</div>
					<?php
				}
				?>
			</div>

			<?php
		}
	}
}
