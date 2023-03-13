<?php
/**
 * This file is used to register rt-movie-production-company taxonomy.
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

if ( ! class_exists( 'MovieLib\admin\classes\taxonomies\Movie_Production_Company' ) ) {

	/**
	 * This class is used to register rt-movie-production-company taxonomy.
	 */
	class Movie_Production_Company {

		use Singleton;

		/**
		 * RT_MOVIE_PRODUCTION_COMPANY_SLUG
		 */
		const SLUG = 'rt-movie-production-company';

		/**
		 * Movie_Production_Company init method.
		 *
		 * @return void
		 */
		protected function init(): void {

			$this->register();

		}

		/**
		 * This function is used to register rt-movie-production-company taxonomy.
		 *
		 * @return void
		 */
		public function register():void {
			$rt_movie_production_company = array(
				'taxonomy'  => self::SLUG,
				'post_type' => array( RT_Movie::SLUG ),
				'args'      => array(
					'labels'             => array(
						'name'                       => __(
							'Production companies',
							'movie-library'
						),
						'singular_name'              => __(
							'Production company',
							'movie-library'
						),
						'search_items'               => __( 'Search Production companies', 'movie-library' ),
						'popular_items'              => __( 'Popular Production companies', 'movie-library' ),
						'all_items'                  => __( 'All Production company', 'movie-library' ),
						'parent_item'                => __( 'Parent Production company', 'movie-library' ),
						'parent_item_colon'          => __( 'Parent Production company:', 'movie-library' ),
						'edit_item'                  => __( 'Edit Production company', 'movie-library' ),
						'update_item'                => __( 'Update Production company', 'movie-library' ),
						'add_new_item'               => __( 'Add New Production company', 'movie-library' ),
						'new_item_name'              => __( 'New Production company Name', 'movie-library' ),
						'separate_items_with_commas' => __(
							'Separate Production companies with commas',
							'movie-library'
						),
						'add_or_remove_items'        => __( 'Add or remove Production companies', 'movie-library' ),
						'choose_from_most_used'      => __(
							'Choose from the most used Production companies',
							'movie-library'
						),
						'not_found'                  => __( 'No Production companies found.', 'movie-library' ),
						'menu_name'                  => __( 'Production companies', 'movie-library' ),
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

			register_taxonomy( $rt_movie_production_company['taxonomy'], $rt_movie_production_company['post_type'], $rt_movie_production_company['args'] );
		}

	}
}