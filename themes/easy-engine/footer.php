<?php
/**
 * This file is template for the footer of the Website.
 *
 * @package EasyEngine
 * @since 1.0.0
 */

?>

				</main>
			</div>
		</div>

<footer id="mast-foot" class="site-footer" role="contentinfo">
	<div class="footer-inner">

		<?php if ( has_nav_menu( 'documentation' ) ) : ?>
			<section>
				<h4><?php echo esc_html( wp_get_nav_menu_name( 'documentation' ) ); ?></h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'documentation',
						'menu_class'      => 'menu-documentation',
						'container'       => 'nav',
						'container_class' => 'menu-documentation-wrapper',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'fallback'        => false,
					)
				);
				?>
				</section>
			<?php endif; ?>



		<?php if ( has_nav_menu( 'community' ) ) : ?>
			<section>
				<h4><?php echo esc_html( wp_get_nav_menu_name( 'community' ) ); ?></h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'community',
						'menu_class'      => 'menu-community',
						'container'       => 'nav',
						'container_class' => 'menu-community-wrapper',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'fallback'        => false,
					)
				);
				?>
			</section>
		<?php endif; ?>


		<?php if ( has_nav_menu( 'easy-engine' ) ) : ?>
			<section>
				<h4><?php echo esc_html( wp_get_nav_menu_name( 'easy-engine' ) ); ?></h4>
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'easy-engine',
						'menu_class'      => 'menu-easy-engine',
						'container'       => 'nav',
						'container_class' => 'menu-easy-engine-wrapper',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'fallback'        => false,
					)
				);
				?>
			</section>
		<?php endif; ?>

		<section>
			<h4><?php esc_html_e( 'Newsletter', 'easy-engine' ); ?></h4>

			<form id="news-letter-form">
				<?php wp_nonce_field( 'news-letter', 'news-letter-nonce' ); ?>
				<label for="news-letter-email" class="email-label"><?php esc_html_e( 'Email', 'easy-engine' ); ?></label>
				<input type="email" class="email-input" id="news-letter-email" name="news-letter-email" placeholder="<?php esc_attr_e( 'Enter Email Address', 'easy-engine' ); ?>" required>
				<div class="sign-me-up-btn-wrapper">
					<input type="submit" class="button" value="<?php esc_attr_e( 'Sign me up', 'easy-engine' ); ?>"/>
				</div>
			</form>

			</section>

	</div>

	<div class="copyrights">
		<span>
			<?php echo esc_html( sprintf( '&copy; %1$s-%2$s', wp_get_theme()->get( 'Author' ), wp_date( 'Y' ) ) ); ?>
			<a href="<?php echo esc_url( wp_get_theme()->get( 'AuthorURI' ) ); ?>" target="_blank"><?php echo esc_html( wp_get_theme()->get( 'Author' ) ); ?></a>
		</span>


		<?php
		if ( has_nav_menu( 'primary-menu' ) ) :
			wp_nav_menu(
				array(
					'theme_location'  => 'primary-menu',
					'menu_class'      => 'primary-menu',
					'container'       => 'nav',
					'container_class' => 'desktop-visible primary-menu-wrapper',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'depth'           => 1,
					'fallback'        => false,
				)
			);
		endif;
		?>

	</div>
</footer>

<?php
wp_footer();
?>
	</body> <!-- /body -->
</html> <!-- /html -->

