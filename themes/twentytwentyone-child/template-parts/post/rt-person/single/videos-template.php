<?php
/**
 * This file is used to display the videos sections of the rt-person post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since 1.0.0
 */


if ( ! isset( $args['id'] ) || ! isset( $args['videos'] ) ) {
	return;
}

$videos = $args['videos'];

if ( ! empty( $videos ) ) :
	?>

		<div class="st-sp-videos-container">
			<div class="st-sp-videos-heading-container">
				<p class="primary-text-secondary-font section-heading-text">
					<?php esc_html_e( 'Videos' ); ?>
				</p>
			</div>

			<div class="st-sp-videos-list-container">
				<div class="st-sp-videos-list">
					<?php
					foreach ( $videos[0] as $video ) :
						?>

						<div class="st-sp-videos-list-item">
							<img src="<?php echo esc_url( wp_get_attachment_image_url( $video, 'full' ) ); ?>" />
							<div class="st-sp-videos-play-button">
								<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_play.svg' ); ?>" />
							</div>
						</div>

						<?php

					endforeach;
					?>
				</div>
			</div>

		</div>

	<?php
	endif;
?>
