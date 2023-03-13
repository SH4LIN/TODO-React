<?php
/**
 * This page is template page for the single rt-person post type.
 * It will call all the other template for the rt-person post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since 1.0.0
 */

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\meta_boxes\RT_Media_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Person_Meta_Box;
use MovieLib\admin\classes\taxonomies\Movie_Person;
use MovieLib\admin\classes\taxonomies\Person_Career;

$hero_data     = array();
$current_id    = get_the_ID();
$current_title = get_the_title();
$full_name     = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_BASIC_FULL_NAME_SLUG, true );
$birth_place   = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_PLACE_SLUG, true );
$career        = get_the_terms( $current_id, Person_Career::SLUG );
$occupation    = '';

if ( ! empty( $career ) ) {

	if ( is_array( $career ) ) {

		$careers = array();

		foreach ( $career as $value ) {

			$careers[] = $value->name;

		}

		$occupation = implode( ', ', $careers );

	} else {

		$occupation = $career->title;

	}
}

$birth_date_str    = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_DATE_SLUG, true );
$birth_date_format = DateTime::createFromFormat( 'Y-m-d', $birth_date_str );
$today             = new DateTime(); // The current date and time.
$age               = '';
try {
	$diff = $today->diff( $birth_date_format ); // The difference between the two dates.
	$age  = $diff->y; // The number of whole years in the difference.
} catch ( Exception $e ) {
	new WP_Error( $e->getMessage() );
}

$birth_date     = $birth_date_format->format( 'j F Y' );
$birth_date_age = sprintf( __( '%1$s (age %2$s years)' ), $birth_date, $age );

$start_year_str     = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_BASIC_START_YEAR_SLUG, true );
$start_year_format  = DateTime::createFromFormat( 'Y-m-d', $start_year_str );
$start_year         = $start_year_format->format( 'Y' );
$start_year_present = sprintf( __( '%1$s-present' ), $start_year );

try {
	$diff = $today->diff( $birth_date_format ); // The difference between the two dates.
	$age  = $diff->y; // The number of whole years in the difference.
} catch ( Exception $e ) {
	new WP_Error( $e->getMessage() );
}

$search_query = array(
	array(
		'taxonomy' => Movie_Person::SLUG,
		'field'    => 'slug',
		'terms'    => array( $current_id ),
	),
);

$query = new WP_Query(
	array(
		'post_type' => RT_Movie::SLUG,
		'tax_query' => $search_query, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
	)
);

$movies_worked  = $query->posts;
$popular_movies = null;
if ( count( $movies_worked ) > 4 ) {
	$popular_movies = array_slice( $query->posts, 0, 3 );
} else {
	$popular_movies = array_slice( $query->posts, 0 );
}

$movie_name_release_date = array();
foreach ( $movies_worked as $movie ) {
	$movie_name_release_date [] = array(
		'movie_name'   => $movie->post_title,
		'release_date' => get_post_meta( $movie->ID, RT_Movie_Meta_Box::MOVIE_META_BASIC_RELEASE_DATE_SLUG, true ),
	);
}

/**
 * This function is used to sort the movie array by release date.
 *
 * @param WP_Post $a This will be the one of the WP_Post object from the array.
 * @param WP_Post $b This will be the one of the WP_Post object from the array.
 *
 * @return int
 */
function sort_by_release_date( $a, $b ): int {

	$date1_str = $a['release_date'];
	if ( empty( $date1_str ) ) {
		return 1;
	}

	$date2_str = $b['release_date'];
	if ( empty( $date2_str ) ) {
		return -1;
	}

	$date1 = DateTime::createFromFormat( 'Y-m-d', $date1_str );
	$date2 = DateTime::createFromFormat( 'Y-m-d', $date2_str );

	if ( $date1 > $date2 ) {
		return 1;
	} elseif ( $date1 < $date2 ) {
		return -1;
	}
	return 0;
}

usort( $movie_name_release_date, 'sort_by_release_date' );

$debut_movie_name = $movie_name_release_date[0]['movie_name'];
$debut_movie_date = $movie_name_release_date[0]['release_date'];
$debut_movie_year = DateTime::createFromFormat( 'Y-m-d', $debut_movie_date )->format( 'Y' );

$debut_movie_name_year = sprintf( '%1$s (%2$s)', $debut_movie_name, $debut_movie_year );

function get_upcoming_movies( $value ) {
	$current_date = gmdate( 'Y-m-d' );
	if ( empty( $value['release_date'] ) ) {
		return false;
	}

	$movie_date = $value['release_date'];

	return $movie_date > $current_date;

}

$upcoming_movies_array = array_filter( $movie_name_release_date, 'get_upcoming_movies' );
$upcoming_movies       = '';

if ( count( $upcoming_movies_array ) > 0 ) {
	$upcoming_movies_array = array_values( $upcoming_movies_array );
	foreach ( $upcoming_movies_array as $upcoming_movie ) {
		$release_year     = DateTime::createFromFormat( 'Y-m-d', $upcoming_movie['release_date'] )->format( 'Y' );
		$upcoming_movies .= sprintf( '%1$s (%2$s), ', $upcoming_movie['movie_name'], $release_year );
	}
}

$twitter_url   = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_SOCIAL_TWITTER_SLUG, true );
$facebook_url  = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_SOCIAL_FACEBOOK_SLUG, true );
$instagram_url = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_SOCIAL_INSTAGRAM_SLUG, true );
$web_url       = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_SOCIAL_WEB_SLUG, true );

$social_urls = array();

if ( ! empty( $twitter_url ) ) {
	$social_urls[] = array(
		'social' => 'twitter',
		'url'    => $twitter_url,
	);
}

if ( ! empty( $facebook_url ) ) {
	$social_urls[] = array(
		'social' => 'facebook',
		'url'    => $facebook_url,
	);
}

if ( ! empty( $instagram_url ) ) {
	$social_urls[] = array(
		'social' => 'instagram',
		'url'    => $instagram_url,
	);
}

if ( ! empty( $web_url ) ) {
	$social_urls[] = array(
		'social' => 'web',
		'url'    => $web_url,
	);
}

$hero_data['current_id']            = $current_id;
$hero_data['full_name']             = $full_name;
$hero_data['occupation']            = $occupation;
$hero_data['birth_date_str']        = $birth_date_str;
$hero_data['birth_date_age']        = $birth_date_age;
$hero_data['birth_place']           = $birth_place;
$hero_data['start_year_present']    = $start_year_present;
$hero_data['debut_movie_name_year'] = $debut_movie_name_year;
$hero_data['upcoming_movies']       = $upcoming_movies;
$hero_data['social_urls']           = $social_urls;

$popular_movies_data['popular_movies'] = $popular_movies;

$snapshots = get_post_meta( $current_id, RT_Media_Meta_Box::IMAGES_SLUG );
$videos    = get_post_meta( $current_id, RT_Media_Meta_Box::VIDEOS_SLUG );

$snapshots_data['snapshots'] = $snapshots;
$videos_data['videos']       = $videos;
?>

<div class="st-sp-container">

	<?php get_template_part( 'template-parts/post/rt-person/single/hero-template', null, $hero_data ); ?>
	<?php get_template_part( 'template-parts/post/rt-person/single/about-quick-links-template' ); ?>
	<?php get_template_part( 'template-parts/post/rt-person/single/popular-movies-template', null, $popular_movies_data ); ?>
	<?php get_template_part( 'template-parts/post/rt-person/single/snapshots-template', null, $snapshots_data ); ?>
	<?php get_template_part( 'template-parts/post/rt-person/single/videos-template',null, $videos_data ); ?>

</div>


