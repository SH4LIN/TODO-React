<?php
/**
 * This file is used to display the cast and crew of the movie.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */

?>
<div class="st-sm-cast-crew-container">
	<div class="st-sm-cast-crew-heading-container">
		<div class="primary-text-heading-font st-sm-cast-crew-heading">
			<?php esc_html_e( 'Cast & Crew' ); ?>
		</div>

		<div class="st-sm-cast-crew-view-all-container">
			<a href="#" class="primary-text-primary-font st-sm-cast-crew-view-all-link">
				<?php esc_html_e( 'View All' ); ?>
			</a>
		</div>
	</div>

	<div class="st-sm-cast-crew-list-container">
		<div class="st-sm-cast-crew-list-items">
			<?php
			$cast = get_post_meta( get_the_ID(), 'rt-movie-meta-crew-actor' );
			if ( ! empty( $cast ) ) {
				foreach ( $cast[0] as $cast_member ) {
					?>
					<div class="st-sm-cast-crew-list-item">
						<div class="st-sm-cast-crew-list-item-image-container">
							<img src="<?php echo esc_url( get_the_post_thumbnail_url( $cast_member['person_id'] ) ); ?>" class="st-sm-cast-crew-list-item-image"/>
						</div>

						<div class="st-sm-cast-crew-list-item-name-container">
							<span class="primary-text-primary-font st-sm-cast-crew-list-item-name">
								<?php echo esc_html( get_the_title( $cast_member['person_id'] ) ); ?>
							</span>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
</div>
