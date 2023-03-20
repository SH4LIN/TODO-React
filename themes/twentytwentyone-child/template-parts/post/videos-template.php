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
if ( ! empty( $args['videos'] ) && ! empty( $args['videos'][0] ) ) :
	?>
	<div class="st-sm-trailer-clips-container"> <!-- trailer-clips-container -->
		<div class="st-sm-trailer-clips-heading-container"> <!-- trailer-clips-heading-container -->
			<div class="primary-text-secondary-font section-heading-text st-sm-trailer-clips-heading"> <!-- trailer-clips-heading -->
				<?php echo esc_html( $args['heading'] ); ?>
			</div> <!-- /trailer-clips-heading -->
		</div> <!-- /trailer-clips-heading-container -->

		<div class="st-sm-trailer-clips-list-container"> <!-- trailer-clips-list-container -->
			<div class="st-sm-trailer-clips-list-items"> <!-- trailer-clips-list-items -->
				<?php
				foreach ( $args['videos'][0] as $trailer_clip ) :
					?>
						<div class="st-sm-trailer-clips-list-item"> <!-- trailer-clips-list-item -->
							<div class="st-sm-trailer-clips-list-item-container"> <!-- trailer-clips-list-item-container -->
								<video src="<?php echo esc_url( wp_get_attachment_url( $trailer_clip ) ); ?>" class="st-sm-trailer-clips-list-item-image st-sp-video"></video>
							</div> <!-- /trailer-clips-list-item-container -->
							<div class="st-sm-videos-play-button"> <!-- videos-play-button -->
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
