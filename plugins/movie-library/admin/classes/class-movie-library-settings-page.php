<?php
/**
 * This file is used to create the submenu which will give you checkbox.
 * Checking it will remove all the data from the database. When you uninstall the plugin.
 *
 * @package Movie Library
 */

namespace MovieLib\admin\classes;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\Movie_Library_Settings_Page' ) ) {
	/**
	 * @class   Movie_Library_Remove_Plugin_Data_Settings_Page
	 *          This class is used to create the submenu which will give you checkbox.
	 *          Checking it will remove all the data from the database. When you uninstall the plugin.
	 * @version 1.0.0
	 */
	class Movie_Library_Settings_Page {

		/**
		 * @var string $parent_slug
		 *      This variable will be used to store the parent slug.
		 */
		private string $parent_slug;

		/**
		 * @var string $page_title
		 *      This variable will be used to store the page title.
		 */
		private string $page_title;

		/**
		 * @var string $menu_title
		 *      This variable will be used to store the menu title.
		 */
		private string $menu_title;

		/**
		 * @var string $capability
		 *      This variable will be used to store the capability.
		 */
		private string $capability;

		/**
		 * @var string $menu_slug
		 *      This variable will be used to store the menu slug.
		 */
		private string $menu_slug;

		/**
		 * @var array $movie_library_settings_page_callback
		 *      This variable will be used to store the callback function.
		 */
		private array $movie_library_settings_page_callback;

		/**
		 * @var string $option_group
		 *      This variable will be used to store the option group.
		 */
		private string $option_group;

		/**
		 * @var string $save_button_text
		 *      This variable will be used to store the save button text.
		 */
		private string $save_button_text;

		/**
		 * @var string $checkbox_option_name
		 *      This variable will be used to store the checkbox option name.
		 */
		private string $checkbox_option_name;

		/**
		 * @var array $form_submission_callback
		 *      This variable will be used to store the form submission callback.
		 */
		private array $form_submission_callback;

		/**
		 * @var array $admin_init_callback
		 *      This variable will be used to store the admin init callback.
		 */
		private array $admin_init_callback;

		/**
		 * @var string $remove_plugin_data_section_id
		 *      This variable will be used to store the remove plugin data section id.
		 */
		private string $remove_plugin_data_section_id;

		/**
		 * @var string $remove_plugin_data_section_title
		 *      This variable will be used to store the remove plugin data section title.
		 */
		private string $remove_plugin_data_section_title;

		/**
		 * @var array $remove_plugin_data_section_callback
		 *      This variable will be used to store the remove plugin data section callback.
		 */
		private array $remove_plugin_data_section_callback;

		/**
		 * @var string $field_description
		 *      This variable will be used to store the field description.
		 */
		private string $remove_plugin_data_section_description;

		/**
		 * @var array $remove_plugin_data_field_callback
		 *      This variable will be used to store the remove plugin data field callback.
		 */
		private array $remove_plugin_data_field_callback;

		/**
		 * @var string $remove_plugin_data_field_title
		 *      This variable will be used to store the remove plugin data field title.
		 */
		private string $remove_plugin_data_field_title;

		public function __construct() {
			$this->parent_slug                            = 'options-general.php';
			$this->page_title                             = __( 'Movie Library Settings', 'movie-library' );
			$this->menu_title                             = __( 'Movie Library Settings', 'movie-library' );
			$this->capability                             = 'manage_options';
			$this->menu_slug                              = 'movie-library-settings';
			$this->movie_library_settings_page_callback   = array( $this, 'movie_library_settings_page' );
			$this->option_group                           = 'movie-library-settings-group';
			$this->save_button_text                       = __( 'Save Changes', 'movie-library' );
			$this->checkbox_option_name                   = 'remove_plugin_data_check_box';
			$this->form_submission_callback               = array( $this, 'remove_plugin_data_settings_submit' );
			$this->admin_init_callback                    = array( $this, 'movie_library_settings' );
			$this->remove_plugin_data_section_id          = 'remove_plugin_data_section';
			$this->remove_plugin_data_section_title       = 'Remove Data';
			$this->remove_plugin_data_section_callback    = array( $this, 'remove_plugin_data_section_callback' );
			$this->remove_plugin_data_section_description = 'Check the checkbox to remove all the data from the database when you uninstall the plugin.';
			$this->remove_plugin_data_field_callback      = array( $this, 'remove_plugin_data_field_callback' );
			$this->remove_plugin_data_field_title         = __( 'Remove Plugin Data', 'movie-library' );
		}

		/**
		 * @function add_remove_plugin_data_sub_menu
		 *           This function will be used to create the submenu.
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
			if ( $hook_name !== false ) {
				add_action( 'load-' . $hook_name, $this->form_submission_callback );
			}
			add_action( 'admin_init', $this->admin_init_callback );
		}

		/**
		 * @function remove_plugin_data_settings_submit
		 *           This function will be used to remove the data from the database.
		 * @return void
		 */
		public function remove_plugin_data_settings_submit(): void {
			if (
				'POST' === $_SERVER[ 'REQUEST_METHOD' ] &&
				isset( $_POST[ 'submit' ] ) &&
				isset( $_POST[ 'option_page' ] ) &&
				$this->option_group === $_POST[ 'option_page' ] ) {
				if ( isset( $_POST[ $this->checkbox_option_name ] ) ) {
					$checkbox_data = sanitize_text_field( $_POST[ $this->checkbox_option_name ] );
					if ( $checkbox_data === 'off' ) {
						$checkbox_data      = 'on';
						$is_setting_changed = true;
					}
				} else {
					$checkbox_data      = 'off';
					$is_setting_changed = true;
				}
				update_option( $this->checkbox_option_name, $checkbox_data );

				$class   = 'notice notice-success is-dismissible';
				$message = __( 'Settings saved.', 'sample-text-domain' );

				printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
			}
		}

		/**
		 * @function remove_plugin_data_settings_page
		 *           This function will be used to create the settings page. Which will have checkbox to remove data.
		 *           When you uninstall the plugin.
		 */
		public function movie_library_settings_page(): void {
			// check user capabilities
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
		 * @function remove_plugin_data_settings
		 *           This function will be used to create the settings.
		 * @return void
		 */
		public function movie_library_settings(): void {
			register_setting( $this->option_group, $this->checkbox_option_name );
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
		}

		/**
		 * @function remove_plugin_data_settings_section_callback
		 *           This function will be used to create the section.
		 * @return void
		 */
		public function remove_plugin_data_section_callback(): void {
			?>
			<p><?php esc_html_e( $this->remove_plugin_data_section_description, 'movie-library' ); ?></p>
			<?php
		}

		/**
		 * @function remove_plugin_data_settings_field_callback
		 *           This function will be used to create the field.
		 * @return void
		 */
		public function remove_plugin_data_field_callback(): void {
			$data = get_option( $this->checkbox_option_name );

			$value   = 'off';
			$checked = '';

			if ( $data ) {
				if ( $data === 'on' ) {
					$checked = 'checked';
				}
				$value = $data;
			}

			?>
			<label for="<?php echo esc_attr( $this->checkbox_option_name ); ?>">
				<input type="<?php echo esc_attr( 'checkbox' ); ?>" name="<?php echo esc_attr( $this->checkbox_option_name ); ?>" id="<?php echo esc_attr( $this->checkbox_option_name ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( $checked ); ?>/>
			</label>
			<div class="notice notice-warning is-dismissible">
				<p><?php esc_html_e( 'Below setting will delete the plugin data when you uninstall the plugin!' ); ?></p>
			</div>
			<?php
		}
	}
}

