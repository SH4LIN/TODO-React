<?php
/**
 * This file is used to display the review of the movie.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */

?>
<div class="st-sm-reviews-container">
	<div class="st-sm-reviews-heading-container">
		<div class="primary-text-secondary-font section-heading-text st-sm-reviews-heading">
			<?php esc_html_e( 'Reviews' ); ?>
		</div>
	</div>

	<div class="st-sm-reviews-list-container">
		<div class="st-sm-reviews-list-items">
			<?php
			$reviews = get_post_meta( get_the_ID(), 'rt-movie-meta-reviews' );
			if ( ! empty( $reviews ) ) {
				foreach ( $reviews[0] as $review ) {
					?>
					<div class="st-sm-reviews-list-item">
						<div class="st-sm-reviews-list-item-image-container">
							<img src="<?php echo esc_url( $review['image'] ); ?>" class="st-sm-reviews-list-item-image"/>
						</div>
						<div class="st-sm-reviews-list-item-content-container">
							<div class="st-sm-reviews-list-item-content">
								<?php echo esc_html( $review['content'] ); ?>
							</div>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
</div>
