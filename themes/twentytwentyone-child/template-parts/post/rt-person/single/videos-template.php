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

if ( ! empty( $videos ) && ! empty( $videos[0] ) ) :
	?>

		<div class="st-sp-videos-container">
			<div class="st-sp-videos-heading-container">
				<p class="primary-text-secondary-font section-heading-text">
					<?php esc_html_e( 'Videos', 'screen-time' ); ?>
				</p>
			</div>

			<div class="st-sp-videos-list-container">
				<div class="st-sp-videos-list">
					<?php
					foreach ( $videos[0] as $video ) :
						?>

							<div class="st-sp-videos-list-item">
							<div class="st-sp-video-list-item-container">
								<video src="<?php echo esc_url( wp_get_attachment_url( $video ) ); ?>" data-url="<?php echo esc_url( wp_get_attachment_url( $video ) ); ?>" class="st-sm-trailer-clips-list-item-image st-sp-video"></video>
							</div>

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

	<div id="lightbox" class="display-none">
		<button id="lightbox-close-btn" class="close-btn">
			<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_close.svg' ); ?>" alt="close" />
		</button>
		<div id="lightbox-video">
		</div>
	</div>

	<?php
	endif;
?>
