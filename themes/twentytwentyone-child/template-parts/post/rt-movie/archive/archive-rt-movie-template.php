<?php
/**
 * This file is template for the archive rt-movie post type it will call all the other parts of the templates.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since 1.0.0
 */

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\taxonomies\Movie_Label;

$slider_movies_args = array(
	'post_type' => RT_Movie::SLUG,
	'tax_query' => array( // phpcs:ignore: WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		array(
			'taxonomy' => Movie_Label::SLUG,
			'field'    => 'slug',
			'terms'    => 'slider',
		),
	),
);

$slider_movies_query = new WP_Query( $slider_movies_args );
$slider_movies       = $slider_movies_query->posts;

wp_reset_postdata();

$upcoming_movies_args = array(
	'post_type' => RT_Movie::SLUG,
	'tax_query' => array( // phpcs:ignore: WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		array(
			'taxonomy' => Movie_Label::SLUG,
			'field'    => 'slug',
			'terms'    => 'upcoming-movies',
		),
	),
);

$upcoming_movies_query = new WP_Query( $upcoming_movies_args );
$upcoming_movies       = $upcoming_movies_query->posts;

wp_reset_postdata();

$trending_movies_args = array(
	'post_type' => RT_Movie::SLUG,
	'tax_query' => array( // phpcs:ignore: WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		array(
			'taxonomy' => Movie_Label::SLUG,
			'field'    => 'slug',
			'terms'    => 'trending-now',
		),
	),
);

$trending_movies_query = new WP_Query( $trending_movies_args );
$trending_movies       = $trending_movies_query->posts;

wp_reset_postdata();

?>


<div class="st-am-container">

	<?php if ( $slider_movies && is_array( $slider_movies ) && count( $slider_movies ) > 0 ) : ?>
		<?php get_template_part( 'template-parts/post/rt-movie/archive/slider-template', null, array( 'movies' => $slider_movies ) ); ?>
	<?php endif; ?>

	<?php if ( $upcoming_movies && is_array( $upcoming_movies ) && count( $upcoming_movies ) > 0 ) : ?>
		<?php get_template_part( 'template-parts/post/rt-movie/archive/upcoming-movies-template', null, array( 'movies' => $upcoming_movies ) ); ?>
	<?php endif; ?>

	<?php if ( $trending_movies && is_array( $trending_movies ) && count( $trending_movies ) > 0 ) : ?>
		<?php get_template_part( 'template-parts/post/rt-movie/archive/trending-movies-template', null, array( 'movies' => $trending_movies ) ); ?>
	<?php endif; ?>

</div>
<?php
wp_reset_postdata();
?>
