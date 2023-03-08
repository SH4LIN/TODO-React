<?php
/**
 * Template part for displaying the site login and language
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One Child
 * @since Twenty Twenty-One Child 1.0
 */

?>

<div class="header-actions">
	<div class="sign-in-container">
		<img class="ic_user" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_user.svg' ); ?>" />
		<span class="primary-text-primary-font heading-text sign-in-text"><?php esc_html_e( 'Sign in' ); ?></span>
	</div>

	<div class="language-container">
		<span class="primary-text-primary-font heading-text language-text"><?php esc_html_e( 'Eng' ); ?></span>
		<img class="ic_down" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_down.svg' ); ?>" />
	</div>
</div>

<div class="menu-container">
	<img class="ic_menu" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_menu.svg' ); ?>" />
</div>
