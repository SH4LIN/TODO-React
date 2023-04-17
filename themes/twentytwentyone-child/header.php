<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Twenty_Twenty_One
 * @since 1.0.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>> <!-- html -->
	<head> <!-- head -->
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>> <!-- body -->
		<?php wp_body_open(); ?>

		<div id="page" class="site"> <!-- site -->

		<?php get_template_part( 'template-parts/header/site-header' ); ?>

		<div id="content" class= "st-site-content"> <!-- site-content -->
			<div id="primary" class= "st-content-area"> <!-- site-content-area -->
				<main id="main" class= "st-site-main" role="main"> <!-- site-main -->