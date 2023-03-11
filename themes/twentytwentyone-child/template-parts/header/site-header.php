<?php
/**
 * Displays the site header.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>

<header id="masthead" class="st-header">

	<div class="st-header-navigation-container">

			<div class="st-header-container">
				<?php get_template_part( 'template-parts/header/site-search' ); ?>
				<?php get_template_part( 'template-parts/header/site-logo' ); ?>
				<?php get_template_part( 'template-parts/header/site-login-language' ); ?>
			</div>

			<div class="st-header-primary-menu-container">
				<?php get_template_part( 'template-parts/header/site-nav' ); ?>
			</div>
	</div>


</header><!-- #masthead -->
