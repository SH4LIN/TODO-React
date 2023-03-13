<?php
/**
 * This file contains template for the expanded navigation menu for mobile views.
 *
 * @package WordPress
 * @subpackage TwentyTwentyOneChild
 * @since Twenty Twenty-One Child 1.0
 */

?>

<div class="st-header-primary-menu-expanded-container hidden">
	<div class="st-header-primary-menu-expanded">
		<div class="st-header-primary-menu-expanded-login-register-actions">
			<div class="primary-text-primary-font st-header-primary-menu-expanded-login-action">
				<?php esc_html_e( 'Sign In', 'screen-time' ); ?>
			</div>

			<div class="primary-text-primary-font st-header-primary-menu-expanded-register-action">
				<?php esc_html_e( 'Register for FREE', 'screen-time' ); ?>
			</div>
		</div>

		<div class="st-header-primary-menu-expanded-separator"></div>

		<div class="st-header-primary-menu-expanded-explore-menu-container">
			<div class="st-header-primary-menu-expanded-explore-menu-text-container">
				<div class="primary-text-primary-font st-header-primary-menu-expanded-explore-menu-text">
					<?php esc_html_e( 'Explore', 'screen-time' ); ?>
				</div>

				<div class="st-header-primary-menu-expanded-explore-menu-down-arrow">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_down_arrow.svg' ); ?>" />
				</div>
			</div>

			<?php
			wp_nav_menu(
				array(
					'menu'            => 'explore',
					'theme_location'  => 'footer',
					'container_class' => 'st-header-primary-menu-expanded-explore-menu',
					'menu_class'      => 'st-header-primary-menu-expanded-explore-menu-list',
					'container'       => 'nav',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'fallback'        => false,
				)
			);
			?>
		</div>

		<div class="st-header-primary-menu-expanded-separator"></div>

		<div class="st-header-primary-menu-expanded-settings-menu-container">
			<div class="st-header-primary-menu-expanded-settings-menu-text-container">
				<div class="primary-text-primary-font st-header-primary-menu-expanded-settings-menu-text">
					<?php esc_html_e( 'Settings', 'screen-time' ); ?>
				</div>

				<div class="st-header-primary-menu-expanded-settings-menu-down-arrow">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_down_arrow.svg' ); ?>" />
				</div>
			</div>


			<div class="st-header-primary-menu-expanded-settings-menu">
				<ul class="st-header-primary-menu-expanded-settings-menu-list">
					<li>
						<?php esc_html_e( 'Language: ' ); ?><span class="language"><?php esc_html_e( 'ENG ' ); ?></span>
					</li>
					<li>
						<a href="http://www.google.com">
							<?php esc_html_e( 'preference', 'screen-time' ); ?>
						</a>
					</li>
					<li>
						<a href="http://www.google.com">
							<?php esc_html_e( 'location', 'screen-time' ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>

		<div class="st-header-primary-menu-expanded-separator"></div>

		<div class="primary-text-tag-font st-header-primary-menu-expanded-version-text">
			<?php esc_html_e( 'Version: 3.9.2' ); ?>
		</div>

	</div>
</div>
