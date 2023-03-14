<?php
/**
 * Displays the site footer.
 *
 * @package TwentyTwentyOneChild
 * @since 1.0.0
 */

$company_menu = wp_nav_menu(
	array(
		'menu'            => 'company',
		'theme_location'  => 'footer',
		'menu_class'      => 'st-company-navigation-list',
		'container'       => 'nav',
		'container_class' => 'st-company-navigation',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'fallback'        => false,
		'echo'            => false,
	)
);

$explore_menu = wp_nav_menu(
	array(
		'menu'            => 'explore',
		'theme_location'  => 'footer',
		'menu_class'      => 'st-explore-navigation-list',
		'container'       => 'nav',
		'container_class' => 'st-explore-navigation',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'fallback'        => false,
		'echo'            => false,
	)
);

?>

<footer>
	<div class="st-footer-container">
		<?php get_template_part( 'template-parts/footer/footer-content' ); ?>

		<?php
		if ( $company_menu ) :
			$display_menu = array(
				'name' => __( 'Company', 'screen-time' ),
				'menu' => $company_menu,
			);
			?>

			<div class="st-footer-company-navigation-container">
				<?php get_template_part( 'template-parts/footer/footer-menu', null, $display_menu ); ?>
			</div>

		<?php endif; ?>

		<?php
		if ( $explore_menu ) :
			$display_menu = array(
				'name' => __( 'Explore', 'screen-time' ),
				'menu' => $explore_menu,
			);
			?>

			<div class="st-footer-explore-navigation-container">
				<?php get_template_part( 'template-parts/footer/footer-menu', null, $display_menu ); ?>
			</div>

		<?php endif; ?>
	</div>

	<div class="st-footer-separator"></div>

	<?php get_template_part( 'template-parts/footer/footer-copyright' ); ?>
</footer>
