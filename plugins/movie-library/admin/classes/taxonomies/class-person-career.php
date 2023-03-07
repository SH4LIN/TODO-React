<?php
/**
 * This file is used to register rt-person-career taxonomy.
 *
 * @package MovieLib\admin\classes\taxonomies
 */

namespace MovieLib\admin\classes\taxonomies;

use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\includes\Singleton;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\taxonomies\Person_Career' ) ) {

	/**
	 * This class is used to register rt-person-career taxonomy.
	 */
	class Person_Career {

		use Singleton;

		/**
		 * RT_PERSON_CAREER_SLUG
		 */
		const SLUG = 'rt-person-career';

		/**
		 * Person_Career init method.
		 *
		 * @return void
		 */
		protected function init(): void {

			$this->register();

		}

		/**
		 * This function is used to register rt-person-career taxonomy.
		 *
		 * @return void
		 */
		public function register(): void {
			$rt_person_career = array(
				'taxonomy'  => self::SLUG,
				'post_type' => array( RT_Person::SLUG ),
				'args'      => array(
					'labels'             => array(
						'name'                       => __( 'Careers', 'movie-library' ),
						'singular_name'              => __( 'Career', 'movie-library' ),
						'search_items'               => __( 'Search Careers', 'movie-library' ),
						'popular_items'              => __( 'Popular Careers', 'movie-library' ),
						'all_items'                  => __( 'All Career', 'movie-library' ),
						'parent_item'                => __( 'Parent Career', 'movie-library' ),
						'parent_item_colon'          => __( 'Parent Career:', 'movie-library' ),
						'edit_item'                  => __( 'Edit Career', 'movie-library' ),
						'update_item'                => __( 'Update Career', 'movie-library' ),
						'add_new_item'               => __( 'Add New Career', 'movie-library' ),
						'new_item_name'              => __( 'New Career Name', 'movie-library' ),
						'separate_items_with_commas' => __( 'Separate Careers with commas', 'movie-library' ),
						'add_or_remove_items'        => __( 'Add or remove Careers', 'movie-library' ),
						'choose_from_most_used'      => __( 'Choose from the most used Careers', 'movie-library' ),
						'not_found'                  => __( 'No Careers found.', 'movie-library' ),
						'menu_name'                  => __( 'Careers', 'movie-library' ),
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

			register_taxonomy( $rt_person_career['taxonomy'], $rt_person_career['post_type'], $rt_person_career['args'] );
		}
	}
}

