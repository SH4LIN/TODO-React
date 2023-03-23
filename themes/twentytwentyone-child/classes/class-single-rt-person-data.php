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
use MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Person_Meta_Box;
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
		 * @return array The hero data for the single rt-person post.
		 */
		public function get_hero_data(): array {
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

			$hero_data['name'] = get_the_title();

			$full_name = get_post_meta( get_the_ID(), RT_Person_Meta_Box::PERSON_META_BASIC_FULL_NAME_SLUG, true );
			if ( ! empty( $full_name ) ) {
				$hero_data['full_name'] = $full_name;
			}

			$birth_place = get_post_meta( get_the_ID(), RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_PLACE_SLUG, true );
			if ( ! empty( $full_name ) ) {
				$hero_data['$birth_place'] = $birth_place;
			}

			$career     = get_the_terms( get_the_ID(), Person_Career::SLUG );
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

			$birth_date_str = get_post_meta( get_the_ID(), RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_DATE_SLUG, true );
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

			$start_year_str = get_post_meta( get_the_ID(), RT_Person_Meta_Box::PERSON_META_BASIC_START_YEAR_SLUG, true );
			if ( ! empty( $start_year_str ) ) {
				$start_year_format = DateTime::createFromFormat( 'Y-m-d', $start_year_str );
				$start_year        = $start_year_format->format( 'Y' );

				// translators: %1$s: start year.
				$start_year_present = sprintf( __( '%1$s-present', 'screen-time' ), $start_year );

				$hero_data['start_year_present'] = $start_year_present;
			}

			$args_debut_movie = array(
				'post_type'      => RT_Movie::SLUG,
				'posts_per_page' => 1,
				'post_status'    => 'publish',
				'orderby'        => 'meta_value',
				'order'          => 'ASC',
				'meta_key'       => 'rt-movie-meta-basic-release-date', //phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'tax_query'      => array( //phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					array(
						'taxonomy' => Movie_Person::SLUG,
						'field'    => 'slug',
						'terms'    => get_the_ID(),
					),
				),
			);

			$debut_movie = get_posts( $args_debut_movie );

			$debut_movie_name = $debut_movie[0]->post_title;
			$debut_movie_date = get_post_meta( $debut_movie[0]->ID, RT_Movie_Meta_Box::MOVIE_META_BASIC_RELEASE_DATE_SLUG, true );
			if ( ! empty( $debut_movie_date ) ) {
				$debut_movie_year = DateTime::createFromFormat( 'Y-m-d', $debut_movie_date )->format( 'Y' );

				$debut_movie_name_year              = sprintf( '%1$s (%2$s)', $debut_movie_name, $debut_movie_year );
				$hero_data['debut_movie_name_year'] = $debut_movie_name_year;
			}

			$args_upcoming_movies = array(
				'post_type'      => RT_Movie::SLUG,
				'posts_per_page' => 2,
				'post_status'    => 'publish',
				'orderby'        => 'meta_value',
				'order'          => 'ASC',
				'meta_key'       => 'rt-movie-meta-basic-release-date', //phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'tax_query'      => array( //phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					array(
						'taxonomy' => Movie_Person::SLUG,
						'field'    => 'slug',
						'terms'    => get_the_ID(),
					),
				),
				//phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				'meta_query'     => array(
					array(
						'key'     => RT_Movie_Meta_Box::MOVIE_META_BASIC_RELEASE_DATE_SLUG,
						'value'   => gmdate( 'Y-m-d' ),
						'compare' => '>=',
						'type'    => 'DATE',
					),
				),
			);

			$upcoming_movies_array = get_posts( $args_upcoming_movies );
			$upcoming_movies       = '';
			if ( count( $upcoming_movies_array ) > 0 ) {
				foreach ( $upcoming_movies_array as $upcoming_movie ) {
					$upcoming_movie_date = get_post_meta( $upcoming_movie->ID, RT_Movie_Meta_Box::MOVIE_META_BASIC_RELEASE_DATE_SLUG, true );
					if ( ! empty( $upcoming_movie_date ) ) {
						$release_year = DateTime::createFromFormat( 'Y-m-d', $debut_movie_date )->format( 'Y' );

						$upcoming_movies .= sprintf( '%1$s (%2$s), ', $upcoming_movie->post_title, $release_year );
					}
				}
			}

			$instagram_url = get_post_meta( get_the_ID(), RT_Person_Meta_Box::PERSON_META_SOCIAL_INSTAGRAM_SLUG, true );
			$twitter_url   = get_post_meta( get_the_ID(), RT_Person_Meta_Box::PERSON_META_SOCIAL_TWITTER_SLUG, true );
			$facebook_url  = get_post_meta( get_the_ID(), RT_Person_Meta_Box::PERSON_META_SOCIAL_FACEBOOK_SLUG, true );
			$web_url       = get_post_meta( get_the_ID(), RT_Person_Meta_Box::PERSON_META_SOCIAL_WEB_SLUG, true );

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

			$hero_data['upcoming_movies'] = $upcoming_movies;
			$hero_data['social_urls']     = $social_urls;

			return $hero_data;
		}
	}

endif;

