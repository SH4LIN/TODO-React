<?php
/**
 * This file is used to display the about and the quick links sections for the rt-person post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

if ( ! isset( $args['id'] ) || ! isset( $args['about'] ) ) {
	return;
}
if ( ! empty( $args['about'] ) ) :
	?>
	<div class="st-sp-about-quick-links-container"> <!-- about-quick-links-container -->
		<div class="st-sp-about-container"> <!-- about-container -->
			<div class="st-sp-about-heading-container"> <!-- about-heading-container -->
				<p class="primary-text-secondary-font section-heading-text about-heading-text"> <!-- about-heading-text -->
					<?php esc_html_e( 'About', 'screen-time' ); ?>
				</p> <!-- /about-heading-text -->
			</div> <!-- /about-heading-container -->

			<div class="st-sp-about-content-container"> <!-- about-content-container -->
				<span class="primary-text-primary-font about-text"> <!-- about-text -->
					<?php echo wp_kses_post( $args['about'] ); ?>
				</span> <!-- /about-text -->
			</div> <!-- /about-content-container -->
		</div> <!-- /about-container -->

		<div class="st-sp-quick-links-container"> <!-- quick-links-container -->
			<div class="st-sp-quick-links-heading-container"> <!-- quick-links-heading-container -->
				<p class="primary-text-secondary-font quick-links-heading-text"> <!-- quick-links-heading-text -->
					<?php esc_html_e( 'Quick Links', 'screen-time' ); ?>
				</p> <!-- /quick-links-heading-text -->
			</div> <!-- /quick-links-heading-container -->

			<div class="st-sp-quick-links-list-container"> <!-- quick-links-list-container -->
				<ul class="st-sp-quick-links"> <!-- quick-links -->
					<li class="st-sp-quick-link"> <!-- quick-link -->
						<a class="primary-text-primary-font" href="#">
							<?php esc_html_e( 'About', 'screen-time' ); ?>
						</a>
					</li> <!-- /quick-link -->
					<li class="st-sp-quick-link">  <!-- quick-link -->
						<a class="primary-text-primary-font" href="#">
							<?php esc_html_e( 'Family', 'screen-time' ); ?>
						</a>
					</li>  <!-- /quick-link -->

					<li class="st-sp-quick-link"> <!-- quick-link -->
						<a class="primary-text-primary-font" href="#">
							<?php esc_html_e( 'Snapshots', 'screen-time' ); ?>
						</a>
					</li> <!-- /quick-link -->

					<li class="st-sp-quick-link"> <!-- quick-link -->
						<a class="primary-text-primary-font" href="#">
							<?php esc_html_e( 'Videos', 'screen-time' ); ?>
						</a>
					</li> <!-- /quick-link -->
				</ul> <!-- /quick-links -->
			</div> <!-- /quick-links-list-container -->
		</div> <!-- /quick-links-container -->
	</div> <!-- /about-quick-links-container -->
<?php endif; ?>
