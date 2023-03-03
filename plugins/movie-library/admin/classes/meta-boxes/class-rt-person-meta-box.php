<?php
/**
 * This file is used to create all the meta-boxes for rt-person post type.
 *
 * @package MovieLib\admin\classes\meta_boxes
 */

namespace MovieLib\admin\classes\meta_boxes;

use MovieLib\admin\classes\custom_post_types\RT_Person;
use WP_Post;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\meta_boxes\RT_Person_Meta_Box' ) ) {

	/**
	 * This class is used to create all the meta-boxes for rt-person post type.
	 */
	class RT_Person_Meta_Box {

		/**
		 * RT_PERSON_META_BASIC_SLUG
		 */
		const PERSON_META_BASIC_SLUG = 'rt-person-meta-basic';

		/**
		 * RT_PERSON_META_SOCIAL_SLUG
		 */
		const PERSON_META_SOCIAL_SLUG = 'rt-person-meta-social';

		/**
		 * Variable instance.
		 *
		 * @var ?RT_Person_Meta_Box $instance The single instance of the class.
		 */
		protected static ?RT_Person_Meta_Box $instance = null;

		/**
		 *  Main RT_Person_Meta_Box Instance.
		 *  Ensures only one instance of RT_Person_Meta_Box is loaded or can be loaded.
		 *
		 * @return RT_Person_Meta_Box - Main instance.
		 */
		public static function instance(): RT_Person_Meta_Box {

			if ( is_null( self::$instance ) ) {

				self::$instance = new self();

			}

			return self::$instance;
		}

		/**
		 * RT_Person_Meta_Box Constructor.
		 */
		private function __construct() {}

		/**
		 * This function is used to create the meta-box for basic information and social information.
		 *
		 * @return void
		 */
		public function create_meta_box():void {

			add_meta_box(
				self::PERSON_META_BASIC_SLUG,
				__( 'Basic', 'movie-library' ),
				array( $this, 'rt_person_meta_basic' ),
				array( RT_Person::SLUG ),
				'side',
				'high'
			);

			add_meta_box(
				self::PERSON_META_SOCIAL_SLUG,
				__( 'Social', 'movie-library' ),
				array( $this, 'rt_person_meta_social' ),
				array( RT_Person::SLUG ),
				'side',
				'high'
			);
		}

		/**
		 * This function is used to display the meta box for the person basic details.
		 *
		 * @param WP_Post $post The post object.
		 *
		 * @return void
		 */
		public function rt_person_meta_basic( WP_Post $post ): void {

			// This will be used to get the person meta basic data.
			$rt_person_meta_basic_data = get_post_meta( $post->ID );

			// This will create the array of the person meta basic keys.
			$rt_person_meta_basic_key = array(
				'birth-date'  => 'rt-person-meta-basic-birth-date',
				'birth-place' => 'rt-person-meta-basic-birth-place',
			);

			// This will be used to add the nonce field.
			wp_nonce_field( 'rt_person_meta_nonce', 'rt_person_meta_nonce' );

			?>

			<div class = "rt-person-meta-fields rt-person-meta-basic-fields">

				<div class = "rt-person-meta-container rt-person-meta-basic-container rt-person-meta-basic-birth-date-container">

					<label class = "rt-person-meta-label rt-person-meta-basic-label rt-person-meta-basic-birth-date-label"
						for = "<?php echo esc_attr( $rt_person_meta_basic_key['birth-date'] ); ?>">

						<?php esc_html_e( 'Birth Date', 'movie-library' ); ?>

					</label>

					<input type = "date"
						value = "<?php echo esc_attr( $rt_person_meta_basic_data[ $rt_person_meta_basic_key['birth-date'] ][0] ); ?>"
						class = "rt-person-meta-field rt-person-meta-basic-field rt-person-meta-basic-birth-date-field"
						name = "<?php echo esc_attr( $rt_person_meta_basic_key['birth-date'] ); ?>"
						id = "<?php echo esc_attr( $rt_person_meta_basic_key['birth-date'] ); ?>" />

				</div>

				<div class = "rt-person-meta-container rt-person-meta-basic-container rt-person-meta-basic-birth-place-container">

					<label class = "rt-person-meta-label rt-person-meta-basic-label rt-person-meta-basic-birth-place-label"
						for = "<?php echo esc_attr( $rt_person_meta_basic_key['birth-place'] ); ?>">

						<?php esc_html_e( 'Birth Place', 'movie-library' ); ?>

					</label>

					<input type = "text"
						value = "<?php echo esc_attr( $rt_person_meta_basic_data[ $rt_person_meta_basic_key['birth-place'] ][0] ); ?>"
						class = "rt-person-meta-field rt-person-meta-basic-field rt-person-meta-basic-birth-place-field"
						name = "<?php echo esc_attr( $rt_person_meta_basic_key['birth-place'] ); ?>"
						id = "<?php echo esc_attr( $rt_person_meta_basic_key['birth-place'] ); ?>" />

				</div>


			</div>

			<?php
		}

		/**
		 * This function is used to create the meta box for the person social details.
		 *
		 * @param WP_Post $post The post object.
		 *
		 * @return void
		 */
		public function rt_person_meta_social( WP_Post $post ): void {

			$rt_person_meta_social_data = get_post_meta( $post->ID );

			$rt_person_meta_social_key = array(
				'twitter'   => 'rt-person-meta-social-twitter',
				'facebook'  => 'rt-person-meta-social-facebook',
				'instagram' => 'rt-person-meta-social-instagram',
				'website'   => 'rt-person-meta-social-web',
			);

			wp_nonce_field( 'rt_person_meta_nonce', 'rt_person_meta_nonce' );

			?>

			<div class = "rt-person-meta-fields rt-person-meta-social-fields">

				<div class = "rt-person-meta-container rt-person-meta-social-container rt-person-meta-social-twitter-container">

					<label class = "rt-person-meta-label rt-person-meta-social-label rt-person-meta-social-twitter-label"
						for = "<?php echo esc_attr( $rt_person_meta_social_key['twitter'] ); ?>">

						<?php esc_html_e( 'Twitter', 'movie-library' ); ?>

					</label>

					<input type = "text"
						value = "<?php echo esc_url( $rt_person_meta_social_data[ $rt_person_meta_social_key['twitter'] ][0] ); ?>"
						class = "rt-person-meta-field rt-person-meta-social-field rt-person-meta-social-twitter-field"
						name = "<?php echo esc_attr( $rt_person_meta_social_key['twitter'] ); ?>"
						id = "<?php echo esc_attr( $rt_person_meta_social_key['twitter'] ); ?>"/>

					<span class = "rt-person-meta-field-error rt-person-meta-social-field-error rt-person-meta-social-twitter-field-error" id="rt-person-meta-social-twitter-field-error"></span>

				</div>

				<div class = "rt-person-meta-container rt-person-meta-social-container rt-person-meta-social-facebook-container">

					<label class = "rt-person-meta-label rt-person-meta-social-label rt-person-meta-social-facebook-label"
						for = "<?php echo esc_attr( $rt_person_meta_social_key['facebook'] ); ?>">

						<?php esc_html_e( 'Facebook', 'movie-library' ); ?>

					</label>

					<input type = "text"
						value = "<?php echo esc_url( $rt_person_meta_social_data[ $rt_person_meta_social_key['facebook'] ][0] ); ?>"
						class = "rt-person-meta-field rt-person-meta-social-field rt-person-meta-social-facebook-field"
						name = "<?php echo esc_attr( $rt_person_meta_social_key['facebook'] ); ?>"
						id = "<?php echo esc_attr( $rt_person_meta_social_key['facebook'] ); ?>"/>

					<span class = "rt-person-meta-field-error rt-person-meta-social-field-error rt-person-meta-social-facebook-field-error" id="rt-person-meta-social-facebook-field-error"></span>

				</div>

				<div class = "rt-person-meta-container rt-person-meta-social-container rt-person-meta-social-instagram-container">

					<label class = "rt-person-meta-label rt-person-meta-social-label rt-person-meta-social-instagram-label"
						for = "<?php echo esc_attr( $rt_person_meta_social_key['instagram'] ); ?>">

						<?php esc_html_e( 'Instagram', 'movie-library' ); ?>

					</label>

					<input type = "text"
						value = "<?php echo esc_url( $rt_person_meta_social_data[ $rt_person_meta_social_key['instagram'] ][0] ); ?>"
						class = "rt-person-meta-field rt-person-meta-social-field rt-person-meta-social-instagram-field"
						name = "<?php echo esc_attr( $rt_person_meta_social_key['instagram'] ); ?>"
						id = "<?php echo esc_attr( $rt_person_meta_social_key['instagram'] ); ?>"/>

					<span class = "rt-person-meta-field-error rt-person-meta-social-field-error rt-person-meta-social-instagram-field-error" id="rt-person-meta-social-instagram-field-error"></span>

				</div>

				<div class = "rt-person-meta-container rt-person-meta-social-container rt-person-meta-social-website-container">

					<label class = "rt-person-meta-label rt-person-meta-social-label rt-person-meta-social-website-label"
						for = "<?php echo esc_attr( $rt_person_meta_social_key['Website'] ); ?>">

						<?php esc_html_e( 'Website', 'movie-library' ); ?>

					</label>

					<input type = "text"
						value = "<?php echo esc_url( $rt_person_meta_social_data[ $rt_person_meta_social_key['website'] ][0] ); ?>"
						class = "rt-person-meta-field rt-person-meta-social-field rt-person-meta-social-website-field"
						name = "<?php echo esc_attr( $rt_person_meta_social_key['website'] ); ?>"
						id = "<?php echo esc_attr( $rt_person_meta_social_key['website'] ); ?>" />

					<span class = "rt-person-meta-field-error rt-person-meta-social-field-error rt-person-meta-social-website-field-error" id="rt-person-meta-social-website-field-error"></span>

				</div>

			</div>

			<?php

		}

		/**
		 * This function is used to save the rt-person post.
		 * First it will verify the nonce if it is set or not.
		 * If the nonce is set then it will verify the nonce.
		 * If the nonce is verified then it will check the expected fields are set or not.
		 * If the expected fields are set then it will sanitize the data, validate data and save the data.
		 *
		 * @param int     $post_id The post ID.
		 * @param WP_Post $post The post object.
		 * @param bool    $update Whether this is an existing post being updated or not.
		 */
		public function save_rt_person_post( int $post_id, WP_Post $post, bool $update ): void {

			// Check if our nonce is set.
			if ( ! isset( $_POST['rt_person_meta_nonce'] ) ) {
				return;
			}

			// Sanitize nonce.
			$rt_person_meta_nonce = sanitize_text_field( wp_unslash( $_POST['rt_person_meta_nonce'] ) );

			// Verify that the nonce is valid.
			if ( ! wp_verify_nonce( $rt_person_meta_nonce, 'rt_person_meta_nonce' ) ) {
				return;
			}

			/** OK, it's safe for us to save the data now. */

			$rt_media_meta_box = RT_Media_Meta_Box::instance();
			$rt_media_meta_box->save_rt_movie_meta_images( $post_id );
			$rt_media_meta_box->save_rt_movie_meta_videos( $post_id );

			// Check if rt-person-meta-basic-birth-date is set. If it is set then sanitize the data and save it.
			if ( isset( $_POST['rt-person-meta-basic-birth-date'] ) ) {

				$rt_person_meta_basic_birth_date = sanitize_text_field( wp_unslash( $_POST['rt-person-meta-basic-birth-date'] ) );

				update_post_meta( $post_id, 'rt-person-meta-basic-birth-date', $rt_person_meta_basic_birth_date );

			}

			// Check if rt-person-meta-basic-birth-place is set. If it is set then sanitize the data and save it.
			if ( isset( $_POST['rt-person-meta-basic-birth-place'] ) ) {

				$rt_person_meta_basic_birth_place = sanitize_text_field( wp_unslash( $_POST['rt-person-meta-basic-birth-place'] ) );

				if ( ! is_numeric( $rt_person_meta_basic_birth_place ) ) {

					update_post_meta( $post_id, 'rt-person-meta-basic-birth-place', $rt_person_meta_basic_birth_place );

				}
			}

			// Check if rt-person-meta-social-twitter url is set. If it is set then sanitize url the data validate the data and save it.
			if ( isset( $_POST['rt-person-meta-social-twitter'] ) ) {

				$rt_person_meta_social_twitter = filter_var( wp_unslash( $_POST['rt-person-meta-social-twitter'] ), FILTER_SANITIZE_URL );

				if ( filter_var( $rt_person_meta_social_twitter, FILTER_VALIDATE_URL ) ) {

					update_post_meta( $post_id, 'rt-person-meta-social-twitter', $rt_person_meta_social_twitter );

				}
			}

			// Check if rt-person-meta-social-facebook url is set. If it is set then sanitize url the data validate the data and save it.
			if ( isset( $_POST['rt-person-meta-social-facebook'] ) ) {

				$rt_person_meta_social_facebook = filter_var( wp_unslash( $_POST['rt-person-meta-social-facebook'] ), FILTER_SANITIZE_URL );

				if ( filter_var( $rt_person_meta_social_facebook, FILTER_VALIDATE_URL ) ) {

					update_post_meta( $post_id, 'rt-person-meta-social-facebook', $rt_person_meta_social_facebook );

				}
			}

			// Check if rt-person-meta-social-instagram url is set. If it is set then sanitize url the data validate the data and save it.
			if ( isset( $_POST['rt-person-meta-social-instagram'] ) ) {

				$rt_person_meta_social_instagram = filter_var( wp_unslash( $_POST['rt-person-meta-social-instagram'] ), FILTER_SANITIZE_URL );

				if ( filter_var( $rt_person_meta_social_instagram, FILTER_VALIDATE_URL ) ) {

					update_post_meta( $post_id, 'rt-person-meta-social-instagram', $rt_person_meta_social_instagram );

				}
			}

			// Check if rt-person-meta-social-web url is set. If it is set then sanitize url the data validate the data and save it.
			if ( isset( $_POST['rt-person-meta-social-web'] ) ) {

				$rt_person_meta_social_web = filter_var( wp_unslash( $_POST['rt-person-meta-social-web'] ), FILTER_SANITIZE_URL );

				if ( filter_var( $rt_person_meta_social_web, FILTER_VALIDATE_URL ) ) {

					update_post_meta( $post_id, 'rt-person-meta-social-web', $rt_person_meta_social_web );

				}
			}
		}

	}
}
