<?php
/**
 * This file is used to perform the activation functionality for the plugin.
 *
 * @package MovieLib\admin\classes
 */

namespace MovieLib\admin\classes;

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
		}
	}
endif;
