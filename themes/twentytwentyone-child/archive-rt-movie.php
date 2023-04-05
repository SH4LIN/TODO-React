<?php
/**
 * This file is used to display the archive page for the rt-movie post type.
 *
 * @package Twenty_Twenty_One_Child
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

$slider_movies = $slider_movies_query->posts;

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

$upcoming_movies = $upcoming_movies_query->posts;

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

$trending_movies = $trending_movies_query->posts;

get_header();
?>

<div class="am-wrapper">

	<?php if ( $slider_movies && count( $slider_movies ) > 0 ) : ?>
		<?php get_template_part( 'template-parts/post/rt-movie/archive/slider-template', null, array( 'movies' => $slider_movies ) ); ?>
	<?php endif; ?>

	<?php if ( $upcoming_movies && count( $upcoming_movies ) > 0 ) : ?>
		<?php get_template_part( 'template-parts/post/rt-movie/archive/upcoming-movies-template', null, array( 'movies' => $upcoming_movies ) ); ?>
	<?php endif; ?>

	<?php if ( $trending_movies && count( $trending_movies ) > 0 ) : ?>
		<div class="trending-movies-wrapper"> <!-- trending-movies-container -->
			<div class="heading-wrapper"> <!-- trending-movies-heading-container -->
				<div class="primary-text-secondary-font section-heading"> <!-- trending-movies-heading -->
					<?php esc_html_e( 'Trending Movies', 'screen-time' ); ?>
				</div> <!-- /trending-movies-heading -->
			</div> <!-- /trending-movies-heading-container -->


			<div class="trending-movies-list"> <!-- trending-movies-list -->
				<?php
				foreach ( $trending_movies as $movie ) :
					get_template_part( 'template-parts/post/movie-template', null, array( 'movie' => $movie ) );
				endforeach;
				?>
			</div> <!-- /trending-movies-list -->
		</div> <!-- /trending-movies-list-container -->
	<?php endif; ?>

</div>

<?php
wp_reset_postdata();
get_footer();


