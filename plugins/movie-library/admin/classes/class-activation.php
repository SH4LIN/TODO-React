<?php
/**
 * This file is used to perform the activation functionality for the plugin.
 *
 * @package MovieLib\admin\classes
 */

namespace MovieLib\admin\classes;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\Activation' ) ) {

	/**
	 * This class is used to perform the activation functionality for the plugin.
	 */
	class Activation {

		/**
		 * This function is used to perform the activation functionality for the plugin.
		 *
		 * @return void
		 */
		public function activate(): void {}
	}
}
