<?php
/**
 * This file is used to create rt-person custom post type.
 *
 * @package MovieLib\admin\classes\custom-post-types
 */

namespace MovieLib\admin\classes\custom_post_types;

use MovieLib\admin\classes\taxonomies\Person_Career;
use MovieLib\includes\Singleton;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\custom_post_types\RT_Person' ) ) {

	/**
	 * This class is used to create rt-person custom post type.
	 */
	class RT_Person {

		use Singleton;

		/**
		 * RT_PERSON_SLUG
		 */
		const SLUG = 'rt-person';

		/**
		 * RT_Person init method.
		 *
		 * @return void
		 */
		protected function init():void {

			add_action( 'init', array( $this, 'register' ) );
			add_action( 'init', array( $this, 'change_permalink_structure' ), 11 );
			add_filter( 'post_type_link', array( $this, 'change_permalink' ), 10, 2 );

		}

		/**
		 * This function is used to register rt-person custom post type.
		 *
		 * @return void
		 */
		public function register(): void {
			$args = array(
				'labels'             => array(
					'name'                  => __( 'Persons', 'movie-library' ),
					'singular_name'         => __( 'Person', 'movie-library' ),
					'menu_name'             => __( 'Persons', 'movie-library' ),
					'name_admin_bar'        => __( 'Person', 'movie-library' ),
					'add_new'               => __( 'Add New', 'movie-library' ),
					'add_new_item'          => __( 'Add New Person', 'movie-library' ),
					'new_item'              => __( 'New Person', 'movie-library' ),
					'edit_item'             => __( 'Edit Person', 'movie-library' ),
					'view_item'             => __( 'View Person', 'movie-library' ),
					'all_items'             => __( 'All Persons', 'movie-library' ),
					'search_items'          => __( 'Search Persons', 'movie-library' ),
					'parent_item_colon'     => __( 'Parent Persons:', 'movie-library' ),
					'not_found'             => __( 'No Persons found.', 'movie-library' ),
					'not_found_in_trash'    => __( 'No Persons found in Trash.', 'movie-library' ),
					'featured_image'        => __( 'Profile picture', 'movie-library' ),
					'set_featured_image'    => __( 'Set Profile picture', 'movie-library' ),
					'remove_featured_image' => __( 'Remove Profile picture', 'movie-library' ),
					'use_featured_image'    => __( 'Use as Profile picture', 'movie-library' ),
					'archives'              => __(
						'Person archives',
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
				'menu_icon'          => 'dashicons-businessman',
				'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
				'show_in_rest'       => true,
			);

			register_post_type( self::SLUG, $args ); // phpcs:ignore WordPress.NamingConventions.ValidPostTypeSlug.NotStringLiteral
		}

		/**
		 * This function is used to change the permalink structure of rt-person post type.
		 *
		 * @return void
		 */
		public function change_permalink_structure() {
			global $wp_rewrite;

			$args = $wp_rewrite->extra_permastructs[ self::SLUG ];

			remove_permastruct( self::SLUG );

			unset( $args['struct'] );

			$args['with_front'] = false;

			$career_slug = Person_Career::SLUG;
			$wp_rewrite->add_permastruct(
				self::SLUG,
				"/person/%$career_slug%/%rt-person%-%post_id%",
				$args
			);
		}

		/**
		 * This function is used to change the permalink of rt-person post type.
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

			$terms = get_the_terms( $post->ID, Person_Career::SLUG );

			if ( ! is_wp_error( $terms ) && ! empty( $terms ) && is_object( $terms[0] ) ) {
				$term = $terms[0]->slug;
			} else {
				$term = 'uncategorized';
			}

			$career_slug = Person_Career::SLUG;
			$post_link   = str_replace( "%$career_slug%", $term, $post_link );

			$post_link = str_replace( '%post_id%', $post->ID, $post_link );

			return $post_link;
		}
	}
}
