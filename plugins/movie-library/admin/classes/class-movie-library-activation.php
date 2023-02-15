<?php
/**
 * This file is used to perform the activation functionality for the plugin.
 *
 * @package admin\classes
 */

namespace admin\classes;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'admin\classes\Movie_Library_Activation' ) ) {

	/**
	 * @class Movie_Library_Activation
	 * This class is used to perform the activation functionality for the plugin.
	 */
	class Movie_Library_Activation {

		/**
		 * This function is used to perform the activation functionality for the plugin.
		 */
		public function activate(): void {}
	}
}
