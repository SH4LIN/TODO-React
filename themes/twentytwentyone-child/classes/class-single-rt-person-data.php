<?php
/**
 * This file contains the class which provides the functionality of fetching single rt-person data.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

require_once get_stylesheet_directory() . '/classes/trait-singleton.php';
use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\meta_boxes\RT_Media_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Person_Meta_Box;
use MovieLib\admin\classes\taxonomies\Movie_Label;
use MovieLib\admin\classes\taxonomies\Movie_Person;
use MovieLib\admin\classes\taxonomies\Person_Career;



if ( ! class_exists( 'Single_RT_Person_Data' ) ) :

	/**
	 * This class is used to fetch the single rt person data.
	 */
	class Single_RT_Person_Data {
		use Singleton;

		/**
		 * Single_RT_Person_Data init function to initialize the class.
		 *
		 * @return void
		 */
		protected function init(): void {}

		/**
		 * This function is used to fetch the hero data for the single rt-person post.
		 *
		 * @param int $current_id The current post id.
		 * @return array The hero data for the single rt-person post.
		 */
		public function get_hero_data( $current_id ): array {
			$hero_data = array();
			$hero_data = wp_parse_args(
				$hero_data,
				array(
					'id'                    => '',
					'name'                  => '',
					'full_name'             => '',
					'birth_place'           => '',
					'occupation'            => '',
					'birth_date_age'        => '',
					'start_year_present'    => '',
					'debut_movie_name_year' => '',
					'upcoming_movies'       => '',
					'social_urls'           => '',
				)
			);

			$current_title = get_the_title( $current_id );

			$hero_data['id']   = $current_id;
			$hero_data['name'] = $current_title;

			$full_name = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_BASIC_FULL_NAME_SLUG, true );
			if ( ! empty( $full_name ) ) {
				$hero_data['full_name'] = $full_name;
			}

			$birth_place = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_PLACE_SLUG, true );
			if ( ! empty( $full_name ) ) {
				$hero_data['$birth_place'] = $birth_place;
			}

			$career     = get_the_terms( $current_id, Person_Career::SLUG );
			$occupation = '';
			if ( ! empty( $career ) ) {
				if ( is_array( $career ) ) {

					$careers = array();
					foreach ( $career as $value ) {
						$careers[] = $value->name;
					}
					$occupation = implode( ', ', $careers );

				} else {
					$occupation = $career->title;
				}
			}

			$hero_data['occupation'] = $occupation;

			$birth_date_str = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_DATE_SLUG, true );
			if ( ! empty( $birth_date_str ) ) {
				$birth_date_format = DateTime::createFromFormat( 'Y-m-d', $birth_date_str );
				$today             = new DateTime(); // The current date and time.
				$age               = '';
				try {
					$diff = $today->diff( $birth_date_format ); // The difference between the two dates.
					$age  = $diff->y; // The number of whole years in the difference.
				} catch ( Exception $e ) {
					new WP_Error( $e->getMessage() );
				}

				$birth_date = $birth_date_format->format( 'j F Y' );

				// translators: %1$s: birth date, %2$s: age.
				$birth_date_age = sprintf( __( '%1$s (age %2$s years)', 'screen-time' ), $birth_date, $age );

				$hero_data['birth_date_age'] = $birth_date_age;
			}

			$start_year_str = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_BASIC_START_YEAR_SLUG, true );
			if ( ! empty( $start_year_str ) ) {
				$start_year_format = DateTime::createFromFormat( 'Y-m-d', $start_year_str );
				$start_year        = $start_year_format->format( 'Y' );

				// translators: %1$s: start year.
				$start_year_present = sprintf( __( '%1$s-present', 'screen-time' ), $start_year );

				$hero_data['start_year_present'] = $start_year_present;
			}

			$search_query = array(
				array(
					'taxonomy' => Movie_Person::SLUG,
					'field'    => 'slug',
					'terms'    => array( $current_id ),
				),
			);

			$query = new WP_Query(
				array(
					'post_type' => RT_Movie::SLUG,
					'tax_query' => $search_query, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				)
			);

			$movies_worked = $query->posts;

			$movie_name_release_date = array();
			foreach ( $movies_worked as $movie ) {
				$movie_name_release_date [] = array(
					'movie_name'   => $movie->post_title,
					'release_date' => get_post_meta( $movie->ID, RT_Movie_Meta_Box::MOVIE_META_BASIC_RELEASE_DATE_SLUG, true ),
				);
			}

			usort( $movie_name_release_date, array( $this, 'sort_by_release_date' ) );

			$debut_movie_name = $movie_name_release_date[0]['movie_name'];
			$debut_movie_date = $movie_name_release_date[0]['release_date'];
			$debut_movie_year = DateTime::createFromFormat( 'Y-m-d', $debut_movie_date )->format( 'Y' );

			$debut_movie_name_year = sprintf( '%1$s (%2$s)', $debut_movie_name, $debut_movie_year );

			$upcoming_movies_array = array_filter( $movie_name_release_date, array( $this, 'get_upcoming_movies' ) );
			$upcoming_movies       = '';

			if ( count( $upcoming_movies_array ) > 0 ) {
				$upcoming_movies_array = array_values( $upcoming_movies_array );
				foreach ( $upcoming_movies_array as $upcoming_movie ) {
					$release_year     = DateTime::createFromFormat( 'Y-m-d', $upcoming_movie['release_date'] )->format( 'Y' );
					$upcoming_movies .= sprintf( '%1$s (%2$s), ', $upcoming_movie['movie_name'], $release_year );
				}
			}

			$instagram_url = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_SOCIAL_INSTAGRAM_SLUG, true );
			$twitter_url   = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_SOCIAL_TWITTER_SLUG, true );
			$facebook_url  = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_SOCIAL_FACEBOOK_SLUG, true );
			$web_url       = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_SOCIAL_WEB_SLUG, true );

			$social_urls = array();

			if ( ! empty( $instagram_url ) ) {
				$social_urls[] = array(
					'social' => 'instagram',
					'url'    => $instagram_url,
				);
			}

			if ( ! empty( $twitter_url ) ) {
				$social_urls[] = array(
					'social' => 'twitter',
					'url'    => $twitter_url,
				);
			}

			if ( ! empty( $facebook_url ) ) {
				$social_urls[] = array(
					'social' => 'facebook',
					'url'    => $facebook_url,
				);
			}

			if ( ! empty( $web_url ) ) {
				$social_urls[] = array(
					'social' => 'web',
					'url'    => $web_url,
				);
			}

			$hero_data['debut_movie_name_year'] = $debut_movie_name_year;
			$hero_data['upcoming_movies']       = $upcoming_movies;
			$hero_data['social_urls']           = $social_urls;

			return $hero_data;
		}

		/**
		 * This function is used to fetch the about data for the single rt-person post.
		 *
		 * @param int $current_id The current post id.
		 * @return array The about data for the single rt-person post.
		 */
		public function get_about_data( $current_id ): array {
			$about_data       = array();
			$about_data['id'] = $current_id;
			$content          = get_the_content( $current_id );
			if ( ! empty( $content ) ) {
				$about_data['about'] = $content;
			}

			$about_data['desktop_heading'] = __( 'About', 'screen-time' );
			$about_data['mobile_heading']  = __( 'About', 'screen-time' );

			$about_data['quick_links'] = array(
				array(
					'title' => __( 'Poster', 'screen-time' ),
					'url'   => '#poster',
				),
				array(
					'title' => __( 'About', 'screen-time' ),
					'url'   => '#about',
				),
				array(
					'title' => __( 'Snapshots', 'screen-time' ),
					'url'   => '#snapshots',
				),
				array(
					'title' => __( 'Videos', 'screen-time' ),
					'url'   => '#videos',
				),
			);

			return $about_data;
		}

		/**
		 * This function is used to fetch the popular movies data for the single rt-person post.
		 *
		 * @param int $current_id The current post id.
		 * @return array Popular movies of specific person.
		 */
		public function get_popular_movies( $current_id ): array {
			$search_query = array(
				'relation' => 'AND',
				array(
					'taxonomy' => Movie_Person::SLUG,
					'field'    => 'slug',
					'terms'    => array( $current_id ),
				),
				array(
					'taxonomy' => Movie_Label::SLUG,
					'field'    => 'slug',
					'terms'    => array( 'popular-movies' ),
				),
			);

			$query = new WP_Query(
				array(
					'post_type' => RT_Movie::SLUG,
					'tax_query' => $search_query, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				)
			);

			return $query->posts;
		}

		/**
		 * This function is used to fetch the snapshots data for the single rt-person post.
		 *
		 * @param int $current_id The current post id.
		 * @return array The snapshots data for the single rt-person post.
		 */
		public function get_snapshots( $current_id ): array {
			$snapshots_data['id']        = $current_id;
			$snapshots_data['snapshots'] = '';
			$snapshots                   = get_post_meta( $current_id, RT_Media_Meta_Box::IMAGES_SLUG );
			if ( ! empty( $snapshots ) ) {
				$snapshots_data['snapshots'] = $snapshots;
			}

			$snapshots_data['heading'] = __( 'Snapshots', 'screen-time' );

			return $snapshots_data;
		}

		/**
		 * This function is used to fetch the videos data for the single rt-person post.
		 *
		 * @param int $current_id The current post id.
		 * @return array The snapshots data for the single rt-person post.
		 */
		public function get_videos( $current_id ): array {
			$videos_data['id']     = $current_id;
			$videos_data['videos'] = '';
			$videos                = get_post_meta( $current_id, RT_Media_Meta_Box::VIDEOS_SLUG );
			if ( ! empty( $videos ) && ! empty( $videos[0] ) ) {
				$videos_data['videos'] = $videos[0];
			}

			$videos_data['heading'] = __( 'Videos', 'screen-time' );

			return $videos_data;
		}

		/**
		 * This function is used to sort the movie array by release date.
		 *
		 * @param WP_Post $a This will be the one of the WP_Post object from the array.
		 * @param WP_Post $b This will be the one of the WP_Post object from the array.
		 *
		 * @return int
		 */
		public function sort_by_release_date( $a, $b ): int {

			$date1_str = $a['release_date'];
			if ( empty( $date1_str ) ) {
				return 1;
			}

			$date2_str = $b['release_date'];
			if ( empty( $date2_str ) ) {
				return -1;
			}

			$date1 = DateTime::createFromFormat( 'Y-m-d', $date1_str );
			$date2 = DateTime::createFromFormat( 'Y-m-d', $date2_str );

			if ( $date1 > $date2 ) {
				return 1;
			} elseif ( $date1 < $date2 ) {
				return -1;
			}
			return 0;
		}

		/**
		 * This function is used to get the upcoming movies for the single rt-person post.
		 *
		 * @param array $value The movie object.
		 * @return bool
		 */
		public function get_upcoming_movies( $value ): bool {
			$current_date = gmdate( 'Y-m-d' );
			if ( empty( $value['release_date'] ) ) {
				return false;
			}

			$movie_date = $value['release_date'];

			return $movie_date > $current_date;

		}
	}

endif;

