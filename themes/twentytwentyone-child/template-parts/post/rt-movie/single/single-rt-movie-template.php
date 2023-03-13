<?php
/**
 * This file is template for the single rt-movie post type it will call all the other parts of the templates.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since 1.0.0
 */

while ( have_posts() ) :
	the_post();
	?>


	<div class="st-sm-container">

		<?php get_template_part( 'template-parts/post/rt-movie/single/poster-title-template' ); ?>
		<?php get_template_part( 'template-parts/post/rt-movie/single/plot-quick-links-template' ); ?>
		<?php get_template_part( 'template-parts/post/rt-movie/single/cast-crew-template' ); ?>
		<?php get_template_part( 'template-parts/post/rt-movie/single/snapshots-template' ); ?>
		<?php get_template_part( 'template-parts/post/rt-movie/single/trailers-clips-template' ); ?>
		<?php get_template_part( 'template-parts/post/rt-movie/single/reviews-template' ); ?>

	</div>
	<?php
endwhile;
wp_reset_postdata();
?>
