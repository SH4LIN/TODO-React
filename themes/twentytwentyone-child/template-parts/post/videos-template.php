<?php
/**
 * This file is used to display the single rt-movie post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

if (
	! isset( $args['id'] ) ||
	! isset( $args['videos'] ) ||
	! isset( $args['heading'] )
) {
	return;
}
if ( ! empty( $args['videos'] ) ) :
	?>
	<div class="videos-wrapper" id="videos">
		<div class="videos-heading-wrapper">
			<p class="primary-text-secondary-font section-heading">
				<?php echo esc_html( $args['heading'] ); ?>
			</p>
		</div>

		<div class="video-list-wrapper">
			<div class="video-list">
				<?php
				foreach ( $args['videos'] as $trailer_clip ) :
					?>
						<div class="video-item-wrapper">
							<div class="video-item">
								<video src="<?php echo esc_url( wp_get_attachment_url( $trailer_clip ) ); ?>" data-src="<?php echo esc_url( wp_get_attachment_url( $trailer_clip ) ); ?>"></video>
							</div>
							<div class= "video-play-button" data-src="<?php echo esc_url( wp_get_attachment_url( $trailer_clip ) ); ?>">
								<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_play.svg' ); ?>" />
							</div>
						</div>
						<?php
					endforeach;
				?>
			</div>
		</div>
	</div>

	<div id="lightbox" class="display-none"> <!-- lightbox -->
		<button id="lightbox-close-btn" class="close-btn"> <!-- lightbox-close-btn -->
			<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_close.svg' ); ?>" alt="close" />
		</button> <!-- /lightbox-close-btn -->
		<div id="lightbox-video"></div> <!-- lightbox-video -->
	</div> <!-- /lightbox -->
<?php endif; ?>
