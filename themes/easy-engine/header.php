<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @package EasyEngine
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

			<header id="masthead" class="site-header" role="banner">
				<div class="header-inner">
					<div class="header-inner__branding">
						<?php
						if ( has_custom_logo() ) {
							the_custom_logo();
						} else {
							?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<?php bloginfo( 'name' ); ?>
							</a>
							<?php
						}
						?>
					</div>

					<nav class="header-inner__navigation">
						<div class="mobile-visible menu-action">
							<button id="menu" aria-controls="primary-menu" aria-expanded="false">
								<i class="fas fa-bars fa-lg"></i>
							</button>

							<button id="close" class="hidden" aria-controls="primary-menu" aria-expanded="false">
								<i class="fas fa-times fa-lg"></i>
							</button>
						</div>


						<?php
						if ( has_nav_menu( 'primary-menu' ) ) {
							wp_nav_menu(
								array(
									'theme_location'  => 'primary-menu',
									'menu_class'      => 'primary-menu-inner',
									'container'       => 'nav',
									'container_class' => 'desktop-visible primary-menu-wrapper',
									'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
									'depth'           => 2,
									'fallback'        => false,
								)
							);
						}
						?>


						<?php get_search_form(); ?>
					</nav>
				</div>

				<?php
				if ( has_nav_menu( 'primary-menu' ) ) {
					wp_nav_menu(
						array(
							'theme_location'  => 'primary-menu',
							'menu_class'      => 'expanded-menu-inner',
							'container'       => 'nav',
							'container_class' => 'mobile-visible expanded-menu-wrapper',
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 2,
							'fallback'        => false,
						)
					);
				}
				?>

			</header>



			<div id="primary" class= "st-content-area"> <!-- site-content-area -->
				<main id="main" class= "st-site-main" role="main"> <!-- site-main -->
