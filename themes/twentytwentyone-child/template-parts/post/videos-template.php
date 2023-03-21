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
	<div class="videos-container">
		<div class="videos-heading-container">
			<p class="primary-text-secondary-font section-heading-text">
				<?php echo esc_html( $args['heading'] ); ?>
			</p>
		</div>

		<div class="videos-list-container">
			<div class="videos-list">
				<?php
				foreach ( $args['videos'] as $trailer_clip ) :
					?>
						<div class="video-item-container">
							<div class="video-item">
								<video src="<?php echo esc_url( wp_get_attachment_url( $trailer_clip ) ); ?>" class="video"></video>
							</div>
							<div class= "video-play-button">
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
