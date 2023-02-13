<?php

/**
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

// If this file is called directly, abort.
defined( 'ABSPATH' ) || exit;
define( 'MLB_PLUGIN_FILE', __FILE__ );

require_once MLB_PLUGIN_DIR . 'includes/movie-library-constants.php';


use MovieLib\MovieLibrary;

if( ! class_exists( 'MovieLib\MovieLibrary' ) ) {
	require_once MLB_PLUGIN_DIR . 'includes/class-movie-library.php';
	movie_library();
}

/**
 * Main instance of Movie_Library.
 * Returns the main instance of Movie_Library to prevent the need to use globals.
 * @return MovieLibrary
 */
function movie_library(): MovieLibrary {
	return MovieLibrary::instance();
}

// Global for backwards compatibility.
$GLOBALS[ 'movie-library' ] = movie_library();



