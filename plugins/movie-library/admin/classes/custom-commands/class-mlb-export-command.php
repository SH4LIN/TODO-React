<?php
/**
 * This file is used to create custom command for exporting data.
 *
 * @package MovieLib\admin\classes\custom_commands
 */

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

/**
 * If WP_CLI is not defined then return.
 */
if ( ! defined( 'WP_CLI' ) ) {
	return;
}

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\custom_post_types\RT_Person;

use function WP_CLI\Utils\make_progress_bar;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\custom_commands\MLB_Export_Command' ) ) :

	/**
	 * This class is used to create custom command for exporting data.
	 * It contains the code to export rt-movie, rt-person post types in csv file.
	 */
	class MLB_Export_Command {

		/**
		 * Exports rt-movie, rt-person post types in csv file.
		 *
		 * ## OPTIONS
		 *
		 * [<post_type>]
		 * : Post type to export.
		 *
		 * ## EXAMPLES
		 *     wp mlb export rt-movie
		 *     wp mlb export rt-person
		 *
		 * @param array $args       Positional arguments.
		 *                          $args[0] is post type.
		 * @param array $assoc_args Associative arguments.
		 */
		public function __invoke( $args, $assoc_args ) {
			if ( ! empty( $args ) ) {
				$post_type = $args[0];
			} else {
				$post_type = '';
			}

			if ( RT_Movie::SLUG === $post_type ) {
				$movie_export = $this->export_custom_posts( $post_type );
				if ( ! $movie_export ) {
					WP_CLI::error( 'Error while exporting rt-movie post type.' );
				} else {
					WP_CLI::success( 'rt-movie post type exported successfully.' );
				}
			} elseif ( RT_Person::SLUG === $post_type ) {
				$person_export = $this->export_custom_posts( $post_type );
				if ( ! $person_export ) {
					WP_CLI::error( 'Error while exporting rt-person post type.' );
				} else {
					WP_CLI::success( 'rt-person post type exported successfully.' );
				}
			} else {
				$movie_export = $this->export_custom_posts( RT_Movie::SLUG );

				if ( ! $movie_export ) {
					WP_CLI::error( 'Error while exporting rt-movie post type.' );
				} else {
					WP_CLI::success( 'rt-movie post type exported successfully.' );
				}

				$person_export = $this->export_custom_posts( RT_Person::SLUG );

				if ( ! $person_export ) {
					WP_CLI::error( 'Error while exporting rt-person post type.' );
				} else {
					WP_CLI::success( 'rt-person post type exported successfully.' );
				}
			}
		}

		/**
		 * Exports rt-movie and rt-person post type in csv file.
		 *
		 * @param string $type Post type to export.
		 * @return bool
		 */
		private function export_custom_posts( $type ) {
			// Making Optimised WP_Query to fetch the post.
			$custom_posts = get_posts(
				array(
					'post_type'      => $type,
					'posts_per_page' => -1,
				)
			);

			$custom_posts = array_map(
				function( $custom_post ) {
					$custom_post->post_meta = wp_json_encode( get_movie_meta( $custom_post->ID ) );
					return $custom_post;
				},
				$custom_posts
			);

			$taxonomies = get_object_taxonomies( $type );

			$custom_posts = array_map(
				function( $custom_post ) use ( $taxonomies ) {
					foreach ( $taxonomies as $taxonomy ) {
						$custom_post->$taxonomy = wp_json_encode( get_the_terms( $custom_post->ID, $taxonomy ) );
					}
					return $custom_post;
				},
				$custom_posts
			);

			// Get the properties of first object.
			$csv_header = array_keys( get_object_vars( $custom_posts[0] ) );

			$creds = request_filesystem_credentials( admin_url(), '', false, false );

			if ( false === $creds ) {
				return false;
			}

			if ( ! WP_Filesystem( $creds ) ) {
				return false;
			}
			global $wp_filesystem;

			$csv    = '';
			$count  = count( $custom_posts );
			$count += 2;

			// translators: %s is the post type.
			$progress = make_progress_bar( sprintf( __( 'Exporting %s', 'movie-library' ), $type ), $count );

			$progress->tick();
			$csv .= $this->get_data_in_csv( $csv_header );
			foreach ( $custom_posts as $custom_post ) {
				$csv .= $this->get_data_in_csv( get_object_vars( $custom_post ) );
				$progress->tick();
			}

			$progress->tick();
			$wp_filesystem->put_contents( "$type.csv", $csv, FS_CHMOD_FILE );
			$progress->finish();

			return true;
		}

		/**
		 * This function is used to convert data into csv format.
		 *
		 * @param array $data_array to be converted into CSV format.
		 *
		 * @return string
		 */
		private function get_data_in_csv( $data_array ) {
			$fd   = ',';
			$quot = '"';
			$str  = '';

			foreach ( $data_array as $data ) {
				$data = str_replace(
					array( $quot, "\n" ),
					array( $quot . $quot, '' ),
					$data
				);
				if ( strchr( $data, $fd ) !== false || strchr( $data, $quot ) !== false ) {
					$str .= $quot . $data . $quot . $fd;
				} else {
					$str .= $data . $fd;
				}
			}

			return substr( $str, 0, -1 ) . "\n";
		}
	}
endif;
WP_CLI::add_command( 'mlb export', 'MLB_Export_Command' );
