<?php
/**
 * This file is used to create all the media meta-boxes for rt-movie and rt-person post type.
 *
 * @package MovieLib\admin\classes\meta_boxes
 */

namespace MovieLib\admin\classes\meta_boxes;

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\includes\Singleton;
use WP_Post;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\meta_boxes\RT_Media_Meta_Box' ) ) {

	/**
	 * This class is used to create all media meta-boxes for rt-movie and rt-person post type.
	 */
	class RT_Media_Meta_Box {

		use Singleton;

		/**
		 * RT_MEDIA_META_IMAGES_SLUG
		 */
		const IMAGES_SLUG = 'rt-media-meta-images';

		/**
		 * RT_MEDIA_META_VIDEOS_SLUG
		 */
		const VIDEOS_SLUG = 'rt-media-meta-videos';

		/**
		 * RT_Media_Meta_Box init method.
		 *
		 * @return void
		 */
		protected function init():void {

			add_action( 'add_meta_boxes', array( $this, 'create_meta_box' ) );

		}

		/**
		 * This function is used to create the meta-box for photos and videos.
		 *
		 * @return void
		 */
		public function create_meta_box():void {

			add_meta_box(
				self::IMAGES_SLUG,
				__( 'Photos', 'movie-library' ),
				array( $this, 'rt_media_meta_images' ),
				array( RT_Movie::SLUG, RT_Person::SLUG ),
				'side',
				'high'
			);

			add_meta_box(
				self::VIDEOS_SLUG,
				__( 'Videos', 'movie-library' ),
				array( $this, 'rt_media_meta_videos' ),
				array( RT_Movie::SLUG, RT_Person::SLUG ),
				'side',
				'high'
			);
		}

		/**
		 * This function is used to create the meta box for the movie images.
		 *
		 * @param WP_Post $post The post object.
		 *
		 * @return void
		 */
		public function rt_media_meta_images( WP_Post $post ): void {

			$rt_media_meta_images_key = array(
				'images' => 'rt-media-meta-images',
			);

			$rt_media_meta_images_data_attachment_ids =
				get_post_meta( $post->ID, $rt_media_meta_images_key['images'] );

			wp_nonce_field( 'rt_media_meta_nonce', 'rt_media_meta_nonce' );

			?>

			<div class = "rt-media-meta-fields rt-media-meta-images">

				<?php
				if ( isset( $rt_media_meta_images_data_attachment_ids ) && ! empty( $rt_media_meta_images_data_attachment_ids[0] ) ) {

					?>

					<input name = "rt-media-meta-uploaded-images"
						value = "<?php echo esc_attr( wp_json_encode( $rt_media_meta_images_data_attachment_ids[0] ) ); ?>"
						hidden = "hidden">

					<h3 class = "rt-media-meta-heading rt-media-meta-images-heading rt-media-meta-uploaded-images-heading">
						<?php esc_html_e( 'Uploaded Images', 'movie-library' ); ?>
					</h3>

					<?php
				}
				?>

				<div class = "rt-media-meta-container rt-media-meta-images-container rt-media-meta-uploaded-images-container">

					<?php

					if ( isset( $rt_media_meta_images_data_attachment_ids ) && ! empty( $rt_media_meta_images_data_attachment_ids[0] ) ) {

						foreach ( $rt_media_meta_images_data_attachment_ids[0] as $rt_media_meta_image_attachment_id ) {

							$image_url = wp_get_attachment_image_url( $rt_media_meta_image_attachment_id );

							if ( ! $image_url ) {
								continue;
							}

							?>

							<div class = "rt-media-meta rt-media-meta-image rt-media-meta-uploaded-image">
								<img src = "<?php echo esc_url( $image_url ); ?>" alt = "">

								<span class = "rt-media-meta-remove rt-media-meta-image-remove rt-media-meta-uploaded-image-remove"
									data-id = "<?php echo esc_attr( $rt_media_meta_image_attachment_id ); ?>">
										X
								</span>
							</div>

							<?php
						}

						?>

						<?php

					}

					?>

				</div>

			</div>

			<div class = "rt-media-meta-container rt-media-meta-images-container rt-media-meta-selected-images-container"
				id = "rt-media-meta-selected-images-container">
			</div>

			<input name = "rt-media-meta-selected-images" hidden = "hidden">

			<button class = "rt-media-meta-add rt-media-meta-add rt-media-meta-images-add"
				type = "button">
				<?php esc_html_e( 'Add Images', 'movie-library' ); ?>
			</button>

			<?php
		}

		/**
		 * This function will add the meta box for videos in rt-movie and rt-person post type.
		 * It will also add the functionality to add and remove videos.
		 * It will also save the videos in the database.
		 * It will also add the functionality to add videos from the media library.
		 *
		 * @param WP_Post $post The post object.
		 *
		 * @return void
		 */
		public function rt_media_meta_videos( WP_Post $post ): void {

			$rt_media_meta_videos_key = array(
				'images' => 'rt-media-meta-videos',
			);

			$rt_media_meta_videos_data_attachment_ids =
				get_post_meta( $post->ID, $rt_media_meta_videos_key['images'] );

			wp_nonce_field( 'rt_media_meta_nonce', 'rt_media_meta_nonce' );

			?>

			<div class = "rt-media-meta-fields rt-media-meta-videos">
				<div class = "rt-media-meta-container rt-media-meta-videos-container rt-media-meta-uploaded-videos-container">

					<?php

					if ( isset( $rt_media_meta_videos_data_attachment_ids ) && ! empty( $rt_media_meta_videos_data_attachment_ids[0] ) ) {

						?>

						<input name = "rt-media-meta-uploaded-videos"
							value = "<?php echo esc_attr( wp_json_encode( $rt_media_meta_videos_data_attachment_ids[0] ) ); ?>"
							hidden = "hidden">

						<h3 class = "rt-media-meta-heading rt-media-meta-videos-heading rt-media-meta-uploaded-videos-heading">
							<?php esc_html_e( 'Uploaded Videos', 'movie-library' ); ?>
						</h3>

						<?php

						foreach ( $rt_media_meta_videos_data_attachment_ids[0] as $rt_media_meta_video_attachment_id ) {

							$video_url = wp_get_attachment_url( $rt_media_meta_video_attachment_id );

							if ( ! $video_url ) {
								continue;
							}

							?>

							<div class = "rt-media-meta rt-media-meta-video rt-media-meta-uploaded-video">
								<video>
									<source src = "<?php echo esc_url( $video_url ); ?>">
								</video>

								<span class = "rt-media-meta-remove rt-media-meta-video-remove rt-media-meta-uploaded-video-remove"
									data-id = "<?php echo esc_attr( $rt_media_meta_video_attachment_id ); ?>">
										X
								</span>
							</div>

							<?php

						}

						?>

						<?php

					}

					?>

				</div>

				<div class = "rt-media-meta-container rt-media-meta-videos-container rt-media-meta-selected-videos-container"
					id = "rt-media-meta-selected-videos-container">
				</div>

				<button class = "rt-media-meta-add rt-media-meta-add rt-media-meta-videos-add"
					type = "button">
					<?php esc_html_e( 'Add Videos', 'movie-library' ); ?>
				</button>

				<input name = "rt-media-meta-selected-videos" hidden = "hidden">

			</div>

			<?php
		}

		/**
		 * This function is used to save the rt-movie-meta-images meta field in the database.
		 * This function will have two array one for selected videos and another for uploaded images.
		 * If the selected images array is not empty then it will update the meta field in the database.
		 * If the uploaded images array is not empty then it will update the meta field in the database.
		 * If both the arrays are empty then it will delete the meta field from the database.
		 *
		 * @param int $post_id Post ID.
		 *
		 * @return void
		 */
		public function save_rt_movie_meta_images( int $post_id ): void {

			// Check if our nonce is set.
			if ( ! isset( $_POST['rt_media_meta_nonce'] ) ) {
				return;
			}

			// Sanitize nonce.
			$rt_movie_meta_nonce = sanitize_text_field( wp_unslash( $_POST['rt_media_meta_nonce'] ) );

			// Verify that the nonce is valid.
			if ( ! wp_verify_nonce( $rt_movie_meta_nonce, 'rt_media_meta_nonce' ) ) {
				return;
			}

			/** OK, it's safe for us to save the data now. */

			$rt_movie_meta_selected_images = array();
			$rt_movie_meta_uploaded_images = array();

			// Checking if rt-movie-meta-images is available in $_POST.
			if ( isset( $_POST['rt-media-meta-selected-images'] ) && ! empty( $_POST['rt-media-meta-selected-images'] ) ) {

				// Sanitize user input.
				$rt_movie_meta_sanitized_selected_images = sanitize_text_field( wp_unslash( $_POST['rt-media-meta-selected-images'] ) );

				$rt_movie_meta_selected_images = json_decode( $rt_movie_meta_sanitized_selected_images, false );

			}

			if ( isset( $_POST['rt-media-meta-uploaded-images'] ) && ! empty( $_POST['rt-media-meta-uploaded-images'] ) ) {

				// Sanitize user input.
				$rt_movie_meta_sanitized_uploaded_images = sanitize_text_field( wp_unslash( $_POST['rt-media-meta-uploaded-images'] ) );

				$rt_movie_meta_uploaded_images = json_decode( $rt_movie_meta_sanitized_uploaded_images, false );

			}

			if ( ! is_array( $rt_movie_meta_selected_images ) ) {

				$rt_movie_meta_selected_images = array();

			}

			if ( ! is_array( $rt_movie_meta_uploaded_images ) ) {

				$rt_movie_meta_uploaded_images = array();

			}

			$rt_media_meta_images = array_unique( array_merge( $rt_movie_meta_selected_images, $rt_movie_meta_uploaded_images ) );

			foreach ( $rt_media_meta_images as $key => $value ) {

				if ( ! wp_get_attachment_image_url( $value ) ) {

					unset( $rt_media_meta_images[ $key ] );

				}
			}
			if ( empty( $rt_media_meta_images ) ) {

				delete_post_meta( $post_id, 'rt-media-meta-images' );

			} else {

				update_post_meta( $post_id, 'rt-media-meta-images', $rt_media_meta_images );

			}

		}

		/**
		 * This function is used to save the rt-movie-meta-videos meta field in the database.
		 * This function will have two array one for selected videos and another for uploaded videos.
		 * If the selected videos array is not empty then it will update the meta field in the database.
		 * If the uploaded videos array is not empty then it will update the meta field in the database.
		 * If both the arrays are empty then it will delete the meta field from the database.
		 *
		 * @param int $post_id The post id.
		 *
		 * @return void
		 */
		public function save_rt_movie_meta_videos( int $post_id ): void {

			// Check if our nonce is set.
			if ( ! isset( $_POST['rt_media_meta_nonce'] ) ) {
				return;
			}

			// Sanitize nonce.
			$rt_movie_meta_nonce = sanitize_text_field( wp_unslash( $_POST['rt_media_meta_nonce'] ) );

			// Verify that the nonce is valid.
			if ( ! wp_verify_nonce( $rt_movie_meta_nonce, 'rt_media_meta_nonce' ) ) {
				return;
			}

			/** OK, it's safe for us to save the data now. */

			$rt_movie_meta_selected_videos = array();
			$rt_movie_meta_uploaded_videos = array();

			// Checking if rt-movie-meta-images is available in $_POST.
			if ( isset( $_POST['rt-media-meta-selected-videos'] ) && ! empty( $_POST['rt-media-meta-selected-videos'] ) ) {

				// Sanitize user input.
				$rt_movie_meta_sanitized_selected_videos = sanitize_text_field( wp_unslash( $_POST['rt-media-meta-selected-videos'] ) );

				$rt_movie_meta_selected_videos = json_decode( $rt_movie_meta_sanitized_selected_videos, false );

			}

			if ( isset( $_POST['rt-media-meta-uploaded-videos'] ) && ! empty( $_POST['rt-media-meta-uploaded-videos'] ) ) {

				// Sanitize user input.
				$rt_movie_meta_sanitized_uploaded_videos = sanitize_text_field( wp_unslash( $_POST['rt-media-meta-uploaded-videos'] ) );

				$rt_movie_meta_uploaded_videos = json_decode( $rt_movie_meta_sanitized_uploaded_videos, false );

			}

			if ( ! is_array( $rt_movie_meta_selected_videos ) ) {

				$rt_movie_meta_selected_videos = array();

			}
			if ( ! is_array( $rt_movie_meta_uploaded_videos ) ) {

				$rt_movie_meta_uploaded_videos = array();

			}

			$rt_media_meta_videos = array_unique( array_merge( $rt_movie_meta_selected_videos, $rt_movie_meta_uploaded_videos ) );

			foreach ( $rt_media_meta_videos as $key => $video ) {

				if ( ! wp_get_attachment_url( $video ) ) {

					unset( $rt_media_meta_videos[ $key ] );

				}
			}

			if ( empty( $rt_media_meta_videos ) ) {

				delete_post_meta( $post_id, 'rt-media-meta-videos' );

			} else {

				update_post_meta( $post_id, 'rt-media-meta-videos', $rt_media_meta_videos );

			}
		}

	}
}
