<?php
/**
 * Core plugin class.
 * @package MovieLibrary
 *          @since 1.0.0
 *        @version 1.0.0
 *          @category Core
 */

namespace MovieLib;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\MovieLibrary' ) ) {
	/**
	 * Main MovieLibrary Class.
	 * @class   MovieLibrary
	 * @version 1.0.0
	 */
	class MovieLibrary {

		/**
		 * The single instance of the class.
		 * @var MovieLibrary
		 */
		protected static $instance = null;

		/**
		 * Main MovieLibrary Instance.
		 * Ensures only one instance of MovieLibrary is loaded or can be loaded.
		 * @return MovieLibrary - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * MovieLibrary Constructor.
		 */
		public function __construct() {
			$this->setup_environment();
			$this->includes();
			$this->init_hooks();
		}



		/**
		 * Include required core files used in admin and on the frontend.
		 */
		public function includes() {
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-post-type.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-taxonomy.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-metabox.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-shortcode.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-widget.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-settings.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-activation.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-deactivation.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-uninstall.php';
		}

		/**
		 * Hook into actions and filters.
		 */
		private function init_hooks() {
			register_activation_hook( __FILE__, [ 'MovieLibraryActivation', 'activate' ] );
			register_deactivation_hook( __FILE__, [ 'MovieLibraryDeactivation', 'deactivate' ] );

			add_action( 'plugins_loaded', [ $this, 'load_plugin_textdomain' ] );
			add_action( 'init', [ $this, 'init' ], 0 );
			add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
			add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ] );
		}

		/**
		 * Init MovieLibrary when WordPress Initialises.
		 */
		public function init() {
			// Before init action.
			do_action( 'before_movie_library_init' );
			// Set up localisation.
			$this->load_plugin_textdomain();
			// Init action.
			do_action( 'movie_library_init' );
		}

		/**
		 * Load Localisation files.
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'movie-library', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Enqueue admin scripts.
		 */
		public function admin_enqueue_scripts() {
			wp_enqueue_style( 'movie-library-admin', MLB_PLUGIN_URL . 'assets/css/admin.css', [], MLB_PLUGIN_VERSION );
		}

		/**
		 * Enqueue frontend scripts.
		 */
		public function wp_enqueue_scripts() {
			wp_enqueue_style( 'movie-library-frontend', MLB_PLUGIN_URL . 'assets/css/frontend.css', [], MLB_PLUGIN_VERSION );
		}
	}
}
	