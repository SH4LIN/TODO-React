<?php
/**
 * This file is the template for the footer content like social links and logo.
 *
 * @package TwentyTwentyOneChild
 * @since 1.0.0
 */

?>
<div class="st-footer-content-container">
	<div class="st-footer-logo-text-container">
		<span class="primary-text-secondary-font st-footer-logo-first-half-text">
			<?php esc_html_e( 'Screen', 'screen-time' ); ?>
		</span>

		<span class="primary-text-secondary-font st-footer-logo-second-half-text">
			<?php esc_html_e( 'Time', 'screen-time' ); ?>
		</span>
	</div>

	<div class="primary-text-primary-font st-footer-follow-text">
		<?php esc_html_e( 'Follow us', 'screen-time' ); ?>
	</div>

	<div class="st-footer-social-container">
		<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_facebook_filled.svg' ); ?>" />
		<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_twitter_filled.svg' ); ?>" />
		<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_youtube_filled.svg' ); ?>" />
		<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_instagram_filled.svg' ); ?>" />
		<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_rss_filled.svg' ); ?>" />
	</div>
</div>
