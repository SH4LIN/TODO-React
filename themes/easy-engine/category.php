<?php
/**
 * This file is used to display the category page.
 *
 * @package EasyEngine
 * @since 1.0.0
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
				get_template_part( 'template-parts/blog-template' );
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
<?php
get_footer();