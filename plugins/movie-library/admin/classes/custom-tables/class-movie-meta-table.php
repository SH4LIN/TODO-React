<?php
/**
 * This file is used to create the wp_moviemeta table.
 *
 * @package MovieLib\admin\classes\custom_tables
 */

namespace MovieLib\admin\classes\custom_tables;

use MovieLib\includes\Singleton;


/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\custom_tables\Movie_Meta_Table' ) ) {

	/**
	 * This class is used to create the wp_moviemeta table. and wrapper functions to perform CRUD operations.
	 */
	class Movie_Meta_Table {

		use Singleton;

		/**
		 * Movie_Meta_Table init method.
		 *
		 * @return void
		 */
		public function init(): void {
			$this->create_table();
		}

		/**
		 * This function is used to create the wp_moviemeta table.
		 *
		 * @return void
		 */
		public function create_table(): void {
			global $wpdb;

			$charset_collate = $wpdb->get_charset_collate();

			$movie_meta_table_name = $wpdb->prefix . 'moviemeta';

			$movie_meta_table_sql = sprintf(
				'CREATE TABLE IF NOT EXISTS %s (
				meta_id bigint(20) unsigned NOT NULL auto_increment,
				movie_id bigint(20) unsigned NOT NULL default "0",
				meta_key varchar(255) default NULL,
				meta_value longtext,
				PRIMARY KEY  (meta_id),
				KEY movie_id (movie_id),
				KEY meta_key (meta_key)
			) %s;',
				$movie_meta_table_name,
				$charset_collate
			);
			dbDelta( $movie_meta_table_sql );
		}

	}
}

