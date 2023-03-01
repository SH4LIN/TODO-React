<?php
/**
 * This file is used to create all the meta-boxes for rt-person post type.
 *
 * @package MovieLib\admin\classes\meta_boxes
 */

namespace MovieLib\admin\classes\meta_boxes;

use WP_Post;
use const MovieLib\admin\classes\custom_post_types\RT_PERSON_SLUG;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

const RT_PERSON_META_BASIC_SLUG  = 'rt-person-meta-basic';
const RT_PERSON_META_SOCIAL_SLUG = 'rt-person-meta-social';

if ( ! class_exists( 'MovieLib\admin\classes\meta_boxes\RT_Person_Meta_Box' ) ) {

	/**
	 * This class is used to create all the meta-boxes for rt-movie post type.
	 */
	class RT_Person_Meta_Box {

		/**
		 * This function is used to create the meta-box for basic information and crew information.
		 *
		 * @return void
		 */
		public function create_meta_box():void {

			add_meta_box(
				RT_PERSON_META_BASIC_SLUG,
				__( 'Basic', 'movie-library' ),
				array( $this, 'rt_person_meta_basic' ),
				array( RT_PERSON_SLUG ),
				'side',
				'high'
			);

			add_meta_box(
				RT_PERSON_META_SOCIAL_SLUG,
				__( 'Social', 'movie-library' ),
				array( $this, 'rt_person_meta_social' ),
				array( RT_PERSON_SLUG ),
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

				</div>

			</div>

			<?php

		}

	}
}
