<?php
/**
 * This file is used to perform the deactivation functionality for the plugin.
 *
 * @package MovieLib\admin\classes
 */

namespace MovieLib\admin\classes;

use MovieLib\admin\classes\roles_capabilities\Movie_Manager_Role_Capabilities;
use MovieLib\includes\Singleton;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\Movie_Library_Deactivation' ) ) {

	/**
	 * This class is used to perform the deactivation functionality for the plugin.
	 */
	class Movie_Library_Deactivation {

		use Singleton;

		/**
		 * Movie_Library_Deactivation init method.
		 *
		 * @return void
		 */
		public function init(): void {
			register_deactivation_hook( MLB_PLUGIN_FILE, array( $this, 'deactivate' ) );
		}

		/**
		 * This function is used to perform the deactivation functionality for the plugin.
		 *
		 * @return void
		 */
		public function deactivate(): void {
			Movie_Manager_Role_Capabilities::instance()->remove_movie_manager_role();
		}

	}
}
