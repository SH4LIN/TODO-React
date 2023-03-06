<?php
/**
 * This file is used to create rt-movie custom post type.
 *
 * @package MovieLib\admin\classes\custom-post-types
 */

namespace MovieLib\admin\classes\custom_post_types;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\custom_post_types\RT_Movie' ) ) {

	/**
	 * This class is used to create rt-movie custom post type.
	 */
	class RT_Movie {

		/**
		 * RT_MOVIE_SLUG
		 */
		const SLUG = 'rt-movie';

		/**
		 * Variable instance.
		 *
		 * @var ?RT_Movie $instance The single instance of the class.
		 */
		protected static ?RT_Movie $instance = null;

		/**
		 *  Main RT_Movie Instance.
		 *  Ensures only one instance of RT_MOVIE is loaded or can be loaded.
		 *
		 * @return RT_Movie - Main instance.
		 */
		public static function instance(): RT_Movie {

			if ( is_null( self::$instance ) ) {

				self::$instance = new self();

			}

			return self::$instance;
		}

		/**
		 * RT_Movie Constructor.
		 */
		private function __construct() {}

		/**
		 * This function is used to register rt-movie custom post type.
		 *
		 * @return void
		 */
		public function register(): void {
			$args = array(
				'labels'             => array(
					'name'                  => __( 'Movies', 'movie-library' ),
					'singular_name'         => __( 'Movie', 'movie-library' ),
					'menu_name'             => __( 'Movies', 'movie-library' ),
					'name_admin_bar'        => __( 'Movie', 'movie-library' ),
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
					'archives'              => _x(
						'Movie archives',
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
				'has_archive'        => 'movies',
				'hierarchical'       => false,
				'menu_position'      => null,
				'menu_icon'          => 'dashicons-format-video',
				'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
				'show_in_rest'       => true,
			);

			register_post_type( self::SLUG, $args ); // phpcs:ignore WordPress.NamingConventions.ValidPostTypeSlug.NotStringLiteral
		}
	}
}
