<?php
/**
 * This file is used to perform the deactivation functionality for the plugin.
 *
 * @package admin\classes
 */

namespace admin\classes;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'admin\classes\Movie_Library_Deactivation' ) ) {

	/**
	 * @class Movie_Library_Deactivation
	 * This class is used to perform the deactivation functionality for the plugin.
	 */
	class Movie_Library_Deactivation {

		/**
		 * This function is used to perform the deactivation functionality for the plugin.
		 */
		public function deactivate(): void {}

	}
}
