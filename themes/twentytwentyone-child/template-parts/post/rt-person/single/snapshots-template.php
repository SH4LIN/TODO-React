<?php
/**
 * This file is used to display the snapshots of the rt-person post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

if ( ! isset( $args['id'] ) || ! isset( $args['snapshots'] ) ) {
	return;
}

$snapshots = $args['snapshots'];

if ( ! empty( $snapshots ) && ! empty( $snapshots[0] ) ) : ?>
	<div class="st-sp-snapshots-container">
		<div class="st-sp-snapshots-heading-container">
			<p class="primary-text-secondary-font section-heading-text">
				<?php esc_html_e( 'Snapshots', 'screen-time' ); ?>
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
