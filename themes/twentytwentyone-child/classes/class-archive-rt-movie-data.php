<?php
/**
 * This file contains the class which provides the functionality of fetching archive rt-movie data.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

/**
 * This is a security measure to prevent direct access to the file.
 */

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\taxonomies\Movie_Label;

defined( 'ABSPATH' ) || exit;

require_once get_stylesheet_directory() . '/classes/trait-singleton.php';




if ( ! class_exists( 'Archive_RT_Movie_Data' ) ) :

	/**
	 * This class is used to fetch the single rt person data.
	 */
	class Archive_RT_Movie_Data {
		use Singleton;

		/**
		 * Archive_RT_Movie_Data init function to initialize the class.
		 *
		 * @return void
		 */
		protected function init(): void {}

		/**
		 * This function is used to fetch the all slider movies data.
		 *
		 * @return array $hero_data The hero data for the archive rt-movie post.
		 */
		public function get_slider_movies(): array {
			$slider_movies_args = array(
				'post_type' => RT_Movie::SLUG,
				'tax_query' => array( // phpcs:ignore: WordPress.DB.SlowDBQuery.slow_db_query_tax_query
									array(
										'taxonomy' => Movie_Label::SLUG,
										'field'    => 'slug',
										'terms'    => 'slider',
									),
				),
			);

			$slider_movies_query = new WP_Query( $slider_movies_args );
			$slider_movies       = $slider_movies_query->posts;

			wp_reset_postdata();

			return $slider_movies;
		}

		/**
		 * This function is used to fetch the all upcoming movies data.
		 *
		 * @return array The hero data for the archive rt-movie post.
		 */
		public function get_upcoming_movies(): array {
			$upcoming_movies_args = array(
				'post_type' => RT_Movie::SLUG,
				'tax_query' => array( // phpcs:ignore: WordPress.DB.SlowDBQuery.slow_db_query_tax_query
								array(
									'taxonomy' => Movie_Label::SLUG,
									'field'    => 'slug',
									'terms'    => 'upcoming-movies',
								),
				),
			);

			$upcoming_movies_query = new WP_Query( $upcoming_movies_args );
			$upcoming_movies       = $upcoming_movies_query->posts;

			wp_reset_postdata();

			return $upcoming_movies;
		}

		/**
		 * This function is used to fetch the all upcoming movies data.
		 *
		 * @return array The hero data for the archive rt-movie post.
		 */
		public function get_trending_movies(): array {
			$trending_movies_args = array(
				'post_type' => RT_Movie::SLUG,
				'tax_query' => array( // phpcs:ignore: WordPress.DB.SlowDBQuery.slow_db_query_tax_query
									array(
										'taxonomy' => Movie_Label::SLUG,
										'field'    => 'slug',
										'terms'    => 'trending-now',
									),
				),
			);

			$trending_movies_query = new WP_Query( $trending_movies_args );
			$trending_movies       = $trending_movies_query->posts;

			wp_reset_postdata();

			return $trending_movies;
		}

	}

endif;

