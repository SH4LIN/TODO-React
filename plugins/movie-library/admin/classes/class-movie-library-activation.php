<?php
/**
 * This file is used to perform the activation functionality for the plugin.
 *
 * @package MovieLib\admin\classes
 */

namespace MovieLib\admin\classes;

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\admin\classes\roles_capabilities\Movie_Manager_Role_Capabilities;
use MovieLib\admin\classes\taxonomies\Movie_Genre;
use MovieLib\admin\classes\taxonomies\Movie_Label;
use MovieLib\admin\classes\taxonomies\Movie_Language;
use MovieLib\admin\classes\taxonomies\Movie_Production_Company;
use MovieLib\admin\classes\taxonomies\Movie_Tag;
use MovieLib\admin\classes\taxonomies\Person_Career;
use MovieLib\admin\classes\custom_tables\MLB_DB_Helper;
use MovieLib\includes\Singleton;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\Movie_Library_Activation' ) ) :

	/**
	 * This class is used to perform the activation functionality for the plugin.
	 */
	class Movie_Library_Activation {

		use Singleton;

		/**
		 * Movie_Library_Activation init method.
		 *
		 * @return void
		 */
		public function init(): void {
			register_activation_hook( MLB_PLUGIN_FILE, array( $this, 'activate' ) );
		}


		/**
		 * This function is used to perform the activation functionality for the plugin.
		 *
		 * @return void
		 */
		public function activate(): void {
			RT_Movie::instance()->register();
			RT_Person::instance()->register();
			Movie_Genre::instance()->register();
			Movie_Language::instance()->register();
			Movie_Label::instance()->register();
			Movie_Production_Company::instance()->register();
			Movie_Tag::instance()->register();
			Person_Career::instance()->register();
			flush_rewrite_rules();

			Movie_Manager_Role_Capabilities::instance()->add_movie_manager_role();

			// Creating custom tables.
			$this->create_tables();
		}

		/**
		 * This file is used to create the custom tables for the movie library plugin.
		 *
		 * @return void
		 */
		private function create_tables() {
			MLB_DB_Helper::instance()->create_tables();
		}
	}
endif;
