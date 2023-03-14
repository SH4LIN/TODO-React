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
<div class="st-sm-cast-crew-container"> <!-- cast-crew-container -->
	<div class="st-sm-cast-crew-heading-container"> <!-- cast-crew-heading-container -->
		<div class="primary-text-secondary-font section-heading-text st-sm-cast-crew-heading"> <!-- cast-crew-heading -->
			<?php esc_html_e( 'Cast & Crew', 'screen-time' ); ?>
		</div> <!-- /cast-crew-heading -->

		<div class="st-sm-cast-crew-view-all-container-desktop"> <!-- cast-crew-view-all-container-desktop -->
			<a href="<?php echo esc_url( $args['link'] ); ?>" class="primary-text-primary-font st-sm-cast-crew-view-all-link">
				<?php esc_html_e( 'View All', 'screen-time' ); ?>
			</a>
		</div> <!-- /cast-crew-view-all-container-desktop -->
	</div>

	<div class="st-sm-cast-crew-list-container"> <!-- cast-crew-list-container -->
		<div class="st-sm-cast-crew-list-items"> <!-- cast-crew-list-items -->
			<?php
			foreach ( $args['crew'][0] as $cast_member ) :
				?>
					<div class="st-sm-cast-crew-list-item"> <!-- cast-crew-list-item -->
						<div class="st-sm-cast-crew-list-item-image-container"> <!-- cast-crew-list-item-image-container -->
							<img src="<?php echo esc_url( get_the_post_thumbnail_url( $cast_member['person_id'], 'gull' ) ); ?>" class="st-sm-cast-crew-list-item-image"/>
						</div> <!-- /cast-crew-list-item-image-container -->

						<div class="st-sm-cast-crew-list-item-name-container"> <!-- cast-crew-list-item-name-container -->
							<span class="primary-text-primary-font st-sm-cast-crew-list-item-name"> <!-- cast-crew-list-item-name -->
								<?php echo esc_html( get_the_title( $cast_member['person_id'] ) ); ?>
							</span> <!-- /cast-crew-list-item-name -->
						</div> <!-- /cast-crew-list-item-name-container -->
					</div> <!-- /cast-crew-list-item -->
					<?php
				endforeach;
			?>
		</div> <!-- /cast-crew-list-items -->
	</div> <!-- /cast-crew-list-container -->

	<div class="st-sm-cast-crew-view-all-container-mobile"> <!-- cast-crew-view-all-container-mobile -->
		<a href="<?php echo esc_url( $args['link'] ); ?>" class="primary-text-primary-font st-sm-cast-crew-view-all-link">
			<?php esc_html_e( 'View All', 'screen-time' ); ?>
		</a>
	</div> <!-- /cast-crew-view-all-container-mobile -->
</div> <!-- /cast-crew-container -->
<?php endif; ?>
