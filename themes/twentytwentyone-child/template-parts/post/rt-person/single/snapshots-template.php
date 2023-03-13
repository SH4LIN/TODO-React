<?php
/**
 * This file is used to display the snapshots of the rt-person post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since 1.0.0
 */

$args = wp_parse_args(
	$args,
	array(
		'snapshots' => '',
	)
);

$snapshots = $args['snapshots'];

if ( $snapshots && is_array( $snapshots ) && count( $snapshots ) > 0 ) :
	?>

	<div class="st-sp-snapshots-container">
			<div class="st-sp-snapshots-heading-container">
				<p class="primary-text-secondary-font section-heading-text">
					<?php esc_html_e( 'Snapshots' ); ?>
				</p>
			</div>

			<div class="st-sp-snapshots-list-container">
				<div class="st-sp-snapshots-list">
					<?php
					foreach ( $snapshots[0] as $snapshot ) :
						?>

						<div class="st-sp-snapshots-list-item">
							<img src="<?php echo esc_url( wp_get_attachment_image_url( $snapshot, 'full' ) ); ?>" />
						</div>

						<?php

					endforeach;
					?>
				</div>
			</div>

		</div>

<?php endif; ?>
