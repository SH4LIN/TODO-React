<?php
/**
 * This file is used to handle all the operation while saving the post.
 *
 * @package MovieLib\admin\classes
 */

namespace MovieLib\admin\classes;

use WP_Post;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\Movie_Library_Save_Post' ) ) {

	/**
	 * This class is used to handle all the operation while saving the post.
	 */
	class Movie_Library_Save_Post {
		/**
		 * This function is used to save the post.
		 * It also checks the user's permission to save the post.
		 * If the user has the permission to save the post then it calls the respective function to save the post.
		 * It also checks if the post is an autosave or a revision.
		 * If the post is an autosave or a revision then it returns.
		 *
		 * @param int     $post_id Post ID.
		 * @param WP_Post $post Post object.
		 * @param bool    $update Whether this is an existing post being updated or not.
		 *
		 * @return void
		 */
		public function save_post( int $post_id, WP_Post $post, bool $update ): void {

			if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
				return;
			}

			// Check is post type is rt-movie or rt-person.
			if ( 'rt-movie' === $post->post_type ) {
				// Check the user's permissions.

				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				} else {

					$this->save_rt_movie_post( $post_id, $post, $update );

				}
			} elseif ( 'rt-person' === $post->post_type ) {

				// Check the user's permissions.
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				} else {

					$this->save_rt_person_post( $post_id, $post, $update );

				}
			} else {

				// Check the user's permissions.
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				}
			}
		}

		/**
		 * This function is used to save the rt-person post.
		 * First it will verify the nonce if it is set or not.
		 * If the nonce is set then it will verify the nonce.
		 * If the nonce is verified then it will check the expected fields are set or not.
		 * If the expected fields are set then it will sanitize the data, validate data and save the data.
		 *
		 * @param int     $post_id The post ID.
		 * @param WP_Post $post The post object.
		 * @param bool    $update Whether this is an existing post being updated or not.
		 */
		private function save_rt_person_post( int $post_id, WP_Post $post, bool $update ): void {

			// Check if our nonce is set.
			if ( ! isset( $_POST['rt_person_meta_nonce'] ) ) {
				return;
			}

			// Sanitize nonce.
			$rt_person_meta_nonce = sanitize_text_field( wp_unslash( $_POST['rt_person_meta_nonce'] ) );

			// Verify that the nonce is valid.
			if ( ! wp_verify_nonce( $rt_person_meta_nonce, 'rt_person_meta_nonce' ) ) {
				return;
			}

			/** OK, it's safe for us to save the data now. */

			$this->save_rt_movie_meta_images( $post_id );
			$this->save_rt_movie_meta_videos( $post_id );

			// Check if rt-person-meta-basic-birth-date is set. If it is set then sanitize the data and save it.
			if ( isset( $_POST['rt-person-meta-basic-birth-date'] ) ) {

				$rt_person_meta_basic_birth_date = sanitize_text_field( wp_unslash( $_POST['rt-person-meta-basic-birth-date'] ) );

				update_post_meta( $post_id, 'rt-person-meta-basic-birth-date', $rt_person_meta_basic_birth_date );

			}

			// Check if rt-person-meta-basic-birth-place is set. If it is set then sanitize the data and save it.
			if ( isset( $_POST['rt-person-meta-basic-birth-place'] ) ) {

				$rt_person_meta_basic_birth_place = sanitize_text_field( wp_unslash( $_POST['rt-person-meta-basic-birth-place'] ) );

				if ( ! is_numeric( $rt_person_meta_basic_birth_place ) ) {

					update_post_meta( $post_id, 'rt-person-meta-basic-birth-place', $rt_person_meta_basic_birth_place );

				}
			}

			// Check if rt-person-meta-social-twitter url is set. If it is set then sanitize url the data validate the data and save it.
			if ( isset( $_POST['rt-person-meta-social-twitter'] ) ) {

				$rt_person_meta_social_twitter = esc_url_raw( wp_unslash( $_POST['rt-person-meta-social-twitter'] ) );

				if ( filter_var( $rt_person_meta_social_twitter, FILTER_VALIDATE_URL ) ) {

					update_post_meta( $post_id, 'rt-person-meta-social-twitter', $rt_person_meta_social_twitter );

				}
			}

			// Check if rt-person-meta-social-facebook url is set. If it is set then sanitize url the data validate the data and save it.
			if ( isset( $_POST['rt-person-meta-social-facebook'] ) ) {

				$rt_person_meta_social_facebook = esc_url_raw( wp_unslash( $_POST['rt-person-meta-social-facebook'] ) );

				if ( filter_var( $rt_person_meta_social_facebook, FILTER_VALIDATE_URL ) ) {

					update_post_meta( $post_id, 'rt-person-meta-social-facebook', $rt_person_meta_social_facebook );

				}
			}

			// Check if rt-person-meta-social-instagram url is set. If it is set then sanitize url the data validate the data and save it.
			if ( isset( $_POST['rt-person-meta-social-instagram'] ) ) {

				$rt_person_meta_social_instagram = esc_url_raw( wp_unslash( $_POST['rt-person-meta-social-instagram'] ) );

				if ( filter_var( $rt_person_meta_social_instagram, FILTER_VALIDATE_URL ) ) {

					update_post_meta( $post_id, 'rt-person-meta-social-instagram', $rt_person_meta_social_instagram );

				}
			}

			// Check if rt-person-meta-social-web url is set. If it is set then sanitize url the data validate the data and save it.
			if ( isset( $_POST['rt-person-meta-social-web'] ) ) {

				$rt_person_meta_social_web = esc_url_raw( wp_unslash( $_POST['rt-person-meta-social-web'] ) );

				if ( filter_var( $rt_person_meta_social_web, FILTER_VALIDATE_URL ) ) {

					update_post_meta( $post_id, 'rt-person-meta-social-web', $rt_person_meta_social_web );

				}
			}
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
		private function save_rt_movie_post( int $post_id, WP_Post $post, bool $update ): void {
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

			$this->save_rt_movie_meta_images( $post_id );
			$this->save_rt_movie_meta_videos( $post_id );

			// Get all the rt-person-career terms.
			$rt_career_terms = get_terms(
				array(
					'taxonomy'   => 'rt-person-career',
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
					$rt_movie_meta_crew_data = sanitize_meta( $meta_key, wp_unslash( $_POST[ $meta_key ] ), 'rt-movie' );

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
			wp_delete_object_term_relationships( $post_id, '_rt-movie-person' );

			if ( $does_any_crew_exist ) {

				wp_set_object_terms( $post_id, $shadow_terms, '_rt-movie-person', true );

			}

			// Checking if rt-movie-meta-basic-rating is available in $_POST.
			if ( isset( $_POST['rt-movie-meta-basic-rating'] ) ) {

				// Sanitize user input.
				$rt_movie_meta_basic_rating = sanitize_text_field( wp_unslash( $_POST['rt-movie-meta-basic-rating'] ) );

				// If value is not numeric than doing explicit type casting.
				if ( ! is_numeric( $rt_movie_meta_basic_rating ) ) {

					$rt_movie_meta_basic_rating = (int) $rt_movie_meta_basic_rating;

				}

				// If the value is between 1 and 5 then it will update the meta field in the database.
				if ( $rt_movie_meta_basic_rating >= 1 && $rt_movie_meta_basic_rating <= 5 ) {

					// Update the meta field in the database.
					update_post_meta( $post_id, 'rt-movie-meta-basic-rating', $rt_movie_meta_basic_rating );

				}
			}

			// Checking if rt-movie-meta-basic-runtime is available in $_POST.
			if ( isset( $_POST['rt-movie-meta-basic-runtime'] ) ) {

				// Sanitize user input.
				$rt_movie_meta_basic_runtime = sanitize_text_field( wp_unslash( $_POST['rt-movie-meta-basic-runtime'] ) );

				// If value is not numeric than doing explicit type casting.
				if ( ! is_numeric( $rt_movie_meta_basic_runtime ) ) {

					$rt_movie_meta_basic_runtime = (int) $rt_movie_meta_basic_runtime;

				}

				// If the value is between 1 and 1000 then it will update the meta field in the database.
				if ( $rt_movie_meta_basic_runtime >= 1 && $rt_movie_meta_basic_runtime <= 1000 ) {

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
		 * This function is used to update the post meta and set the object terms
		 *
		 * @param int    $post_id Post ID.
		 * @param mixed  $terms  Terms to be stored.
		 * @param string $key   Meta key.
		 *
		 * @return void
		 */
		private function set_object_terms( int $post_id, mixed $terms, string $key ): void {

			update_post_meta( $post_id, $key, $terms );

		}

		/**
		 * This function is used to save the rt-movie-meta-images meta field in the database.
		 * This function will have two array one for selected videos and another for uploaded images.
		 * If the selected images array is not empty then it will update the meta field in the database.
		 * If the uploaded images array is not empty then it will update the meta field in the database.
		 * If both the arrays are empty then it will delete the meta field from the database.
		 *
		 * @param int $post_id Post ID.
		 *
		 * @return void
		 */
		private function save_rt_movie_meta_images( int $post_id ): void {

			// Check if our nonce is set.
			if ( ! isset( $_POST['rt_media_meta_nonce'] ) ) {
				return;
			}

			// Sanitize nonce.
			$rt_movie_meta_nonce = sanitize_text_field( wp_unslash( $_POST['rt_media_meta_nonce'] ) );

			// Verify that the nonce is valid.
			if ( ! wp_verify_nonce( $rt_movie_meta_nonce, 'rt_media_meta_nonce' ) ) {
				return;
			}

			/** OK, it's safe for us to save the data now. */

			$rt_movie_meta_selected_images = array();
			$rt_movie_meta_uploaded_images = array();

			// Checking if rt-movie-meta-images is available in $_POST.
			if ( isset( $_POST['rt-media-meta-selected-images'] ) && ! empty( $_POST['rt-media-meta-selected-images'] ) ) {

				// Sanitize user input.
				$rt_movie_meta_sanitized_selected_images = sanitize_text_field( wp_unslash( $_POST['rt-media-meta-selected-images'] ) );

				$rt_movie_meta_selected_images = json_decode( $rt_movie_meta_sanitized_selected_images, false );

			}

			if ( isset( $_POST['rt-media-meta-uploaded-images'] ) && ! empty( $_POST['rt-media-meta-uploaded-images'] ) ) {

				// Sanitize user input.
				$rt_movie_meta_sanitized_uploaded_images = sanitize_text_field( wp_unslash( $_POST['rt-media-meta-uploaded-images'] ) );

				$rt_movie_meta_uploaded_images = json_decode( $rt_movie_meta_sanitized_uploaded_images, false );

			}

			if ( ! is_array( $rt_movie_meta_selected_images ) ) {

				$rt_movie_meta_selected_images = array();

			}

			if ( ! is_array( $rt_movie_meta_uploaded_images ) ) {

				$rt_movie_meta_uploaded_images = array();

			}

			$rt_media_meta_images = array_unique( array_merge( $rt_movie_meta_selected_images, $rt_movie_meta_uploaded_images ) );

			foreach ( $rt_media_meta_images as $key => $value ) {

				if ( ! wp_get_attachment_image_url( $value ) ) {

					unset( $rt_media_meta_images[ $key ] );

				}
			}
			if ( empty( $rt_media_meta_images ) ) {

				delete_post_meta( $post_id, 'rt-media-meta-images' );

			} else {

				update_post_meta( $post_id, 'rt-media-meta-images', $rt_media_meta_images );

			}

		}

		/**
		 * This function is used to save the rt-movie-meta-videos meta field in the database.
		 * This function will have two array one for selected videos and another for uploaded videos.
		 * If the selected videos array is not empty then it will update the meta field in the database.
		 * If the uploaded videos array is not empty then it will update the meta field in the database.
		 * If both the arrays are empty then it will delete the meta field from the database.
		 *
		 * @param int $post_id The post id.
		 *
		 * @return void
		 */
		private function save_rt_movie_meta_videos( int $post_id ): void {

			// Check if our nonce is set.
			if ( ! isset( $_POST['rt_media_meta_nonce'] ) ) {
				return;
			}

			// Sanitize nonce.
			$rt_movie_meta_nonce = sanitize_text_field( wp_unslash( $_POST['rt_media_meta_nonce'] ) );

			// Verify that the nonce is valid.
			if ( ! wp_verify_nonce( $rt_movie_meta_nonce, 'rt_media_meta_nonce' ) ) {
				return;
			}

			/** OK, it's safe for us to save the data now. */

			$rt_movie_meta_selected_videos = array();
			$rt_movie_meta_uploaded_videos = array();

			// Checking if rt-movie-meta-images is available in $_POST.
			if ( isset( $_POST['rt-media-meta-selected-videos'] ) && ! empty( $_POST['rt-media-meta-selected-videos'] ) ) {

				// Sanitize user input.
				$rt_movie_meta_sanitized_selected_videos = sanitize_text_field( wp_unslash( $_POST['rt-media-meta-selected-videos'] ) );

				$rt_movie_meta_selected_videos = json_decode( $rt_movie_meta_sanitized_selected_videos, false );

			}

			if ( isset( $_POST['rt-media-meta-uploaded-videos'] ) && ! empty( $_POST['rt-media-meta-uploaded-videos'] ) ) {

				// Sanitize user input.
				$rt_movie_meta_sanitized_uploaded_videos = sanitize_text_field( wp_unslash( $_POST['rt-media-meta-uploaded-videos'] ) );

				$rt_movie_meta_uploaded_videos = json_decode( $rt_movie_meta_sanitized_uploaded_videos, false );

			}

			if ( ! is_array( $rt_movie_meta_selected_videos ) ) {

				$rt_movie_meta_selected_videos = array();

			}
			if ( ! is_array( $rt_movie_meta_uploaded_videos ) ) {

				$rt_movie_meta_uploaded_videos = array();

			}

			$rt_media_meta_videos = array_unique( array_merge( $rt_movie_meta_selected_videos, $rt_movie_meta_uploaded_videos ) );

			foreach ( $rt_media_meta_videos as $key => $video ) {

				if ( ! wp_get_attachment_url( $video ) ) {

					unset( $rt_media_meta_videos[ $key ] );

				}
			}

			if ( empty( $rt_media_meta_videos ) ) {

				delete_post_meta( $post_id, 'rt-media-meta-videos' );

			} else {

				update_post_meta( $post_id, 'rt-media-meta-videos', $rt_media_meta_videos );

			}
		}
	}
}
