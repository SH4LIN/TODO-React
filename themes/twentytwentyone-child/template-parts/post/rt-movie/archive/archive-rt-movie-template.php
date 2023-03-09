<?php
/**
 * This file is template for the archive rt-movie post type it will call all the other parts of the templates.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */

?>


<div class="st-am-container">

	<?php get_template_part( 'template-parts/post/rt-movie/archive/slider-template' ); ?>
	<div class="st-am-site-content">
		<?php get_template_part( 'template-parts/post/rt-movie/archive/upcoming-movies-template' ); ?>
		<?php get_template_part( 'template-parts/post/rt-movie/archive/trending-movies-template' ); ?>
	</div>


</div>
<?php
wp_reset_postdata();
?>
