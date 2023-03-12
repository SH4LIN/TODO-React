<?php
/**
 * This file is used to create all the meta-boxes for rt-person post type.
 *
 * @package MovieLib\admin\classes\meta_boxes
 */

namespace MovieLib\admin\classes\meta_boxes;

use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\includes\Singleton;
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

		use Singleton;

		/**
		 * RT_PERSON_META_BASIC_SLUG
		 */
		const PERSON_META_BASIC_SLUG = 'rt-person-meta-basic';

		/**
		 * RT_PERSON_META_SOCIAL_SLUG
		 */
		const PERSON_META_SOCIAL_SLUG = 'rt-person-meta-social';

		/**
		 * PERSON_META_BASIC_BIRTH_DATE_SLUG
		 */
		const PERSON_META_BASIC_BIRTH_DATE_SLUG = 'rt-person-meta-basic-birth-date';

		/**
		 * PERSON_META_BASIC_BIRTH_PLACE_SLUG
		 */
		const PERSON_META_BASIC_BIRTH_PLACE_SLUG = 'rt-person-meta-basic-birth-place';

		/**
		 * PERSON_META_BASIC_BIRTH_DATE_SLUG
		 */
		const PERSON_META_BASIC_FULL_NAME_SLUG = 'rt-person-meta-basic-full-name';

		/**
		 * PERSON_META_BASIC_BIRTH_DATE_SLUG
		 */
		const PERSON_META_BASIC_START_YEAR_SLUG = 'rt-person-meta-basic-start-year';

		/**
		 * PERSON_META_SOCIAL_TWITTER_SLUG
		 */
		const PERSON_META_SOCIAL_TWITTER_SLUG = 'rt-person-meta-social-twitter';

		/**
		 * PERSON_META_SOCIAL_FACEBOOK_SLUG
		 */
		const PERSON_META_SOCIAL_FACEBOOK_SLUG = 'rt-person-meta-social-facebook';

		/**
		 * PERSON_META_SOCIAL_INSTAGRAM_SLUG
		 */
		const PERSON_META_SOCIAL_INSTAGRAM_SLUG = 'rt-person-meta-social-instagram';

		/**
		 * PERSON_META_SOCIAL_WEB_SLUG
		 */
		const PERSON_META_SOCIAL_WEB_SLUG = 'rt-person-meta-social-web';

		/**
		 * RT_Person_Meta_Box init method.
		 *
		 * @return void
		 */
		protected function init(): void {

			add_action( 'add_meta_boxes', array( $this, 'create_meta_box' ) );

		}

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

			// This will be used to add the nonce field.
			wp_nonce_field( 'rt_person_meta_nonce', 'rt_person_meta_nonce' );

			?>

			<div class = "rt-person-meta-fields rt-person-meta-basic-fields">
				<div class = "rt-person-meta-container rt-person-meta-basic-container rt-person-meta-basic-birth-date-container">
					<label class = "rt-person-meta-label rt-person-meta-basic-label rt-person-meta-basic-birth-date-label"
						for = "<?php echo esc_attr( self::PERSON_META_BASIC_BIRTH_DATE_SLUG ); ?>">
						<?php esc_html_e( 'Birth Date', 'movie-library' ); ?>
					</label>

					<?php
					$birth_date = '';
					if ( isset( $rt_person_meta_basic_data[ self::PERSON_META_BASIC_BIRTH_DATE_SLUG ] ) ) {
						$birth_date = $rt_person_meta_basic_data[ self::PERSON_META_BASIC_BIRTH_DATE_SLUG ][0];
					}
					?>

					<input type = "date"
						value = "<?php echo esc_attr( $birth_date ); ?>"
						class = "rt-person-meta-field rt-person-meta-basic-field rt-person-meta-basic-birth-date-field"
						name = "<?php echo esc_attr( self::PERSON_META_BASIC_BIRTH_DATE_SLUG ); ?>"
						id = "<?php echo esc_attr( self::PERSON_META_BASIC_BIRTH_DATE_SLUG ); ?>" />
				</div>

				<div class = "rt-person-meta-container rt-person-meta-basic-container rt-person-meta-basic-birth-place-container">
					<label class = "rt-person-meta-label rt-person-meta-basic-label rt-person-meta-basic-birth-place-label"
						for = "<?php echo esc_attr( self::PERSON_META_BASIC_BIRTH_PLACE_SLUG ); ?>">
						<?php esc_html_e( 'Birth Place', 'movie-library' ); ?>
					</label>

					<?php
					$birth_place = '';
					if ( isset( $rt_person_meta_basic_data[ self::PERSON_META_BASIC_BIRTH_PLACE_SLUG ] ) ) {
						$birth_place = $rt_person_meta_basic_data[ self::PERSON_META_BASIC_BIRTH_PLACE_SLUG ][0];
					}
					?>

					<input type = "text"
						value = "<?php echo esc_attr( $birth_place ); ?>"
						class = "rt-person-meta-field rt-person-meta-basic-field rt-person-meta-basic-birth-place-field"
						name = "<?php echo esc_attr( self::PERSON_META_BASIC_BIRTH_PLACE_SLUG ); ?>"
						id = "<?php echo esc_attr( self::PERSON_META_BASIC_BIRTH_PLACE_SLUG ); ?>" />
				</div>

				<div class = "rt-person-meta-container rt-person-meta-basic-container rt-person-meta-basic-full-name-container">
					<label class = "rt-person-meta-label rt-person-meta-basic-label rt-person-meta-basic-full-name-label"
						for = "<?php echo esc_attr( self::PERSON_META_BASIC_FULL_NAME_SLUG ); ?>">
						<?php esc_html_e( 'Full Name', 'movie-library' ); ?>
					</label>

					<?php
					$full_name = '';
					if ( isset( $rt_person_meta_basic_data[ self::PERSON_META_BASIC_FULL_NAME_SLUG ] ) ) {
						$full_name = $rt_person_meta_basic_data[ self::PERSON_META_BASIC_FULL_NAME_SLUG ][0];
					}
					?>

					<input type = "text"
						value = "<?php echo esc_attr( $full_name ); ?>"
						class = "rt-person-meta-field rt-person-meta-basic-field rt-person-meta-basic-full-name-field"
						name = "<?php echo esc_attr( self::PERSON_META_BASIC_FULL_NAME_SLUG ); ?>"
						id = "<?php echo esc_attr( self::PERSON_META_BASIC_FULL_NAME_SLUG ); ?>" />
				</div>

				<div class = "rt-person-meta-container rt-person-meta-basic-container rt-person-meta-basic-start-year-container">
					<label class = "rt-person-meta-label rt-person-meta-basic-label rt-person-meta-basic-start-year-label"
						for = "<?php echo esc_attr( self::PERSON_META_BASIC_START_YEAR_SLUG ); ?>">
						<?php esc_html_e( 'Started Career', 'movie-library' ); ?>
					</label>

					<?php
					$start_year = '';
					if ( isset( $rt_person_meta_basic_data[ self::PERSON_META_BASIC_START_YEAR_SLUG ] ) ) {
						$start_year = $rt_person_meta_basic_data[ self::PERSON_META_BASIC_START_YEAR_SLUG ][0];
					}
					?>

					<input type = "date"
						value = "<?php echo esc_attr( $start_year ); ?>"
						class = "rt-person-meta-field rt-person-meta-basic-field rt-person-meta-basic-start-year-field"
						name = "<?php echo esc_attr( self::PERSON_META_BASIC_START_YEAR_SLUG ); ?>"
						id = "<?php echo esc_attr( self::PERSON_META_BASIC_START_YEAR_SLUG ); ?>" />
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

			wp_nonce_field( 'rt_person_meta_nonce', 'rt_person_meta_nonce' );

			?>

			<div class = "rt-person-meta-fields rt-person-meta-social-fields">
				<div class = "rt-person-meta-container rt-person-meta-social-container rt-person-meta-social-twitter-container">
					<label class = "rt-person-meta-label rt-person-meta-social-label rt-person-meta-social-twitter-label"
						for = "<?php echo esc_attr( self::PERSON_META_SOCIAL_TWITTER_SLUG ); ?>">
						<?php esc_html_e( 'Twitter', 'movie-library' ); ?>
					</label>

					<?php
					$twitter = '';
					if ( isset( $rt_person_meta_social_data[ self::PERSON_META_SOCIAL_TWITTER_SLUG ] ) ) {
						$twitter = $rt_person_meta_social_data[ self::PERSON_META_SOCIAL_TWITTER_SLUG ][0];
					}
					?>

					<input type = "text"
						value = "<?php echo esc_url( $twitter ); ?>"
						class = "rt-person-meta-field rt-person-meta-social-field rt-person-meta-social-twitter-field"
						name = "<?php echo esc_attr( self::PERSON_META_SOCIAL_TWITTER_SLUG ); ?>"
						id = "<?php echo esc_attr( self::PERSON_META_SOCIAL_TWITTER_SLUG ); ?>"/>

					<span class = "rt-person-meta-field-error rt-person-meta-social-field-error rt-person-meta-social-twitter-field-error" id="rt-person-meta-social-twitter-field-error"></span>
				</div>

				<div class = "rt-person-meta-container rt-person-meta-social-container rt-person-meta-social-facebook-container">
					<label class = "rt-person-meta-label rt-person-meta-social-label rt-person-meta-social-facebook-label"
						for = "<?php echo esc_attr( self::PERSON_META_SOCIAL_FACEBOOK_SLUG ); ?>">
						<?php esc_html_e( 'Facebook', 'movie-library' ); ?>
					</label>

					<?php
					$facebook = '';
					if ( isset( $rt_person_meta_social_data[ self::PERSON_META_SOCIAL_FACEBOOK_SLUG ] ) ) {
						$facebook = $rt_person_meta_social_data[ self::PERSON_META_SOCIAL_FACEBOOK_SLUG ][0];
					}
					?>

					<input type = "text"
						value = "<?php echo esc_url( $facebook ); ?>"
						class = "rt-person-meta-field rt-person-meta-social-field rt-person-meta-social-facebook-field"
						name = "<?php echo esc_attr( self::PERSON_META_SOCIAL_FACEBOOK_SLUG ); ?>"
						id = "<?php echo esc_attr( self::PERSON_META_SOCIAL_FACEBOOK_SLUG ); ?>"/>

					<span class = "rt-person-meta-field-error rt-person-meta-social-field-error rt-person-meta-social-facebook-field-error" id="rt-person-meta-social-facebook-field-error"></span>
				</div>

				<div class = "rt-person-meta-container rt-person-meta-social-container rt-person-meta-social-instagram-container">
					<label class = "rt-person-meta-label rt-person-meta-social-label rt-person-meta-social-instagram-label"
						for = "<?php echo esc_attr( self::PERSON_META_SOCIAL_INSTAGRAM_SLUG ); ?>">
						<?php esc_html_e( 'Instagram', 'movie-library' ); ?>
					</label>

					<?php
					$instagram = '';
					if ( isset( $rt_person_meta_social_data[ self::PERSON_META_SOCIAL_INSTAGRAM_SLUG ] ) ) {
						$instagram = $rt_person_meta_social_data[ self::PERSON_META_SOCIAL_INSTAGRAM_SLUG ][0];
					}
					?>

					<input type = "text"
						value = "<?php echo esc_url( $instagram ); ?>"
						class = "rt-person-meta-field rt-person-meta-social-field rt-person-meta-social-instagram-field"
						name = "<?php echo esc_attr( self::PERSON_META_SOCIAL_INSTAGRAM_SLUG ); ?>"
						id = "<?php echo esc_attr( self::PERSON_META_SOCIAL_INSTAGRAM_SLUG ); ?>"/>

					<span class = "rt-person-meta-field-error rt-person-meta-social-field-error rt-person-meta-social-instagram-field-error" id="rt-person-meta-social-instagram-field-error"></span>
				</div>

				<div class = "rt-person-meta-container rt-person-meta-social-container rt-person-meta-social-website-container">
					<label class = "rt-person-meta-label rt-person-meta-social-label rt-person-meta-social-website-label"
						for = "<?php echo esc_attr( self::PERSON_META_SOCIAL_WEB_SLUG ); ?>">
						<?php esc_html_e( 'Website', 'movie-library' ); ?>
					</label>

					<?php
					$website = '';
					if ( isset( $rt_person_meta_social_data[ self::PERSON_META_SOCIAL_WEB_SLUG ] ) ) {
						$website = $rt_person_meta_social_data[ self::PERSON_META_SOCIAL_WEB_SLUG ][0];
					}
					?>

					<input type = "text"
						value = "<?php echo esc_url( $website ); ?>"
						class = "rt-person-meta-field rt-person-meta-social-field rt-person-meta-social-website-field"
						name = "<?php echo esc_attr( self::PERSON_META_SOCIAL_WEB_SLUG ); ?>"
						id = "<?php echo esc_attr( self::PERSON_META_SOCIAL_WEB_SLUG ); ?>" />

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
			$rt_media_meta_box->save_rt_movie_meta_banner_images( $post_id );
			$rt_media_meta_box->save_rt_movie_meta_videos( $post_id );

			// Check if self::PERSON_META_BASIC_BIRTH_DATE_SLUG is set. If it is set then sanitize the data and save it.
			if ( isset( $_POST[ self::PERSON_META_BASIC_BIRTH_DATE_SLUG ] ) ) {

				$rt_person_meta_basic_birth_date = sanitize_text_field( wp_unslash( $_POST[ self::PERSON_META_BASIC_BIRTH_DATE_SLUG ] ) );

				update_post_meta( $post_id, self::PERSON_META_BASIC_BIRTH_DATE_SLUG, $rt_person_meta_basic_birth_date );

			}

			// Check if self::PERSON_META_BASIC_BIRTH_PLACE_SLUG is set. If it is set then sanitize the data and save it.
			if ( isset( $_POST[ self::PERSON_META_BASIC_BIRTH_PLACE_SLUG ] ) ) {

				$rt_person_meta_basic_birth_place = sanitize_text_field( wp_unslash( $_POST[ self::PERSON_META_BASIC_BIRTH_PLACE_SLUG ] ) );

				if ( ! is_numeric( $rt_person_meta_basic_birth_place ) ) {

					update_post_meta( $post_id, self::PERSON_META_BASIC_BIRTH_PLACE_SLUG, $rt_person_meta_basic_birth_place );

				}
			}

			if ( isset( $_POST[ self::PERSON_META_BASIC_FULL_NAME_SLUG ] ) ) {

				$rt_person_meta_basic_full_name = sanitize_text_field( wp_unslash( $_POST[ self::PERSON_META_BASIC_FULL_NAME_SLUG ] ) );

				if ( ! is_numeric( $rt_person_meta_basic_full_name ) ) {

					update_post_meta( $post_id, self::PERSON_META_BASIC_FULL_NAME_SLUG, $rt_person_meta_basic_full_name );

				}
			}

			if ( isset( $_POST[ self::PERSON_META_BASIC_START_YEAR_SLUG ] ) ) {

				$rt_person_meta_basic_full_name = sanitize_text_field( wp_unslash( $_POST[ self::PERSON_META_BASIC_START_YEAR_SLUG ] ) );

				if ( ! is_numeric( $rt_person_meta_basic_full_name ) ) {

					update_post_meta( $post_id, self::PERSON_META_BASIC_START_YEAR_SLUG, $rt_person_meta_basic_full_name );

				}
			}

			// Check if self::PERSON_META_SOCIAL_TWITTER_SLUG url is set. If it is set then sanitize url the data validate the data and save it.
			if ( isset( $_POST[ self::PERSON_META_SOCIAL_TWITTER_SLUG ] ) ) {

				$rt_person_meta_social_twitter = filter_var( wp_unslash( $_POST[ self::PERSON_META_SOCIAL_TWITTER_SLUG ] ), FILTER_SANITIZE_URL );

				if ( filter_var( $rt_person_meta_social_twitter, FILTER_VALIDATE_URL ) ) {

					update_post_meta( $post_id, self::PERSON_META_SOCIAL_TWITTER_SLUG, $rt_person_meta_social_twitter );

				} else {

					update_post_meta( $post_id, self::PERSON_META_SOCIAL_TWITTER_SLUG, '' );

				}
			}

			// Check if self::PERSON_META_SOCIAL_FACEBOOK_SLUG url is set. If it is set then sanitize url the data validate the data and save it.
			if ( isset( $_POST[ self::PERSON_META_SOCIAL_FACEBOOK_SLUG ] ) ) {

				$rt_person_meta_social_facebook = filter_var( wp_unslash( $_POST[ self::PERSON_META_SOCIAL_FACEBOOK_SLUG ] ), FILTER_SANITIZE_URL );

				if ( filter_var( $rt_person_meta_social_facebook, FILTER_VALIDATE_URL ) ) {

					update_post_meta( $post_id, self::PERSON_META_SOCIAL_FACEBOOK_SLUG, $rt_person_meta_social_facebook );

				} else {

					update_post_meta( $post_id, self::PERSON_META_SOCIAL_FACEBOOK_SLUG, '' );

				}
			}

			// Check if self::PERSON_META_SOCIAL_INSTAGRAM_SLUG url is set. If it is set then sanitize url the data validate the data and save it.
			if ( isset( $_POST[ self::PERSON_META_SOCIAL_INSTAGRAM_SLUG ] ) ) {

				$rt_person_meta_social_instagram = filter_var( wp_unslash( $_POST[ self::PERSON_META_SOCIAL_INSTAGRAM_SLUG ] ), FILTER_SANITIZE_URL );

				if ( filter_var( $rt_person_meta_social_instagram, FILTER_VALIDATE_URL ) ) {

					update_post_meta( $post_id, self::PERSON_META_SOCIAL_INSTAGRAM_SLUG, $rt_person_meta_social_instagram );

				} else {

					update_post_meta( $post_id, self::PERSON_META_SOCIAL_INSTAGRAM_SLUG, '' );

				}
			}

			// Check if self::PERSON_META_SOCIAL_WEB_SLUG url is set. If it is set then sanitize url the data validate the data and save it.
			if ( isset( $_POST[ self::PERSON_META_SOCIAL_WEB_SLUG ] ) ) {

				$rt_person_meta_social_web = filter_var( wp_unslash( $_POST[ self::PERSON_META_SOCIAL_WEB_SLUG ] ), FILTER_SANITIZE_URL );

				if ( filter_var( $rt_person_meta_social_web, FILTER_VALIDATE_URL ) ) {

					update_post_meta( $post_id, self::PERSON_META_SOCIAL_WEB_SLUG, $rt_person_meta_social_web );

				} else {

					update_post_meta( $post_id, self::PERSON_META_SOCIAL_WEB_SLUG, '' );

				}
			}
		}

	}
}
