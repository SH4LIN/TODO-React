<?php
/**
 * This file is used to display the about and the quick links sections for the rt-person post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since 1.0.0
 */

?>
<div class="st-sp-about-quick-links-container">
	<div class="st-sp-about-container">
		<div class="st-sp-about-heading-container">
			<p class="primary-text-secondary-font section-heading-text about-heading-text">
				<?php esc_html_e( 'About' ); ?>
			</p>
		</div>

		<div class="st-sp-about-content-container">
			<span class="primary-text-primary-font about-text">
				<?php echo wp_kses_post( the_content() ); ?>
			</span>
		</div>
	</div>

	<div class="st-sp-quick-links-container">
		<div class="st-sp-quick-links-heading-container">
			<p class="primary-text-secondary-font quick-links-heading-text">
				<?php esc_html_e( 'Quick Links' ); ?>
			</p>
		</div>

		<div class="st-sp-quick-links-list-container">
			<ul class="st-sp-quick-links">
				<li class="st-sp-quick-link">
					<a class="primary-text-primary-font" href="#">
						<?php esc_html_e( 'About' ); ?>
					</a>
				</li>

				<li class="st-sp-quick-link">
					<a class="primary-text-primary-font" href="#">
						<?php esc_html_e( 'Family' ); ?>
					</a>
				</li>

				<li class="st-sp-quick-link">
					<a class="primary-text-primary-font" href="#">
						<?php esc_html_e( 'Snapshots' ); ?>
					</a>
				</li>

				<li class="st-sp-quick-link">
					<a class="primary-text-primary-font" href="#">
						<?php esc_html_e( 'Videos' ); ?>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
