<?php
/**
 * This file is used to display the about and the quick links sections for the rt-person post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

if (
	! isset( $args['quick_links'] ) ||
	! isset( $args['desktop_heading'] ) ||
	! isset( $args['mobile_heading'] )
) {
	return;
}

if ( ! empty( get_the_content() ) ) :
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
					<?php the_content(); ?>
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

				<?php
				echo wp_kses(
					$args['quick_links'],
					array(
						'nav' => array(
							'class' => array(),
							'id'    => array(),
						),
						'ul'  => array(
							'class' => array(),
							'id'    => array(),
						),
						'li'  => array(
							'class' => array(),
							'id'    => array(),
						),
						'a'   => array(
							'class' => array(),
							'id'    => array(),
						),
					)
				);
				?>
			</div> <!-- /quick-links-container -->
		<?php endif; ?>
	</section> <!-- /about-quick-links-container -->
<?php endif; ?>
