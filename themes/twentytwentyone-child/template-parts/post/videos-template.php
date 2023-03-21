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
	<div class="videos-container"> <!-- trailer-clips-container -->
		<div class="videos-heading-container"> <!-- trailer-clips-heading-container -->
			<p class="primary-text-secondary-font section-heading-text"> <!-- trailer-clips-heading -->
				<?php echo esc_html( $args['heading'] ); ?>
			</p> <!-- /trailer-clips-heading -->
		</div> <!-- /trailer-clips-heading-container -->

		<div class="videos-list-container"> <!-- trailer-clips-list-container -->
			<div class="videos-list"> <!-- trailer-clips-list-items -->
				<?php
				foreach ( $args['videos'] as $trailer_clip ) :
					?>
						<div class="video-item-container"> <!-- trailer-clips-list-item -->
							<div class="video-item"> <!-- trailer-clips-list-item-container -->
								<video src="<?php echo esc_url( wp_get_attachment_url( $trailer_clip ) ); ?>" class="video"></video>
							</div> <!-- /trailer-clips-list-item-container -->
							<div class= "video-play-button"> <!-- videos-play-button -->
								<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_play.svg' ); ?>" />
							</div> <!-- /videos-play-button -->
						</div> <!-- /trailer-clips-list-item -->
						<?php
					endforeach;
				?>
			</div> <!-- /trailer-clips-list-items -->
		</div> <!-- /trailer-clips-list-container -->
	</div> <!-- /trailer-clips-container -->

	<div id="lightbox" class="display-none"> <!-- lightbox -->
		<button id="lightbox-close-btn" class="close-btn"> <!-- lightbox-close-btn -->
			<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_close.svg' ); ?>" alt="close" />
		</button> <!-- /lightbox-close-btn -->
		<div id="lightbox-video"></div> <!-- lightbox-video -->
	</div> <!-- /lightbox -->
<?php endif; ?>
