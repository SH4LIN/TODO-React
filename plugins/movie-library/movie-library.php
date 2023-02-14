<?php

/**
 * @package           MovieLib
 * @author            Shalin Shah
 * @wordPress-Plugin
 * Plugin Name:       Movie Library
 * Plugin URI:        https://learn.rtcamp.com
 * Description:       This plugin provides features to create movie library.
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.2
 * Author:            Shalin Shah
 * Author URI:        https://learn.rtcamp.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://learn.rtcamp.com
 * Text Domain:       movie-library
 * Domain Path:       /languages
 */

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

/**
 * It Defines constants about the plugin directory plugin url plugin relative path plugin basename, plugin file, plugin
 * slug, plugin name, plugin version.
 */

/**
 * @const MLB_PLUGIN_DIR
 */
define( "MLB_PLUGIN_DIR", plugin_dir_path( __FILE__ ) );

/**
 * @const MLB_PLUGIN_URL
 */
define( 'MLB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * @const MLB_PLUGIN_BASENAME
 */
define( 'MLB_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * @const MLB_PLUGIN_RELATIVE_PATH
 */
define( 'MLB_PLUGIN_RELATIVE_PATH', plugin_basename( dirname( __FILE__ ) ) );

/**
 * @const MLB_PLUGIN_FILE
 */
const MLB_PLUGIN_FILE = __FILE__;

/**
 * @const MLB_PLUGIN_VERSION
 */
const MLB_PLUGIN_VERSION = '1.0.0';

/**
 * @const MLB_TEXT_DOMAIN
 */
const MLB_TEXT_DOMAIN = 'movie-library';

/**
 * @const MLB_SLUG
 */
const MLB_SLUG = 'movie-library';

/**
 * @const MLB_NAME
 */
const MLB_NAME = 'Movie Library';

require_once MLB_PLUGIN_DIR . 'includes/class-movie-library.php';

use MovieLib\Movie_Library;

movie_library();

/**
 * @function movie_library()
 * Main instance of Movie_Library.
 * Returns the main instance of Movie_Library to prevent the need to use globals.
 *
 * @return Movie_Library
 */
function movie_library(): Movie_Library {
	return Movie_Library::instance();
}

// Global for backwards compatibility.
$GLOBALS[ 'movie-library' ] = movie_library();



