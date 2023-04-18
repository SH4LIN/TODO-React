<?php
/**
 * This file is the fallback file for all the templates.
 *
 * @package EasyEngine
 * @since 1.0.0
 */

get_header();
if ( have_posts() ) {
	// Load posts loop.
	while ( have_posts() ) {
		the_post();
		the_content();
	}
}
get_footer();

