<?php
/**
 * This file is template for the single rt-movie post type it will call all the other parts of the templates.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since 1.0.0
 */

use MovieLib\admin\classes\custom_post_types\RT_Person;

require_once get_stylesheet_directory() . '/classes/class-single-rt-movie-data.php';

$current_id = get_the_ID();

?>


	<div class="st-sm-container">

		<?php get_template_part( 'template-parts/post/rt-movie/single/poster-title-template', null, Single_RT_Movie_Data::instance()->get_poster_title_data( $current_id ) ); ?>
		<?php get_template_part( 'template-parts/post/rt-movie/single/plot-quick-links-template', null, Single_RT_Movie_Data::instance()->get_plot_data( $current_id ) ); ?>
		<?php get_template_part( 'template-parts/post/rt-movie/single/cast-crew-template', null, Single_RT_Movie_Data::instance()->get_crew_data( $current_id ) ); ?>
		<?php get_template_part( 'template-parts/post/rt-movie/single/snapshots-template', null, Single_RT_Movie_Data::instance()->get_snapshot_data( $current_id ) ); ?>
		<?php get_template_part( 'template-parts/post/rt-movie/single/trailers-clips-template', null, Single_RT_Movie_Data::instance()->get_video_data( $current_id ) ); ?>
		<?php get_template_part( 'template-parts/post/rt-movie/single/reviews-template', null, Single_RT_Movie_Data::instance()->get_comment_data( $current_id ) ); ?>

	</div>

