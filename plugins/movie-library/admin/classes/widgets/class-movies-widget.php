<?php
/**
 * This file is used to display the Recent Movies and Top Rated Movies on the dashboard widget.
 *
 * @package MovieLib\admin\classes\widgets
 */

namespace MovieLib\admin\classes\widgets;

use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box;
use MovieLib\includes\Singleton;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\widgets\Movies_Widget' ) ) {

	/**
	 * This class is used to display the Recent and Top rated movies.
	 */
	class Movies_Widget {

		use Singleton;

		/**
		 * RT_DASHBOARD_MOVIE_WIDGET_SLUG
		 */
		const RT_DASHBOARD_MOVIE_WIDGET_SLUG = 'rt-dashboard-movie-widget';

		/**
		 * Movies_Widget init method.
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
		}

		/**
		 * This function will first call the fetch recent movies and top-rated movies functions.
		 * And then display the data in the dashboard widget.
		 *
		 * @return void
		 */
		public function display_dashboard_movie_widget(): void {
			$movies = $this->fetch_recent_movies();
			?>
			<div class="rt-dashboard-widget">
				<div class="rt-dashboard-widget__recent-movies">
					<h3><?php esc_html_e( 'Recent Movies', 'movie-library' ); ?></h3>
					<?php
					if ( ! empty( $movies ) ) {
						require MLB_PLUGIN_DIR . 'admin/classes/partials/dashboard-movie-card.php';
					} else {
						?>
						<p><?php esc_html_e( 'No recent movies found.', 'movie-library' ); ?></p>
						<?php
					}
					?>
				</div>
				<?php
				unset( $movies );
				$movies = $this->fetch_top_rated_movies();
				?>
				<div class="rt-dashboard-widget__top-rated-movies">
					<h3><?php esc_html_e( 'Top Rated Movies', 'movie-library' ); ?></h3>
					<?php
					if ( ! empty( $movies ) ) {
						require MLB_PLUGIN_DIR . 'admin/classes/partials/dashboard-movie-card.php';
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
					} else {
						$poster = MLB_PLUGIN_URL . 'admin/images/placeholder.webp';
					}

					if ( current_user_can( 'edit_post', $movie->ID ) ) {
						$edit_link = get_edit_post_link( $movie->ID );
					} else {
						$edit_link = '';
					}

					// If current user can view post.
					if ( current_user_can( 'read_post', $movie->ID ) ) {
						$view_link = get_permalink( $movie->ID );
					} else {
						$view_link = '';
					}

					$extracted_movies[] = array(
						'edit_link' => $edit_link,
						'view_link' => $view_link,
						'title'     => $movie->post_title,
						'poster'    => $poster,
					);
				}
			}

			return $extracted_movies;
		}
	}
}
