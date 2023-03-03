<?php
/**
 * This file is used to register rt-movie-genre taxonomy.
 *
 * @package MovieLib\admin\classes\taxonomies
 */

namespace MovieLib\admin\classes\taxonomies;

use const MovieLib\admin\classes\custom_post_types\RT_MOVIE_SLUG;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

/**
 * RT_MOVIE_GENRE_SLUG
 */
const RT_MOVIE_GENRE_SLUG = 'rt-movie-genre';

if ( ! class_exists( 'MovieLib\admin\classes\taxonomies\Movie_Genre' ) ) {

	/**
	 * This class is used to register rt-movie-genre taxonomy.
	 */
	class Movie_Genre {

		/**
		 * Variable instance.
		 *
		 * @var ?Movie_Genre $instance The single instance of the class.
		 */
		protected static ?Movie_Genre $instance = null;

		/**
		 *  Main Movie_Genre Instance.
		 *  Ensures only one instance of Movie_Genre is loaded or can be loaded.
		 *
		 * @return Movie_Genre - Main instance.
		 */
		public static function instance(): Movie_Genre {

			if ( is_null( self::$instance ) ) {

				self::$instance = new self();

			}

			return self::$instance;
		}

		/**
		 * Movie_Genre Constructor.
		 */
		private function __construct() {}

		/**
		 * This function is used to register rt-movie-genre taxonomy.
		 *
		 * @return void
		 */
		public function register():void {
			$rt_movie_genre = array(
				'taxonomy'  => RT_MOVIE_GENRE_SLUG,
				'post_type' => array( RT_MOVIE_SLUG ),
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
					'rewrite'            => false,
				),
			);

			register_taxonomy( $rt_movie_genre['taxonomy'], $rt_movie_genre['post_type'], $rt_movie_genre['args'] );
		}

	}
}
