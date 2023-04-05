<?php
/**
 * This file is template for the single rt-movie post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\admin\classes\meta_boxes\RT_Media_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box;
use MovieLib\admin\classes\taxonomies\Movie_Genre;

get_header();

$poster_title_data = array();

if ( has_post_thumbnail() ) {
	$poster_url = get_the_post_thumbnail_url( null, 'full' );
} else {
	$poster_url = get_stylesheet_directory_uri() . '/assets/src/images/placeholder.webp';
}
$poster_title_data['poster'] = $poster_url;

$poster_title_data['rating'] = '';
$rating                      = get_movie_meta( get_the_ID(), RT_Movie_Meta_Box::MOVIE_META_BASIC_RATING_SLUG, true );
if ( ! empty( $rating ) ) {
	$poster_title_data['rating'] = $rating . '/10';
}

$poster_title_data['release_year'] = '';
$release_year                      = get_movie_meta( get_the_ID(), RT_Movie_Meta_Box::MOVIE_META_BASIC_RELEASE_DATE_SLUG, true );
if ( ! empty( $release_year ) ) {
	$date                              = DateTime::createFromFormat( 'Y-m-d', $release_year );
	$poster_title_data['release_year'] = $date->format( 'Y' );
}

$poster_title_data['content_rating'] = 'PG-13';

$poster_title_data['runtime'] = '';

$minutes = get_movie_meta( get_the_ID(), RT_Movie_Meta_Box::MOVIE_META_BASIC_RUNTIME_SLUG, true );
if ( ! empty( $minutes ) ) {
	$poster_title_data['runtime'] = intdiv( $minutes, 60 ) . __( 'H ', 'screen-time' ) . ( $minutes % 60 ) . __( 'M', 'screen-time' );
}

$poster_title_data['genres'] = '';
$genres                      = get_the_terms( get_the_ID(), Movie_Genre::SLUG );
if ( ! empty( $genres ) ) {
	$poster_title_data['genres'] = $genres;
}

$poster_title_data['directors'] = '';
$directors                      = get_movie_meta( get_the_ID(), 'rt-movie-meta-crew-director' );
if ( ! empty( $directors ) ) {
	$poster_title_data['directors'] = $directors;
}

$trailer_clips = get_movie_meta( get_the_ID(), RT_Media_Meta_Box::VIDEOS_SLUG, true );

$poster_title_data['trailer'] = '';
if ( ! empty( $trailer_clips ) ) {
	$poster_title_data['trailer'] = $trailer_clips[0];
}

$plot_data = array();

$plot_data['desktop_heading'] = __( 'Plot', 'screen-time' );
$plot_data['mobile_heading']  = __( 'Synopsis', 'screen-time' );

$plot_data['quick_links'] = wp_nav_menu(
	array(
		'theme_location'  => 'single-movie',
		'menu_class'      => 'quick-links-list',
		'container'       => 'nav',
		'container_class' => 'quick-links-list-container',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'fallback'        => false,
		'echo'            => false,
	)
);

$crew_data = array();

$crew_data['link'] = get_post_type_archive_link( RT_Person::SLUG ) . '?movie_id=' . get_the_ID();

$crew              = get_movie_meta( get_the_ID(), 'rt-movie-meta-crew-actor' );
$crew_data['crew'] = '';
if ( ! empty( $crew ) ) {
	$crew_data['crew'] = $crew;
}

$snapshots_data = array();

$snapshots                   = get_movie_meta( get_the_ID(), RT_Media_Meta_Box::IMAGES_SLUG );
$snapshots_data['snapshots'] = '';
if ( ! empty( $snapshots ) ) {
	$snapshots_data['snapshots'] = $snapshots;
}

$snapshots_data['heading'] = __( 'Snapshots', 'screen-time' );

$videos_data = array();

$trailer_clips = get_movie_meta( get_the_ID(), RT_Media_Meta_Box::VIDEOS_SLUG );

$videos_data['videos'] = '';
if ( ! empty( $trailer_clips ) && ! empty( $trailer_clips[0] ) ) {
	$videos_data['videos'] = $trailer_clips[0];
}

$videos_data['heading'] = __( 'Trailer & Clips', 'screen-time' );

$comments_data = array();

$post_comments = get_comments(
	array(
		'post_id' => get_the_ID(),
	)
);

$comments_data['comments'] = '';
if ( ! empty( $post_comments ) ) {
	$comments_data['comments'] = $post_comments;
}

?>

<div class="sm-wrapper"> <!-- sm-container -->

	<?php get_template_part( 'template-parts/post/rt-movie/single/poster-title-template', null, $poster_title_data ); ?>
	<?php get_template_part( 'template-parts/post/about-template', null, $plot_data ); ?>
	<?php get_template_part( 'template-parts/post/rt-movie/single/cast-crew-template', null, $crew_data ); ?>
	<?php get_template_part( 'template-parts/post/snapshots-template', null, $snapshots_data ); ?>
	<?php get_template_part( 'template-parts/post/videos-template', null, $videos_data ); ?>
	<?php get_template_part( 'template-parts/post/rt-movie/single/reviews-template', null, $comments_data ); ?>

</div> <!-- /sm-container -->
<?php
get_footer();
