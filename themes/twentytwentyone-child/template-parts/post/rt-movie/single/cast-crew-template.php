<?php
/**
 * This file is used to display the cast and crew of the movie.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

if (
	! isset( $args['id'] ) ||
	! isset( $args['crew'] ) ||
	! isset( $args['link'] )
) {
	return;
}

if ( ! empty( $args['crew'] ) && ! empty( $args['crew'][0] ) ) :

	?>
<div class="cast-crew-wrapper"> <!-- cast-crew-container -->
	<div class="cast-crew-heading-wrapper"> <!-- cast-crew-heading-container -->
		<p class="primary-text-secondary-font section-heading-text"> <!-- cast-crew-heading -->
			<?php esc_html_e( 'Cast & Crew', 'screen-time' ); ?>
		</p> <!-- /cast-crew-heading -->

		<div class="view-all-wrapper-desktop"> <!-- cast-crew-view-all-container-desktop -->
			<a href="<?php echo esc_url( $args['link'] ); ?>" class="primary-text-primary-font st-sm-cast-crew-view-all-link">
				<?php esc_html_e( 'View All', 'screen-time' ); ?>
			</a>
		</div> <!-- /cast-crew-view-all-container-desktop -->
	</div>

	<div class="cast-crew-list-wrapper"> <!-- cast-crew-list-container -->
		<div class="cast-crew-items"> <!-- cast-crew-list-items -->
			<?php
			foreach ( $args['crew'][0] as $cast_member ) :
				?>
					<a href="<?php echo esc_url( get_permalink( $cast_member['person_id'] ) ); ?>">
						<div class="cast-crew-item"> <!-- cast-crew-list-item -->
							<div class="cast-crew-image-wrapper"> <!-- cast-crew-list-item-image-container -->
								<img src="<?php echo esc_url( get_the_post_thumbnail_url( $cast_member['person_id'], 'gull' ) ); ?>" loading="lazy" />
							</div> <!-- /cast-crew-list-item-image-container -->

							<div class="cast-crew-name-wrapper"> <!-- cast-crew-list-item-name-container -->
								<span class="primary-text-primary-font"> <!-- cast-crew-list-item-name -->
									<?php echo esc_html( get_the_title( $cast_member['person_id'] ) ); ?>
								</span> <!-- /cast-crew-list-item-name -->
							</div> <!-- /cast-crew-list-item-name-container -->
						</div> <!-- /cast-crew-list-item -->
					</a>
					<?php
				endforeach;
			?>
		</div> <!-- /cast-crew-list-items -->
	</div> <!-- /cast-crew-list-container -->

	<div class="view-all-wrapper-mobile"> <!-- cast-crew-view-all-container-mobile -->
		<a href="<?php echo esc_url( $args['link'] ); ?>" class="primary-text-primary-font st-sm-cast-crew-view-all-link">
			<?php esc_html_e( 'View All', 'screen-time' ); ?>
		</a>
	</div> <!-- /cast-crew-view-all-container-mobile -->
</div> <!-- /cast-crew-container -->
<?php endif; ?>
