<?php
/**
 * This file is used to display the snapshots of the movie.
 *
 * @package Twenty_Twenty_One_Child
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

	<div class="st-sm-snapshots-container"> <!-- snapshots-container -->
		<div class="st-sm-snapshots-heading-container"> <!-- snapshots-heading-container -->
			<div class="primary-text-secondary-font section-heading-text st-sm-snapshots-heading"> <!-- snapshots-heading -->
				<?php echo esc_html( $args['heading'] ); ?>
			</div> <!-- /snapshots-heading -->
		</div> <!-- /snapshots-heading-container -->

		<div class="st-sm-snapshots-list-container"> <!-- snapshots-list-container -->
			<div class="st-sm-snapshots-list-items"> <!-- snapshots-list-items -->
				<?php
				foreach ( $args['snapshots'][0] as $snapshot ) {
					?>
						<div class="st-sm-snapshots-list-item"> <!-- snapshots-list-item -->
							<div class="st-sm-snapshots-list-item-image-container"> <!-- snapshots-list-item-image-container -->
								<img src="<?php echo esc_url( wp_get_attachment_url( $snapshot ) ); ?>" class="st-sm-snapshots-list-item-image" loading="lazy"/>
							</div> <!-- /snapshots-list-item-image-container -->
						</div> <!-- /snapshots-list-item -->
						<?php
				}
				?>
			</div> <!-- /snapshots-list-items -->
		</div> <!-- /snapshots-list-container -->
	</div> <!-- /snapshots-container -->
<?php endif; ?>
