<?php
/**
 * This file is used to create all the meta-boxes for rt-movie post type.
 *
 * @package MovieLib\admin\classes\meta_boxes
 */

namespace MovieLib\admin\classes\meta_boxes;

use WP_Post;
use WP_Query;
use const MovieLib\admin\classes\custom_post_types\RT_MOVIE_SLUG;
use const MovieLib\admin\classes\custom_post_types\RT_PERSON_SLUG;
use const MovieLib\admin\classes\taxonomies\RT_PERSON_CAREER_SLUG;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

const RT_MOVIE_META_BASIC_SLUG = 'rt-movie-meta-basic';
const RT_MOVIE_META_CREW_SLUG  = 'rt-movie-meta-crew';

if ( ! class_exists( 'MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box' ) ) {

	/**
	 * This class is used to create all the meta-boxes for rt-movie post type.
	 */
	class RT_Movie_Meta_Box {

		/**
		 * This function is used to create the meta-box for basic information and crew information.
		 *
		 * @return void
		 */
		public function create_meta_box():void {

			add_meta_box(
				RT_MOVIE_META_BASIC_SLUG,
				__( 'Basic', 'movie-library' ),
				array( $this, 'rt_movie_meta_basic' ),
				array( RT_MOVIE_SLUG ),
				'side',
				'high'
			);

				add_meta_box(
					RT_MOVIE_META_CREW_SLUG,
					__( 'Crew', 'movie-library' ),
					array( $this, 'rt_movie_meta_crew' ),
					array( RT_MOVIE_SLUG ),
					'side',
					'high'
				);
		}

		/**
		 * This function is used to display the meta box for the movie details.
		 *
		 * @param WP_Post $post The post object.
		 *
		 * @return void
		 */
		public function rt_movie_meta_basic( WP_Post $post ): void {

			// This will get the movie basic meta-data.
			$rt_movie_meta_basic_data = get_post_meta( $post->ID );

			// This will create the meta key for the movie basic meta-data.
			$rt_movie_meta_basic_key = array(
				'rating'       => 'rt-movie-meta-basic-rating',
				'runtime'      => 'rt-movie-meta-basic-runtime',
				'release-date' => 'rt-movie-meta-basic-release-date',
			);

			// This will add the nonce field for the movie basic meta-data.
			wp_nonce_field( 'rt_movie_meta_nonce', 'rt_movie_meta_nonce' );

			?>

			<div class = "rt-movie-meta-fields rt-movie-meta-basic-fields">

				<div class = "rt-movie-meta-container rt-movie-meta-basic-container rt-movie-meta-basic-rating-container">

					<label class = "rt-movie-meta-label rt-movie-meta-basic-label rt-movie-meta-basic-rating-label"
						for = "<?php echo esc_attr( $rt_movie_meta_basic_key['rating'] ); ?>">

						<?php esc_html_e( 'Rating (Between 0-10)', 'movie-library' ); ?>

					</label>

					<?php
					$rating = '';
					if ( isset( $rt_movie_meta_basic_data[ $rt_movie_meta_basic_key['rating'] ] ) ) {
						$rating = $rt_movie_meta_basic_data[ $rt_movie_meta_basic_key['rating'] ][0];
					}
					?>

					<input type = "number"
						value = "<?php echo esc_attr( $rating ); ?>"
						class = "rt-movie-meta-field rt-movie-meta-basic-field rt-movie-meta-basic-rating-field"
						name = "<?php echo esc_attr( $rt_movie_meta_basic_key['rating'] ); ?>"
						id = "<?php echo esc_attr( $rt_movie_meta_basic_key['rating'] ); ?>"
						max = "10"
						min = "0" />

					<span class = "rt-movie-meta-field-error rt-movie-meta-basic-field-error rt-movie-meta-basic-rating-field-error" id="rt-movie-meta-basic-rating-field-error"></span>

				</div>

				<div class = "rt-movie-meta-container rt-movie-meta-basic-container rt-movie-meta-basic-runtime-container">

					<label class = "rt-movie-meta-label rt-movie-meta-basic-label rt-movie-meta-basic-runtime-label"
						for    = "<?php echo esc_attr( $rt_movie_meta_basic_key['runtime'] ); ?>" >

						<?php esc_html_e( 'Runtime (Minutes)', 'movie-library' ); ?>

					</label>

					<?php
					$runtime = '';
					if ( isset( $rt_movie_meta_basic_data[ $rt_movie_meta_basic_key['runtime'] ] ) ) {
						$runtime = $rt_movie_meta_basic_data[ $rt_movie_meta_basic_key['runtime'] ][0];
					}
					?>

					<input type = "number"
						value = "<?php echo esc_attr( $runtime ); ?>"
						class = "rt-movie-meta-field rt-movie-meta-basic-field rt-movie-meta-basic-runtime-field"
						name  = "<?php echo esc_attr( $rt_movie_meta_basic_key['runtime'] ); ?>"
						id    = "<?php echo esc_attr( $rt_movie_meta_basic_key['runtime'] ); ?>"
						min   = "1"
						max   = "1000" />

					<span class = "rt-movie-meta-field-error rt-movie-meta-basic-field-error rt-movie-meta-basic-runtime-field-error" id="rt-movie-meta-basic-runtime-field-error"></span>

				</div>

				<div class = "rt-movie-meta-container rt-movie-meta-basic-container rt-movie-meta-basic-release-date-container">

					<label class = "rt-movie-meta-label rt-movie-meta-basic-label rt-movie-meta-basic-release-date-label"
						for    = "<?php echo esc_attr( $rt_movie_meta_basic_key['release-date'] ); ?> ">

						<?php esc_html_e( 'Release Date', 'movie-library' ); ?>

					</label>

					<?php
					$release_date = '';
					if ( isset( $rt_movie_meta_basic_data[ $rt_movie_meta_basic_key['release-date'] ] ) ) {
						$release_date = $rt_movie_meta_basic_data[ $rt_movie_meta_basic_key['release-date'] ][0];
					}
					?>

					<input type = "date"
						value = "<?php echo esc_attr( $release_date ); ?>"
						class = "rt-movie-meta-field rt-movie-meta-basic-field rt-movie-meta-basic-release-date-field"
						name  = "<?php echo esc_attr( $rt_movie_meta_basic_key['release-date'] ); ?>"
						id    = "<?php echo esc_attr( $rt_movie_meta_basic_key['release-date'] ); ?>" />

				</div>

			</div>

			<?php
		}

		/**
		 * This function is used to display the meta box for the movie crew.
		 *
		 * @param WP_Post $post The post object.
		 *
		 * @return void
		 */
		public function rt_movie_meta_crew( WP_Post $post ): void {
			$rt_career_terms = get_terms(
				array(
					'taxonomy'   => RT_PERSON_CAREER_SLUG,
					'hide_empty' => false,
				)
			);

			$rt_people_data          = array();
			$rt_movie_meta_crew_data = array();

			// Getting the data of each person according to their career and storing it in an array.
			// Also getting the meta-data for each person and storing it in an array.
			foreach ( $rt_career_terms as $rt_career_term ) {

				$key                                     = 'rt-movie-meta-crew-' . $rt_career_term->slug;
				$rt_movie_meta_crew_data[ $key ]         = get_post_meta( $post->ID, $key );
				$rt_people_data[ $rt_career_term->name ] = $this->get_person_data( $rt_career_term );

			}

			// Un-shifting the data to get the data in the correct order.
			$rt_movie_meta_crew_data = $this->un_shift( $rt_movie_meta_crew_data );

			$selected_crew_ids = array();

			// Getting the person ids of the selected people.
			foreach ( $rt_movie_meta_crew_data as $key => $rt_movie_meta_crew_individual_data ) {

				if ( empty( $rt_movie_meta_crew_individual_data ) ) {
					$selected_crew_ids[ $key ] = array();
					continue;
				}

				foreach ( $rt_movie_meta_crew_individual_data as $rt_movie_data ) {

					$selected_crew_ids[ $key ][] = $rt_movie_data['person_id'];

				}
			}

			wp_nonce_field( 'rt_movie_meta_nonce', 'rt_movie_meta_nonce' );

			?>

			<div class = "rt-movie-meta-fields rt-movie-meta-crew-fields">

				<?php
				foreach ( $rt_people_data as $key => $rt_person_each_key_data ) {

					if ( empty( $rt_person_each_key_data ) ) {
						continue;
					}

					?>

					<div class = "rt-movie-meta-container rt-movie-meta-crew-container
					<?php echo esc_attr( strtolower( 'rt-movie-meta-crew-' . $key . '-container' ) ); ?> ">

						<label class = "rt-movie-meta-label rt-movie-meta-crew-label
								<?php echo esc_attr( strtolower( 'rt-movie-meta-crew-' . $key . '-label' ) ); ?>"
							for = "<?php echo esc_attr( strtolower( str_replace( '-', '_', 'rt-movie-meta-crew-' . $key ) ) ); ?>">

							<?php echo esc_html( $key ); ?>

						</label>

						<select class = "rt-movie-meta-field rt-movie-meta-crew-field
									<?php echo esc_attr( strtolower( 'rt-movie-meta-crew-' . $key . '-field' ) ); ?>"
							name = "<?php echo esc_attr( strtolower( 'rt-movie-meta-crew-' . $key ) . '[]' ); ?>"
							id = "<?php echo esc_attr( strtolower( str_replace( '-', '_', 'rt-movie-meta-crew-' . $key ) ) ); ?>"
							multiple = "multiple" >

							<?php

							foreach ( $rt_person_each_key_data as $rt_person_data ) {

								if ( empty( $selected_crew_ids[ strtolower( 'rt-movie-meta-crew-' . $key ) ] ) ) {

									printf(
										'<option value="%1$d">%2$s</option>',
										esc_attr( $rt_person_data['id'] ),
										esc_html( $rt_person_data['name'] )
									);

								} else {

									$selected = in_array(
										$rt_person_data['id'],
										$selected_crew_ids[ strtolower( 'rt-movie-meta-crew-' . $key ) ],
										true
									) ? 'selected' : '';

									printf(
										'<option value="%1$d" %2$s>%3$s</option>',
										esc_attr( $rt_person_data['id'] ),
										esc_attr( $selected ),
										esc_html( $rt_person_data['name'] ),
									);

								}
							}
							?>

						</select>

						<?php if ( 'Actor' === $key ) { ?>

							<div id = "rt_movie_meta_crew_actor_character_container">

								<?php

								if ( isset( $rt_movie_meta_crew_data['rt-movie-meta-crew-actor'] ) ) {

									foreach ( $rt_movie_meta_crew_data['rt-movie-meta-crew-actor'] as $rt_character_data ) {

										?>

										<div class = "rt-movie-meta-crew-actor-character-container">

											<label class = "rt-movie-meta-label rt-movie-meta-crew-label "
												for = "<?php echo esc_attr( $rt_character_data['person_id'] ); ?>">

												<?php echo esc_html( $rt_character_data['person_name'] . ( ' (Character Name)' ) ); ?>

											</label>

											<input type = "text"
												class = "rt-movie-meta-crew-actor-character-field"
												name = "<?php echo esc_attr( $rt_character_data['person_id'] ); ?>"
												id = "<?php echo esc_attr( $rt_character_data['person_id'] ); ?>"
												value = "<?php echo esc_attr( $rt_character_data['character_name'] ); ?>"/>

											<input type = "text"
												class = "hidden-field"
												name = "<?php echo esc_attr( $rt_character_data['person_id'] . '-name' ); ?>"
												id = "<?php echo esc_attr( $rt_character_data['person_id'] . '-name' ); ?>"
												value = "<?php echo esc_attr( $rt_character_data['person_name'] ); ?>"/>

										</div>

									<?php } ?>

								<?php } ?>

							</div>

						<?php } ?>

					</div>

					<?php
				}
				?>

			</div>

			<?php
		}

		/**
		 * This function is used to get the person data.
		 *
		 * @param object $rt_career_term The career term object.
		 *
		 * @return array
		 */
		private function get_person_data( $rt_career_term ): array {

			$rt_person_data = array();

			$rt_person_query = new WP_Query(
				array(
					'post_type' => RT_PERSON_SLUG,
					'per_page'  => 10,
					'tax_query' => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
										  array(
											  'taxonomy' => RT_PERSON_CAREER_SLUG,
											  'field'    => 'term_id',
											  'terms'    => $rt_career_term->term_id,
										  ),
					),
				)
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

			wp_reset_postdata();

			return $rt_person_data;

		}

		/**
		 * This function is used to unshift the array.
		 *
		 * @param array $array The array to be unshifted.
		 * @return array
		 */
		private function un_shift( array $array ): array {

			$un_shifted_array = array();

			foreach ( $array as $key => $rt_movie_meta_crew ) {

				if ( empty( $rt_movie_meta_crew ) ) {
					continue;
				}

				$un_shifted_array[ $key ] = $rt_movie_meta_crew[0];

			}

			return $un_shifted_array;

		}

	}
}
