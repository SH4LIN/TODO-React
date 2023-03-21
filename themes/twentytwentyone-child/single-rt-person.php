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
	<?php get_template_part( 'template-parts/post/about-template', null, $single_rt_person_data->get_about_data( $current_id ) ); ?>

	<?php
	$movies = $single_rt_person_data->get_popular_movies( $current_id );

	if ( $movies && count( $movies ) > 0 ) :
		?>
		<div class= "popular-movies-wrapper">
		<div class="heading-wrapper">
			<p class="primary-text-secondary-font section-heading-text">
				<?php esc_html_e( 'Popular Movies', 'screen-time' ); ?>
			</p>
		</div>

		<div class="popular-movies-list-wrapper">
			<?php
			foreach ( $movies as $movie ) :
				get_template_part( 'template-parts/post/movie-template', null, array( 'movie' => $movie ) );
			endforeach;
			?>
		</div>
	</div>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/post/snapshots-template', null, $single_rt_person_data->get_snapshots( $current_id ) ); ?>
	<?php get_template_part( 'template-parts/post/videos-template', null, $single_rt_person_data->get_videos( $current_id ) ); ?>

</div>

<?php
get_footer();
