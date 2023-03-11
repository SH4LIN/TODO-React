<?php
/**
 * This file is used to display the archive page for the rt-movie post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */

$rt_movie_query = new WP_Query(
	array(
		'post_type'      => 'rt-movie',
		'posts_per_page' => 13,
	)
);

get_header();
get_template_part(
	'template-parts/post/rt-movie/archive/archive-rt-movie-template',
	null,
	array(
		'rt_movie_query' => $rt_movie_query,
	)
);


