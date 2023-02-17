<?php
/**
 * This file is used to perform the deactivation functionality for the plugin.
 *
 * @package MovieLib\admin\classes
 */

namespace MovieLib\admin\classes;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\Movie_Library_Deactivation' ) ) {

	/**
	 * @class Movie_Library_Deactivation
	 * This class is used to perform the deactivation functionality for the plugin.
	 */
	class Movie_Library_Deactivation {

		/**
		 * @function deactivate.
		 *           This function is used to perform the deactivation functionality for the plugin.
		 * @return void
		 */
		public function deactivate(): void {}

	}
}
