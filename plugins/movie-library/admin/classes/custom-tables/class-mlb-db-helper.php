<?php
/**
 * This file contains the class to create tables and hooks to manipulate meta queries.
 *
 * @package MovieLib\admin\classes\custom_tables
 */

namespace MovieLib\admin\classes\custom_tables;

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\includes\Singleton;

require_once ABSPATH . 'wp-admin/includes/upgrade.php';

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\custom_tables\MLB_DB_Helper' ) ) :

	/**
	 * This class is used to create tables and hooks to manipulate meta queries.
	 */
	class MLB_DB_Helper {

		use Singleton;

		/**
		 * DB_Helper init method.
		 *
		 * @return void
		 */
		public function init(): void {}

		/**
		 * This function is used to create the wp_personmeta and wp_moviemeta table.
		 *
		 * @return void
		 */
		public function create_tables() {
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

		/**
		 * This function is used to add hooks to manipulate meta queries.
		 *
		 * @return void
		 */
		public function add_hooks(): void {
			add_action( 'plugins_loaded', array( $this, 'register_custom_tables' ) );
			add_action( 'get_meta_sql', array( $this, 'change_meta_query_array' ) );
			add_action( 'posts_join', array( $this, 'change_meta_query' ) );
			add_action( 'posts_orderby', array( $this, 'change_meta_query' ) );
		}

		/**
		 * This function is used to register the custom tables. So it can extend the functionality of METADATA API.
		 *
		 * @return void
		 */
		public function register_custom_tables(): void {
			global $wpdb;

			$wpdb->moviemeta  = $wpdb->prefix . 'moviemeta';
			$wpdb->personmeta = $wpdb->prefix . 'personmeta';

		}

		/**
		 * Method to change the meta query
		 *
		 * It changes the meta query when some particular post type is being queried.
		 *
		 * @param string $sql SQL query.
		 *
		 * @return string
		 */
		public function change_meta_query( $sql ) {

			if ( 'rt-person' === get_post_type() ) {
				$sql = str_replace( 'wp_postmeta.post_id', 'wp_moviemeta.movie_id', $sql );
				$sql = str_replace( 'wp_postmeta', 'wp_moviemeta', $sql );
				$sql = str_replace( 'wp_postmeta.meta_value', 'wp_moviemeta.meta_value', $sql );
			} elseif ( 'rt-movie' === get_post_type() ) {
				$sql = str_replace( 'wp_postmeta.post_id', 'wp_personmeta.person_id', $sql );
				$sql = str_replace( 'wp_postmeta', 'wp_personmeta', $sql );
				$sql = str_replace( 'wp_postmeta.meta_value', 'wp_personmeta.meta_value', $sql );
			}

			if ( is_admin() ) {
				$sql = str_replace( 'wp_postmeta.post_id', 'wp_moviemeta.movie_id', $sql );
				$sql = str_replace( 'wp_postmeta', 'wp_moviemeta', $sql );
				$sql = str_replace( 'wp_postmeta.meta_value', 'wp_moviemeta.meta_value', $sql );
			}

			return $sql;
		}

		/**
		 * Wrapper function for the change_meta_query() method
		 *
		 * Get_meta_sql hook passes the array of SQL query.
		 * So this method is used to change the array by calling the change_meta_query() method.
		 *
		 * @param array $sql SQL query.
		 *
		 * @return array
		 */
		public function change_meta_query_array( $sql ) {
			$sql['join']  = $this->change_meta_query( $sql['join'] );
			$sql['where'] = $this->change_meta_query( $sql['where'] );

			return $sql;
		}
	}
endif;
