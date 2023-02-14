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
		 * This constructor will include all the required files and will register activation and deactivation hooks.
		 */
		private function __construct() {
			$this->includes();
			$this->register_activation_deactivation_hooks();
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 */
		private function includes(): void {
			require_once MLB_PLUGIN_DIR . 'admin/class-movie-library-activation.php';
			require_once MLB_PLUGIN_DIR . 'admin/class-movie-library-deactivation.php';
			/*include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-metabox.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-shortcode.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-widget.php';
			include_once MLB_PLUGIN_DIR . 'includes/class-movie-library-settings.php';
			*/
		}

		/**
		 * Attaching callbacks into actions and filters.
		 */
		private function register_activation_deactivation_hooks(): void {
			$movie_library_activation   = new Movie_Library_Activation();
			$movie_library_deactivation = new Movie_Library_Deactivation();
			register_activation_hook( __FILE__, [ $movie_library_activation, 'activate' ] );
			register_deactivation_hook( __FILE__, [ $movie_library_deactivation, 'deactivate' ] );
		}

	}
}
	