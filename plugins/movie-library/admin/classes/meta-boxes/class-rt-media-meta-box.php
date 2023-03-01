<?php
/**
 * This file is used to create all the media meta-boxes for rt-movie and rt-person post type.
 *
 * @package MovieLib\admin\classes\meta_boxes
 */

namespace MovieLib\admin\classes\meta_boxes;

use WP_Post;
use const MovieLib\admin\classes\custom_post_types\RT_MOVIE_SLUG;
use const MovieLib\admin\classes\custom_post_types\RT_PERSON_SLUG;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

const RT_MEDIA_META_IMAGES_SLUG = 'rt-media-meta-images';
const RT_MEDIA_META_VIDEOS_SLUG = 'rt-media-meta-videos';

if ( ! class_exists( 'MovieLib\admin\classes\meta_boxes\RT_Media_Meta_Box' ) ) {

	/**
	 * This class is used to create all the meta-boxes for rt-movie post type.
	 */
	class RT_Media_Meta_Box {

		/**
		 * This function is used to create the meta-box for basic information and crew information.
		 *
		 * @return void
		 */
		public function create_meta_box():void {

			add_meta_box(
				RT_MEDIA_META_IMAGES_SLUG,
				__( 'Photos', 'movie-library' ),
				array( $this, 'rt_media_meta_images' ),
				array( RT_MOVIE_SLUG, RT_PERSON_SLUG ),
				'side',
				'high'
			);

			add_meta_box(
				RT_MEDIA_META_VIDEOS_SLUG,
				__( 'Videos', 'movie-library' ),
				array( $this, 'rt_media_meta_videos' ),
				array( RT_MOVIE_SLUG, RT_PERSON_SLUG ),
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

	}
}
