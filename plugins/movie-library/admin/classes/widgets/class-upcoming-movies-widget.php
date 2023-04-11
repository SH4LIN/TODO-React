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

if ( ! class_exists( 'MovieLib\admin\classes\widgets\Upcoming_Movies_Widget' ) ) {

	/**
	 * This class is used to add the dashboard widget.
	 */
	class Upcoming_Movies_Widget {

		use Singleton;

		/**
		 * RT_DASHBOARD_UPCOMING_MOVIE_WIDGET_SLUG
		 */
		const RT_DASHBOARD_UPCOMING_MOVIE_WIDGET_SLUG = 'rt-dashboard-upcoming-movie-widget';

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
				self::RT_DASHBOARD_UPCOMING_MOVIE_WIDGET_SLUG,
				__( 'Upcoming Movies', 'movie-library' ),
				array( $this, 'display_dashboard_upcoming_movie_widget' )
			);
		}

		/**
		 * This function will fetch the upcoming movies from the REST API.
		 * And then display the data in the dashboard widget.
		 *
		 * @return void
		 */
		public function display_dashboard_upcoming_movie_widget(): void {
			$movies = $this->fetch_upcoming_movies();
			?>
			<div class="rt-dashboard-widget__upcoming-movies">
				<?php
				if ( ! empty( $movies ) ) {
					require MLB_PLUGIN_DIR . 'admin/classes/partials/dashboard-movie-card.php';
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
		 * This function is used to fetch the upcoming movies from the REST API using the HTTP API of WordPress.
		 *
		 * @return array
		 */
		private function fetch_upcoming_movies(): array {
			$local_response = get_transient( self::RT_DASHBOARD_UPCOMING_MOVIES_SLUG );
			if ( false === $local_response ) {

				$api_url = get_option( 'api_base_url_input_box' );
				$api_key = get_option( 'api_key_input_box' );
				if ( $api_url && $api_key ) {
					$local_response = wp_remote_get( esc_url( $api_url . $api_key ) );

					if ( ! is_wp_error( $local_response ) && wp_remote_retrieve_response_code( $local_response ) === 200 ) {
						set_transient( self::RT_DASHBOARD_UPCOMING_MOVIES_SLUG, $local_response, 4 * HOUR_IN_SECONDS );
					}
				}
			}

			$movies          = json_decode( wp_remote_retrieve_body( $local_response ), true );
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
