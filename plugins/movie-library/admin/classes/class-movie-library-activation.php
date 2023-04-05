<?php
/**
 * This file is used to perform the activation functionality for the plugin.
 *
 * @package MovieLib\admin\classes
 */

namespace MovieLib\admin\classes;

use MovieLib\admin\classes\custom_tables\MLB_DB_Helper;
use MovieLib\includes\Singleton;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\Movie_Library_Activation' ) ) :

	/**
	 * This class is used to perform the activation functionality for the plugin.
	 */
	class Movie_Library_Activation {

		use Singleton;

		/**
		 * Movie_Library_Activation init method.
		 *
		 * @return void
		 */
		public function init(): void {
			register_activation_hook( MLB_PLUGIN_FILE, array( $this, 'activate' ) );
		}


		/**
		 * This function is used to perform the activation functionality for the plugin.
		 *
		 * @return void
		 */
		public function activate(): void {
			flush_rewrite_rules();

			// Creating custom tables.
			$this->create_tables();
		}

		/**
		 * This file is used to create the custom tables for the movie library plugin.
		 *
		 * @return void
		 */
		private function create_tables() {
			MLB_DB_Helper::instance()->create_tables();
		}
	}
endif;
