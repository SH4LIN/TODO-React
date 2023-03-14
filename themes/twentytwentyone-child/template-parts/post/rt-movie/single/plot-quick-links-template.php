<?php
/**
 * This file will be used to display the Plot of the movie and the quick link for the rt-movie post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since 1.0.0
 */

if (
	! isset( $args['id'] ) ||
	! isset( $args['plot'] )
) {
	return;
}
if ( ! empty( $args['plot'] ) ) :
	?>
	<div class="st-sm-plot-quick-links-container">
		<div class="st-sm-plot-container">
			<div class="primary-text-secondary-font section-heading-text st-sm-plot-heading">
				<?php esc_html_e( 'Plot' ); ?>
			</div>
			<div class="primary-text-secondary-font section-heading-text st-sm-synopsis-heading">
				<?php esc_html_e( 'Synopsis' ); ?>
			</div>

			<div class="primary-text-primary-font st-sm-plot-text">
				<?php echo wp_kses_post( $args['plot'] ); ?>
			</div>
		</div>

		<div class="st-sm-quick-links-container">
			<div class="primary-text-secondary-font st-sm-quick-links-heading">
				<?php esc_html_e( 'Quick Links' ); ?>
			</div>

			<div class="st-sm-quick-links-list-container">
				<ul class="st-sm-quick-links">
					<li class="st-sm-quick-link">
						<a href="#" class="primary-text-primary-font">
							<?php esc_html_e( 'Synopsis' ); ?>
						</a>
					</li>

					<li class="st-sm-quick-link">
						<a href="#" class="primary-text-primary-font">
							<?php esc_html_e( 'Cast & Crew' ); ?>
						</a>
					</li>

					<li class="st-sm-quick-link">
						<a href="#" class="primary-text-primary-font">
							<?php esc_html_e( 'Snapshots' ); ?>
						</a>
					</li>

					<li class="st-sm-quick-link">
						<a href="#" class="primary-text-primary-font">
							<?php esc_html_e( 'Trailer & Clips' ); ?>
						</a>
					</li>

					<li class="st-sm-quick-link">
						<a href="#" class="primary-text-primary-font">
							<?php esc_html_e( 'Reviews' ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<?php endif; ?>
