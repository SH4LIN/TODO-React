<?php

/**
 * Core plugin class.
 *
 * @class    Movie_Library
 * @package  MovieLib
 * @since    1.0.0
 * @version  1.0.0
 */

namespace MovieLib;

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'MovieLib\Movie_Library' ) ) {
	/**
	 * @class   Movie_Library
	 *          This is the main class of the plugin. It is used to initialize the plugin.
	 *          It will include all the required files and will register activation and deactivation hooks.
	 *
	 * @function @public instance()
	 *           This function is used to get the single instance of the class.
	 *           It will create a new instance if it is not already created.
	 *
	 * @function @private __construct()
	 *           This function is used to initialize the class.
	 *           It will include all the required files and will register activation and deactivation hooks.
	 *
	 * @function @private includes()
	 *           This function is used to include all the required files.
	 *
	 * @function @private register_activation_deactivation_hooks()
	 *           This function is used to register activation and deactivation hooks.
	 *
	 *
	 * @version 1.0.0
	 */
	class Movie_Library {

		/**
		 *
		 * The single instance of the class.
		 *
		 * @var $instance
		 */
		protected static $instance = null;

		/**
		 * @function instance
		 * Main Movie_Library Instance.
		 * Ensures only one instance of Movie_Library is loaded or can be loaded.
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
		 * @function __construct
		 * Movie_Library Constructor.
		 * This constructor will include all the required files and will register activation and deactivation hooks.
		 */
		private function __construct() {
			$this->includes();
			$this->register_hooks();
		}

		/**
		 * @function includes
		 * Include required core files used in admin and on the frontend.
		 */
		private function includes(): void {
			require_once MLB_PLUGIN_DIR . 'admin/class-movie-library-activation.php';
			require_once MLB_PLUGIN_DIR . 'admin/class-movie-library-deactivation.php';
			require_once MLB_PLUGIN_DIR . 'admin/class-movie-library-post-type.php';
			require_once MLB_PLUGIN_DIR . 'admin/class-movie-library-taxonomy.php';
			/*include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-metabox.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-shortcode.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-widget.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-settings.php';
			*/
		}

		/**
		 * @function register_activation_deactivation_hooks
		 * Attaching callbacks into actions and filters.
		 */
		private function register_hooks(): void {
			$movie_library_activation   = new Movie_Library_Activation();
			$movie_library_deactivation = new Movie_Library_Deactivation();
			register_activation_hook( MLB_PLUGIN_FILE, [ $movie_library_activation, 'activate' ] );
			register_deactivation_hook( MLB_PLUGIN_FILE, [ $movie_library_deactivation, 'deactivate' ] );
			add_action( 'init', [ $this, 'load_plugin_text_domain' ] );
			add_action( 'init', [ $this, 'setup_environment' ]);
			/*add_action( 'plugins_loaded', [ $this, 'load_plugin_text_domain' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
			add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ] );*/
		}

		/**
		 * @function setup_environment
		 * This function is used to setup the environment for the plugin. Like regestering custom post type and custom taxonomy.
		 * @return void
		 */
		public function setup_environment(): void {
			// Set up localisation.
			$post_type = new Movie_Library_Post_type();
			$post_type->register_custom_post_type();
			$taxonomy = new Movie_Library_Taxonomy();
			$taxonomy->register_custom_taxonomy();
		}

		/**
		 * Load Localisation files.
		 */
		public function load_plugin_text_domain(): void {
			load_plugin_textdomain( 'movie-library', false, MLB_PLUGIN_RELATIVE_PATH . '/languages' );
		}

		/**
		 * Enqueue admin scripts.
		 */
		public function admin_enqueue_scripts(): void {
			wp_enqueue_style( 'movie-library-admin', MLB_PLUGIN_URL . 'assets/css/admin.css', [], MLB_PLUGIN_VERSION );
		}

		/**
		 * Enqueue frontend scripts.
		 */
		public function wp_enqueue_scripts(): void {
			wp_enqueue_style( 'movie-library-frontend', MLB_PLUGIN_URL . 'assets/css/frontend.css', [], MLB_PLUGIN_VERSION );
		}

	}
}
	