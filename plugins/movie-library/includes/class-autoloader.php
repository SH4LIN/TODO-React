<?php
/**
 * This file is used to autoload the classes of the plugin.
 *
 * @package MovieLib\includes
 */

namespace MovieLib\includes;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

/**
 * This class is used to autoload the classes of the plugin.
 */
class Autoloader {

	/**
	 * This function will register the autoloader function.
	 * spl_autoload_register() will register the autoloader callback function.
	 *
	 * @return void
	 */
	public static function register(): void {

		spl_autoload_register( array( new self(), 'load_classes' ) );

	}

	/**
	 * This function will load the classes of the plugin.
	 * First it will convert the class name to lowercase.
	 * Then it will replace the underscore with a dash.
	 * Then it will explode the class name by the backslash.
	 * Then it will replace the last element of the array with the class-prefix.
	 * Then it will implode the array by the backslash.
	 * Then it will replace the backslash with the directory separator.
	 * Then it will check if the file exists.
	 * If the file exists then it will require the file.
	 * If the file does not exist then it will return false.
	 * If the file exists then it will return true.
	 *
	 * @param string $class class name that needs to be autolodaded.
	 *
	 * @return bool
	 */
	public function load_classes( $class ): bool {

		$class                             = strtolower( $class );
		$class                             = str_replace( '_', '-', $class );
		$class                             = explode( '\\', $class );
		$class[ array_key_last( $class ) ] = 'class-' . $class[ array_key_last( $class ) ];

		if ( 'movielib' === $class[0] ) {

			unset( $class[0] );

		}

		$class = implode( '\\', $class );
		$file  = MLB_PLUGIN_DIR . $class . '.php';
		$file  = str_replace( '\\', DIRECTORY_SEPARATOR, $file );

		if ( file_exists( $file ) ) {

			require_once $file;
			return true;

		}

		return false;
	}
}

/**
 * Below code will call the register function of the Movie_Library_Autoloader class.
 */
Autoloader::register();
