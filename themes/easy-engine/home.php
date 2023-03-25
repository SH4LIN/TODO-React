<?php
/**
 * This page is used to display the blog posts.
 */

get_header();
?>

<section class="blog-wrapper">
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
					<a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_date() ); ?></a>
				</div>

				<div class="post-data">
					<?php
					if ( ! empty( get_the_title() ) ) :
						?>
						<div class="post-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</div>
						<?php
					endif;
					?>

					<div class="post-meta">
						<?php
						if ( ! empty( get_the_author() ) ) :
							?>
							<div class="post-author">
								<?php esc_html_e( 'Posted by' ); ?>  <?php the_author_link(); ?>
							</div>
							<?php
						endif;
						?>

						<?php
						if (  has_category() ) :
							?>
							<div class="post-category">
								<?php esc_html_e( 'Category' ); ?> <?php the_category( ', ' ); ?>
							</div>
							<?php
						endif;
						?>

						<?php
						if (  has_tag() ) :
							?>
							<div class="post-tag">
								<?php esc_html_e( 'Tagged' ); ?> <?php the_tags('', ', '); ?>
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
		the_posts_pagination( array(
			'mid_size'           => 2,
			'prev_text'          => __( '&laquo; Previous', 'easy-engine' ),
			'next_text'          => __( 'Next &raquo;', 'easy-engine' ),
		) );
	}
	?>
	</article>
</section>
<?php
get_footer();