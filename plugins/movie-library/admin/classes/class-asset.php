<?php
/**
 * This file is used to enqueue scripts and styles.]
 *
 * @package MovieLib\admin\classes
 */

namespace MovieLib\admin\classes;

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\custom_post_types\RT_Person;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\Asset' ) ) {

	/**
	 * This class is used to enqueue scripts and styles.
	 */
	class Asset {

		/**
		 * Variable instance.
		 *
		 * @var ?Asset $instance The single instance of the class.
		 */
		protected static ?Asset $instance = null;

		/**
		 *  Main Asset Instance.
		 *  Ensures only one instance of Asset is loaded or can be loaded.
		 *
		 * @return Asset - Main instance.
		 */
		public static function instance(): Asset {

			if ( is_null( self::$instance ) ) {

				self::$instance = new self();

			}

			return self::$instance;
		}

		/**
		 * Movie_Library_Save_Post Constructor.
		 */
		private function __construct() {
			$this->register_scripts();
		}

		/**
		 * This function is used to register all the scripts.
		 * It will register the admin script.
		 * It will set the translation for the admin script.
		 *
		 * @return void
		 */
		private function register_scripts(): void {

			wp_register_script(
				'movie-library-image-video-upload',
				MLB_PLUGIN_URL . 'admin/js/movie-library-image-video-upload.js',
				array( 'wp-i18n', 'jquery' ),
				MLB_PLUGIN_VERSION,
				true
			);

			wp_register_script(
				'movie-library-custom-label',
				MLB_PLUGIN_URL . 'admin/js/movie-library-custom-label.js',
				array(
					'wp-hooks',
					'wp-i18n',
				),
				MLB_PLUGIN_VERSION,
				true
			);

			wp_register_script(
				'movie-library-character',
				MLB_PLUGIN_URL . 'admin/js/movie-library-character.js',
				array(
					'wp-i18n',
				),
				MLB_PLUGIN_VERSION,
				true
			);

			wp_register_script(
				'movie-library-rt-movie-validation',
				MLB_PLUGIN_URL . 'admin/js/movie-library-rt-movie-validation.js',
				array(
					'wp-i18n',
				),
				MLB_PLUGIN_VERSION,
				true
			);

			wp_register_script(
				'movie-library-rt-person-validation',
				MLB_PLUGIN_URL . 'admin/js/movie-library-rt-person-validation.js',
				array(
					'wp-i18n',
				),
				MLB_PLUGIN_VERSION,
				true
			);

		}

		/**
		 * This function is used to enqueue the admin CSS.
		 *
		 * @return void
		 */
		public function enqueue_admin_css(): void {

			wp_enqueue_style( 'movie-library-admin', MLB_PLUGIN_URL . 'admin/css/movie-library-admin.css', array(), MLB_PLUGIN_VERSION );

		}

		/**
		 * This function Enqueues image, video upload script.
		 *
		 * @return void
		 */
		public function enqueue_image_video_upload_script(): void {

			wp_enqueue_script( 'movie-library-image-video-upload' );
			wp_set_script_translations( 'movie-library-image-video-upload', 'movie-library', MLB_PLUGIN_DIR . 'languages' );
			wp_enqueue_media();

		}

		/**
		 * This function Enqueues custom label script.
		 *
		 * @return void
		 */
		public function enqueue_custom_label_character_script(): void {

			if ( get_post_type() === RT_Movie::SLUG ) {

				wp_enqueue_script( 'movie-library-custom-label' );
				wp_set_script_translations( 'movie-library-custom-label', 'movie-library', MLB_PLUGIN_DIR . 'languages' );

				wp_enqueue_script( 'movie-library-character' );
				wp_set_script_translations( 'movie-library-character', 'movie-library', MLB_PLUGIN_DIR . 'languages' );

			}

		}

		/**
		 * This function Enqueues validation script.
		 *
		 * @return void
		 */
		public function enqueue_validation_script(): void {

			$post_type = get_post_type();

			if ( RT_Movie::SLUG === $post_type ) {

				wp_enqueue_script( 'movie-library-rt-movie-validation' );
				wp_set_script_translations( 'movie-library-rt-movie-validation', 'movie-library', MLB_PLUGIN_DIR . 'languages' );

			} elseif ( RT_Person::SLUG === $post_type ) {

				wp_enqueue_script( 'movie-library-rt-person-validation' );
				wp_set_script_translations( 'movie-library-rt-person-validation', 'movie-library', MLB_PLUGIN_DIR . 'languages' );

			}

		}

		/**
		 *  Enqueue frontend scripts.
		 *
		 * @return void
		 */
		public function enqueue_frontend_scripts(): void {

			wp_enqueue_style( 'movie-library-frontend', MLB_PLUGIN_URL . 'public/css/movie-library-frontend.css', array(), MLB_PLUGIN_VERSION );
			wp_enqueue_script( 'movie-library-frontend', MLB_PLUGIN_URL . 'public/js/movie-library-frontend.js', array(), MLB_PLUGIN_VERSION, true );

		}

	}

}
