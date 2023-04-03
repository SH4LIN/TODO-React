<?php
/**
 * This file is used to add the movie manager role and capabilities.
 * Movie manager role will have capabilities to edit the rt-movie post type and rt-person post type.
 * and settings related to the movie-library plugin.
 *
 * @package MovieLib\admin\classes\roles-capabilities
 */

namespace MovieLib\admin\classes\roles_capabilities;

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\admin\classes\taxonomies\Movie_Genre;
use MovieLib\admin\classes\taxonomies\Movie_Label;
use MovieLib\admin\classes\taxonomies\Movie_Language;
use MovieLib\admin\classes\taxonomies\Movie_Production_Company;
use MovieLib\admin\classes\taxonomies\Movie_Tag;
use MovieLib\admin\classes\taxonomies\Person_Career;
use MovieLib\includes\Singleton;
use WP_Post_Type;
use WP_Taxonomy;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\roles_capabilities\Movie_Manager_Role_Capabilities' ) ) :

	/**
	 * This class is used to add the movie manager role and capabilities.
	 */
	class Movie_Manager_Role_Capabilities {

		use Singleton;

		/**
		 * Movie_Manager_Role_Capabilities init method.
		 *
		 * @return void
		 */
		public function init(): void {

		}

		public function add_movie_manager_role() {
			$capabilities = $this->get_movie_manager_capabilities();

			$admin_role = get_role( 'administrator' );
			foreach ( $capabilities as $capability ) {
				$admin_role->add_cap( $capability );
			}

			$capabilities = array_fill_keys( $capabilities, true );
			add_role( 'movie_manager', __( 'Movie Manager', 'movie-library' ), $capabilities );
			echo 'Movie Manager role added successfully.';

		}

		private function get_movie_manager_capabilities() {
			$capabilities = array();

			$post_types = array( RT_Movie::SLUG, RT_Person::SLUG );

			foreach ( $post_types as $post_type ) {
				$post_type_object = get_post_type_object( $post_type );

				if ( ! $post_type_object instanceof WP_Post_Type ) {
					continue;
				}

				$post_type_caps = (array) $post_type_object->cap;

				unset(
					$post_type_caps['edit_post'],
					$post_type_caps['read_post'],
					$post_type_caps['delete_post'],
					$post_type_caps['create_posts'],
				);

				$capabilities = array_merge( $capabilities, array_values( $post_type_caps ) );
			}

			$taxonomies = array(
				Movie_Genre::SLUG,
				Movie_Label::SLUG,
				Movie_Language::SLUG,
				Movie_Production_Company::SLUG,
				Movie_Tag::SLUG,
				Person_Career::SLUG,
			);

			foreach ( $taxonomies as $taxonomy ) {
				$taxonomy_object = get_taxonomy( $taxonomy );

				if ( ! $taxonomy_object instanceof WP_Taxonomy ) {
					continue;
				}

				$taxonomy_caps = (array) $taxonomy_object->cap;

				$capabilities = array_merge( $capabilities, array_values( $taxonomy_caps ) );
			}

			return array_unique( $capabilities );
		}

		public function remove_movie_manager_role() {
			$capabilities = $this->get_movie_manager_capabilities();

			$admin_role = get_role( 'administrator' );
			foreach ( $capabilities as $capability ) {
				$admin_role->remove_cap( $capability );
			}

			remove_role( 'movie_manager' );
		}

	}
endif;
