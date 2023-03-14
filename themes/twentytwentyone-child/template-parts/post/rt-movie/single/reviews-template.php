<?php
/**
 * This file is used to display the review of the movie.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

if (
	! isset( $args['id'] ) ||
	! isset( $args['comments'] )
) {
	return;
}

if ( ! empty( $args['comments'] ) ) :

	?>
<div class="st-sm-reviews-container"> <!-- reviews-container -->
	<div class="st-sm-reviews-heading-container"> <!-- reviews-heading-container -->
		<div class="primary-text-secondary-font section-heading-text st-sm-reviews-heading"> <!-- reviews-heading -->
			<?php esc_html_e( 'Reviews', 'screen-time' ); ?>
		</div> <!-- /reviews-heading -->
	</div> <!-- /reviews-heading-container -->

	<div class="st-sm-reviews-list-container"> <!-- reviews-list-container -->
		<div class="st-sm-reviews-list-items"> <!-- reviews-list-items -->
			<?php
			foreach ( $args['comments'] as $post_comment ) :
				?>
					<div class="st-sm-reviews-list-item"> <!-- reviews-list-item -->
						<div class="st-sm-reviews-list-item-image-name-rating-container"> <!-- reviews-list-item-image-name-rating-container -->
							<div class="st-sm-reviews-list-item-image-name-container"> <!-- reviews-list-item-image-name-container -->
								<img src="<?php echo esc_url( get_avatar_url( $post_comment->comment_author_email ) ); ?>" class="st-sm-reviews-list-item-image"/>

								<span class="secondary-text-primary-font st-sm-reviews-list-item-name-text"> <!-- reviews-list-item-name-text -->
									<?php echo esc_html( $post_comment->comment_author ); ?>
								</span> <!-- /reviews-list-item-name-text -->
							</div> <!-- /reviews-list-item-image-name-container -->

							<div class="st-sm-reviews-list-item-rating-container"> <!-- reviews-list-item-rating-container -->
								<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_star.svg' ); ?>" class="st-sm-reviews-list-item-image"/>

								<span class="primary-text-primary-font st-sm-reviews-list-item-rating-text"> <!-- reviews-list-item-rating-text -->
									<?php esc_html_e( '8.4/10', 'screen-time' ); ?>
								</span> <!-- /reviews-list-item-rating-text -->
							</div> <!-- /reviews-list-item-rating-container -->
						</div> <!-- /reviews-list-item-image-name-rating-container -->

						<div class="st-sm-reviews-list-item-content-container"> <!-- reviews-list-item-content-container -->
							<div class="primary-text-primary-font st-sm-reviews-list-item-content"> <!-- reviews-list-item-content -->
								<?php echo esc_html( $post_comment->comment_content ); ?>
							</div> <!-- /reviews-list-item-content -->
						</div> <!-- /reviews-list-item-content-container -->

						<div class="st-sm-reviews-list-item-date-container"> <!-- reviews-list-item-date-container -->
							<div class="secondary-text-primary-font st-sm-reviews-list-item-date"> <!-- reviews-list-item-date -->
								<?php echo esc_html( $post_comment->comment_date ); ?>
							</div> <!-- /reviews-list-item-date -->
						</div> <!-- /reviews-list-item-date-container -->
					</div> <!-- /reviews-list-item -->
					<?php
				endforeach;
			?>
		</div> <!-- /reviews-list-items -->
	</div> <!-- /reviews-list-container -->
</div> <!-- /reviews-container -->
<?php endif; ?>
