<?php
/**
 * This file is template for the footer of the site.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since 1.0.0
 */

?>

<footer>
	<div class="st-footer-container">
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

			<?php
			$company_menu = wp_nav_menu(
				array(
					'menu'            => 'company',
					'theme_location'  => 'footer',
					'menu_class'      => 'st-company-navigation-list',
					'container'       => 'nav',
					'container_class' => 'st-company-navigation',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'fallback'        => false,
					'echo'            => false,
				)
			);

			if ( $company_menu ) :
				?>
			<div class="st-footer-company-navigation-container">
				<span class="primary-text-primary-font st-footer-company-navigation">
					<?php esc_html_e( 'Company', 'screen-time' ); ?>
				</span>

				<?php echo $company_menu; ?>
			</div>

			<?php endif; ?>


		<div class="st-footer-explore-navigation-container">
			<?php
			$explore_menu = wp_nav_menu(
				array(
					'menu'            => 'explore',
					'theme_location'  => 'footer',
					'menu_class'      => 'st-explore-navigation-list',
					'container'       => 'nav',
					'container_class' => 'st-explore-navigation',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'fallback'        => false,
					'echo'            => false,
				)
			);

			if ( $explore_menu ) :
				?>
				<div class="st-footer-company-navigation-container">
				<span class="primary-text-primary-font st-footer-company-navigation">
					<?php esc_html_e( 'Explore', 'screen-time' ); ?>
				</span>

					<?php echo $explore_menu; ?>
			</div>

			<?php endif; ?>
		</div>


	</div>

	<div class="st-footer-separator"></div>

		<div class="primary-text-primary-font st-footer-rights-reserved-text">
			<?php
			esc_html_e(
				'© 2022 ScreenTime. All Rights Reserved.
					 Terms of Service  |  Privacy Policy',
				'screen-time'
			);
			?>
		</div>
</footer>


<?php wp_footer(); ?>

</body>
</html>
