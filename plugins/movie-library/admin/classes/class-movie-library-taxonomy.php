<?php
/**
 * This file is used to create the taxonomy for the plugin.
 *
 * @package MovieLib\admin\classes
 */

namespace MovieLib\admin\classes;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\Movie_Library_Taxonomy' ) ) {
	/**
	 * @class Movie_Library_Taxonomy
	 * This class contains all the functions to create the taxonomy for the plugin.
	 */
	class Movie_Library_Taxonomy {
		function register_custom_taxonomy(): void {
			$custom_taxonomies = $this->get_custom_taxonomies();
			foreach ( $custom_taxonomies as $custom_taxonomy ) {
				register_taxonomy( $custom_taxonomy[ 'taxonomy' ], $custom_taxonomy[ 'post_type' ], $custom_taxonomy[ 'args' ] );
			}
			flush_rewrite_rules();
		}

		function get_custom_taxonomies(): array {
			$custom_taxonomies_array = array(
				array(
					'taxonomy'  => 'rt-movie-genre',
					'post_type' => array( 'rt-movie' ),
					'args'      => array(
						'labels'             => array(
							'name'                       => _x( 'Genres', 'taxonomy general name', 'movie-library' ),
							'singular_name'              => _x( 'Genre', 'taxonomy singular name', 'movie-library' ),
							'search_items'               => __( 'Search Genres', 'movie-library' ),
							'popular_items'              => __( 'Popular Genres', 'movie-library' ),
							'all_items'                  => __( 'All Genres', 'movie-library' ),
							'parent_item'                => __( 'Parent Genre', 'movie-library' ),
							'parent_item_colon'          => __( 'Parent Genre:', 'movie-library' ),
							'edit_item'                  => __( 'Edit Genre', 'movie-library' ),
							'update_item'                => __( 'Update Genre', 'movie-library' ),
							'add_new_item'               => __( 'Add New Genre', 'movie-library' ),
							'new_item_name'              => __( 'New Genre Name', 'movie-library' ),
							'separate_items_with_commas' => __( 'Separate genres with commas', 'movie-library' ),
							'add_or_remove_items'        => __( 'Add or remove genres', 'movie-library' ),
							'choose_from_most_used'      => __( 'Choose from the most used genres', 'movie-library' ),
							'not_found'                  => __( 'No genres found.', 'movie-library' ),
							'menu_name'                  => __( 'Genres', 'movie-library' ),
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
						'rewrite'            => array( 'slug' => 'rt-movie-genre' ),
					),
				),
				array(
					'taxonomy'  => 'rt-movie-label',
					'post_type' => array( 'rt-movie' ),
					'args'      => array(
						'labels'             => array(
							'name'                       => _x( 'Labels', 'taxonomy general name', 'movie-library' ),
							'singular_name'              => _x( 'Label', 'taxonomy singular name', 'movie-library' ),
							'search_items'               => __( 'Search Labels', 'movie-library' ),
							'popular_items'              => __( 'Popular Labels', 'movie-library' ),
							'all_items'                  => __( 'All Labels', 'movie-library' ),
							'parent_item'                => __( 'Parent Label', 'movie-library' ),
							'parent_item_colon'          => __( 'Parent Label:', 'movie-library' ),
							'edit_item'                  => __( 'Edit Label', 'movie-library' ),
							'update_item'                => __( 'Update Label', 'movie-library' ),
							'add_new_item'               => __( 'Add New Genre', 'movie-library' ),
							'new_item_name'              => __( 'New Genre Name', 'movie-library' ),
							'separate_items_with_commas' => __( 'Separate labels with commas', 'movie-library' ),
							'add_or_remove_items'        => __( 'Add or remove labels', 'movie-library' ),
							'choose_from_most_used'      => __( 'Choose from the most used labels', 'movie-library' ),
							'not_found'                  => __( 'No labels found.', 'movie-library' ),
							'menu_name'                  => __( 'Labels', 'movie-library' ),
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
						'rewrite'            => array( 'slug' => 'rt-movie-label' ),
					),
				),
				array(
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
							'choose_from_most_used'      => __( 'Choose from the most used Languages', 'movie-library' ),
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
						'rewrite'            => array( 'slug' => 'rt-movie-language' ),
					),
				),
				array(
					'taxonomy'  => 'rt-movie-production-company',
					'post_type' => array( 'rt-movie' ),
					'args'      => array(
						'labels'             => array(
							'name'                       => _x( 'Production companies', 'taxonomy general name', 'movie-library' ),
							'singular_name'              => _x( 'Production company', 'taxonomy singular name', 'movie-library' ),
							'search_items'               => __( 'Search Production companies', 'movie-library' ),
							'popular_items'              => __( 'Popular Production companies', 'movie-library' ),
							'all_items'                  => __( 'All Production company', 'movie-library' ),
							'parent_item'                => __( 'Parent Production company', 'movie-library' ),
							'parent_item_colon'          => __( 'Parent Production company:', 'movie-library' ),
							'edit_item'                  => __( 'Edit Production company', 'movie-library' ),
							'update_item'                => __( 'Update Production company', 'movie-library' ),
							'add_new_item'               => __( 'Add New Production company', 'movie-library' ),
							'new_item_name'              => __( 'New Production company Name', 'movie-library' ),
							'separate_items_with_commas' => __( 'Separate Production companies with commas', 'movie-library' ),
							'add_or_remove_items'        => __( 'Add or remove Production companies', 'movie-library' ),
							'choose_from_most_used'      => __( 'Choose from the most used Production companies', 'movie-library' ),
							'not_found'                  => __( 'No Production companies found.', 'movie-library' ),
							'menu_name'                  => __( 'Production companies', 'movie-library' ),
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
						'rewrite'            => array( 'slug' => 'rt-movie-production-company' ),
					),
				),
				array(
					'taxonomy'  => 'rt-movie-tag',
					'post_type' => array( 'rt-movie' ),
					'args'      => array(
						'labels'             => array(
							'name'                       => _x( 'Tags', 'taxonomy general name', 'movie-library' ),
							'singular_name'              => _x( 'Tag', 'taxonomy singular name', 'movie-library' ),
							'search_items'               => __( 'Search Tags', 'movie-library' ),
							'popular_items'              => __( 'Popular Tags', 'movie-library' ),
							'all_items'                  => __( 'All Tag', 'movie-library' ),
							'parent_item'                => __( 'Parent Tag', 'movie-library' ),
							'parent_item_colon'          => __( 'Parent Tag:', 'movie-library' ),
							'edit_item'                  => __( 'Edit Tag', 'movie-library' ),
							'update_item'                => __( 'Update Tag', 'movie-library' ),
							'add_new_item'               => __( 'Add New Tag', 'movie-library' ),
							'new_item_name'              => __( 'New Tag Name', 'movie-library' ),
							'separate_items_with_commas' => __( 'Separate Tags with commas', 'movie-library' ),
							'add_or_remove_items'        => __( 'Add or remove Tags', 'movie-library' ),
							'choose_from_most_used'      => __( 'Choose from the most used Tags', 'movie-library' ),
							'not_found'                  => __( 'No Tags found.', 'movie-library' ),
							'menu_name'                  => __( 'Tags', 'movie-library' ),
						),
						'hierarchical'       => false,
						'show_ui'            => true,
						'show_in_menu'       => true,
						'show_in_nav_menus'  => true,
						'show_admin_column'  => true,
						'show_in_quick_edit' => true,
						'show_in_rest'       => true,
						'query_var'          => true,
						'public'             => true,
						'publicly_queryable' => true,
						'rewrite'            => array( 'slug' => 'rt-movie-tag' ),
					),
				),
				array(
					'taxonomy'  => '_rt-movie-person',
					'post_type' => array( 'rt-movie' ),
					'args'      => array(
						'label'              => __( 'Internal Markers', 'movie-library' ),
						'hierarchical'       => false,
						'show_ui'            => true,
						'show_in_menu'       => true,
						'show_in_nav_menus'  => true,
						'show_admin_column'  => true,
						'show_in_quick_edit' => true,
						'show_in_rest'       => true,
						'query_var'          => false,
						'public'             => false,
						'publicly_queryable' => false,
						'rewrite'            => false,
					),
				),
				array(
					'taxonomy'  => 'rt-person-career',
					'post_type' => array( 'rt-person' ),
					'args'      => array(
						'labels'             => array(
							'name'                       => _x( 'Careers', 'taxonomy general name', 'movie-library' ),
							'singular_name'              => _x( 'Career', 'taxonomy singular name', 'movie-library' ),
							'search_items'               => __( 'Search Careers', 'movie-library' ),
							'popular_items'              => __( 'Popular Careers', 'movie-library' ),
							'all_items'                  => __( 'All Career', 'movie-library' ),
							'parent_item'                => __( 'Parent Career', 'movie-library' ),
							'parent_item_colon'          => __( 'Parent Career:', 'movie-library' ),
							'edit_item'                  => __( 'Edit Career', 'movie-library' ),
							'update_item'                => __( 'Update Career', 'movie-library' ),
							'add_new_item'               => __( 'Add New Career', 'movie-library' ),
							'new_item_name'              => __( 'New Career Name', 'movie-library' ),
							'separate_items_with_commas' => __( 'Separate Careers with commas', 'movie-library' ),
							'add_or_remove_items'        => __( 'Add or remove Careers', 'movie-library' ),
							'choose_from_most_used'      => __( 'Choose from the most used Careers', 'movie-library' ),
							'not_found'                  => __( 'No Careers found.', 'movie-library' ),
							'menu_name'                  => __( 'Careers', 'movie-library' ),
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
						'rewrite'            => array( 'slug' => 'rt-person-career' ),
					),
				),
			);
			return $custom_taxonomies_array;
		}
	}
}
