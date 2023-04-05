<?php
/**
 * This file contains template for the expanded navigation menu for mobile views.
 *
 * @package WordPress
 * @subpackage TwentyTwentyOneChild
 * @since 1.0.0
 */

?>

<div class="primary-menu-expanded-container"> <!-- header-primary-menu-expanded-container -->
	<div class="primary-menu-expanded">
		<div class="primary-menu-expanded-login-register-actions">
			<p class="primary-text-primary-font primary-menu-expanded-login-action">
				<?php esc_html_e( 'Sign In', 'screen-time' ); ?>
			</p>

			<p class="primary-text-primary-font primary-menu-expanded-register-action">
				<?php esc_html_e( 'Register for FREE', 'screen-time' ); ?>
			</p>
		</div>

		<div class="primary-menu-expanded-separator"></div>

		<div class="primary-menu-expanded-explore-menu-wrapper">
			<div class="primary-menu-expanded-explore-menu-text-wrapper">
				<p class="primary-text-primary-font primary-menu-expanded-explore-menu-text">
					<?php esc_html_e( 'Explore', 'screen-time' ); ?>
				</p>

				<div class="primary-menu-expanded-explore-menu-down-arrow" id="explore-btn">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_down_arrow.svg' ); ?>" />
				</div>
			</div>

			<?php
			wp_nav_menu(
				array(
					'menu'            => 'explore',
					'theme_location'  => 'footer',
					'container_class' => 'primary-menu-expanded-explore-menu',
					'menu_class'      => 'primary-menu-expanded-explore-menu-list',
					'container'       => 'nav',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'fallback'        => false,
				)
			);
			?>
		</div>

		<div class="primary-menu-expanded-separator"></div>

		<div class="primary-menu-expanded-settings-menu-wrapper">
			<div class="primary-menu-expanded-settings-menu-text-wrapper">
				<p class="primary-text-primary-font primary-menu-expanded-settings-menu-text">
					<?php esc_html_e( 'Settings', 'screen-time' ); ?>
				</p>

				<div class="primary-menu-expanded-settings-menu-down-arrow" id="settings-btn">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_down_arrow.svg' ); ?>" />
				</div>
			</div>


			<div class="primary-menu-expanded-settings-menu">
				<ul class="primary-menu-expanded-settings-menu-list">
					<li>
						<?php esc_html_e( 'Language: ', 'screen-time' ); ?>
						<span class="language"><?php esc_html_e( 'ENG ', 'screen-time' ); ?></span>
					</li>

					<li>
						<a href="<?php esc_url( 'http://www.google.com' ); ?>">
							<?php esc_html_e( 'preference', 'screen-time' ); ?>
						</a>
					</li>

					<li>
						<a href="<?php esc_url( 'http://www.google.com' ); ?>">
							<?php esc_html_e( 'location', 'screen-time' ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>

		<div class="primary-menu-expanded-separator"></div>

		<div class="primary-text-tag-font primary-menu-expanded-version-text">
			<?php esc_html_e( 'Version: 3.9.2', 'screen-time' ); ?>
		</div>

	</div>
</div> <!-- header-primary-menu-expanded-container -->
