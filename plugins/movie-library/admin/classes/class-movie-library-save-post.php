<?php
/**
 * This file is used to handle all the operation while saving the post.
 *
 * @package MovieLib\admin\classes
 */

namespace MovieLib\admin\classes;

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\includes\Singleton;
use WP_Post;
use MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Person_Meta_Box;



/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\Movie_Library_Save_Post' ) ) {

	/**
	 * This class is used to handle all the operation while saving the post.
	 */
	class Movie_Library_Save_Post {

		use Singleton;

		/**
		 * Movie_Library_Save_Post init method.
		 *
		 * @return void
		 */
		private function init(): void {}

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
		public function save_custom_post( int $post_id, WP_Post $post, bool $update ): void {

			if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
				return;
			}

			// Check is post type is rt-movie or rt-person.
			if ( RT_Movie::SLUG === $post->post_type ) {
				// Check the user's permissions.

				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				} else {

					$rt_movie_meta_box = RT_Movie_Meta_Box::instance();
					$rt_movie_meta_box->save_rt_movie_post( $post_id, $post, $update );

				}
			} elseif ( RT_Person::SLUG === $post->post_type ) {

				// Check the user's permissions.
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				} else {

					$rt_person_meta_box = RT_Person_Meta_Box::instance();
					$rt_person_meta_box->save_rt_person_post( $post_id, $post, $update );

				}
			} else {

				// Check the user's permissions.
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				}
			}
		}
	}
}
