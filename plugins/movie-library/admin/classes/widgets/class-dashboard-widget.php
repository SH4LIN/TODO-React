<?php
/**
 * This file is used to create the dashboard widget.
 * This widget is used to display the most recent movies.
 * And also the top-rated movies.
 *
 * @package MovieLib\admin\classes\widgets
 */

namespace MovieLib\admin\classes\widgets;

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box;
use MovieLib\includes\Singleton;
use WP_Query;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\widgets\Dashboard_Widget' ) ) {

	/**
	 * This class is used to add the dashboard widget.
	 */
	class Dashboard_Widget {

		use Singleton;

		/**
		 * RT_DASHBOARD_MOVIE_WIDGET_SLUG
		 */
		const RT_DASHBOARD_MOVIE_WIDGET_SLUG = 'rt-dashboard-movie-widget';

		/**
		 * RT_DASHBOARD_UPCOMING_MOVIE_WIDGET_SLUG
		 */
		const RT_DASHBOARD_UPCOMING_MOVIE_WIDGET_SLUG = 'rt-dashboard-upcoming-movie-widget';

		/**
		 * RT_DASHBOARD_RECENT_MOVIES_SLUG
		 */
		const RT_DASHBOARD_RECENT_MOVIES_SLUG = 'rt-dashboard-recent-movies';

		/**
		 * RT_DASHBOARD_TOP_RATED_MOVIES_SLUG
		 */
		const RT_DASHBOARD_TOP_RATED_MOVIES_SLUG = 'rt-dashboard-top-rated-movies';

		/**
		 * RT_DASHBOARD_TOP_RATED_MOVIES_SLUG
		 */
		const RT_DASHBOARD_UPCOMING_MOVIES_SLUG = 'rt-dashboard-upcoming-movies';

		/**
		 * Dashboard_Widget init method.
		 *
		 * @return void
		 */
		protected function init(): void {
			add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widget' ) );
		}

		/**
		 * This function is used to add the dashboard widget.
		 * That will display the recent movies and top-rated movies.
		 *
		 * @return void
		 */
		public function add_dashboard_widget(): void {
			wp_add_dashboard_widget(
				self::RT_DASHBOARD_MOVIE_WIDGET_SLUG,
				__( 'Movie Library', 'movie-library' ),
				array( $this, 'display_dashboard_movie_widget' )
			);

			wp_add_dashboard_widget(
				self::RT_DASHBOARD_UPCOMING_MOVIE_WIDGET_SLUG,
				__( 'Upcoming Movies', 'movie-library' ),
				array( $this, 'display_dashboard_upcoming_movie_widget' )
			);
		}

		/**
		 * This function will first call the fetch recent movies and top-rated movies functions.
		 * And then display the data in the dashboard widget.
		 *
		 * @return void
		 */
		public function display_dashboard_movie_widget(): void {
			$recent_movies = $this->fetch_recent_movies();
			$top_rated     = $this->fetch_top_rated_movies();
			?>
			<div class="rt-dashboard-widget">
				<div class="rt-dashboard-widget__recent-movies">
					<h3><?php esc_html_e( 'Recent Movies', 'movie-library' ); ?></h3>
					<?php
					if ( ! empty( $recent_movies ) ) {
						?>
						<ul>
							<?php
							foreach ( $recent_movies as $movie ) {
								?>
								<li>
									<img src="<?php echo esc_url( $movie['poster'] ); ?>">
									<p><?php echo esc_html( $movie['title'] ); ?></p>
								</li>
								<?php
							}
							?>
						</ul>
						<?php
					} else {
						?>
						<p><?php esc_html_e( 'No recent movies found.', 'movie-library' ); ?></p>
						<?php
					}
					?>
				</div>
				<div class="rt-dashboard-widget__top-rated-movies">
					<h3><?php esc_html_e( 'Top Rated Movies', 'movie-library' ); ?></h3>
					<?php
					if ( ! empty( $top_rated ) ) {
						?>
						<ul>
							<?php
							foreach ( $top_rated as $movie ) {
								?>
								<li>
									<img src="<?php echo esc_url( $movie['poster'] ); ?>">
									<p><?php echo esc_html( $movie['title'] ); ?></p>
								</li>
								<?php
							}
							?>
						</ul>
						<?php
					} else {
						?>
						<p><?php esc_html_e( 'No top rated movies found.', 'movie-library' ); ?></p>
						<?php
					}
					?>
				</div>
			</div>
			<?php
		}

		/**
		 * This function will fetch the upcoming movies from the REST API.
		 * And then display the data in the dashboard widget.
		 *
		 * @return void
		 */
		public function display_dashboard_upcoming_movie_widget(): void {
			$upcoming_movies = $this->fetch_upcoming_movies();
			?>
			<div class="rt-dashboard-widget__upcoming-movies">
				<?php
				if ( ! empty( $upcoming_movies ) ) {
					?>
					<ul>
						<?php
						foreach ( $upcoming_movies as $movie ) {
							?>
							<li>
								<img src="<?php echo esc_url( $movie['poster'] ); ?>">
								<p><?php echo esc_html( $movie['title'] ); ?></p>
							</li>
							<?php
						}
						?>
					</ul>
					<?php
				} else {
					?>
					<p><?php esc_html_e( 'No upcoming movies found.', 'movie-library' ); ?></p>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 * This function is used to fetch the recent movies from the REST API using the HTTP API of WordPress.
		 *
		 * @return array
		 */
		private function fetch_recent_movies(): array {
			$recent_movies_args = array(
				'post_type'      => RT_Movie::SLUG,
				'posts_per_page' => 6,
				'meta_key'       => RT_Movie_Meta_Box::MOVIE_META_BASIC_RELEASE_DATE_SLUG, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'orderby'        => 'date',
				'order'          => 'DESC',
			);

			$movies = get_posts( $recent_movies_args );

			return $this->extract_movie_data( $movies );
		}

		/**
		 * This function is used to fetch the top-rated movies from the REST API using the HTTP API of WordPress.
		 *
		 * @return array
		 */
		private function fetch_top_rated_movies(): array {
			$top_rated_movies_args = array(
				'post_type'      => RT_Movie::SLUG,
				'posts_per_page' => 6,
				'meta_key'       => RT_Movie_Meta_Box::MOVIE_META_BASIC_RATING_SLUG, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'orderby'        => 'meta_value',
				'order'          => 'DESC',
			);

			$movies = get_posts( $top_rated_movies_args );

			return $this->extract_movie_data( $movies );
		}

		/**
		 * This function is used to extract the required data from recent movies and top-rated movies.
		 *
		 * @param array $movies The array of movies.
		 * @return array
		 */
		private function extract_movie_data( $movies ): array {
			$extracted_movies = array();

			if ( ! empty( $movies ) ) {
				foreach ( $movies as $movie ) {
					if ( has_post_thumbnail( $movie->ID ) ) {
						$poster = get_the_post_thumbnail_url( $movie->ID );
					}
					$extracted_movies[] = array(
						'title'  => $movie->post_title,
						'poster' => $poster,
					);
				}
			}

			return $extracted_movies;
		}

		/**
		 * This function is used to fetch the upcoming movies from the REST API using the HTTP API of WordPress.
		 *
		 * @return array
		 */
		private function fetch_upcoming_movies(): array {
			$local_response = get_transient( self::RT_DASHBOARD_UPCOMING_MOVIES_SLUG );
			if ( false === $local_response ) {
				$local_response = wp_remote_get( 'https://imdb-api.com/en/API/ComingSoon/k_823vv7z1' );

				if ( ! is_wp_error( $local_response ) && wp_remote_retrieve_response_code( $local_response ) === 200 ) {
					set_transient( self::RT_DASHBOARD_UPCOMING_MOVIES_SLUG, $local_response, 4 * HOUR_IN_SECONDS );
				}
			}

			$movies = json_decode( wp_remote_retrieve_body( $local_response ), true );

			$upcoming_movies = array();
			if ( ! empty( $movies['items'] ) ) {
				$i = 0;
				foreach ( $movies['items'] as $movie ) {
					$upcoming_movies[] = array(
						'title'  => $movie['title'],
						'poster' => $movie['image'],
					);
					++$i;
					if ( 6 === $i ) {
						break;
					}
				}
			}

			return $upcoming_movies;
		}
	}
}
