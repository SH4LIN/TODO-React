<?php
/**
 * This file is used to display the snapshots of the movie.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

if (
	! isset( $args['snapshots'] )
) {
	return;
}

if ( ! empty( $args['snapshots'] ) && ! empty( $args['snapshots'][0] ) ) :
	?>

	<div class="snapshots-wrapper" id="snapshots"> <!-- snapshots-container -->
		<div class="snapshots-heading-wrapper"> <!-- snapshots-heading-container -->
			<p class="primary-text-secondary-font section-heading"> <!-- snapshots-heading -->
				<?php echo esc_html( $args['heading'] ); ?>
			</p> <!-- /snapshots-heading -->
		</div> <!-- /snapshots-heading-container -->

		<div class="snapshot-list-wrapper"> <!-- snapshots-list-container -->
			<div class="snapshot-list"> <!-- snapshots-list-items -->
				<?php
				foreach ( $args['snapshots'][0] as $snapshot ) {
					?>
						<div class="snapshot-item-wrapper"> <!-- snapshots-list-item -->
							<img src="<?php echo esc_url( wp_get_attachment_url( $snapshot ) ); ?>" loading="lazy"/>
						</div> <!-- /snapshots-list-item -->
						<?php
				}
				?>
			</div> <!-- /snapshots-list-items -->
		</div> <!-- /snapshots-list-container -->
	</div> <!-- /snapshots-container -->
<?php endif; ?>
