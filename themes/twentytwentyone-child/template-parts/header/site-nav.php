<?php
/**
 * This file is used to display the navigation menu.
 *
 * @package WordPress
 * @subpackage TwentyTwentyOneChild
 * @since Twenty Twenty-One Child 1.0
 */

wp_nav_menu(
	array(
		'theme_location'  => 'header',
		'menu_class'      => 'st-primary-navigation-list',
		'container'       => 'nav',
		'container_class' => 'st-primary-navigation',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	)
);

