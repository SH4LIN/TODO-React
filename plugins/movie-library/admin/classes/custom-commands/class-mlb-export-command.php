<?php
/**
 * This file is used to create custom command for exporting data.
 *
 * @package MovieLib\admin\classes\custom_commands
 */


/**
 * This is a security measure to prevent direct access to the file.
 */

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\admin\classes\taxonomies\Movie_Genre;
use MovieLib\admin\classes\taxonomies\Movie_Label;
use MovieLib\admin\classes\taxonomies\Movie_Language;
use MovieLib\admin\classes\taxonomies\Movie_Production_Company;
use MovieLib\admin\classes\taxonomies\Movie_Tag;
use MovieLib\admin\classes\taxonomies\Person_Career;

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
			$post_type = $args[0];

			if ( 'rt-movie' === $post_type ) {
				$movie_export = $this->export_rt_movie();
				if ( ! $movie_export ) {
					WP_CLI::error( 'Error while exporting rt-movie post type.' );
				} else {
					WP_CLI::success( 'rt-movie post type exported successfully.' );
				}
			} elseif ( 'rt-person' === $post_type ) {
				$person_export = $this->export_rt_person();
				if ( ! $person_export ) {
					WP_CLI::error( 'Error while exporting rt-person post type.' );
				} else {
					WP_CLI::success( 'rt-person post type exported successfully.' );
				}
			} else {
				$movie_export  = $this->export_rt_movie();
				$person_export = $this->export_rt_person();

				if ( ! $movie_export ) {
					WP_CLI::error( 'Error while exporting rt-movie post type.' );
				} else {
					WP_CLI::success( 'rt-movie post type exported successfully.' );
				}

				if ( ! $person_export ) {
					WP_CLI::error( 'Error while exporting rt-person post type.' );
				} else {
					WP_CLI::success( 'rt-person post type exported successfully.' );
				}
			}
		}

		/**
		 * Exports rt-movie post type in csv file.
		 *
		 * @return bool
		 */
		private function export_rt_movie() {
			$movie_posts = get_posts(
				array(
					'post_type'      => RT_Movie::SLUG,
					'posts_per_page' => -1,
				)
			);

			$movie_posts = array_map(
				function( $movie_post ) {
					$movie_post->post_meta = wp_json_encode( get_movie_meta( $movie_post->ID ) );
					return $movie_post;
				},
				$movie_posts
			);

			$taxonomies = get_object_taxonomies( RT_Movie::SLUG );

			$movie_posts = array_map(
				function( $movie_post ) use ( $taxonomies ) {
					foreach ( $taxonomies as $taxonomy ) {
						$movie_post->$taxonomy = implode( ',', wp_list_pluck( get_the_terms( $movie_post->ID, $taxonomy ), 'name' ) );
					}
					return $movie_post;
				},
				$movie_posts
			);

			// Get the properties of first object.

			$csv_header = array_keys( get_object_vars( $movie_posts[0] ) );

			// Write to csv file.
			$fp = fopen( 'rt-movie.csv', 'w' );
			fputcsv( $fp, $csv_header );
			foreach ( $movie_posts as $movie_post ) {
				if ( false === fputcsv( $fp, get_object_vars( $movie_post ) ) ) {
					unlink( 'rt-movie.csv' );
					return false;
				}
			}
			fclose( $fp );

			return true;
		}

		/**
		 * Exports rt-person post type in csv file.
		 *
		 * @return bool
		 */
		private function export_rt_person() {
			$person_posts = get_posts(
				array(
					'post_type'      => RT_Person::SLUG,
					'posts_per_page' => -1,
				)
			);

			$person_posts = array_map(
				function( $person_post ) {
					$person_post->post_meta = wp_json_encode( get_person_meta( $person_post->ID ) );
					return $person_post;
				},
				$person_posts
			);

			$taxonomies = get_object_taxonomies( RT_Person::SLUG );

			$person_posts = array_map(
				function( $person_post ) use ( $taxonomies ) {
					foreach ( $taxonomies as $taxonomy ) {
						$person_post->$taxonomy = implode( ',', wp_list_pluck( get_the_terms( $person_post->ID, $taxonomy ), 'name' ) );
					}
					return $person_post;
				},
				$person_posts
			);

			$csv_header = array_keys( get_object_vars( $person_posts[0] ) );

			// Write to csv file.
			$fp         = fopen( 'rt-person.csv', 'w' );
			fputcsv( $fp, $csv_header );
			foreach ( $person_posts as $person_post ) {
				if ( false === fputcsv( $fp, get_object_vars( $person_post ) ) ) {
					unlink( 'rt-person.csv' );
					return false;
				}
			}
			fclose( $fp );
			return true;
		}
	}
endif;
WP_CLI::add_command( 'mlb export', 'MLB_Export_Command' );
