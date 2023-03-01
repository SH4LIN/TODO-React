<?php
/**
 * This file is used to register rt-movie-person shadow taxonomy.
 *
 * @package MovieLib\admin\classes\taxonomies
 */

namespace MovieLib\admin\classes\taxonomies;

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
		 * This function is used to register rt-movie-person shadow taxonomy.
		 *
		 * @return void
		 */
		public function register():void {
			$rt_movie_person = array(
				'taxonomy'  => '_rt-movie-person',
				'post_type' => array( 'rt-movie' ),
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
