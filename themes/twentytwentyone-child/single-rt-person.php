<?php
/**
 * This file is used to display the single rt-person post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

get_header();

$current_id = get_the_ID();

require_once get_stylesheet_directory() . '/classes/class-single-rt-person-data.php';

$single_rt_person_data = Single_RT_Person_Data::instance();
?>

<div class="sp-wrapper">

	<?php get_template_part( 'template-parts/post/rt-person/single/hero-template', null, $single_rt_person_data->get_hero_data( $current_id ) ); ?>
	<?php get_template_part( 'template-parts/post/about-template.php', null, $single_rt_person_data->get_about_data( $current_id ) ); ?>
	<?php get_template_part( 'template-parts/post/rt-person/single/popular-movies-template', null, $single_rt_person_data->get_popular_movies( $current_id ) ); ?>
	<?php get_template_part( 'template-parts/post/snapshots-template', null, $single_rt_person_data->get_snapshots( $current_id ) ); ?>
	<?php get_template_part( 'template-parts/post/videos-template', null, $single_rt_person_data->get_videos( $current_id ) ); ?>

</div>

<?php
get_footer();
