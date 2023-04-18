<?php
/**
 * Template Name: Front Page
 *
 * This file is a template file for the front page.
 *
 * @package EasyEngine
 * @since 1.0.0
 */

/**
 * This is security to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="front-page-wrapper">
		<div class="content-wrapper">
			<?php the_content(); ?>
		</div>
</section>
<?php
get_footer();


