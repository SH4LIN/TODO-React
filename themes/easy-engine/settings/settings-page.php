<?php
/**
 * This file is used to display the checkbox to enable/disable search option.
 *
 * @package EasyEngine
 * @since 1.0.0
 */

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'add_ee_sub_menu' ) ) {

	/**
	 * This function will be used to create the submenu.
	 *
	 * @return void
	 */
	function add_ee_sub_menu(): void {

		add_option( 'ee-search-setting-checkbox', 'on' );

		$hook_name = add_theme_page(
			__( 'Easy Engine Settings', 'easy-engine' ),
			__( 'Easy Engine Settings', 'easy-engine' ),
			'manage_options',
			'ee-settings',
			'ee_theme_settings_page'
		);

		if ( false !== $hook_name ) {

			add_action( 'load-' . $hook_name, 'ee_search_setting_submit' );

		}

		add_action( 'admin_init', 'ee_settings' );

	}
}

if ( ! function_exists( 'ee_theme_settings_page' ) ) {

	/**
	 * This function will be used to create the settings page. Which will have checkbox to remove data.
	 * When you uninstall the plugin.
	 */
	function ee_theme_settings_page(): void {
		// Check user capabilities.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>

		<div class="wrap">
				<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
				<form action="<?php menu_page_url( 'ee-settings' ); ?>" method="POST">
					<?php
					settings_fields( 'ee-search-setting-group' );
					do_settings_sections( 'ee-settings' );
					submit_button( __( 'Save Changes', 'easy-engine' ) );
					?>
				</form>
			</div>
		<?php
	}
}

if ( ! function_exists( 'ee_settings' ) ) {

	/**
	 * This function will be used to create the settings.
	 *
	 * @return void
	 */
	function ee_settings(): void {
		register_setting( 'ee-search-setting-group', 'ee-search-setting' );
		add_settings_section(
			'ee-search-setting-section',
			__( 'Search Settings', 'easy-engine' ),
			'ee_search_setting_section_callback',
			'ee-settings'
		);
		add_settings_field(
			'ee-search-setting-checkbox',
			__( 'Enable Search', 'easy-engine' ),
			'ee_search_setting_data_field_callback',
			'ee-settings',
			'ee-search-setting-section',
		);
	}
}

if ( ! function_exists( 'ee_search_setting_section_callback' ) ) {

	/**
	 * This function will be used to create the section.
	 *
	 * @return void
	 */
	function ee_search_setting_section_callback(): void {}
}

if ( ! function_exists( 'ee_search_setting_data_field_callback' ) ) {

	/**
	 * This function will be used to create the field.
	 *
	 * @return void
	 */
	function ee_search_setting_data_field_callback(): void {
		$data = get_option( 'ee-search-setting-checkbox' );

		$value   = 'on';
		$checked = '';

		if ( $data ) {
			if ( 'on' === $data ) {
				$checked = 'checked';
			}
			$value = $data;
		}

		?>

		<label for="ee-search-setting-checkbox">

			<input type="checkbox"
				name="ee-search-setting-checkbox"
				id="ee-search-setting-checkbox"
				value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( $checked ); ?>/>
		</label>
		<?php
	}
}

if ( ! function_exists( 'ee_search_setting_submit' ) ) {

	/**
	 * This function will be used to remove the data from the database.
	 *
	 * @return void
	 */
	function ee_search_setting_submit(): void {

		if ( isset( $_SERVER['REQUEST_METHOD'] ) &&
			'POST' === $_SERVER['REQUEST_METHOD'] &&
			isset( $_POST['submit'] ) &&
			isset( $_POST['option_page'] ) &&
			'ee-search-setting-group' === $_POST['option_page'] ) {

			if ( ! isset( $_POST['_wpnonce'] ) ) {
				return;
			}

			// Sanitize nonce.
			$rt_person_meta_nonce = sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) );

			// Verify that the nonce is valid.
			if ( ! wp_verify_nonce( $rt_person_meta_nonce, 'ee-search-setting-group-options' ) ) {
				return;
			}

			if ( isset( $_POST['ee-search-setting-checkbox'] ) ) {

				$checkbox_data = sanitize_text_field( wp_unslash( $_POST['ee-search-setting-checkbox'] ) );

				if ( 'off' === $checkbox_data ) {

					$checkbox_data = 'on';
				}
			} else {

				$checkbox_data = 'off';
			}

			update_option( 'ee-search-setting-checkbox', $checkbox_data );

			$class   = 'notice notice-success is-dismissible';
			$message = __( 'Settings saved.', 'easy-engine' );

			printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
		}
	}
}
