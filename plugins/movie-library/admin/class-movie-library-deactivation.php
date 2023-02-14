<?php

/**
 * This file is used to perform the deactivation functionality for the plugin.
 */

namespace MovieLib;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Movie_Library_Deactivation' ) ) {

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