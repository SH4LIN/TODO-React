<?php
/**
 * Core plugin class.
 *
 * @class    Movie_Library
 * @package  MovieLib
 * @since    1.0.0
 * @version  1.0.0
 * @category Core
 */

namespace MovieLib;

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'MovieLib\Movie_Library' ) ) {
	/**
	 * Main Movie_Library Class.
	 *
	 * @class   Movie_Library
	 * @version 1.0.0
	 */
	class Movie_Library {

		/**
		 * The single instance of the class.
		 *
		 * @var $instance
		 */
		protected static $instance = null;


		/**
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
		 * Movie_Library Constructor.
		 */
		private function __construct() {
			$this->includes();
			$this->init_hooks();
		}

		private function setup_environment(): void {
			// Set up localisation.
			$this->load_plugin_text_domain();
			$post_type = new Movie_Library_Post_type();
			$post_type->register_custom_post_type();
			$taxonomy = new Movie_Library_Taxonomy();
			$taxonomy->register_custom_taxonomy();
		}


		/**
		 * Include required core files used in admin and on the frontend.
		 */
		private function includes(): void {
			require_once MLB_PLUGIN_DIR . 'admin/class-movie-library-post-type.php';
			require_once MLB_PLUGIN_DIR . 'admin/class-movie-library-taxonomy.php';
			/*include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-metabox.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-shortcode.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-widget.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-settings.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-activation.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-deactivation.php';*/
		}

		/**
		 * Attaching callbacks into actions and filters.
		 */
		private function init_hooks(): void {
			register_activation_hook( __FILE__, [ 'MovieLibraryActivation', 'activate' ] );
			register_deactivation_hook( __FILE__, [ 'MovieLibraryDeactivation', 'deactivate' ] );

			//add_action( 'plugins_loaded', [ $this, 'load_plugin_text_domain' ] );
			add_action( 'init', [ $this, 'init' ] );
			//add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
			//add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ] );
		}

		/**
		 * Init MovieLibrary when WordPress Initialises.
		 */
		public function init(): void {
			//Setup the environment.
			$this->setup_environment();
		}

		/**
		 * Load Localisation files.
		 */
		private function load_plugin_text_domain(): void {
			load_plugin_textdomain( 'movie-library', false, MLB_PLUGIN_RELATIVE_PATH . '/languages' );
		}

		/**
		 * Enqueue admin scripts.
		 */
		private function admin_enqueue_scripts(): void {
			wp_enqueue_style( 'movie-library-admin', MLB_PLUGIN_URL . 'assets/css/admin.css', [], MLB_PLUGIN_VERSION );
		}

		/**
		 * Enqueue frontend scripts.
		 */
		private function wp_enqueue_scripts(): void {
			wp_enqueue_style( 'movie-library-frontend', MLB_PLUGIN_URL . 'assets/css/frontend.css', [], MLB_PLUGIN_VERSION );
		}
	}
}
	