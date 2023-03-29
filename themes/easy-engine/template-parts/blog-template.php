<?php
/**
 * This file is used to display the blog posts from blog page or from the search page.
 *
 * @package EasyEngine
 * @since 1.0.0
 */

/**
 * This is security to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;
?>

<section class="archive-wrapper">
	<div class="breadcrumb-wrapper">
		<?php get_breadcrumbs(); ?>
	</div>

	<article class="posts-wrapper">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				?>
				<div class="post-wrapper">
					<div class="post-date">
						<!-- Using get_the_date() because the_date() was not giving the date of multiple post of the same date -->
						<a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_date() ); ?></a>
					</div>

					<div class="post-data">
						<?php
						if ( ! empty( get_the_title() ) ) :
							?>
							<div class="post-title">
								<a class="post-title-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</div>
							<?php
						endif;
						?>

						<div class="post-meta">
							<?php
							if ( ! empty( get_the_author() ) ) :
								?>
								<div class="post-author">
									<?php esc_html_e( 'Posted by', 'easy-engine' ); ?>  <span><?php the_author_link(); ?></span>
								</div>
								<?php
							endif;
							?>

							<?php
							if ( has_category() ) :
								?>
								<div class="post-category">
									<?php esc_html_e( 'Category', 'easy-engine' ); ?> <?php the_category( ', ' ); ?>
								</div>
								<?php
							endif;
							?>

							<?php
							if ( has_tag() ) :
								?>
								<div class="post-tag">
									<?php esc_html_e( 'Tagged', 'easy-engine' ); ?> <?php the_tags( '', ', ' ); ?>
								</div>
								<?php
							endif;
							?>
						</div>
					</div>
				</div>
				<?php
			}

			// Previous/next page navigation.
			the_posts_pagination(
				array(
					'mid_size'  => 2,
					'prev_text' => __( '&laquo; Previous', 'easy-engine' ),
					'next_text' => __( 'Next &raquo;', 'easy-engine' ),
				)
			);
		}
		?>
	</article>
</section>
