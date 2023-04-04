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
<div class="reviews-wrapper" id="reviews"> <!-- reviews-container -->
	<div class="reviews-heading-wrapper"> <!-- reviews-heading-container -->
		<p class="primary-text-secondary-font section-heading"> <!-- reviews-heading -->
			<?php esc_html_e( 'Reviews', 'screen-time' ); ?>
		</p> <!-- /reviews-heading -->
	</div> <!-- /reviews-heading-container -->

	<div class="reviews-list-wrapper"> <!-- reviews-list-container -->
		<div class="reviews-list"> <!-- reviews-list-items -->
			<?php
			foreach ( $args['comments'] as $post_comment ) :
				?>
					<div class="review-list-item"> <!-- reviews-list-item -->
						<div class="review-profile-wrapper"> <!-- reviews-list-item-image-name-rating-container -->
							<div class="profile-picture-name-wrapper"> <!-- reviews-list-item-image-name-container -->
								<img src="<?php echo esc_url( get_avatar_url( $post_comment->comment_author_email ) ); ?>"/>

								<span class="secondary-text-primary-font"> <!-- reviews-list-item-name-text -->
									<?php echo esc_html( $post_comment->comment_author ); ?>
								</span> <!-- /reviews-list-item-name-text -->
							</div> <!-- /reviews-list-item-image-name-container -->

							<div class="review-rating-wrapper"> <!-- reviews-list-item-rating-container -->
								<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_star.svg' ); ?>" />

								<span class="primary-text-primary-font"> <!-- reviews-list-item-rating-text -->
									<?php esc_html_e( '8.4/10', 'screen-time' ); ?>
								</span> <!-- /reviews-list-item-rating-text -->
							</div> <!-- /reviews-list-item-rating-container -->
						</div> <!-- /reviews-list-item-image-name-rating-container -->

						<div class="review-content-wrapper"> <!-- reviews-list-item-content-container -->
							<p class="primary-text-primary-font st-sm-reviews-list-item-content"> <!-- reviews-list-item-content -->
								<?php echo esc_html( $post_comment->comment_content ); ?>
							</p> <!-- /reviews-list-item-content -->
						</div> <!-- /reviews-list-item-content-container -->

						<div class="review-date-wrapper"> <!-- reviews-list-item-date-container -->
							<p class="secondary-text-primary-font"> <!-- reviews-list-item-date -->
								<?php echo wp_kses( '12<sup>th</sup> Dec 2022', array( 'sup' => array() ) ); ?>
							</p> <!-- /reviews-list-item-date -->
						</div> <!-- /reviews-list-item-date-container -->
					</div> <!-- /reviews-list-item -->
					<?php
				endforeach;
			?>
		</div> <!-- /reviews-list-items -->
	</div> <!-- /reviews-list-container -->
</div> <!-- /reviews-container -->
<?php endif; ?>
