<?php
/**
 * Displays the site header.
 *
 * @package TwentyTwentyOneChild
 * @since 1.0.0
 */

?>
<form class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
	<div class="search-wrapper">
		<label for="search-input" class="screen-reader-text">
			<?php esc_html_e( 'Search', 'screen-time' ); ?>
		</label>
		<input
			type="search"
			id="search-input"
			class="search-field"
			placeholder="<?php esc_attr_e( 'Search', 'screen-time' ); ?>"
			value="<?php echo get_search_query(); ?>"
			name="s"
		/>
		<button type="submit" class="search-submit">
			<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_search.svg' ); ?>">
		</button>
	</div>
</form>

<header id="masthead" class= "header-wrapper"> <!-- header -->
	<div class="header-navigation-container"> <!-- header-navigation-container -->

		<div class="header-container"> <!-- header-container -->
			<div class="header-search-container"> <!-- header-search-container -->
				<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_search.svg' ); ?>">

				<span class="primary-text-primary-font header-text header-search-text">
					<?php esc_html_e( 'Search', 'screen-time' ); ?>
				</span>
			</div> <!-- /header-search-container -->

			<div id="logo" class="header-logo-container"> <!-- header-logo-container -->
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span class="primary-text-secondary-font header-logo-first-half-text">
						<?php esc_html_e( 'Screen', 'screen-time' ); ?>
					</span>
				</a>

				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span class="primary-text-secondary-font header-logo-last-half-text">
						<?php esc_html_e( ' Time', 'screen-time' ); ?>
					</span>
				</a>
			</div> <!-- /header-logo-container -->

			<div class="header-actions-menu-container"> <!-- header-actions-menu-container -->
				<div class="header-actions-container">
					<div class="header-sign-in-container">
						<img class="ic_user" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_user.svg' ); ?>" />

						<span class= "primary-text-primary-font header-text header-sign-in-text"><?php esc_html_e( 'Sign in', 'screen-time' ); ?></span>
					</div>

					<div class="header-language-container">
						<span class="primary-text-primary-font header-text header-language-text"><?php esc_html_e( 'Eng', 'screen-time' ); ?></span>

						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_down.svg' ); ?>" />
					</div>
				</div>

				<div class="header-menu-container">
					<img id="hamburger_menu_icon" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_menu.svg' ); ?>" />

					<img id="close_menu_icon" class="hidden" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_close.svg' ); ?>" />
				</div>
			</div> <!-- /header-actions-menu-container -->
		</div> <!-- /header-container -->

		<div class="primary-menu"> <!-- header-primary-menu -->
			<div class="primary-menu-container"> <!-- header-primary-menu-container -->
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'header',
						'menu_class'      => 'primary-navigation-list',
						'container'       => 'nav',
						'container_class' => 'primary-navigation',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					)
				);
				?>
			</div> <!-- header-primary-menu-container -->

			<?php get_template_part( 'template-parts/header/site-nav-expanded' ); ?>
		</div> <!-- /header-primary-menu -->
	</div> <!-- /header-navigation-container -->
</header> <!-- /header -->
