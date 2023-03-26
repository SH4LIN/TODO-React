<?php
/**
 * This file is used to register rt-movie-genre taxonomy.
 *
 * @package MovieLib\admin\classes\taxonomies
 */

namespace MovieLib\admin\classes\taxonomies;

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\includes\Singleton;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\taxonomies\Movie_Genre' ) ) {

	/**
	 * This class is used to register rt-movie-genre taxonomy.
	 */
	class Movie_Genre {

		use Singleton;

		/**
		 * RT_MOVIE_GENRE_SLUG
		 */
		const SLUG = 'rt-movie-genre';

		/**
		 * Movie_Genre init method.
		 *
		 * @return void
		 */
		protected function init(): void {

			add_action( 'init', array( $this, 'register' ) );

		}

		/**
		 * This function is used to register rt-movie-genre taxonomy.
		 *
		 * @return void
		 */
		public function register():void {
			$rt_movie_genre = array(
				'taxonomy'  => self::SLUG,
				'post_type' => array( RT_Movie::SLUG ),
				'args'      => array(
					'labels'             => array(
						'name'                       => __( 'Genres', 'movie-library' ),
						'singular_name'              => __( 'Genre', 'movie-library' ),
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
				),
			);

			register_taxonomy( $rt_movie_genre['taxonomy'], $rt_movie_genre['post_type'], $rt_movie_genre['args'] );
		}

	}
}
