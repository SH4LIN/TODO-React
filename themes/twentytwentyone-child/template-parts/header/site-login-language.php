<?php
/**
 * Template part for displaying the site login and language
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One Child
 * @since Twenty Twenty-One Child 1.0
 */

?>

<div class="st-header-actions-menu-container">
	<div class="st-header-actions-container">
		<div class="st-header-sign-in-container">
			<img class="ic_user" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_user.svg' ); ?>" />
			<span class="primary-text-primary-font st-header-text st-header-sign-in-text"><?php esc_html_e( 'Sign in' ); ?></span>
		</div>

		<div class="st-header-language-container">
			<span class="primary-text-primary-font st-header-text st-header-language-text"><?php esc_html_e( 'Eng' ); ?></span>
			<img class="ic_down" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_down.svg' ); ?>" />
		</div>
	</div>

	<div class="st-header-menu-container">
		<img id="hamburger_menu_icon" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_menu.svg' ); ?>" />
		<img id="close_menu_icon" class="hidden" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_close.svg' ); ?>" />
	</div>
</div>
