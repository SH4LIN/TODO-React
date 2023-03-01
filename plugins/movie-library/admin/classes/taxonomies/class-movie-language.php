<?php
/**
 * This file is used to register rt-movie-language taxonomy.
 *
 * @package MovieLib\admin\classes\taxonomies
 */

namespace MovieLib\admin\classes\taxonomies;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\taxonomies\Movie_Language' ) ) {

	/**
	 * This class is used to register rt-movie-language taxonomy.
	 */
	class Movie_Language {

		/**
		 * This function is used to register rt-movie-language taxonomy.
		 *
		 * @return void
		 */
		public function register():void {
			$rt_movie_language = array(
				'taxonomy'  => 'rt-movie-language',
				'post_type' => array( 'rt-movie' ),
				'args'      => array(
					'labels'             => array(
						'name'                       => _x( 'Languages', 'taxonomy general name', 'movie-library' ),
						'singular_name'              => _x( 'Language', 'taxonomy singular name', 'movie-library' ),
						'search_items'               => __( 'Search Languages', 'movie-library' ),
						'popular_items'              => __( 'Popular Languages', 'movie-library' ),
						'all_items'                  => __( 'All Languages', 'movie-library' ),
						'parent_item'                => __( 'Parent Language', 'movie-library' ),
						'parent_item_colon'          => __( 'Parent Language:', 'movie-library' ),
						'edit_item'                  => __( 'Edit Language', 'movie-library' ),
						'update_item'                => __( 'Update Language', 'movie-library' ),
						'add_new_item'               => __( 'Add New Language', 'movie-library' ),
						'new_item_name'              => __( 'New Language Name', 'movie-library' ),
						'separate_items_with_commas' => __( 'Separate Languages with commas', 'movie-library' ),
						'add_or_remove_items'        => __( 'Add or remove Languages', 'movie-library' ),
						'choose_from_most_used'      => __(
							'Choose from the most used Languages',
							'movie-library'
						),
						'not_found'                  => __( 'No Languages found.', 'movie-library' ),
						'menu_name'                  => __( 'Languages', 'movie-library' ),
					),
					'hierarchical'       => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'show_in_nav_menus'  => true,
					'show_admin_column'  => true,
					'show_in_quick_edit' => true,
					'show_in_rest'       => true,
					'query_var'          => true,
					'public'             => true,
					'publicly_queryable' => true,
					'rewrite'            => false,
				),
			);

			register_taxonomy( $rt_movie_language['taxonomy'], $rt_movie_language['post_type'], $rt_movie_language['args'] );
		}

	}
}
