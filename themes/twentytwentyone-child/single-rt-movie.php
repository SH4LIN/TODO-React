<?php
/**
 * This file is template for the single rt-movie post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

get_header();
$current_id = get_the_ID();

require_once get_stylesheet_directory() . '/classes/class-single-rt-movie-data.php';

$single_rt_movie_data = Single_RT_Movie_Data::instance();
?>

<div class="sm-wrapper"> <!-- sm-container -->

	<?php get_template_part( 'template-parts/post/rt-movie/single/poster-title-template', null, $single_rt_movie_data->get_poster_title_data( $current_id ) ); ?>
	<?php get_template_part( 'template-parts/post/about-quick-links-template', null, $single_rt_movie_data->get_plot_data( $current_id ) ); ?>
	<?php get_template_part( 'template-parts/post/rt-movie/single/cast-crew-template', null, $single_rt_movie_data->get_crew_data( $current_id ) ); ?>
	<?php get_template_part( 'template-parts/post/snapshots-template', null, $single_rt_movie_data->get_snapshot_data( $current_id ) ); ?>
	<?php get_template_part( 'template-parts/post/videos-template', null, $single_rt_movie_data->get_video_data( $current_id ) ); ?>
	<?php get_template_part( 'template-parts/post/rt-movie/single/reviews-template', null, $single_rt_movie_data->get_comment_data( $current_id ) ); ?>

</div> <!-- /sm-container -->
<?php
get_footer();
