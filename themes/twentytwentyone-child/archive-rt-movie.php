<?php
/**
 * This file is used to display the archive page for the rt-movie post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\taxonomies\Movie_Label;

require_once get_stylesheet_directory() . '/classes/class-archive-rt-movie-data.php';

$slider_movies   = Archive_RT_Movie_Data::instance()->get_slider_movies();
$upcoming_movies = Archive_RT_Movie_Data::instance()->get_upcoming_movies();
$trending_movies = Archive_RT_Movie_Data::instance()->get_trending_movies();

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
		<?php get_template_part( 'template-parts/post/rt-movie/archive/trending-movies-template', null, array( 'movies' => $trending_movies ) ); ?>
	<?php endif; ?>

</div>

<?php
wp_reset_postdata();
get_footer();


