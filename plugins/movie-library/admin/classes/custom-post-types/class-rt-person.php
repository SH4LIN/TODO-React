<?php
/**
 * This file is used to create rt-person custom post type.
 *
 * @package MovieLib\admin\classes\custom-post-types
 */

namespace MovieLib\admin\classes\custom_post_types;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

/**
 * RT_PERSON_SLUG
 */
const RT_PERSON_SLUG = 'rt-person';

if ( ! class_exists( 'MovieLib\admin\classes\custom_post_types\Rt_Person' ) ) {

	/**
	 * This class is used to create rt-person custom post type.
	 */
	class Rt_Person {

		/**
		 * This function is used to register rt-person custom post type.
		 *
		 * @return void
		 */
		public function register(): void {
			$args = array(
				'labels'             => array(
					'name'                  => _x( 'People', 'Post type general name', 'movie-library' ),
					'singular_name'         => _x( 'Person', 'Post type singular name', 'movie-library' ),
					'menu_name'             => _x( 'People', 'Admin Menu text', 'movie-library' ),
					'name_admin_bar'        => _x( 'Person', 'Add New on Toolbar', 'movie-library' ),
					'add_new'               => __( 'Add New', 'movie-library' ),
					'add_new_item'          => __( 'Add New Person', 'movie-library' ),
					'new_item'              => __( 'New Person', 'movie-library' ),
					'edit_item'             => __( 'Edit Person', 'movie-library' ),
					'view_item'             => __( 'View Person', 'movie-library' ),
					'all_items'             => __( 'All People', 'movie-library' ),
					'search_items'          => __( 'Search People', 'movie-library' ),
					'parent_item_colon'     => __( 'Parent People:', 'movie-library' ),
					'not_found'             => __( 'No people found.', 'movie-library' ),
					'not_found_in_trash'    => __( 'No people found in Trash.', 'movie-library' ),
					'featured_image'        => _x( 'Profile picture', 'person', 'movie-library' ),
					'set_featured_image'    => _x( 'Set Profile picture', 'person', 'movie-library' ),
					'remove_featured_image' => _x( 'Remove Profile picture', 'person', 'movie-library' ),
					'use_featured_image'    => _x( 'Use as Profile picture', 'person', 'movie-library' ),
					'archives'              => _x(
						'Person archives',
						'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4',
						'movie-library'
					),
				),
				'description'        => __( 'Description.', 'movie-library' ),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => false,
				'capability_type'    => 'post',
				'has_archive'        => 'people',
				'hierarchical'       => false,
				'menu_position'      => null,
				'menu_icon'          => 'dashicons-businessman',
				'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
				'show_in_rest'       => true,

			);

			register_post_type( RT_PERSON_SLUG, $args );

		}
	}
}
