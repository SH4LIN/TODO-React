<?php
/**
 * This file is template for the footer of the site.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

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

?>
				</div>
			</div>
		</div>
	</div>

	<footer>
		<div class="footer-wrapper">
			<div class="footer-content-wrapper">
				<div class="footer-logo-text-wrapper">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<span class="primary-text-secondary-font footer-logo-first-half-text">
							<?php esc_html_e( 'Screen', 'screen-time' ); ?>
						</span>
					</a>

					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<span class="primary-text-secondary-font footer-logo-second-half-text">
							<?php esc_html_e( 'Time', 'screen-time' ); ?>
						</span>
					</a>
				</div>

				<p class="primary-text-primary-font footer-follow-text">
					<?php esc_html_e( 'Follow us', 'screen-time' ); ?>
				</p>

				<div class="footer-social-container">
					<a href="<?php echo esc_url( 'www.facebook.com' ); ?>"><img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_facebook_filled.svg' ); ?>" /></a>
					<a href="<?php echo esc_url( 'www.twitter.com' ); ?>"><img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_twitter_filled.svg' ); ?>" /></a>
					<a href="<?php echo esc_url( 'www.youtube.com' ); ?>"><img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_youtube_filled.svg' ); ?>" /></a>
					<a href="<?php echo esc_url( 'www.instagram.com' ); ?>"><img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_instagram_filled.svg' ); ?>" /></a>
					<a href="<?php echo esc_url( 'www.google.com' ); ?>"><img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_rss_filled.svg' ); ?>" /></a>
				</div>
			</div>

			<?php
			if ( $company_menu ) :
				$display_menu = array(
					'name' => __( 'Company', 'screen-time' ),
					'menu' => $company_menu,
				);
				?>

				<div class="footer-company-navigation-wrapper">
					<?php get_template_part( 'template-parts/footer/footer-menu', null, $display_menu ); ?>
				</div>

			<?php endif; ?>

			<?php
			if ( $explore_menu ) :
				$display_menu = array(
					'name' => __( 'Explore', 'screen-time' ),
					'menu' => $explore_menu,
				);
				?>

				<div class="footer-explore-navigation-wrapper">
					<?php get_template_part( 'template-parts/footer/footer-menu', null, $display_menu ); ?>
				</div>

			<?php endif; ?>

			<div class="footer-separator"></div>

			<div class="primary-text-primary-font footer-rights-reserved-text">
				<?php
				esc_html_e(
					'© 2022 ScreenTime. All Rights Reserved.
					Terms of Service  |  Privacy Policy',
					'screen-time'
				);
				?>
			</div>
		</div>
	</footer>
<?php
wp_footer();
?>
	</body> <!-- /body -->
</html> <!-- /html -->
