<?php
/**
 * This file is used to register rt-movie-tag taxonomy.
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

if ( ! class_exists( 'MovieLib\admin\classes\taxonomies\Movie_Tag' ) ) {

	/**
	 * This class is used to register rt-movie-production-company taxonomy.
	 */
	class Movie_Tag {

		use Singleton;

		/**
		 * RT_MOVIE_TAG_SLUG
		 */
		const SLUG = 'rt-movie-tag';

		/**
		 * Movie_Tag init method.
		 *
		 * @return void
		 */
		protected function init(): void {

			add_action( 'init', array( $this, 'register' ) );

		}

		/**
		 * This function is used to register rt-movie-tag taxonomy.
		 *
		 * @return void
		 */
		public function register():void {
			$rt_movie_tag = array(
				'taxonomy'  => self::SLUG,
				'post_type' => array( RT_Movie::SLUG ),
				'args'      => array(
					'labels'             => array(
						'name'                       => __( 'Tags', 'movie-library' ),
						'singular_name'              => __( 'Tag', 'movie-library' ),
						'search_items'               => __( 'Search Tags', 'movie-library' ),
						'popular_items'              => __( 'Popular Tags', 'movie-library' ),
						'all_items'                  => __( 'All Tag', 'movie-library' ),
						'parent_item'                => __( 'Parent Tag', 'movie-library' ),
						'parent_item_colon'          => __( 'Parent Tag:', 'movie-library' ),
						'edit_item'                  => __( 'Edit Tag', 'movie-library' ),
						'update_item'                => __( 'Update Tag', 'movie-library' ),
						'add_new_item'               => __( 'Add New Tag', 'movie-library' ),
						'new_item_name'              => __( 'New Tag Name', 'movie-library' ),
						'separate_items_with_commas' => __( 'Separate Tags with commas', 'movie-library' ),
						'add_or_remove_items'        => __( 'Add or remove Tags', 'movie-library' ),
						'choose_from_most_used'      => __( 'Choose from the most used Tags', 'movie-library' ),
						'not_found'                  => __( 'No Tags found.', 'movie-library' ),
						'menu_name'                  => __( 'Tags', 'movie-library' ),
					),
					'hierarchical'       => false,
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

			register_taxonomy( $rt_movie_tag['taxonomy'], $rt_movie_tag['post_type'], $rt_movie_tag['args'] );
		}

	}
}
