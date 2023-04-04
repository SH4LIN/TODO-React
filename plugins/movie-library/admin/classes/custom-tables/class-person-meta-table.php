<?php
/**
 * This file is used to create the wp_personmeta table.
 *
 * @package MovieLib\admin\classes\custom_tables
 */

namespace MovieLib\admin\classes\custom_tables;

use MovieLib\includes\Singleton;

require_once ABSPATH . 'wp-admin/includes/upgrade.php';


/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\custom_tables\Person_Meta_Table' ) ) {

	/**
	 * This class is used to create the wp_personmeta table. and wrapper functions to perform CRUD operations.
	 */
	class Person_Meta_Table {

		use Singleton;

		/**
		 * Person_Meta_Table init method.
		 *
		 * @return void
		 */
		public function init(): void {
			$this->create_table();
		}

		/**
		 * This function is used to create the wp_personmeta table.
		 *
		 * @return void
		 */
		public function create_table(): void {
			global $wpdb;

			$charset_collate = $wpdb->get_charset_collate();

			$person_meta_table_name = $wpdb->prefix . 'personmeta';

			$person_meta_table_sql = sprintf(
				'CREATE TABLE IF NOT EXISTS %s (
				meta_id bigint(20) unsigned NOT NULL auto_increment,
				person_id bigint(20) unsigned NOT NULL default "0",
				meta_key varchar(255) default NULL,
				meta_value longtext,
				PRIMARY KEY  (meta_id),
				KEY person_id (person_id),
				KEY meta_key (meta_key)
			) %s;',
				$person_meta_table_name,
				$charset_collate
			);

			dbDelta( $person_meta_table_sql );
		}
	}
}
