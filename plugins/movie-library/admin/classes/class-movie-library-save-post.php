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
	 * @class Movie_Library_Save_Post
	 * This class is used to handle all the operation while saving the post.
	 */
	class Movie_Library_Save_Post {
		public function save_post( int $post_id, WP_Post $post, bool $update ): void {
			if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
				return;
			}
			// Check the user's permissions.
			if ( isset( $_POST[ 'post_type' ] ) ) {
				if ( $_POST[ 'post_type' ] === 'rt-movie' ) {
					if ( ! current_user_can( 'edit_page', $post_id ) ) {
						return;
					} else {
						$this->save_rt_movie_post( $post_id, $post, $update );
					}
				} elseif ( $_POST[ 'post_type' ] === 'rt-person' ) {
					if ( ! current_user_can( 'edit_page', $post_id ) ) {
						return;
					} else {
						$this->save_rt_person_post( $post_id, $post, $update );
					}
				} else {
					if ( ! current_user_can( 'edit_post', $post_id ) ) {
						return;
					}
				}
			}
		}

		/**
		 * This function is used to save the rt-person post.
		 *
		 * @param int     $post_id The post ID.
		 * @param WP_Post $post    The post object.
		 * @param bool    $update  Whether this is an existing post being updated or not.
		 */
		private function save_rt_person_post( int $post_id, WP_Post $post, bool $update ): void {
			// Check if our nonce is set.
			if ( ! isset( $_POST[ 'rt_person_meta_nonce' ] ) ) {
				return;
			}
			//Sanitize nonce
			$rt_person_meta_nonce = sanitize_text_field( $_POST[ 'rt_person_meta_nonce' ] );
			// Verify that the nonce is valid.
			if ( ! wp_verify_nonce( $rt_person_meta_nonce, 'rt_person_meta_nonce' ) ) {
				return;
			}

			/** OK, it's safe for us to save the data now. */

			if ( isset( $_POST[ 'rt-person-meta-basic-birth-date' ] ) ) {
				$rt_person_meta_basic_birth_date = sanitize_text_field( $_POST[ 'rt-person-meta-basic-birth-date' ] );
				update_post_meta( $post_id, 'rt-person-meta-basic-birth-date', $rt_person_meta_basic_birth_date );
			}

			if ( isset( $_POST[ 'rt-person-meta-basic-birth-place' ] ) ) {
				$rt_person_meta_basic_birth_place = sanitize_text_field( $_POST[ 'rt-person-meta-basic-birth-place' ] );
				if ( ! is_numeric( $rt_person_meta_basic_birth_place ) ) {
					update_post_meta( $post_id, 'rt-person-meta-basic-birth-place', $rt_person_meta_basic_birth_place );
				}
			}

			if ( isset( $_POST[ 'rt-person-meta-social-twitter' ] ) ) {
				$rt_person_meta_social_twitter = filter_var( $_POST[ 'rt-person-meta-social-twitter' ], FILTER_SANITIZE_URL );
				if ( filter_var( $rt_person_meta_social_twitter, FILTER_VALIDATE_URL ) ) {
					update_post_meta( $post_id, 'rt-person-meta-social-twitter', $rt_person_meta_social_twitter );
				}
			}

			if ( isset( $_POST[ 'rt-person-meta-social-facebook' ] ) ) {
				$rt_person_meta_social_facebook = filter_var( $_POST[ 'rt-person-meta-social-facebook' ], FILTER_SANITIZE_URL );
				if ( filter_var( $rt_person_meta_social_facebook, FILTER_VALIDATE_URL ) ) {
					update_post_meta( $post_id, 'rt-person-meta-social-facebook', $rt_person_meta_social_facebook );
				}
			}

			if ( isset( $_POST[ 'rt-person-meta-social-instagram' ] ) ) {
				$rt_person_meta_social_instagram = filter_var( $_POST[ 'rt-person-meta-social-instagram' ], FILTER_SANITIZE_URL );
				if ( filter_var( $rt_person_meta_social_instagram, FILTER_VALIDATE_URL ) ) {
					update_post_meta( $post_id, 'rt-person-meta-social-instagram', $rt_person_meta_social_instagram );
				}
			}

			if ( isset( $_POST[ 'rt-person-meta-social-web' ] ) ) {
				$rt_person_meta_social_web = filter_var( $_POST[ 'rt-person-meta-social-web' ], FILTER_SANITIZE_URL );
				if ( filter_var( $rt_person_meta_social_web, FILTER_VALIDATE_URL ) ) {
					update_post_meta( $post_id, 'rt-person-meta-social-web', $rt_person_meta_social_web );
				}
			}
		}

		/**
		 * This function is used to save the rt-movie post.
		 *
		 * @param int     $post_id The post ID.
		 * @param WP_Post $post    The post object.
		 * @param bool    $update  Whether this is an existing post being updated or not.
		 */
		private function save_rt_movie_post( int $post_id, WP_Post $post, bool $update ): void {

			// Check if our nonce is set.
			if ( ! isset( $_POST[ 'rt_movie_meta_nonce' ] ) ) {
				return;
			}
			//Sanitize nonce
			$rt_movie_meta_nonce = sanitize_text_field( $_POST[ 'rt_movie_meta_nonce' ] );
			// Verify that the nonce is valid.
			if ( ! wp_verify_nonce( $rt_movie_meta_nonce, 'rt_movie_meta_nonce' ) ) {
				return;
			}

			/** OK, it's safe for us to save the data now. */

			$rt_career_terms = get_terms(
				[
					'taxonomy'   => 'rt-person-career',
					'hide_empty' => true,
				]
			);

			$does_any_crew_exist = false;
			foreach ( $rt_career_terms as $rt_career_term ) {
				$meta_key = 'rt-movie-meta-crew-' . $rt_career_term->slug;
				// Make sure that it is set.
				if ( isset( $_POST[ $meta_key ] ) ) {
					$does_any_crew_exist     = true;
					$rt_movie_meta_crew_data = $_POST[ $meta_key ];
					if ( is_array( $rt_movie_meta_crew_data ) && count( $rt_movie_meta_crew_data ) > 0 ) {
						$shadow_terms = array();
						foreach ( $rt_movie_meta_crew_data as $rt_movie_meta_crew ) {
							// Sanitize user input.
							$rt_movie_meta_crew = sanitize_text_field( $rt_movie_meta_crew );
							//If value is emptier than delete the term
							if ( ! empty( $rt_movie_meta_crew ) && is_numeric( $rt_movie_meta_crew ) ) {
								$shadow_terms[] = $rt_movie_meta_crew;
							}
						}
						$this->set_object_terms( $post_id, $shadow_terms, $meta_key );
					} else {
						if ( ! empty( $rt_movie_meta_crew_data ) && is_numeric( $rt_movie_meta_crew_data ) ) {
							// Sanitize user input.
							$rt_movie_meta_crew_data = sanitize_text_field( $rt_movie_meta_crew_data );
							$this->set_object_terms( $post_id, [ $rt_movie_meta_crew_data ], $meta_key );
						}
					}
				} else {
					update_post_meta( $post_id, $meta_key, [] );
				}
			}

			if ( ! $does_any_crew_exist ) {
				wp_delete_object_term_relationships( $post_id, '_rt-movie-person' );
			}

			// Make sure that it is set.
			if ( isset( $_POST[ 'rt-movie-meta-basic-rating' ] ) ) {
				// Sanitize user input.
				$rt_movie_meta_basic_rating = sanitize_text_field( $_POST[ 'rt-movie-meta-basic-rating' ] );
				//Validate user input.
				if ( ! is_numeric( $rt_movie_meta_basic_rating ) ) {
					$rt_movie_meta_basic_rating = (int)$rt_movie_meta_basic_rating;
				}
				if ( $rt_movie_meta_basic_rating >= 1 && $rt_movie_meta_basic_rating <= 5 ) {
					// Update the meta field in the database.
					update_post_meta( $post_id, 'rt-movie-meta-basic-rating', $rt_movie_meta_basic_rating );
				}
			}

			if ( isset( $_POST[ 'rt-movie-meta-basic-runtime' ] ) ) {
				// Sanitize user input.
				$rt_movie_meta_basic_runtime = sanitize_text_field( $_POST[ 'rt-movie-meta-basic-runtime' ] );
				//Validate user input.
				if ( ! is_numeric( $rt_movie_meta_basic_runtime ) ) {
					$rt_movie_meta_basic_runtime = (int)$rt_movie_meta_basic_runtime;
				}
				if ( $rt_movie_meta_basic_runtime >= 1 && $rt_movie_meta_basic_runtime <= 1000 ) {
					update_post_meta( $post_id, 'rt-movie-meta-basic-runtime', $rt_movie_meta_basic_runtime );
				}
			}

			if ( isset( $_POST[ 'rt-movie-meta-basic-release-date' ] ) ) {
				// Sanitize user input.
				$rt_movie_meta_basic_release_date = sanitize_text_field( $_POST[ 'rt-movie-meta-basic-release-date' ] );
				// Update the meta field in the database.
				update_post_meta( $post_id, 'rt-movie-meta-basic-release-date', $rt_movie_meta_basic_release_date );
			}
		}

		/**
		 * @function set_object_terms
		 *           This function is used to update the post meta and set the object terms
		 *
		 * @param int    $post_id
		 * @param mixed  $terms
		 * @param string $key
		 *
		 * @return void
		 */
		private function set_object_terms( int $post_id, mixed $terms, string $key ): void {
			update_post_meta( $post_id, $key, $terms );
			wp_set_object_terms( $post_id, $terms, '_rt-movie-person', true );
		}
	}
}
