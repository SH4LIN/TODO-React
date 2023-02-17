<?php
/**
 * This file is used to handle all the operation while saving the post.
 *
 * @package MovieLib\admin\classes
 */

namespace MovieLib\admin\classes;

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
		public function save_post( $post_id, $post, $update ): void {
			if(wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
				return;
			}
			$post_type = get_post_type( $post_id );
			// Check the user's permissions.
			if ( isset( $_POST['post_type'] ) && ($_POST['post_type'] === 'rt-movie' || $post_type === 'rt-movie') ) {
				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return;
				}else{
					$this->save_rt_movie_post($post_id, $post, $update);
				}
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				}
			}
		}

		private function save_rt_movie_post($post_id, $post, $update): void {

			// Check if our nonce is set.
			if ( ! isset( $_POST['rt_movie_meta_nonce'] ) ) {
				return;
			}
			//Sanitize nonce
			$rt_movie_meta_nonce = sanitize_text_field( $_POST['rt_movie_meta_nonce'] );
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


			foreach ( $rt_career_terms as $rt_career_term ) {
				$key = 'rt-movie-meta-crew-' . $rt_career_term->slug;
				// Make sure that it is set.
				if ( isset( $_POST[ $key ] ) ) {
					$rt_movie_meta_crew = $_POST[$key];
					if(is_array($rt_movie_meta_crew) && count($rt_movie_meta_crew) > 0){
						$terms = array();
						foreach ($rt_movie_meta_crew as $crew){
							// Sanitize user input.
							$crew = sanitize_text_field($crew);
							//If value is empty than delete the term
							if(!empty($crew)){
								$terms[] = $crew;
							}

						}
						update_post_meta( $post_id, $key, $terms );
						wp_set_object_terms($post_id, $terms,'_rt-movie-person', true);
					}
				}else{
					update_post_meta( $post_id, $key, [] );
				}
			}




			foreach ($keys as $key){
				$exp = '/^rt-movie-meta-crew/';
				if (preg_match($exp, $key) === 1){


				}
			}
			// Make sure that it is set.
			if ( isset( $_POST['rt-movie-meta-basic-rating'] ) ) {
				// Sanitize user input.
				$rt_movie_meta_basic_rating = sanitize_text_field( $_POST['rt-movie-meta-basic-rating'] );
				//Validate user input.
				if ( ! is_numeric( $rt_movie_meta_basic_rating ) ) {
					$rt_movie_meta_basic_rating = (int)$rt_movie_meta_basic_rating;
				}
				if($rt_movie_meta_basic_rating > 5){
					$rt_movie_meta_basic_rating = 5;
				}elseif ($rt_movie_meta_basic_rating < 0){
					$rt_movie_meta_basic_rating = 0;
				}
				update_post_meta( $post_id, 'rt-movie-meta-basic-rating', $rt_movie_meta_basic_rating );
				// Update the meta field in the database.
			}

			if ( isset( $_POST['rt-movie-meta-basic-runtime'] ) ) {
				// Sanitize user input.
				$rt_movie_meta_basic_runtime = sanitize_text_field( $_POST['rt-movie-meta-basic-runtime'] );
				//Validate user input.
				if ( ! is_numeric( $rt_movie_meta_basic_runtime ) ) {
					$rt_movie_meta_basic_runtime = (int)$rt_movie_meta_basic_runtime;
				}
				update_post_meta( $post_id, 'rt-movie-meta-basic-runtime', $rt_movie_meta_basic_runtime );
			}

			if ( isset( $_POST['rt-movie-meta-basic-release-date'] ) ) {
				// Sanitize user input.
				$rt_movie_meta_basic_release_date = sanitize_text_field( $_POST['rt-movie-meta-basic-release-date'] );
				// Update the meta field in the database.
				update_post_meta( $post_id, 'rt-movie-meta-basic-release-date', $rt_movie_meta_basic_release_date );
			}

		}
	}
}