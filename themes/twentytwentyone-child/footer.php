<?php
/**
 * This file is template for the footer of the site.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */

$cst_footer_logo = has_custom_logo() ? get_custom_logo() : '<h2 class="st-header-logo">Screen <span>Time</span></h2>';
$privacy_link    = get_privacy_policy_url( '<div class="privacy-policy">', '</div>' );

?>

				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!-- #content -->
			<footer class="st-footer"> <!-- .st-footer -->
				<div class="st-container">
					<div class="st-footer-inner">
						<div class="st-footer-info">
							<div class="st-footer-logo">
								<?php echo $cst_footer_logo; ?>
							</div>
							<div class="st-footer-social">
								<p class="st-footer-social-heading">
									<?php esc_html_e( 'Follow us', 'screen-time' ); ?>
								</p>
								<ul class="st-footer-social-list">
									<li class="st-footer-social-list-item">
										<a href="https://www.instagram.com/screentimeapp/" target="_blank" rel="noopener noreferrer">
											<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/instagram.svg'; ?>" alt="Instagram">
										</a>
									</li>
									<li class="st-footer-social-list-item">
										<a href="https://www.instagram.com/screentimeapp/" target="_blank" rel="noopener noreferrer">
											<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/instagram.svg'; ?>" alt="Instagram">
										</a>
									</li>
									<li class="st-footer-social-list-item">
										<a href="https://www.instagram.com/screentimeapp/" target="_blank" rel="noopener noreferrer">
											<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/instagram.svg'; ?>" alt="Instagram">
										</a>
									</li>
									<li class="st-footer-social-list-item">
										<a href="https://www.youtube.com/channel/UCZ1Z1YQ1Q9Z1Z1YQ1Q9Z1Z1" target="_blank" rel="noopener noreferrer">
											<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/youtube.svg'; ?>" alt="Youtube">
										</a>
									</li>
									<li class="st-footer-social-list-item">
										<a href="#" target="_blank" rel="noopener noreferrer">
											<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/rss.svg'; ?>" alt="Linkedin">
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="st-footer-col">
							<?php if ( has_nav_menu( 'footer-col-1' ) ) : ?>
								<nav aria-label="<?php esc_attr_e( 'Footer menu', 'screen-time' ); ?>" class="st-footer-navigation">
									<p class="st-footer-nav-title">
										<?php echo wp_get_nav_menu_name( 'footer-col-1' ); ?>
									</p>
									<ul class="st-footer-nav-wrapper">
										<?php
											wp_nav_menu(
												array(
													'theme_location' => 'footer-col-1',
													'items_wrap'     => '%3$s',
													'container'      => false,
													'depth'          => 1,
													'link_before'    => '<span>',
													'link_after'     => '</span>',
													'fallback_cb'    => false,
												)
											);
										?>
									</ul><!-- .footer-navigation-wrapper -->
								</nav><!-- .footer-navigation -->
							<?php endif; ?>
						</div>
						<div class="st-footer-col">
							<?php if ( has_nav_menu( 'footer-col-2' ) ) : ?>
								<nav aria-label="<?php esc_attr_e( 'Footer menu', 'screen-time' ); ?>" class="st-footer-navigation">
									<p class="st-footer-nav-title">
										<?php echo wp_get_nav_menu_name( 'footer-col-1' ); ?>
									</p>
									<ul class="st-footer-nav-wrapper">
										<?php
											wp_nav_menu(
												array(
													'theme_location' => 'footer-col-2',
													'items_wrap'     => '%3$s',
													'container'      => false,
													'depth'          => 1,
													'link_before'    => '<span>',
													'link_after'     => '</span>',
													'fallback_cb'    => false,
												)
											);
										?>
									</ul><!-- .footer-navigation-wrapper -->
								</nav><!-- .footer-navigation -->
							<?php endif; ?>
						</div>
					</div>
					<div class="st-footer-powered-by"><!-- .powered-by -->
					   <p>
						<?php
							printf(
								/* translators: %s: Privacy Policy. */
								esc_html( '© 2022 Lifestyle Magazine. All Rights Reserved. Terms of Service  |  %s' ),
								'<a href="' . esc_url( $privacy_link ) . '">Privacy Policy</a>'
							);
							?>
					   </p>
					</div><!-- .powered-by -->
				</div>
			</footer><!-- .st-footer -->
	</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
