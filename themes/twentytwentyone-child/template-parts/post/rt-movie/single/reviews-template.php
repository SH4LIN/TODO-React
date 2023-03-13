<?php
/**
 * This file is used to display the review of the movie.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since 1.0.0
 */

$post_comments = get_comments(
	array(
		'post_id' => get_the_ID(),
	)
);


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
			if ( ! empty( $post_comments ) ) {
				foreach ( $post_comments as $post_comment ) {
					?>
					<div class="st-sm-reviews-list-item">
						<div class="st-sm-reviews-list-item-image-name-rating-container">
							<div class="st-sm-reviews-list-item-image-name-container">
								<img src="<?php echo esc_url( get_avatar_url( $post_comment->comment_author_email ) ); ?>" class="st-sm-reviews-list-item-image"/>


								<span class="secondary-text-primary-font st-sm-reviews-list-item-name-text">
									<?php echo esc_html( $post_comment->comment_author ); ?>
								</span>
							</div>

							<div class="st-sm-reviews-list-item-rating-container">
								<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_star.svg' ); ?>" class="st-sm-reviews-list-item-image"/>

								<span class="primary-text-primary-font st-sm-reviews-list-item-rating-text">
									<?php esc_html_e( '8.4/10' ); ?>
								</span>
							</div>
						</div>

						<div class="st-sm-reviews-list-item-content-container">
							<div class="primary-text-primary-font st-sm-reviews-list-item-content">
								<?php echo esc_html( $post_comment->comment_content ); ?>
							</div>
						</div>

						<div class="st-sm-reviews-list-item-date-container">
							<div class="secondary-text-primary-font st-sm-reviews-list-item-date">
								<?php echo esc_html__( '12th Dec 2022', 'screen-time' ); ?>
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
