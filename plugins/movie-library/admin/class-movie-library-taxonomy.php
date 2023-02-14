<?php
/**
 * This file is used to create the taxonomy for the plugin.
 */

namespace MovieLib;

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'MovieLib\Movie_Library_Taxonomy' ) ) {
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
						'labels'            => array(
							'name'                       => _x( 'Genres', 'taxonomy general name', 'movie-library' ),
							'singular_name'              => _x( 'Genre', 'taxonomy singular name', 'movie-library' ),
							'search_items'               => __( 'Search Genres', 'movie-library' ),
							'popular_items'              => __( 'Popular Genres', 'movie-library' ),
							'all_items'                  => __( 'All Genres', 'movie-library' ),
							'parent_item'                => null,
							'parent_item_colon'          => null,
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
						'hierarchical'      => true,
						'show_ui'           => true,
						'show_admin_column' => true,
						'query_var'         => true,
						'rewrite'           => array( 'slug' => 'genre' ),
					),
				),
			);
			return $custom_taxonomies_array;
		}
	}
}