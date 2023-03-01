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

use MovieLib\admin\classes\Activation;
use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\custom_post_types\Rt_Person;
use MovieLib\admin\classes\Deactivation;
use MovieLib\admin\classes\Settings_Page;
use MovieLib\admin\classes\Movie_Library_Save_Post;
use MovieLib\admin\classes\Shortcodes;
use MovieLib\admin\classes\Meta_Boxes;
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

			$this->register_scripts();
			$this->register_hooks();
			$this->register_custom_post_types();
			$this->register_custom_taxonomies();
			flush_rewrite_rules();

		}

		/**
		 * This function is used to register all the scripts.
		 * It will register the admin script.
		 * It will set the translation for the admin script.
		 *
		 * @return void
		 */
		private function register_scripts(): void {

			wp_register_script(
				'movie-library-image-video-upload',
				MLB_PLUGIN_URL . 'admin/js/movie-library-image-video-upload.js',
				array( 'wp-i18n', 'jquery' ),
				MLB_PLUGIN_VERSION,
				true
			);

			wp_register_script(
				'movie-library-custom-label',
				MLB_PLUGIN_URL . 'admin/js/movie-library-custom-label.js',
				array(
					'wp-hooks',
					'wp-i18n',
				),
				MLB_PLUGIN_VERSION,
				true
			);

			wp_register_script(
				'movie-library-character',
				MLB_PLUGIN_URL . 'admin/js/movie-library-character.js',
				array(
					'wp-i18n',
					'jquery',
				),
				MLB_PLUGIN_VERSION,
				true
			);

			wp_register_script(
				'movie-library-validation',
				MLB_PLUGIN_URL . 'admin/js/movie-library-validation.js',
				array(
					'wp-i18n',
					'jquery',
				),
				MLB_PLUGIN_VERSION,
				true
			);

		}

		/**
		 * Attaching callbacks into actions and filters.
		 *
		 * @return void
		 */
		private function register_hooks(): void {
			$movie_library_activation    = new Activation();
			$movie_library_deactivation  = new Deactivation();
			$movie_library_meta_boxes    = new Meta_Boxes();
			$movie_library_save_post     = new Movie_Library_Save_Post();
			$movie_library_settings_page = new Settings_Page();

			register_activation_hook( MLB_PLUGIN_FILE, array( $movie_library_activation, 'activate' ) );
			register_deactivation_hook( MLB_PLUGIN_FILE, array( $movie_library_deactivation, 'deactivate' ) );

			add_action( 'init', array( $this, 'setup_environment' ) );
			add_action( 'plugins_loaded', array( $this, 'load_plugin_text_domain' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_css' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_image_video_upload_script' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_custom_label_character_script' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_validation_script' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
			add_action( 'add_meta_boxes', array( $movie_library_meta_boxes, 'add_meta_boxes' ) );
			add_action( 'save_post', array( $movie_library_save_post, 'save_post' ), 10, 3 );
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

			$rt_movie = new RT_Movie();
			$rt_movie->register();

			$rt_person = new Rt_Person();
			$rt_person->register();

		}

		/**
		 * This function is used to register the custom taxonomies.
		 *
		 * @return void
		 */
		private function register_custom_taxonomies(): void {
			$rt_movie_genre = new Movie_Genre();
			$rt_movie_genre->register();

			$rt_movie_language = new Movie_Language();
			$rt_movie_language->register();

			$rt_movie_label = new Movie_Label();
			$rt_movie_label->register();

			$rt_movie_person = new Movie_Person();
			$rt_movie_person->register();

			$rt_movie_production_company = new Movie_Production_Company();
			$rt_movie_production_company->register();

			$rt_movie_tag = new Movie_Tag();
			$rt_movie_tag->register();

			$rt_person_career = new Person_Career();
			$rt_person_career->register();

		}

		/**
		 * This function is used to setup the environment for the plugin. Like regestering custom post type and custom taxonomy.
		 *
		 * @return void
		 */
		public function setup_environment(): void {


			$shortcode = new Shortcodes();
			$shortcode->register_shortcodes();

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
		 * This function is used to enqueue the admin CSS.
		 *
		 * @return void
		 */
		public function enqueue_admin_css(): void {

			wp_enqueue_style( 'movie-library-admin', MLB_PLUGIN_URL . 'admin/css/movie-library-admin.css', array(), MLB_PLUGIN_VERSION );

		}

		/**
		 * This function Enqueues image, video upload script.
		 *
		 * @return void
		 */
		public function enqueue_image_video_upload_script(): void {

			wp_enqueue_script( 'movie-library-image-video-upload' );
			wp_set_script_translations( 'movie-library-image-video-upload', 'movie-library', MLB_PLUGIN_DIR . 'languages' );
			wp_enqueue_media();

		}

		/**
		 * This function Enqueues custom label script.
		 *
		 * @return void
		 */
		public function enqueue_custom_label_character_script(): void {

			if ( get_post_type() === 'rt-movie' ) {

				wp_enqueue_script( 'movie-library-custom-label' );
				wp_set_script_translations( 'movie-library-custom-label', 'movie-library', MLB_PLUGIN_DIR . 'languages' );

				wp_enqueue_script( 'movie-library-character' );
				wp_set_script_translations( 'movie-library-character', 'movie-library', MLB_PLUGIN_DIR . 'languages' );

			}

		}

		/**
		 * This function Enqueues validation script.
		 *
		 * @return void
		 */
		public function enqueue_validation_script(): void {

			$post_type = get_post_type();

			wp_enqueue_script( 'movie-library-validation' );
			wp_localize_script( 'movie-library-validation', 'movieLibrary', array( 'postType' => $post_type ) );
			wp_set_script_translations( 'movie-library-validation', 'movie-library', MLB_PLUGIN_DIR . 'languages' );

		}

		/**
		 *  Enqueue frontend scripts.
		 *
		 * @return void
		 */
		public function wp_enqueue_scripts(): void {

			wp_enqueue_style( 'movie-library-frontend', MLB_PLUGIN_URL . 'public/css/movie-library-frontend.css', array(), MLB_PLUGIN_VERSION );
			wp_enqueue_script( 'movie-library-frontend', MLB_PLUGIN_URL . 'public/js/movie-library-frontend.js', array(), MLB_PLUGIN_VERSION, true );

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

			if ( 'rt-movie' === $post->post_type ) {

				$title = __( 'Title', 'movie-library' );

			} elseif ( 'rt-person' === $post->post_type ) {

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

			if ( 'rt-movie' === $post->post_type ) {

				$title = __( 'Plot', 'movie-library' );

			} elseif ( 'rt-person' === $post->post_type ) {

				$title = __( 'Biography', 'movie-library' );

			}

			return $title;
		}

	}
}
