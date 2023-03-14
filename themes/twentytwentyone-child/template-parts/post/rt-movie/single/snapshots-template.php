<?php
/**
 * This file is used to display the snapshots of the movie.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since 1.0.0
 */

if (
	! isset( $args['id'] ) ||
	! isset( $args['snapshots'] )
) {
	return;
}

if ( ! empty( $args['snapshots'] ) && ! empty( $args['snapshots'][0] ) ) :
	?>

	<div class="st-sm-snapshots-container">
		<div class="st-sm-snapshots-heading-container">
			<div class="primary-text-secondary-font section-heading-text st-sm-snapshots-heading">
				<?php esc_html_e( 'Snapshots' ); ?>
			</div>
		</div>

		<div class="st-sm-snapshots-list-container">
			<div class="st-sm-snapshots-list-items">
				<?php
				foreach ( $args['snapshots'][0] as $snapshot ) {
					?>
						<div class="st-sm-snapshots-list-item">
							<div class="st-sm-snapshots-list-item-image-container">
								<img src="<?php echo esc_url( wp_get_attachment_url( $snapshot ) ); ?>" class="st-sm-snapshots-list-item-image"/>
							</div>
						</div>
						<?php
				}
				?>
			</div>
		</div>
	</div>
<?php endif; ?>
