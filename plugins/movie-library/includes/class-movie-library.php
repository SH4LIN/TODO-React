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
use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\admin\classes\meta_boxes\RT_Media_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Person_Meta_Box;
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

		/**
		 * Variable instance.
		 *
		 * @var ?Movie_Library $instance The single instance of the class.
		 */
		protected static ?Movie_Library $instance = null;

		/**
		 * Main Movie_Library Instance.
		 *  Ensures only one instance of Movie_Library is loaded or can be loaded.
		 *
		 * @return Movie_Library - Main instance.
		 */
		public static function instance(): Movie_Library {

			if ( is_null( self::$instance ) ) {

				self::$instance = new self();

			}

			return self::$instance;
		}

		/**
		 * Movie_Library Constructor.
		 * This constructor will include all the required files and will register activation and deactivation hooks.
		 */
		private function __construct() {

			$this->register_hooks();
			$this->register_custom_post_types();
			$this->register_custom_taxonomies();
			flush_rewrite_rules();

		}

		/**
		 * Attaching callbacks into actions and filters.
		 *
		 * @return void
		 */
		private function register_hooks(): void {
			$movie_library_save_post     = Movie_Library_Save_Post::instance();
			$movie_library_settings_page = Settings_Page::instance();

			$asset = Asset::instance();

			add_action( 'init', array( $this, 'setup_environment' ) );
			add_action( 'plugins_loaded', array( $this, 'load_plugin_text_domain' ) );
			add_action( 'admin_enqueue_scripts', array( $asset, 'enqueue_admin_css' ) );
			add_action( 'admin_enqueue_scripts', array( $asset, 'enqueue_image_video_upload_script' ) );
			add_action( 'admin_enqueue_scripts', array( $asset, 'enqueue_custom_label_character_script' ) );
			add_action( 'admin_enqueue_scripts', array( $asset, 'enqueue_validation_script' ) );
			add_action( 'wp_enqueue_scripts', array( $asset, 'enqueue_frontend_scripts' ) );
			add_action( 'add_meta_boxes', array( $this, 'add_custom_meta_boxes' ) );
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
		 * This function is used to register the custom post types.
		 *
		 * @return void
		 */
		private function register_custom_post_types(): void {

			$rt_movie = RT_Movie::instance();
			$rt_movie->register();

			$rt_person = RT_Person::instance();
			$rt_person->register();

		}

		/**
		 * This function is used to register the custom taxonomies.
		 *
		 * @return void
		 */
		private function register_custom_taxonomies(): void {

			$rt_movie_genre = Movie_Genre::instance();
			$rt_movie_genre->register();

			$rt_movie_language = Movie_Language::instance();
			$rt_movie_language->register();

			$rt_movie_label = Movie_Label::instance();
			$rt_movie_label->register();

			$rt_movie_person = Movie_Person::instance();
			$rt_movie_person->register();

			$rt_movie_production_company = Movie_Production_Company::instance();
			$rt_movie_production_company->register();

			$rt_movie_tag = Movie_Tag::instance();
			$rt_movie_tag->register();

			$rt_person_career = Person_Career::instance();
			$rt_person_career->register();

		}

		/**
		 * This function is used to setup the environment for the plugin. Like regestering custom post type and custom taxonomy.
		 *
		 * @return void
		 */
		public function setup_environment(): void {

			$movie_shortcode = Movie_Shortcode::instance();
			$movie_shortcode->register();

			$person_shortcode = Person_Shortcode::instance();
			$person_shortcode->register();

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

			$rt_movie_meta_box = RT_Movie_Meta_Box::instance();
			$rt_movie_meta_box->create_meta_box();

			$rt_person_meta_box = RT_Person_Meta_Box::instance();
			$rt_person_meta_box->create_meta_box();

			$rt_media_meta_box = RT_Media_Meta_Box::instance();
			$rt_media_meta_box->create_meta_box();

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
