<?php
/**
 * This file is used to display the single rt-movie post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */

?>
<div class="st-sm-trailer-clips-container">
	<div class="st-sm-trailer-clips-heading-container">
		<div class="primary-text-secondary-font section-heading-text st-sm-trailer-clips-heading">
			<?php esc_html_e( 'Trailer & Clips' ); ?>
		</div>
	</div>

	<div class="st-sm-trailer-clips-list-container">
		<div class="st-sm-trailer-clips-list-items">
			<?php
			$trailer_clips = get_post_meta( get_the_ID(), 'rt-media-meta-videos' );
			if ( ! empty( $trailer_clips ) ) {
				foreach ( $trailer_clips[0] as $trailer_clip ) {
					?>
					<div class="st-sm-trailer-clips-list-item">
						<div class="st-sm-trailer-clips-list-item-image-container">
							<img src="<?php echo esc_url( wp_get_attachment_url( $trailer_clip ) ); ?>" class="st-sm-trailer-clips-list-item-image"/>
						</div>
						<div class="st-sm-videos-play-button">
							<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_play.svg' ); ?>" />
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
</div>
