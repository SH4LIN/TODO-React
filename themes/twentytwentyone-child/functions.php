<?php
/**
 * Twenty Twenty-One Child functions and definitions
 *
 * @package WordPress
 * @subpackage TwentyTwentyOneChild
 * @since Twenty Twenty-One Child 1.0
 */

if ( ! function_exists( 'twenty_twenty_one_child_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since Twenty Twenty-One Child 1.0
	 *
	 * @return void
	 */
	function twenty_twenty_one_child_setup(): void {
		// Make theme available for translation.
		load_theme_textdomain( 'screen-time', get_stylesheet_directory() . '/languages' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Set the default content width.
		$GLOBALS['content_width'] = 580;

		// Register navigation menus uses wp_nav_menu in five places.
		register_nav_menus(
			array(
				'header' => __( 'Header Menu', 'screen-time' ),
				'footer' => __( 'Footer Menu', 'screen-time' ),
			)
		);

		// Switch default core markup for search form, comment form, and comments
		// to output valid HTML5.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Add support for experimental link color control.
		add_theme_support(
			'custom-units',
			array(
				'px',
				'rem',
				'em',
				'vw',
				'vh',
				'vmin',
				'vmax',
			)
		);
	}

endif;
add_action( 'after_setup_theme', 'twenty_twenty_one_child_setup' );

if ( ! function_exists( 'twenty_twenty_one_child_scripts' ) ) :

	/**
	 * Enqueue scripts and styles.
	 *
	 * @since Twenty Twenty-One Child 1.0
	 *
	 * @return void
	 */
	function twenty_twenty_one_child_scripts(): void {
		wp_enqueue_style( 'twenty-twenty-one-child-style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
		wp_enqueue_style( 'twenty-twenty-one-header-style', get_stylesheet_directory_uri() . '/assets/css/header.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/header.css' ) );
	}

endif;
add_action( 'wp_enqueue_scripts', 'twenty_twenty_one_child_scripts' );
