<?php
/**
 * Twenty Twenty-One Child functions and definitions
 *
 * @package TwentyTwentyOneChild
 * @since 1.0.0
 */

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\custom_post_types\RT_Person;

if ( ! function_exists( 'twenty_twenty_one_child_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since 1.0.0
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
				'header'       => __( 'Header Menu', 'screen-time' ),
				'footer-col-1' => __( 'Footer First Menu', 'screen-time' ),
				'footer-col-2' => __( 'Footer Second Menu', 'screen-time' ),
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
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function twenty_twenty_one_child_scripts(): void {
		wp_enqueue_style( 'twenty-twenty-one-child-style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
		wp_enqueue_style( 'twenty-twenty-one-header-style', get_stylesheet_directory_uri() . '/assets/css/header.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/header.css' ) );
		wp_enqueue_style( 'twenty-twenty-one-footer-style', get_stylesheet_directory_uri() . '/assets/css/footer.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/footer.css' ) );
		if ( is_singular( RT_Movie::SLUG ) ) {
			wp_enqueue_style( 'twenty-twenty-one-single-movie-style', get_stylesheet_directory_uri() . '/assets/css/single-movie.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/single-movie.css' ) );
			wp_register_script( 'video-player', get_stylesheet_directory_uri() . '/assets/js/video-player.js', array(), filemtime( get_stylesheet_directory() . '/assets/js/video-player.js' ), true );
			wp_enqueue_script( 'video-player' );
		}

		if ( is_singular( RT_Person::SLUG ) ) {
			wp_enqueue_style( 'twenty-twenty-one-single-person-style', get_stylesheet_directory_uri() . '/assets/css/single-person.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/single-person.css' ) );
			wp_register_script( 'video-player', get_stylesheet_directory_uri() . '/assets/js/video-player.js', array(), filemtime( get_stylesheet_directory() . '/assets/js/video-player.js' ), true );
			wp_enqueue_script( 'video-player' );
		}

		if ( is_post_type_archive( RT_Movie::SLUG ) || is_home() ) {
			wp_enqueue_style( 'twenty-twenty-one-archive-movie-style', get_stylesheet_directory_uri() . '/assets/css/archive-movie.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/archive-movie.css' ) );
			wp_register_script( 'movie-slider', get_stylesheet_directory_uri() . '/assets/js/movie-slider.js', array(), filemtime( get_stylesheet_directory() . '/assets/js/movie-slider.js' ), true );
			wp_enqueue_script( 'movie-slider' );

		}

		if ( is_post_type_archive( RT_Person::SLUG ) ) {
			wp_enqueue_style( 'twenty-twenty-one-archive-person-style', get_stylesheet_directory_uri() . '/assets/css/archive-person.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/archive-person.css' ) );
		}

		// Ignoring the version number because it's a Google font.
		wp_enqueue_style( 'font-families', 'https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@100;200;300;400;500;600;700;800;900&family=Heebo:wght@100;200;300;400;500;600;700;800;900&display=swap', array(), null ); // phpcs:ignore:WordPress.WP.EnqueuedResourceParameters.MissingVersion

		wp_enqueue_script( 'menu-expand', get_stylesheet_directory_uri() . '/assets/js/menu-expand.js', array(), filemtime( get_stylesheet_directory() . '/assets/js/menu-expand.js' ), true );
		wp_enqueue_script( 'menu-expand' );

	}

endif;
add_action( 'wp_enqueue_scripts', 'twenty_twenty_one_child_scripts' );
