<?php
/**
 * This file is template for the single rt-movie post type it will call all the other parts of the templates.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since 1.0.0
 */

use MovieLib\admin\classes\custom_post_types\RT_Person;

$poster_title_data = array();

$current_id  = get_the_ID();
$movie_title = get_the_title( $current_id );

$poster_title_data['id']   = $current_id;
$poster_title_data['name'] = $movie_title;

$post_thumbnail_id = get_post_thumbnail_id( $current_id );
$poster_url        = '';
if ( $post_thumbnail_id ) {
	$poster_url = wp_get_attachment_image_url( $post_thumbnail_id, 'full' );
} else {
	$poster_url = get_stylesheet_directory_uri() . '/assets/src/images/placeholder.webp';
}
$poster_title_data['poster'] = $poster_url;

$poster_title_data['rating'] = '';
$rating                      = get_post_meta( $current_id, 'rt-movie-meta-basic-rating', true );
if ( ! empty( $rating ) ) {
	$poster_title_data['rating'] = $rating . '/10';
}

$poster_title_data['release_year'] = '';
$release_year                      = get_post_meta( $current_id, 'rt-movie-meta-basic-release-date', true );
if ( ! empty( $release_year ) ) {
	$date                              = DateTime::createFromFormat( 'Y-m-d', $release_year );
	$poster_title_data['release_year'] = $date->format( 'Y' );
}

$poster_title_data['content_rating'] = 'PG-13';

$poster_title_data['runtime'] = '';

$minutes = get_post_meta( $current_id, 'rt-movie-meta-basic-runtime', true );
if ( ! empty( $minutes ) ) {
	$poster_title_data['runtime'] = intdiv( $minutes, 60 ) . __( 'H ' ) . ( $minutes % 60 ) . __( 'M' );
}

$poster_title_data['genres'] = '';
$genres                      = get_the_terms( $current_id, 'rt-movie-genre' );
if ( ! empty( $genres ) ) {
	$poster_title_data['genres'] = $genres;
}

$poster_title_data['synopsis'] = '';
$synopsis                      = get_the_excerpt( $current_id );
if ( ! empty( $synopsis ) ) {
	$poster_title_data['synopsis'] = $synopsis;
}

$poster_title_data['directors'] = '';
$directors                      = get_post_meta( $current_id, 'rt-movie-meta-crew-director' );
if ( ! empty( $directors ) ) {
	$poster_title_data['directors'] = $directors;
}

$plot_data = array();

$plot_data['id'] = $current_id;

$plot              = get_the_content( $current_id );
$plot_data['plot'] = '';
if ( ! empty( $plot ) ) {
	$plot_data['plot'] = $plot;
}

$crew_data = array();

$crew_data['id']   = $current_id;
$crew_data['link'] = get_post_type_archive_link( RT_Person::SLUG ) . '?movie_id=' . $current_id;

$crew              = get_post_meta( $current_id, 'rt-movie-meta-crew-actor' );
$crew_data['crew'] = '';
if ( ! empty( $crew ) ) {
	$crew_data['crew'] = $crew;
}

$snapshots_data = array();

$snapshots_data['id'] = $current_id;

$snapshots                   = get_post_meta( $current_id, 'rt-media-meta-images' );
$snapshots_data['snapshots'] = '';
if ( ! empty( $snapshots ) ) {
	$snapshots_data['snapshots'] = $snapshots;
}

$trailer_data = array();

$trailer_data['id'] = $current_id;

$trailer_clips = get_post_meta( $current_id, 'rt-media-meta-videos' );

$trailer_data['trailers'] = '';
if ( ! empty( $trailer_clips ) ) {
	$trailer_data['trailers'] = $trailer_clips;
}

$comments_data = array();

$comments_data['id'] = $current_id;

$post_comments = get_comments(
	array(
		'post_id' => $current_id,
	)
);

$comments_data['comments'] = '';
if ( ! empty( $post_comments ) ) {
	$comments_data['comments'] = $post_comments;
}

?>


	<div class="st-sm-container">

		<?php get_template_part( 'template-parts/post/rt-movie/single/poster-title-template', null, $poster_title_data ); ?>
		<?php get_template_part( 'template-parts/post/rt-movie/single/plot-quick-links-template', null, $plot_data ); ?>
		<?php get_template_part( 'template-parts/post/rt-movie/single/cast-crew-template', null, $crew_data ); ?>
		<?php get_template_part( 'template-parts/post/rt-movie/single/snapshots-template', null, $snapshots_data ); ?>
		<?php get_template_part( 'template-parts/post/rt-movie/single/trailers-clips-template', null, $trailer_data ); ?>
		<?php get_template_part( 'template-parts/post/rt-movie/single/reviews-template', null, $comments_data ); ?>

	</div>

