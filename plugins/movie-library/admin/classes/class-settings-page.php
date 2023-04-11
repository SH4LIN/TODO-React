<?php
/**
 * This file is used to create the submenu which will give you checkbox.
 * Checking it will remove all the data from the database. When you uninstall the plugin.
 *
 * @package Movie Library
 */

namespace MovieLib\admin\classes;

use MovieLib\includes\Singleton;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\Settings_Page' ) ) {
	/**
	 * This class is used to create the submenu which will give you checkbox.
	 * Checking it will remove all the data from the database. When you uninstall the plugin.
	 *
	 * @version 1.0.0
	 */
	class Settings_Page {

		use Singleton;

		/**
		 * Variable parent slug.
		 *
		 * @var string $parent_slug This variable will be used to store the parent slug.
		 */
		private string $parent_slug;

		/**
		 * Variable page title.
		 *
		 * @var string $page_title
		 */
		private string $page_title;

		/**
		 * Variable manu title.
		 *
		 * @var string $menu_title This variable will be used to store the menu title.
		 */
		private string $menu_title;

		/**
		 * Variable capability.
		 *
		 * @var string $capability This variable will be used to store the capability.
		 */
		private string $capability;

		/**
		 * Variable menu slug.
		 *
		 * @var string $menu_slugThis variable will be used to store the menu slug.
		 */
		private string $menu_slug;

		/**
		 * Variable movie library settings page callback.
		 *
		 * @var array $movie_library_settings_page_callbackThis variable will be used to store the callback function.
		 */
		private array $movie_library_settings_page_callback;

		/**
		 * Variable option group.
		 *
		 * @var string $option_group his variable will be used to store the option group.
		 */
		private string $option_group;

		/**
		 * Variable save button text.
		 *
		 * @var string $save_button_text This variable will be used to store the save button text.
		 */
		private string $save_button_text;

		/**
		 * Variable checkbox option name.
		 *
		 * @var string $checkbox_option_name This variable will be used to store the checkbox option name.
		 */
		private string $checkbox_option_name;

		/**
		 * Variable API Base URL input-box option name.
		 *
		 * @var string $api_base_url_option_name This variable will be used to store the API Base URL option name.
		 */
		private string $api_base_url_option_name;

		/**
		 * Variable API Key input-box option name.
		 *
		 * @var string $api_key_option_name This variable will be used to store the API Key option name.
		 */
		private string $api_key_option_name;

		/**
		 * Variable form submission callback.
		 *
		 * @var array $form_submission_callback This variable will be used to store the form submission callback.
		 */
		private array $form_submission_callback;

		/**
		 * Variable admin init callback.
		 *
		 * @var array $admin_init_callback This variable will be used to store the admin init callback.
		 */
		private array $admin_init_callback;

		/**
		 * Variable remove plugin data section id.
		 *
		 * @var string $remove_plugin_data_section_id This variable will be used to store the remove plugin data section id.
		 */
		private string $remove_plugin_data_section_id;

		/**
		 * Variable API data section id.
		 *
		 * @var string $api_data_section_id This variable will be used to store the API data section id.
		 */
		private string $api_data_section_id;

		/**
		 * Variable remove plugin data section title.
		 *
		 * @var string $remove_plugin_data_section_title This variable will be used to store the remove plugin data section title.
		 */
		private string $remove_plugin_data_section_title;

		/**
		 * Variable API data section title.
		 *
		 * @var string $api_section_title This variable will be used to store the API data section title.
		 */
		private string $api_section_title;

		/**
		 * Variable remove plugin data section callback.
		 *
		 * @var array $remove_plugin_data_section_callback This variable will be used to store the remove plugin data section callback.
		 */
		private array $remove_plugin_data_section_callback;

		/**
		 * Variable API data section callback.
		 *
		 * @var array $api_data_section_callback This variable will be used to store the API data section callback.
		 */
		private array $api_data_section_callback;

		/**
		 * Variable remove plugin data field callback.
		 *
		 * @var array $remove_plugin_data_field_callback This variable will be used to store the remove plugin data field callback.
		 */
		private array $remove_plugin_data_field_callback;

		/**
		 * Variable API Base URL data field callback.
		 *
		 * @var array $api_base_url_field_callback This variable will be used to store the API Base URL data field callback.
		 */
		private array $api_base_url_field_callback;

		/**
		 * Variable API Key data field callback.
		 *
		 * @var array $api_key_field_callback This variable will be used to store the API Key data field callback.
		 */
		private array $api_key_field_callback;

		/**
		 * Variable remove plugin data field title.
		 *
		 * @var string $remove_plugin_data_field_title This variable will be used to store the remove plugin data field title.
		 */
		private string $remove_plugin_data_field_title;

		/**
		 * Variable API Base URL field title.
		 *
		 * @var string $api_base_url_field_title This variable will be used to store the API Base URL field title.
		 */
		private string $api_base_url_field_title;

		/**
		 * Variable API Key field title.
		 *
		 * @var string $api_key_field_title This variable will be used to store the API Key field title.
		 */
		private string $api_key_field_title;

		/**
		 * Variable API Base URL Error.
		 *
		 * @var string $base_url_error This variable will be used to display the API Base URL Error.
		 */
		private string $base_url_error;

		/**
		 * Variable API Key Error.
		 *
		 * @var string $key_error This variable will be used to display the API Key Error.
		 */
		private string $key_error;

		/**
		 * Constructor of the class.
		 * It is used to initialize the variables that are used to create the sub menu page.
		 *
		 * @return void
		 */
		protected function init(): void {
			$this->parent_slug                          = 'options-general.php';
			$this->page_title                           = __( 'Movie Library Settings', 'movie-library' );
			$this->menu_title                           = __( 'Movie Library Settings', 'movie-library' );
			$this->capability                           = 'manage_options';
			$this->menu_slug                            = 'movie-library-settings';
			$this->movie_library_settings_page_callback = array( $this, 'movie_library_settings_page' );
			$this->option_group                         = 'movie-library-settings-group';
			$this->save_button_text                     = __( 'Save Changes', 'movie-library' );
			$this->checkbox_option_name                 = 'remove_plugin_data_check_box';
			$this->form_submission_callback             = array( $this, 'remove_plugin_data_settings_submit' );
			$this->admin_init_callback                  = array( $this, 'movie_library_settings' );

			$this->remove_plugin_data_section_id       = 'remove_plugin_data_section';
			$this->remove_plugin_data_section_title    = __( 'Remove Data', 'movie-library' );
			$this->remove_plugin_data_section_callback = array( $this, 'remove_plugin_data_section_callback' );
			$this->remove_plugin_data_field_callback   = array( $this, 'remove_plugin_data_field_callback' );
			$this->remove_plugin_data_field_title      = __( 'Remove Plugin Data', 'movie-library' );

			$this->api_data_section_id       = 'api_section';
			$this->api_section_title         = __( 'API Settings', 'movie-library' );
			$this->api_data_section_callback = array( $this, 'api_data_section_callback' );
			$this->api_base_url_field_title  = __( 'API Base URL', 'movie-library' );
			$this->api_key_field_title       = __( 'API Key', 'movie-library' );

			$this->api_base_url_option_name = 'api_base_url_input_box';
			$this->api_key_option_name      = 'api_key_input_box';

			$this->api_base_url_field_callback = array( $this, 'api_base_url_field_callback' );
			$this->api_key_field_callback      = array( $this, 'api_key_field_callback' );
		}

		/**
		 * This function will be used to create the submenu.
		 *
		 * @return void
		 */
		public function add_movie_library_sub_menu(): void {

			$hook_name = add_submenu_page(
				$this->parent_slug,
				$this->page_title,
				$this->menu_title,
				$this->capability,
				$this->menu_slug,
				$this->movie_library_settings_page_callback
			);

			if ( false !== $hook_name ) {

				add_action( 'load-' . $hook_name, $this->form_submission_callback );

			}

			add_action( 'admin_init', $this->admin_init_callback );

		}

		/**
		 * This function will be used to create the settings page. Which will have checkbox to remove data.
		 * When you uninstall the plugin.
		 */
		public function movie_library_settings_page(): void {
			// Check user capabilities.
			if ( ! current_user_can( $this->capability ) ) {
				return;
			}
			?>

			<div class="wrap">
				<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
				<form action="<?php menu_page_url( $this->menu_slug ); ?>" method="POST">
					<?php
					settings_fields( $this->option_group );
					do_settings_sections( $this->menu_slug );
					submit_button( $this->save_button_text );
					?>
				</form>
			</div>
			<?php
		}

		/**
		 * This function will be used to create the settings.
		 *
		 * @return void
		 */
		public function movie_library_settings(): void {
			register_setting( $this->option_group, $this->checkbox_option_name );
			register_setting( $this->option_group, $this->api_base_url_option_name );
			register_setting( $this->option_group, $this->api_key_option_name );
			add_settings_section(
				$this->remove_plugin_data_section_id,
				$this->remove_plugin_data_section_title,
				$this->remove_plugin_data_section_callback,
				$this->menu_slug
			);
			add_settings_field(
				$this->checkbox_option_name,
				$this->remove_plugin_data_field_title,
				$this->remove_plugin_data_field_callback,
				$this->menu_slug,
				$this->remove_plugin_data_section_id,
			);

			add_settings_section(
				$this->api_data_section_id,
				$this->api_section_title,
				$this->api_data_section_callback,
				$this->menu_slug
			);
			add_settings_field(
				$this->api_base_url_option_name,
				$this->api_base_url_field_title,
				$this->api_base_url_field_callback,
				$this->menu_slug,
				$this->api_data_section_id,
			);
			add_settings_field(
				$this->api_key_option_name,
				$this->api_key_field_title,
				$this->api_key_field_callback,
				$this->menu_slug,
				$this->api_data_section_id,
			);
		}

		/**
		 * This function is callback function for the API Base URL field in the settings page.
		 *
		 * @return void
		 */
		public function api_base_url_field_callback() {
			$data = get_option( $this->api_base_url_option_name );

			?>

			<label for="<?php echo esc_attr( $this->api_base_url_option_name ); ?>">

				<input type="<?php echo esc_attr( 'url' ); ?>"
					name="<?php echo esc_attr( $this->api_base_url_option_name ); ?>"
					id="<?php echo esc_attr( $this->api_base_url_option_name ); ?>"
					value="<?php echo esc_attr( $data ); ?>" />

			</label>

			<div class="base_url_error">

				<?php if ( ! empty( $this->base_url_error ) ) : ?>
					<p class="error"><?php echo esc_html( $this->base_url_error ); ?></p>
				<?php endif; ?>

			</div>

			<?php
		}

		/**
		 * This function is callback function for the API Key field in the settings page.
		 *
		 * @return void
		 */
		public function api_key_field_callback() {
			$data = get_option( $this->api_key_option_name );

			?>

			<label for="<?php echo esc_attr( $this->api_key_option_name ); ?>">

				<input type="<?php echo esc_attr( 'text' ); ?>"
					name="<?php echo esc_attr( $this->api_key_option_name ); ?>"
					id="<?php echo esc_attr( $this->api_key_option_name ); ?>"
					value="<?php echo esc_attr( $data ); ?>" />

			</label>

			<div class="key_error">

				<?php if ( ! empty( $this->key_error ) ) : ?>
					<p class="error"><?php echo esc_html( $this->key_error ); ?></p>
				<?php endif; ?>

			</div>

			<?php
		}

		/**
		 * This function will be used to create the section.
		 *
		 * @return void
		 */
		public function remove_plugin_data_section_callback(): void {
			?>
			<p><?php esc_html_e( 'Check the checkbox to remove all the data from the database when you uninstall the plugin.', 'movie-library' ); ?></p>
			<?php
		}

		/**
		 * This function will be used to create the section.
		 *
		 * @return void
		 */
		public function api_data_section_callback(): void {}

		/**
		 * This function will be used to create the field.
		 *
		 * @return void
		 */
		public function remove_plugin_data_field_callback(): void {
			$data = get_option( $this->checkbox_option_name );

			$value   = 'off';
			$checked = '';

			if ( $data ) {
				if ( 'on' === $data ) {
					$checked = 'checked';
				}
				$value = $data;
			}

			?>

			<label for="<?php echo esc_attr( $this->checkbox_option_name ); ?>">

				<input type="<?php echo esc_attr( 'checkbox' ); ?>"
					name="<?php echo esc_attr( $this->checkbox_option_name ); ?>"
					id="<?php echo esc_attr( $this->checkbox_option_name ); ?>"
					value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( $checked ); ?>/>

			</label>

			<div class="notice notice-warning is-dismissible">

				<p>
					<?php esc_html_e( 'Below setting will delete the plugin data when you uninstall the plugin!', 'movie-library' ); ?>
				</p>

			</div>

			<?php

		}

		/**
		 * This function will be used to remove the data from the database.
		 *
		 * @return void
		 */
		public function remove_plugin_data_settings_submit(): void {

			if ( isset( $_SERVER['REQUEST_METHOD'] ) &&
					'POST' === $_SERVER['REQUEST_METHOD'] &&
					isset( $_POST['submit'] ) &&
					isset( $_POST['option_page'] ) &&
					$this->option_group === $_POST['option_page'] ) {

				if ( ! isset( $_POST['_wpnonce'] ) ) {
					return;
				}

				// Sanitize nonce.
				$rt_person_meta_nonce = sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) );

				// Verify that the nonce is valid.
				if ( ! wp_verify_nonce( $rt_person_meta_nonce, "$this->option_group-options" ) ) {
					return;
				}

				if ( isset( $_POST[ $this->checkbox_option_name ] ) ) {

					$checkbox_data = sanitize_text_field( wp_unslash( $_POST[ $this->checkbox_option_name ] ) );

					if ( 'off' === $checkbox_data ) {

						$checkbox_data = 'on';

					}
				} else {

					$checkbox_data = 'off';

				}

				update_option( $this->checkbox_option_name, $checkbox_data );

				$base_url_data = '';
				if ( isset( $_POST[ $this->api_base_url_option_name ] ) ) {
					$base_url_data = esc_url_raw( wp_unslash( $_POST[ $this->api_base_url_option_name ] ) );
				}

				if ( ! empty( $base_url_data ) ) {
					$base_url_data = wp_http_validate_url( $base_url_data );

					if ( false === $base_url_data ) {
						$this->base_url_error = __( 'Please enter a valid URL.', 'movie-library' );
						return;
					} else {
						$this->base_url_error = '';
					}
				}
				update_option( $this->api_base_url_option_name, $base_url_data );

				$key_data = '';
				if ( isset( $_POST[ $this->api_key_option_name ] ) ) {
					$key_data = sanitize_text_field( wp_unslash( $_POST[ $this->api_key_option_name ] ) );
				}

				if ( ! empty( $base_url_data ) ) {
					if ( empty( $key_data ) ) {
						$this->key_error = __( 'Please Provide API Key', 'movie-library' );
						return;
					} else {
						$api_url  = $base_url_data . $key_data;
						$response = wp_remote_get( $api_url );
						if ( is_wp_error( $response ) ) {
							$this->key_error = __( 'Please Provide Valid API Key', 'movie-library' );
							return;
						} else {
							$this->key_error = '';
							update_option( $this->api_key_option_name, $key_data );
						}
					}
				}

				$class   = 'notice notice-success is-dismissible';
				$message = __( 'Settings saved.', 'movie-library' );

				printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );

			}

		}

	}
}

