<?php

/**
 * This file is used to perform the activation functionality for the plugin.
 */

namespace MovieLib;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Movie_Library_Activation' ) ) {

	/**
	 * @class Movie_Library_Activation
	 * This class is used to perform the activation functionality for the plugin.
	 */
	class Movie_Library_Activation {

		/**
		 * This function is used to perform the activation functionality for the plugin.
		 */
		public function activate(): void {
			$this->includes();
			$this->register_hooks();
		}

		private function includes(): void {
			require_once MLB_PLUGIN_DIR . 'admin/class-movie-library-post-type.php';
			require_once MLB_PLUGIN_DIR . 'admin/class-movie-library-taxonomy.php';
		}

		private function register_hooks(): void {
			add_action( 'init', [ $this, 'load_plugin_text_domain' ] );
			add_action( 'init', [ $this, 'setup_environment' ] );
			/*add_action( 'plugins_loaded', [ $this, 'load_plugin_text_domain' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
			add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ] );*/
		}

		/**
		 * @function setup_environment
		 * This function is used to setup the environment for the plugin. Like regestering custom post type and custom taxonomy.
		 * @return void
		 */
		private function setup_environment(): void {
			// Set up localisation.
			$post_type = new Movie_Library_Post_type();
			$post_type->register_custom_post_type();
			$taxonomy = new Movie_Library_Taxonomy();
			$taxonomy->register_custom_taxonomy();
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