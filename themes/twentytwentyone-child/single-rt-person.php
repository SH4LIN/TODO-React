<?php
/**
 * This file is used to display the single rt-person post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\meta_boxes\RT_Media_Meta_Box;
use MovieLib\admin\classes\taxonomies\Movie_Label;
use MovieLib\admin\classes\taxonomies\Movie_Person;

get_header();

$current_id = get_the_ID();

require_once get_stylesheet_directory() . '/classes/class-single-rt-person-data.php';

$about_data = array();

$about_data['desktop_heading'] = __( 'About', 'screen-time' );
$about_data['mobile_heading']  = __( 'About', 'screen-time' );

$about_data['quick_links'] = wp_nav_menu(
	array(
		'menu'            => 'single-person',
		'menu_class'      => 'quick-links-list',
		'container'       => 'nav',
		'container_class' => 'quick-links-list-container',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'fallback'        => false,
		'echo'            => false,
	)
);

$search_query = array(
	'relation' => 'AND',
	array(
		'taxonomy' => Movie_Person::SLUG,
		'field'    => 'slug',
		'terms'    => array( get_the_ID() ),
	),
	array(
		'taxonomy' => Movie_Label::SLUG,
		'field'    => 'slug',
		'terms'    => array( 'popular-movies' ),
	),
);

$query          = new WP_Query(
	array(
		'post_type' => RT_Movie::SLUG,
		'tax_query' => $search_query, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
	)
);
$popular_movies = $query->posts;

$snapshots_data['snapshots'] = '';
$snapshots                   = get_post_meta( get_the_ID(), RT_Media_Meta_Box::IMAGES_SLUG );
if ( ! empty( $snapshots ) ) {
	$snapshots_data['snapshots'] = $snapshots;
}

$snapshots_data['heading'] = __( 'Snapshots', 'screen-time' );

$videos_data['videos'] = '';
$videos                = get_post_meta( get_the_ID(), RT_Media_Meta_Box::VIDEOS_SLUG );
if ( ! empty( $videos ) && ! empty( $videos[0] ) ) {
	$videos_data['videos'] = $videos[0];
}

$videos_data['heading'] = __( 'Videos', 'screen-time' );

$single_rt_person_data = Single_RT_Person_Data::instance();
?>

<div class="sp-wrapper">

	<?php get_template_part( 'template-parts/post/rt-person/single/hero-template', null, $single_rt_person_data->get_hero_data() ); ?>
	<?php get_template_part( 'template-parts/post/about-template', null, $about_data ); ?>

	<?php

	if ( ! empty( $popular_movies ) ) :
		?>
		<div class= "popular-movies-wrapper">
		<div class="heading-wrapper">
			<p class="primary-text-secondary-font section-heading">
				<?php esc_html_e( 'Popular Movies', 'screen-time' ); ?>
			</p>
		</div>

		<div class="popular-movies-list-wrapper">
			<?php
			foreach ( $popular_movies as $movie ) :
				get_template_part( 'template-parts/post/movie-template', null, array( 'movie' => $movie ) );
			endforeach;
			?>
		</div>
	</div>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/post/snapshots-template', null, $snapshots_data ); ?>
	<?php get_template_part( 'template-parts/post/videos-template', null, $videos_data ); ?>

</div>

<?php
get_footer();
