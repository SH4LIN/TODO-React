<?php
/**
 * This file is template file for the single post page.
 *
 * @package EasyEngine
 * @since 1.0.0
 */

/**
 * This is security to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( have_posts() ) {
	the_post();
}

$related_posts = get_posts(
	array(
		'category__in'   => wp_get_post_categories( get_the_ID() ),
		'posts_per_page' => 4,
	)
);

if ( ! empty( $related_posts ) ) {
	$related_posts = array_filter(
		$related_posts,
		function( $post ) {
			return get_the_ID() !== $post->ID;
		}
	);

	if ( ! empty( $related_posts ) ) {
		$related_posts = array_slice( $related_posts, 0, 3 );
	}
}

get_header();
?>
<section class="single-post-wrapper">
	<div class="breadcrumb-wrapper">
		<?php get_breadcrumbs(); ?>
	</div>

	<div class="post-data">
		<?php the_title( '<h1 class="post-title">', '</h1>' ); ?>

		<div class="post-meta">
			<?php
			if ( ! empty( get_the_author() ) ) :
				?>
				<span class="post-author">
					<?php
					esc_html_e( 'Posted by', 'easy-engine' );
					?>

					<?php the_author_link(); ?>

					<span>
						<?php esc_html_e( 'on', 'easy-engine' ); ?>

						<?php the_date(); ?>
					</span>
				</span>
				<?php
			endif;
			?>

			<?php
			if ( has_category() ) :
				?>
				<span class="post-category">
					<?php esc_html_e( 'Category', 'easy-engine' ); ?>

					<?php the_category( ', ' ); ?>
				</span>
				<?php
			endif;
			?>

			<?php
			if ( has_tag() ) :
				?>
				<span class="post-tag">
					<?php esc_html_e( 'Tagged', 'easy-engine' ); ?>

					<?php the_tags( '', ', ' ); ?>
				</span>
				<?php
			endif;
			?>
		</div>

		<div class="post-content-wrapper">
			<?php the_post_thumbnail(); ?>

			<?php the_content(); ?>
		</div>

		<?php get_template_part( 'template-parts/socials-buttons' ); ?>

		<?php if ( ! empty( $related_posts ) ) : ?>
			<section class="related-section">
				<p>
					<?php esc_html_e( 'Related', 'easy-engine' ); ?>
				</p>

				<div class="related-posts-wrapper">
					<?php
					foreach ( $related_posts as $related_post ) {
						if ( get_the_ID() === $related_post->ID ) {
							continue;
						}
						?>
						<div class="related-post">
							<div class="related-post-title">
								<a href="<?php the_permalink( $related_post->ID ); ?>">
									<?php echo esc_html( $related_post->post_title ); ?>
								</a>
							</div>
							<div class="related-post-date">
								<?php echo esc_html( get_the_date( '', $related_post->ID ) ); ?>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</section>
		<?php endif; ?>
		<section class="comments-section">
			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</section>
	</div>
</section>

<?php
wp_reset_postdata();
get_footer();
