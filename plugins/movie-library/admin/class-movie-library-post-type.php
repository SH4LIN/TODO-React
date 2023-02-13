<?php

namespace MovieLib;

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'MovieLib\Movie_Library_Post_type' ) ) {
	/**
	 * Main Custom_Post_type Class.
	 *
	 * @class   Custom_Post_Type
	 * @version 1.0.0
	 */
	class Movie_Library_Post_type {
		public function register_custom_post_type(): void {
			$custom_post_types = $this->get_custom_post_types();
			foreach ( $custom_post_types as $custom_post_type ) {
				register_post_type( $custom_post_type[ 'post_type' ], $custom_post_type[ 'args' ] );
			}
		}

		private function get_custom_post_types(): array {
			return [
				[
					'post_type' => 'rt-movie',
					'args'      => [
						'labels'             => [
							'name'                  => _x( 'Movies', 'Post type general name', 'movie-library' ),
							'singular_name'         => _x( 'Movie', 'Post type singular name', 'movie-library' ),
							'menu_name'             => _x( 'Movies', 'Admin Menu text', 'movie-library' ),
							'name_admin_bar'        => _x( 'Movie', 'Add New on Toolbar', 'movie-library' ),
							'add_new'               => __( 'Add New', 'movie-library' ),
							'add_new_item'          => __( 'Add New Movie', 'movie-library' ),
							'new_item'              => __( 'New Movie', 'movie-library' ),
							'edit_item'             => __( 'Edit Movie', 'movie-library' ),
							'view_item'             => __( 'View Movie', 'movie-library' ),
							'all_items'             => __( 'All Movies', 'movie-library' ),
							'search_items'          => __( 'Search Movies', 'movie-library' ),
							'parent_item_colon'     => __( 'Parent Movies:', 'movie-library' ),
							'not_found'             => __( 'No movies found.', 'movie-library' ),
							'not_found_in_trash'    => __( 'No movies found in Trash.', 'movie-library' ),
							'featured_image'        => _x( 'Movie Poster', 'movie', 'movie-library' ),
							'set_featured_image'    => _x( 'Set Movie Poster', 'movie', 'movie-library' ),
							'remove_featured_image' => _x( 'Remove Movie Poster', 'movie', 'movie-library' ),
							'use_featured_image'    => _x( 'Use as Movie Poster', 'movie', 'movie-library' ),
							'archives'              => _x( 'Movie archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'movie-library' ),
						],
						'description'        => __( 'Description.', 'movie-library' ),
						'public'             => true,
						'publicly_queryable' => true,
						'show_ui'            => true,
						'show_in_menu'       => true,
						'query_var'          => true,
						'rewrite'            => true,
						'capability_type'    => 'post',
						'has_archive'        => 'movies',
						'hierarchical'       => false,
						'menu_position'      => null,
						'menu_icon'          => 'dashicons-format-video',
						'supports'           => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ],
						'show_in_rest'       => true,
					],
				],
				[
					'post_type' => 'rt-person',
					'args'      => [
						'labels'             => [
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
							'featured_image'        => _x( 'Person Photo', 'person', 'movie-library' ),
							'set_featured_image'    => _x( 'Set Person Photo', 'person', 'movie-library' ),
							'remove_featured_image' => _x( 'Remove Person Photo', 'person', 'movie-library' ),
							'use_featured_image'    => _x( 'Use as Person Photo', 'person', 'movie-library' ),
							'archives'              => _x( 'Person archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'movie-library' ),
						],
						'description'        => __( 'Description.', 'movie-library' ),
						'public'             => true,
						'publicly_queryable' => true,
						'show_ui'            => true,
						'show_in_menu'       => true,
						'query_var'          => true,
						'rewrite'            => true,
						'capability_type'    => 'post',
						'has_archive'        => 'people',
						'hierarchical'       => false,
						'menu_position'      => null,
						'menu_icon'          => 'dashicons-businessman',
						'supports'           => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt' ],
						'show_in_rest'       => true,
					]
				]
			];
		}
	}
}