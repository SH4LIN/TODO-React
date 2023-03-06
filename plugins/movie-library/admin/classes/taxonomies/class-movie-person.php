<?php
/**
 * This file is used to register rt-movie-person shadow taxonomy.
 *
 * @package MovieLib\admin\classes\taxonomies
 */

namespace MovieLib\admin\classes\taxonomies;

use MovieLib\admin\classes\custom_post_types\RT_Movie;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\taxonomies\Movie_Person' ) ) {

	/**
	 * This class is used to register rt-movie-person shadow taxonomy.
	 */
	class Movie_Person {

		/**
		 * RT_MOVIE_PERSON_SLUG
		 */
		const SLUG = '_rt-movie-person';

		/**
		 * Variable instance.
		 *
		 * @var ?Movie_Person $instance The single instance of the class.
		 */
		protected static ?Movie_Person $instance = null;

		/**
		 *  Main Movie_Person Instance.
		 *  Ensures only one instance of Movie_Person is loaded or can be loaded.
		 *
		 * @return Movie_Person - Main instance.
		 */
		public static function instance(): Movie_Person {

			if ( is_null( self::$instance ) ) {

				self::$instance = new self();

			}

			return self::$instance;
		}

		/**
		 * Movie_Person Constructor.
		 */
		private function __construct() {}

		/**
		 * This function is used to register rt-movie-person shadow taxonomy.
		 *
		 * @return void
		 */
		public function register():void {
			$rt_movie_person = array(
				'taxonomy'  => self::SLUG,
				'post_type' => array( RT_Movie::SLUG ),
				'args'      => array(
					'label'              => __( 'Internal Markers', 'movie-library' ),
					'hierarchical'       => false,
					'show_ui'            => false,
					'show_in_menu'       => false,
					'show_in_nav_menus'  => false,
					'show_admin_column'  => false,
					'show_in_quick_edit' => false,
					'show_in_rest'       => false,
					'query_var'          => false,
					'public'             => false,
					'publicly_queryable' => false,
					'rewrite'            => false,
				),
			);

			register_taxonomy( $rt_movie_person['taxonomy'], $rt_movie_person['post_type'], $rt_movie_person['args'] );
		}

	}
}
