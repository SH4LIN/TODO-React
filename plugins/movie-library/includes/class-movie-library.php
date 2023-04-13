<?php
/**
 * Core plugin class.
 *
 * @class    Movie_Library
 * @package  MovieLib\includes
 * @since    1.0.0
 * @version  1.0.0
 */

namespace MovieLib\includes;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

use MovieLib\admin\classes\Asset;
use MovieLib\admin\classes\custom_endpoints\Custom_Endpoint_Movie;
use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\admin\classes\custom_tables\MLB_DB_Helper;
use MovieLib\admin\classes\meta_boxes\RT_Media_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Person_Meta_Box;
use MovieLib\admin\classes\Movie_Library_Activation;
use MovieLib\admin\classes\Movie_Library_Deactivation;
use MovieLib\admin\classes\Settings_Page;
use MovieLib\admin\classes\Movie_Library_Save_Post;
use MovieLib\admin\classes\shortcodes\Movie_Shortcode;
use MovieLib\admin\classes\shortcodes\Person_Shortcode;
use MovieLib\admin\classes\taxonomies\Movie_Genre;
use MovieLib\admin\classes\taxonomies\Movie_Label;
use MovieLib\admin\classes\taxonomies\Movie_Language;
use MovieLib\admin\classes\taxonomies\Movie_Person;
use MovieLib\admin\classes\taxonomies\Movie_Production_Company;
use MovieLib\admin\classes\taxonomies\Movie_Tag;
use MovieLib\admin\classes\taxonomies\Person_Career;
use WP_Post;

if ( ! class_exists( 'MovieLib\includes\Movie_Library' ) ) {

	/**
	 * This is the main class of the plugin. It is used to initialize the plugin.
	 * It will include all the required files and will register activation and deactivation hooks.
	 *
	 * @version 1.0.0
	 */
	class Movie_Library {

		use Singleton;

		/**
		 * Movie_Library Constructor.
		 * This constructor will include all the required files and will register activation and deactivation hooks.
		 *
		 * @return void
		 */
		protected function init(): void {

			$this->register_custom_post_types();
			$this->register_custom_taxonomies();
			$this->register_hooks();
			$this->add_custom_meta_boxes();
			$this->setup_environment();
			$this->load_all_scripts();

		}

		/**
		 * Attaching callbacks into actions and filters.
		 *
		 * @return void
		 */
		private function register_hooks(): void {
			Movie_Library_Activation::instance();
			Movie_Library_Deactivation::instance();
			Custom_Endpoint_Movie::instance();
			MLB_DB_Helper::instance()->add_hooks();

			$movie_library_save_post     = Movie_Library_Save_Post::instance();
			$movie_library_settings_page = Settings_Page::instance();

			add_action( 'plugins_loaded', array( $this, 'load_plugin_text_domain' ) );
			add_action( 'save_post', array( $movie_library_save_post, 'save_custom_post' ), 10, 3 );
			add_action(
				'admin_menu',
				array(
					$movie_library_settings_page,
					'add_movie_library_sub_menu',
				)
			);

			add_filter( 'enter_title_here', array( $this, 'change_title_text' ), 10, 2 );
			add_filter( 'write_your_story', array( $this, 'change_post_content_text' ), 10, 2 );
		}

		/**
		 * This function is used to load scripts and styles.
		 *
		 * @return void
		 */
		private function load_all_scripts(): void {

			Asset::instance();

		}

		/**
		 * This function is used to register the custom post types.
		 *
		 * @return void
		 */
		private function register_custom_post_types(): void {

			RT_Movie::instance();
			RT_Person::instance();

		}

		/**
		 * This function is used to register the custom taxonomies.
		 *
		 * @return void
		 */
		private function register_custom_taxonomies(): void {

			Movie_Genre::instance();
			Movie_Language::instance();
			Movie_Label::instance();
			Movie_Person::instance();
			Movie_Production_Company::instance();
			Movie_Tag::instance();
			Person_Career::instance();

		}

		/**
		 * This function is used to setup the environment for the plugin. Like regestering custom post type and custom taxonomy.
		 *
		 * @return void
		 */
		public function setup_environment(): void {

			Movie_Shortcode::instance();
			Person_Shortcode::instance();

		}

		/**
		 * Load Localisation files.
		 *
		 * @return void
		 */
		public function load_plugin_text_domain(): void {

			load_plugin_textdomain( 'movie-library', false, MLB_PLUGIN_RELATIVE_PATH . '/languages' );

		}

		/**
		 * This function is used to add all the meta-boxes.
		 *
		 * @return void
		 */
		public function add_custom_meta_boxes(): void {

			RT_Movie_Meta_Box::instance();
			RT_Person_Meta_Box::instance();
			RT_Media_Meta_Box::instance();

		}

		/**
		 * This function is used to change the title text for the post type.
		 * It will change the title text to "Title" for the post type "rt-movie" and "Name" for the post type "rt-person".
		 * It will not change the title text for any other post type.
		 * It will return the original title text for any other post type.
		 *
		 * @param string  $title title that needs to be changed.
		 * @param WP_Post $post post object.
		 *
		 * @return string
		 */
		public function change_title_text( $title, $post ): string {

			if ( RT_Movie::SLUG === $post->post_type ) {

				$title = __( 'Title', 'movie-library' );

			} elseif ( RT_Person::SLUG === $post->post_type ) {

				$title = __( 'Name', 'movie-library' );

			}

			return $title;
		}

		/**
		 * This function is used to change the post content text for the post type.
		 * It will change the post content text to "Plot" for the post type "rt-movie" and "Biography" for the post type "rt-person".
		 * It will not change the post content text for any other post type.
		 * It will return the original post content text for any other post type.
		 *
		 * @param string  $title title that needs to be changed.
		 * @param WP_Post $post post object.
		 *
		 * @return string
		 */
		public function change_post_content_text( $title, $post ): string {

			if ( RT_Movie::SLUG === $post->post_type ) {

				$title = __( 'Plot', 'movie-library' );

			} elseif ( RT_Person::SLUG === $post->post_type ) {

				$title = __( 'Biography', 'movie-library' );

			}

			return $title;
		}

	}
}
