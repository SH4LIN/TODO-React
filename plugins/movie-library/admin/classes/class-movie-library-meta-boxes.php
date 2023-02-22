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
	 * This class is used to create the meta boxes for the plugin.
	 */
	class Movie_Library_Meta_Boxes {

		/**
		 * This function is used to add the meta boxes for the plugin.
		 *
		 * @return void
		 */
		public function add_meta_boxes(): void {

			// This code will get all the meta boxes arguments.
			$meta_boxes_args = $this->get_meta_boxes_args();

			// Adding the meta box for each meta boxes arguments.
			foreach ( $meta_boxes_args as $meta_box_id => $meta_box_args ) {

				// This will call the add_meta_box WordPress function. To add the meta boxes in the admin area.
				add_meta_box(
					$meta_box_id,
					$meta_box_args['title'],
					$meta_box_args['callback'],
					$meta_box_args['screen'],
					$meta_box_args['context'],
					$meta_box_args['priority']
				);

			}

		}

		/**
		 * This function is used to get the meta boxes arguments.
		 *
		 * @return array The meta boxes arguments.
		 */
		private function get_meta_boxes_args(): array {

			/**
			 * For future reference, If you want to add more meta boxes, you can add them here.
			 */
			return array(
				'rt-movie-meta-basic'   => array(
					'title'    => __( 'Basic', 'movie-library' ),
					'callback' => array( $this, 'rt_movie_meta_basic' ),
					'screen'   => array( 'rt-movie' ),
					'context'  => 'side',
					'priority' => 'high',
				),
				'rt-movie-meta-crew'    => array(
					'title'    => __( 'Crew', 'movie-library' ),
					'callback' => array( $this, 'rt_movie_meta_crew' ),
					'screen'   => array( 'rt-movie' ),
					'context'  => 'side',
					'priority' => 'high',
				),
				'rt-person-meta-basic'  => array(
					'title'    => __( 'Basic', 'movie-library' ),
					'callback' => array( $this, 'rt_person_meta_basic' ),
					'screen'   => array( 'rt-person' ),
					'context'  => 'side',
					'priority' => 'high',
				),
				'rt-person-meta-social' => array(
					'title'    => __( 'Basic', 'movie-library' ),
					'callback' => array( $this, 'rt_person_meta_social' ),
					'screen'   => array( 'rt-person' ),
					'context'  => 'side',
					'priority' => 'high',
				),
				'rt-media-meta-images'  => array(
					'title'    => __( 'Photos', 'movie-library' ),
					'callback' => array( $this, 'rt_media_meta_images' ),
					'screen'   => array( 'rt-movie', 'rt-person' ),
					'context'  => 'side',
					'priority' => 'high',
				),
				'rt-media-meta-videos'  => array(
					'title'    => __( 'Videos', 'movie-library' ),
					'callback' => array( $this, 'rt_media_meta_videos' ),
					'screen'   => array( 'rt-movie', 'rt-person' ),
					'context'  => 'side',
					'priority' => 'high',
				),
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

						<?php esc_html_e( 'Rating (Between 1-10)', 'movie-library' ); ?>

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
							max = "5"
							min = "1" />

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
					'taxonomy'   => 'rt-person-career',
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
													id = "<?php echo esc_attr( $rt_character_data['person_id'] ); ?>"
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
		 * This function is used to display the meta box for the person basic details.
		 *
		 * @param WP_Post $post The post object.
		 *
		 * @return void
		 */
		public function rt_person_meta_basic( WP_Post $post ): void {

			// This will be used to get the person meta basic data.
			$rt_person_meta_basic_data = get_post_meta( $post->ID );

			// This will create the array of the person meta basic keys.
			$rt_person_meta_basic_key = array(
				'birth-date'  => 'rt-person-meta-basic-birth-date',
				'birth-place' => 'rt-person-meta-basic-birth-place',
			);

			// This will be used to add the nonce field.
			wp_nonce_field( 'rt_person_meta_nonce', 'rt_person_meta_nonce' );

			?>

			<div class = "rt-person-meta-fields rt-person-meta-basic-fields">

				<div class = "rt-person-meta-container rt-person-meta-basic-container rt-person-meta-basic-birth-date-container">

					<label class = "rt-person-meta-label rt-person-meta-basic-label rt-person-meta-basic-birth-date-label"
							for = "<?php echo esc_attr( $rt_person_meta_basic_key['birth-date'] ); ?>">

						<?php esc_html_e( 'Birth Date', 'movie-library' ); ?>

					</label>

					<input type = "date"
							value = "<?php echo esc_attr( $rt_person_meta_basic_data[ $rt_person_meta_basic_key['birth-date'] ][0] ); ?>"
							class = "rt-person-meta-field rt-person-meta-basic-field rt-person-meta-basic-birth-date-field"
							name = "<?php echo esc_attr( $rt_person_meta_basic_key['birth-date'] ); ?>"
							id = "<?php echo esc_attr( $rt_person_meta_basic_key['birth-date'] ); ?>" />

				</div>

				<div class = "rt-person-meta-container rt-person-meta-basic-container rt-person-meta-basic-birth-place-container">

					<label class = "rt-person-meta-label rt-person-meta-basic-label rt-person-meta-basic-birth-place-label"
							for = "<?php echo esc_attr( $rt_person_meta_basic_key['birth-place'] ); ?>">

						<?php esc_html_e( 'Birth Place', 'movie-library' ); ?>

					</label>

					<input type = "text"
							value = "<?php echo esc_attr( $rt_person_meta_basic_data[ $rt_person_meta_basic_key['birth-place'] ][0] ); ?>"
							class = "rt-person-meta-field rt-person-meta-basic-field rt-person-meta-basic-birth-place-field"
							name = "<?php echo esc_attr( $rt_person_meta_basic_key['birth-place'] ); ?>"
							id = "<?php echo esc_attr( $rt_person_meta_basic_key['birth-place'] ); ?>" />

				</div>


			</div>

			<?php
		}

		/**
		 * This function is used to create the meta box for the person social details.
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

			<div class = "rt-person-meta-fields rt-person-meta-social-fields">

				<div class = "rt-person-meta-container rt-person-meta-social-container rt-person-meta-social-twitter-container">

					<label class = "rt-person-meta-label rt-person-meta-social-label rt-person-meta-social-twitter-label"
								for = "<?php echo esc_attr( $rt_person_meta_social_key['twitter'] ); ?>">

						<?php esc_html_e( 'Twitter', 'movie-library' ); ?>

					</label>

					<input type = "text"
							value = "<?php echo esc_url( $rt_person_meta_social_data[ $rt_person_meta_social_key['twitter'] ][0] ); ?>"
							class = "rt-person-meta-field rt-person-meta-social-field rt-person-meta-social-twitter-field"
							name = "<?php echo esc_attr( $rt_person_meta_social_key['twitter'] ); ?>"
							id = "<?php echo esc_attr( $rt_person_meta_social_key['twitter'] ); ?>"/>

				</div>

				<div class = "rt-person-meta-container rt-person-meta-social-container rt-person-meta-social-facebook-container">

					<label class = "rt-person-meta-label rt-person-meta-social-label rt-person-meta-social-facebook-label"
								for = "<?php echo esc_attr( $rt_person_meta_social_key['facebook'] ); ?>">

						<?php esc_html_e( 'Facebook', 'movie-library' ); ?>

					</label>

					<input type = "text"
							value = "<?php echo esc_url( $rt_person_meta_social_data[ $rt_person_meta_social_key['facebook'] ][0] ); ?>"
							class = "rt-person-meta-field rt-person-meta-social-field rt-person-meta-social-facebook-field"
							name = "<?php echo esc_attr( $rt_person_meta_social_key['facebook'] ); ?>"
							id = "<?php echo esc_attr( $rt_person_meta_social_key['facebook'] ); ?>"/>

				</div>

				<div class = "rt-person-meta-container rt-person-meta-social-container rt-person-meta-social-instagram-container">

					<label class = "rt-person-meta-label rt-person-meta-social-label rt-person-meta-social-instagram-label"
							for = "<?php echo esc_attr( $rt_person_meta_social_key['instagram'] ); ?>">

						<?php esc_html_e( 'Instagram', 'movie-library' ); ?>

					</label>

					<input type = "text"
							value = "<?php echo esc_url( $rt_person_meta_social_data[ $rt_person_meta_social_key['instagram'] ][0] ); ?>"
							class = "rt-person-meta-field rt-person-meta-social-field rt-person-meta-social-instagram-field"
							name = "<?php echo esc_attr( $rt_person_meta_social_key['instagram'] ); ?>"
							id = "<?php echo esc_attr( $rt_person_meta_social_key['instagram'] ); ?>"/>

				</div>

				<div class = "rt-person-meta-container rt-person-meta-social-container rt-person-meta-social-website-container">

					<label class = "rt-person-meta-label rt-person-meta-social-label rt-person-meta-social-website-label"
								for = "<?php echo esc_attr( $rt_person_meta_social_key['Website'] ); ?>">

						<?php esc_html_e( 'Website', 'movie-library' ); ?>

					</label>

					<input type = "text"
							value = "<?php echo esc_url( $rt_person_meta_social_data[ $rt_person_meta_social_key['website'] ][0] ); ?>"
							class = "rt-person-meta-field rt-person-meta-social-field rt-person-meta-social-website-field"
							name = "<?php echo esc_attr( $rt_person_meta_social_key['website'] ); ?>"
							id = "<?php echo esc_attr( $rt_person_meta_social_key['website'] ); ?>" />

				</div>

			</div>

			<?php

		}

		/**
		 * This function is used to create the meta box for the movie images.
		 *
		 * @param WP_Post $post The post object.
		 *
		 * @return void
		 */
		public function rt_media_meta_images( WP_Post $post ): void {

			$rt_media_meta_images_key = array(
				'images' => 'rt-media-meta-images',
			);

			$rt_media_meta_images_data_attachment_ids =
				get_post_meta( $post->ID, $rt_media_meta_images_key['images'] );

			wp_nonce_field( 'rt_media_meta_nonce', 'rt_media_meta_nonce' );

			?>

			<div class = "rt-media-meta-fields rt-media-meta-images">

				<div class = "rt-media-meta-container rt-media-meta-images-container rt-media-meta-uploaded-images-container">

					<?php

					if ( isset( $rt_media_meta_images_data_attachment_ids ) && ! empty( $rt_media_meta_images_data_attachment_ids[0] ) ) {

						?>

						<input name = "rt-media-meta-uploaded-images"
								value = "<?php echo esc_attr( wp_json_encode( $rt_media_meta_images_data_attachment_ids[0] ) ); ?>"
								hidden = "hidden">

						<h3 class = "rt-media-meta-heading rt-media-meta-images-heading rt-media-meta-uploaded-images-heading">

							<?php esc_html_e( 'Uploaded Images', 'movie-library' ); ?>

						</h3>

						<?php

						foreach ( $rt_media_meta_images_data_attachment_ids[0] as $rt_media_meta_image_attachment_id ) {

							$image_url = wp_get_attachment_image_url( $rt_media_meta_image_attachment_id, 'full' );

							if ( ! $image_url ) {
								continue;
							}

							?>

							<div class = "rt-media-meta rt-media-meta-image rt-media-meta-uploaded-image">

								<img src = "<?php echo esc_url( $image_url ); ?>" alt = "">

								<span class = "rt-media-meta-remove rt-media-meta-image-remove rt-media-meta-uploaded-image-remove"
										data-id = "<?php echo esc_attr( $rt_media_meta_image_attachment_id ); ?>">

										X

								</span>

							</div>

							<?php

						}

						?>

						<?php

					}

					?>

				</div>

				<div class = "rt-media-meta-container rt-media-meta-images-container rt-media-meta-selected-images-container"
						id = "rt-media-meta-selected-images-container">

				</div>

				<button class = "rt-media-meta-add rt-media-meta-add rt-media-meta-images-add"
						type = "button">

					<?php esc_html_e( 'Add Images', 'movie-library' ); ?>

				</button>

				<input name = "rt-media-meta-selected-images" hidden = "hidden">

			</div>

			<?php
		}

		/**
		 * This function will add the meta box for videos in rt-movie and rt-person post type.
		 * It will also add the functionality to add and remove videos.
		 * It will also save the videos in the database.
		 * It will also add the functionality to add videos from the media library.
		 *
		 * @param WP_Post $post The post object.
		 *
		 * @return void
		 */
		public function rt_media_meta_videos( WP_Post $post ): void {

			$rt_media_meta_videos_key = array(
				'images' => 'rt-media-meta-videos',
			);

			$rt_media_meta_videos_data_attachment_ids =
				get_post_meta( $post->ID, $rt_media_meta_videos_key['images'] );

			wp_nonce_field( 'rt_media_meta_nonce', 'rt_media_meta_nonce' );

			?>

			<div class = "rt-media-meta-fields rt-media-meta-videos">

				<div class = "rt-media-meta-container rt-media-meta-videos-container rt-media-meta-uploaded-videos-container">

					<?php

					if ( isset( $rt_media_meta_videos_data_attachment_ids ) && ! empty( $rt_media_meta_videos_data_attachment_ids[0] ) ) {

						?>

						<input name = "rt-media-meta-uploaded-videos"
								value = "<?php echo esc_attr( wp_json_encode( $rt_media_meta_videos_data_attachment_ids[0] ) ); ?>"
								hidden = "hidden">

						<h3 class = "rt-media-meta-heading rt-media-meta-videos-heading rt-media-meta-uploaded-videos-heading">

							<?php esc_html_e( 'Uploaded Videos', 'movie-library' ); ?>

						</h3>

						<?php

						foreach ( $rt_media_meta_videos_data_attachment_ids[0] as $rt_media_meta_video_attachment_id ) {

							$video_url = wp_get_attachment_url( $rt_media_meta_video_attachment_id );

							if ( ! $video_url ) {
								continue;
							}

							?>

							<div class = "rt-media-meta rt-media-meta-video rt-media-meta-uploaded-video">

								<video>

									<source src = "<?php echo esc_url( $video_url ); ?>">

								</video>

								<span class = "rt-media-meta-remove rt-media-meta-video-remove rt-media-meta-uploaded-video-remove"
										data-id = "<?php echo esc_attr( $rt_media_meta_video_attachment_id ); ?>">

										X

								</span>

							</div>

							<?php

						}

						?>

						<?php

					}

					?>

				</div>

				<div class = "rt-media-meta-container rt-media-meta-videos-container rt-media-meta-selected-videos-container"
						id = "rt-media-meta-selected-videos-container">

				</div>

				<button class = "rt-media-meta-add rt-media-meta-add rt-media-meta-videos-add"
						type = "button">

					<?php esc_html_e( 'Add Videos', 'movie-library' ); ?>

				</button>

				<input name = "rt-media-meta-selected-videos" hidden = "hidden">

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
					'post_type' => 'rt-person',
					'per_page'  => 10,
					'tax_query' => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
						array(
							'taxonomy' => 'rt-person-career',
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

