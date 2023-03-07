<?php
/**
 * Displays the site header.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

$wrapper_classes = 'screen-time-header';
?>

<header id="masthead" class="<?php echo esc_attr( $wrapper_classes ); ?>">

	<div class="search-container">
		<div>
			<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_search.svg' ); ?>">
			<span class="primary-text heading-text search-text">SEARCH</span>
		</div>
	</div>

	<?php get_template_part( 'template-parts/header/site-logo' ); ?>

	<div class="header-actions">
		<div class="sign-in-action">
			<img class="ic_user" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_user.svg' ); ?>" />
			<span class="primary-text heading-text sign-in-text">SIGN IN</span>
		</div>

		<div class="language-action">
			<span class="primary-text heading-text language-text"> ENG  ▼</span>
		</div>

		<div class="menu-action">
			<img class="ic_menu" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_menu.svg' ); ?>" />
		</div>
	</div>

</header><!-- #masthead -->
