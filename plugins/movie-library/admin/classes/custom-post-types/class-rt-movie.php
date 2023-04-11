<?php
/**
 * This file is used to create rt-movie custom post type.
 *
 * @package MovieLib\admin\classes\custom-post-types
 */

namespace MovieLib\admin\classes\custom_post_types;

use MovieLib\admin\classes\taxonomies\Movie_Genre;
use MovieLib\includes\Singleton;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\custom_post_types\RT_Movie' ) ) {

	/**
	 * This class is used to create rt-movie custom post type.
	 */
	class RT_Movie {

		use Singleton;

		/**
		 * RT_MOVIE_SLUG
		 */
		const SLUG = 'rt-movie';

		/**
		 * RT_Movie init method.
		 *
		 * @return void
		 */
		protected function init(): void {

			add_action( 'init', array( $this, 'register' ) );
			add_action( 'init', array( $this, 'change_permalink_structure' ), 11 );
			add_filter( 'post_type_link', array( $this, 'change_permalink' ), 10, 2 );

		}

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
					'featured_image'        => __( 'Movie Poster', 'movie-library' ),
					'set_featured_image'    => __( 'Set Movie Poster', 'movie-library' ),
					'remove_featured_image' => __( 'Remove Movie Poster', 'movie-library' ),
					'use_featured_image'    => __( 'Use as Movie Poster', 'movie-library' ),
					'archives'              => __(
						'Movie archives',
						'movie-library'
					),
				),
				'description'        => __( 'Description.', 'movie-library' ),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'capability_type'    => 'post',
				'has_archive'        => true,
				'menu_icon'          => 'dashicons-format-video',
				'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
				'show_in_rest'       => true,
			);

			register_post_type( self::SLUG, $args ); // phpcs:ignore WordPress.NamingConventions.ValidPostTypeSlug.NotStringLiteral
		}

		/**
		 * This function is used to change the permalink structure of rt-movie post type.
		 *
		 * @return void
		 */
		public function change_permalink_structure() {
			global $wp_rewrite;

			$args = $wp_rewrite->extra_permastructs[ self::SLUG ];

			remove_permastruct( self::SLUG );

			unset( $args['struct'] );

			$args['with_front'] = false;

			$genre_slug = Movie_Genre::SLUG;
			$wp_rewrite->add_permastruct(
				self::SLUG,
				"/movie/%${genre_slug}%/%rt-movie%-%post_id%",
				$args
			);
		}

		/**
		 * This function is used to change the permalink of rt-movie post type.
		 *
		 * @param string $post_link The post's permalink.
		 * @param object $post      The post in question.
		 *
		 * @return string
		 */
		public function change_permalink( $post_link, $post ) {

			if ( self::SLUG !== $post->post_type ) {
				return $post_link;
			}

			$terms = get_the_terms( $post->ID, Movie_Genre::SLUG );

			if ( ! is_wp_error( $terms ) && ! empty( $terms ) && is_object( $terms[0] ) ) {
				$term = $terms[0]->slug;
			} else {
				$term = 'uncategorized';
			}

			$genre_slug = Movie_Genre::SLUG;
			$post_link  = str_replace( "%$genre_slug%", $term, $post_link );

			$post_link = str_replace( '%post_id%', $post->ID, $post_link );

			return $post_link;
		}
	}
}
