<?php
/**
 * This file is used to register rt-movie-person shadow taxonomy.
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
 * RT_MOVIE_PERSON_SLUG
 */
const RT_MOVIE_PERSON_SLUG = '_rt-movie-person';

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
				'taxonomy'  => RT_MOVIE_PERSON_SLUG,
				'post_type' => array( RT_MOVIE_SLUG ),
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
