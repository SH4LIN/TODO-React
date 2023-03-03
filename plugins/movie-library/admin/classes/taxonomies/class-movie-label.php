<?php
/**
 * This file is used to register rt-movie-label taxonomy.
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
 * RT_MOVIE_LABEL_SLUG
 */
const RT_MOVIE_LABEL_SLUG = 'rt-movie-label';

if ( ! class_exists( 'MovieLib\admin\classes\taxonomies\Movie_Label' ) ) {

	/**
	 * This class is used to register rt-movie-label taxonomy.
	 */
	class Movie_Label {

		/**
		 * Variable instance.
		 *
		 * @var ?Movie_Label $instance The single instance of the class.
		 */
		protected static ?Movie_Label $instance = null;

		/**
		 *  Main Movie_Label Instance.
		 *  Ensures only one instance of Movie_Label is loaded or can be loaded.
		 *
		 * @return Movie_Label - Main instance.
		 */
		public static function instance(): Movie_Label {

			if ( is_null( self::$instance ) ) {

				self::$instance = new self();

			}

			return self::$instance;
		}

		/**
		 * Movie_Label Constructor.
		 */
		private function __construct() {}

		/**
		 * This function is used to register rt-movie-label taxonomy.
		 *
		 * @return void
		 */
		public function register():void {
			$rt_movie_label = array(
				'taxonomy'  => RT_MOVIE_LABEL_SLUG,
				'post_type' => array( RT_MOVIE_SLUG ),
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
					'rewrite'            => false,
				),
			);

			register_taxonomy( $rt_movie_label['taxonomy'], $rt_movie_label['post_type'], $rt_movie_label['args'] );
		}

	}
}
