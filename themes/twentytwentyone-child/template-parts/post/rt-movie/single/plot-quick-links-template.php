<?php
/**
 * This file will be used to display the Plot of the movie and the quick link for the rt-movie post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */

?>
<div class="st-sm-plot-quick-links-container">
	<div class="st-sm-plot-container">
		<div class="primary-text-heading-font st-sm-plot-heading">
			<?php esc_html_e( 'Plot' ); ?>
		</div>

		<div class="primary-text-primary-font st-sm-plot-text">
			<?php wp_kses_post( the_content() ); ?>
		</div>
	</div>

	<div class="st-sm-quick-links-container">
		<div class="primary-text-heading-font st-sm-quick-links-heading">
			<?php esc_html_e( 'Quick Links' ); ?>
		</div>

		<div class="st-sm-quick-links-list-container">
			<ul class="st-sm-quick-links-list">
				<li class="st-sm-quick-links-list-item">
					<a href="#" class="primary-text-primary-font st-sm-quick-links-list-item-link">
						<?php esc_html_e( 'Synopsis' ); ?>
					</a>
				</li>

				<li class="st-sm-quick-links-list-item">
					<a href="#" class="primary-text-primary-font st-sm-quick-links-list-item-link">
						<?php esc_html_e( 'Cast & Crew' ); ?>
					</a>
				</li>

				<li class="st-sm-quick-links-list-item">
					<a href="#" class="primary-text-primary-font st-sm-quick-links-list-item-link">
						<?php esc_html_e( 'Snapshots' ); ?>
					</a>
				</li>

				<li class="st-sm-quick-links-list-item">
					<a href="#" class="primary-text-primary-font st-sm-quick-links-list-item-link">
						<?php esc_html_e( 'Trailer & Clips' ); ?>
					</a>
				</li>

				<li class="st-sm-quick-links-list-item">
					<a href="#" class="primary-text-primary-font st-sm-quick-links-list-item-link">
						<?php esc_html_e( 'Reviews' ); ?>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
