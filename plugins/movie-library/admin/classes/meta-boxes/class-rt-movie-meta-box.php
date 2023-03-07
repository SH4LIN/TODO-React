<?php
/**
 * This file is used to create all the meta-boxes for rt-movie post type.
 *
 * @package MovieLib\admin\classes\meta_boxes
 */

namespace MovieLib\admin\classes\meta_boxes;

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\admin\classes\taxonomies\Movie_Person;
use MovieLib\admin\classes\taxonomies\Person_Career;
use MovieLib\includes\Singleton;
use WP_Post;
use WP_Query;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box' ) ) {

	/**
	 * This class is used to create all the meta-boxes for rt-movie post type.
	 */
	class RT_Movie_Meta_Box {

		use Singleton;

		/**
		 * RT_MOVIE_META_BASIC_SLUG
		 */
		const MOVIE_META_BASIC_SLUG = 'rt-movie-meta-basic';

		/**
		 * RT_MOVIE_META_CREW_SLUG
		 */
		const MOVIE_META_CREW_SLUG = 'rt-movie-meta-crew';

		/**
		 * RT_Movie_Meta_Box init method.
		 *
		 * @return void
		 */
		protected function init(): void {

			add_action( 'add_meta_boxes', array( $this, 'create_meta_box' ) );

		}

		/**
		 * This function is used to create the meta-box for basic information and crew information.
		 *
		 * @return void
		 */
		public function create_meta_box():void {

			add_meta_box(
				self::MOVIE_META_BASIC_SLUG,
				__( 'Basic', 'movie-library' ),
				array( $this, 'rt_movie_meta_basic' ),
				array( RT_Movie::SLUG ),
				'side',
				'high'
			);

			add_meta_box(
				self::MOVIE_META_CREW_SLUG,
				__( 'Crew', 'movie-library' ),
				array( $this, 'rt_movie_meta_crew' ),
				array( RT_Movie::SLUG ),
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
					'taxonomy'   => Person_Career::SLUG,
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
		 * This function is used to save the rt-movie post.
		 * First it will verify the nonce if it is set or not.
		 * If the nonce is set then it will verify the nonce.
		 * If the nonce is verified then it will check the expected fields are set or not.
		 * If the expected fields are set then it will sanitize the data, validate data and save the data.
		 * crew data are stored dynamically with the help of get_terms() function.
		 * and for each crew data it will create shadow taxonomy term.
		 *
		 * @param int     $post_id The post ID.
		 * @param WP_Post $post The post object.
		 * @param bool    $update Whether this is an existing post being updated or not.
		 */
		public function save_rt_movie_post( int $post_id, WP_Post $post, bool $update ): void {
			// Check if our nonce is set.
			if ( ! isset( $_POST['rt_movie_meta_nonce'] ) ) {
				return;
			}

			// Sanitize nonce.
			$rt_movie_meta_nonce = sanitize_text_field( wp_unslash( $_POST['rt_movie_meta_nonce'] ) );

			// Verify that the nonce is valid.
			if ( ! wp_verify_nonce( $rt_movie_meta_nonce, 'rt_movie_meta_nonce' ) ) {
				return;
			}

			/** OK, it's safe for us to save the data now. */

			$rt_media_meta_box = RT_Media_Meta_Box::instance();
			$rt_media_meta_box->save_rt_movie_meta_images( $post_id );
			$rt_media_meta_box->save_rt_movie_meta_videos( $post_id );

			// Get all the rt-person-career terms.
			$rt_career_terms = get_terms(
				array(
					'taxonomy'   => Person_Career::SLUG,
					'hide_empty' => true,
				)
			);

			// Setting the flag to false. If any crew data is set then it will be set to true. And if there is no crew data then it will be false.
			$does_any_crew_exist = false;
			$shadow_terms        = array();

			// Running foreach loop for each rt-person-career term.
			foreach ( $rt_career_terms as $rt_career_term ) {

				// Creating meta key for each rt-person-career term.
				$meta_key = sanitize_key( 'rt-movie-meta-crew-' . $rt_career_term->slug );

				// Checking if meta ke is available in $_POST.
				if ( isset( $_POST[ $meta_key ] ) ) {

					// Setting the flag to true.
					$does_any_crew_exist = true;

					// Getting the crew data from $_POST.
					$rt_movie_meta_crew_data = sanitize_meta( $meta_key, wp_unslash( $_POST[ $meta_key ] ), RT_Movie::SLUG );

					// Checking if the crew data is array or not.
					if ( is_array( $rt_movie_meta_crew_data ) && count( $rt_movie_meta_crew_data ) > 0 ) {

						// Creating an empty array to store the shadow taxonomy term.
						$terms = array();

						// Running foreach loop for each crew data.
						foreach ( $rt_movie_meta_crew_data as $rt_movie_meta_crew ) {

							// Sanitizing the crew data.
							$rt_movie_meta_crew = sanitize_text_field( $rt_movie_meta_crew );

							// Checking if the crew data is empty or not and if the crew data is numeric or not.
							if ( ! empty( $rt_movie_meta_crew ) && is_numeric( $rt_movie_meta_crew ) ) {

								if ( 'rt-movie-meta-crew-actor' === $meta_key ) {

									$term = array();

									if ( isset( $_POST[ $rt_movie_meta_crew ] ) ) {

										$rt_movie_meta_crew_character_name = sanitize_text_field( wp_unslash( $_POST[ $rt_movie_meta_crew ] ) );
										$term['character_name']            = $rt_movie_meta_crew_character_name;

									}

									if ( isset( $_POST[ $rt_movie_meta_crew . '-name' ] ) ) {

										$rt_movie_meta_crew_person_name = sanitize_text_field( wp_unslash( $_POST[ $rt_movie_meta_crew . '-name' ] ) );
										$term['person_name']            = $rt_movie_meta_crew_person_name;

									}

									$term['person_id'] = (int) $rt_movie_meta_crew;
									$terms[]           = $term;

								} else {

									$terms[]['person_id'] = (int) $rt_movie_meta_crew;

								}

								$shadow_terms[] = $rt_movie_meta_crew;

							}
						}

						// Updating the post meta with the shadow taxonomy term.
						$this->set_object_terms( $post_id, $terms, $meta_key );

					} else {

						if ( ! empty( $rt_movie_meta_crew_data ) && is_numeric( $rt_movie_meta_crew_data ) ) {

							// Sanitize user input.
							$rt_movie_meta_crew_data = sanitize_text_field( $rt_movie_meta_crew_data );
							$shadow_terms[]          = $rt_movie_meta_crew_data;

							$this->set_object_terms( $post_id, array( $rt_movie_meta_crew_data ), $meta_key );

						}
					}
				} else {

					// If the meta key is not available in $_POST then it will delete the post meta.
					update_post_meta( $post_id, $meta_key, array() );

				}
			}

			// If there is no crew data then it will delete the term_relationships.
			wp_delete_object_term_relationships( $post_id, Movie_Person::SLUG );

			if ( $does_any_crew_exist ) {

				wp_set_object_terms( $post_id, $shadow_terms, Movie_Person::SLUG, true );

			}

			// Checking if rt-movie-meta-basic-rating is available in $_POST.
			if ( isset( $_POST['rt-movie-meta-basic-rating'] ) ) {

				// Sanitize user input.
				$rt_movie_meta_basic_rating = sanitize_text_field( wp_unslash( $_POST['rt-movie-meta-basic-rating'] ) );

				// If value is not numeric than doing explicit type casting.
				if ( ! is_numeric( $rt_movie_meta_basic_rating ) ) {

					$rt_movie_meta_basic_rating = (float) $rt_movie_meta_basic_rating;

				}

				// If value is less than 0 than setting it to 0.
				if ( $rt_movie_meta_basic_rating < 0 ) {

					$rt_movie_meta_basic_rating = 0;

				}

				// If value is greater than 10 than setting it to 10.
				if ( $rt_movie_meta_basic_rating > 10 ) {

					$rt_movie_meta_basic_rating = 10;

				}

				// Update the meta field in the database.
				update_post_meta( $post_id, 'rt-movie-meta-basic-rating', $rt_movie_meta_basic_rating );

			}

			// Checking if rt-movie-meta-basic-runtime is available in $_POST.
			if ( isset( $_POST['rt-movie-meta-basic-runtime'] ) ) {

				// Sanitize user input.
				$rt_movie_meta_basic_runtime = sanitize_text_field( wp_unslash( $_POST['rt-movie-meta-basic-runtime'] ) );

				// If value is not numeric than doing explicit type casting.
				if ( ! is_numeric( $rt_movie_meta_basic_runtime ) ) {

					$rt_movie_meta_basic_runtime = (int) $rt_movie_meta_basic_runtime;

				}

				if ( $rt_movie_meta_basic_runtime > 0 && $rt_movie_meta_basic_runtime <= 1000 ) {

					update_post_meta( $post_id, 'rt-movie-meta-basic-runtime', $rt_movie_meta_basic_runtime );

				}
			}

			// Checking if rt-movie-meta-basic-release-date is available in $_POST.
			if ( isset( $_POST['rt-movie-meta-basic-release-date'] ) ) {

				// Sanitize user input.
				$rt_movie_meta_basic_release_date = sanitize_text_field( wp_unslash( $_POST['rt-movie-meta-basic-release-date'] ) );

				// Update the meta field in the database.
				update_post_meta( $post_id, 'rt-movie-meta-basic-release-date', $rt_movie_meta_basic_release_date );

			}
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
					'post_type' => RT_Person::SLUG,
					'per_page'  => 10,
					'tax_query' => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
									array(
											'taxonomy' => Person_Career::SLUG,
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

		/**
		 * This function is used to update the post meta and set the object terms
		 *
		 * @param int    $post_id Post ID.
		 * @param mixed  $terms  Terms to be stored.
		 * @param string $key   Meta key.
		 *
		 * @return void
		 */
		private function set_object_terms( int $post_id, $terms, string $key ): void {

			update_post_meta( $post_id, $key, $terms );

		}

	}
}
