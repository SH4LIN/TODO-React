<?php
/**
 * This file is used to display the about and the quick links sections for the rt-person post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

if (
	! isset( $args['id'] ) ||
	! isset( $args['about'] ) ||
	! isset( $args['quick_links'] ) ||
	! isset( $args['desktop_heading'] ) ||
	! isset( $args['mobile_heading'] )
) {
	return;
}
if ( ! empty( $args['about'] ) ) :
	?>
	<section class="about-quick-links-section" id="about"> <!-- about-quick-links-container -->
		<div class="about-wrapper"> <!-- about-container -->
			<div class="about-heading-wrapper"> <!-- about-heading-container -->
				<p class="primary-text-secondary-font section-heading about-desktop-heading"> <!-- plot-heading -->
					<?php echo esc_html( $args['desktop_heading'] ); ?>
				</p> <!-- /plot-heading -->

				<p class="primary-text-secondary-font section-heading about-mobile-heading"> <!-- synopsis-heading -->
					<?php echo esc_html( $args['mobile_heading'] ); ?>
				</p> <!-- /synopsis-heading -->
			</div> <!-- /about-heading-container -->

			<div class="about-content-container"> <!-- about-content-container -->
				<span class="primary-text-primary-font about-text"> <!-- about-text -->
					<?php echo wp_kses_post( $args['about'] ); ?>
				</span> <!-- /about-text -->
			</div> <!-- /about-content-container -->
		</div> <!-- /about-container -->

		<?php
		if ( ! empty( $args['quick_links'] ) ) :
			?>
			<div class="quick-links-wrapper"> <!-- quick-links-container -->
				<div class= "quick-links-heading-wrapper"> <!-- quick-links-heading-container -->
					<p class="primary-text-secondary-font quick-links-heading"> <!-- quick-links-heading-text -->
						<?php esc_html_e( 'Quick Links', 'screen-time' ); ?>
					</p> <!-- /quick-links-heading-text -->
				</div> <!-- /quick-links-heading-container -->

				<div class="quick-links-list-container"> <!-- quick-links-list-container -->
					<ul class="quick-links-list"> <!-- quick-links -->
						<?php
						foreach ( $args['quick_links'] as $quick_link ) :
							?>
							<li class="quick-link-item"> <!-- quick-link -->
								<a class="primary-text-primary-font" href="<?php echo esc_url( $quick_link['url'] ); ?>">
									<?php echo esc_html( $quick_link['title'] ); ?>
								</a>
							</li> <!-- /quick-link -->
						<?php endforeach; ?>
					</ul> <!-- /quick-links -->
				</div> <!-- /quick-links-list-container -->
			</div> <!-- /quick-links-container -->
		</section> <!-- /about-quick-links-container -->
	<?php endif; ?>
<?php endif; ?>
