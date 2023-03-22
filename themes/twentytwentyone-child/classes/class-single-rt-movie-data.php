<?php
/**
 * This file contains the class which provides the functionality of fetching single rt-movie data.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\admin\classes\meta_boxes\RT_Media_Meta_Box;

require_once get_stylesheet_directory() . '/classes/trait-singleton.php';

if ( ! class_exists( 'Single_RT_Movie_Data' ) ) :

	/**
	 * This class is used to fetch the single rt movie data.
	 */
	class Single_RT_Movie_Data {
		use Singleton;

		/**
		 * Single_RT_Movie_Data init function to initialize the class.
		 *
		 * @return void
		 */
		protected function init(): void {}

		/**
		 * This function is used to fetch the poster title data for the single rt-movie post.
		 *
		 * @param int $current_id The current post id.
		 * @return array $poster_title_data The poster title data for the single rt-person post.
		 */
		public function get_poster_title_data( $current_id ): array {
			$poster_title_data = array();
			$movie_title       = get_the_title( $current_id );

			$poster_title_data['id']   = $current_id;
			$poster_title_data['name'] = $movie_title;

			$post_thumbnail_id = get_post_thumbnail_id( $current_id );
			$poster_url        = '';
			if ( $post_thumbnail_id ) {
				$poster_url = wp_get_attachment_image_url( $post_thumbnail_id, 'full' );
			} else {
				$poster_url = get_stylesheet_directory_uri() . '/assets/src/images/placeholder.webp';
			}
			$poster_title_data['poster'] = $poster_url;

			$poster_title_data['rating'] = '';
			$rating                      = get_post_meta( $current_id, 'rt-movie-meta-basic-rating', true );
			if ( ! empty( $rating ) ) {
				$poster_title_data['rating'] = $rating . '/10';
			}

			$poster_title_data['release_year'] = '';
			$release_year                      = get_post_meta( $current_id, 'rt-movie-meta-basic-release-date', true );
			if ( ! empty( $release_year ) ) {
				$date                              = DateTime::createFromFormat( 'Y-m-d', $release_year );
				$poster_title_data['release_year'] = $date->format( 'Y' );
			}

			$poster_title_data['content_rating'] = 'PG-13';

			$poster_title_data['runtime'] = '';

			$minutes = get_post_meta( $current_id, 'rt-movie-meta-basic-runtime', true );
			if ( ! empty( $minutes ) ) {
				$poster_title_data['runtime'] = intdiv( $minutes, 60 ) . __( 'H ', 'screen-time' ) . ( $minutes % 60 ) . __( 'M', 'screen-time' );
			}

			$poster_title_data['genres'] = '';
			$genres                      = get_the_terms( $current_id, 'rt-movie-genre' );
			if ( ! empty( $genres ) ) {
				$poster_title_data['genres'] = $genres;
			}

			$poster_title_data['synopsis'] = '';
			$synopsis                      = get_the_excerpt( $current_id );
			if ( ! empty( $synopsis ) ) {
				$poster_title_data['synopsis'] = $synopsis;
			}

			$poster_title_data['directors'] = '';
			$directors                      = get_post_meta( $current_id, 'rt-movie-meta-crew-director' );
			if ( ! empty( $directors ) ) {
				$poster_title_data['directors'] = $directors;
			}

			$trailer_clips = $this->get_video_data( $current_id );

			$poster_title_data['trailer'] = '';
			if ( ! empty( $trailer_clips['videos'] ) ) {
				$poster_title_data['trailer'] = $trailer_clips['videos'][0];
			}

			return $poster_title_data;
		}

		/**
		 * This function is used to fetch the plot data for the single rt-movie post.
		 *
		 * @param int $current_id The current post id.
		 * @return array The plot data for the single rt-movie post.
		 */
		public function get_plot_data( $current_id ): array {
			$plot_data = array();

			$plot_data['id'] = $current_id;

			$plot               = get_the_content( $current_id );
			$plot_data['about'] = '';
			if ( ! empty( $plot ) ) {
				$plot_data['about'] = $plot;
			}

			$plot_data['desktop_heading'] = __( 'Plot', 'screen-time' );
			$plot_data['mobile_heading']  = __( 'Synopsis', 'screen-time' );

			$plot_data['quick_links'] = array(
				array(
					'title' => __( 'Poster', 'screen-time' ),
					'url'   => '#poster',
				),
				array(
					'title' => __( 'Cast & Crew', 'screen-time' ),
					'url'   => '#cast-crew',
				),
				array(
					'title' => __( 'Snapshots', 'screen-time' ),
					'url'   => '#snapshots',
				),
				array(
					'title' => __( 'Trailer & Clips', 'screen-time' ),
					'url'   => '#videos',
				),
				array(
					'title' => __( 'Reviews', 'screen-time' ),
					'url'   => '#reviews',
				),
			);

			return $plot_data;
		}

		/**
		 * This function is used to fetch the crew data for the single rt-movie post.
		 *
		 * @param int $current_id The current post id.
		 * @return array The crew data for the single rt-movie post.
		 */
		public function get_crew_data( $current_id ): array {
			$crew_data = array();

			$crew_data['id']   = $current_id;
			$crew_data['link'] = get_post_type_archive_link( RT_Person::SLUG ) . '?movie_id=' . $current_id;

			$crew              = get_post_meta( $current_id, 'rt-movie-meta-crew-actor' );
			$crew_data['crew'] = '';
			if ( ! empty( $crew ) ) {
				$crew_data['crew'] = $crew;
			}
			return $crew_data;
		}

		/**
		 * This function is used to fetch the snapshots data for the single rt-movie post.
		 *
		 * @param int $current_id The current post id.
		 * @return array The snapshots data for the single rt-movie post.
		 */
		public function get_snapshot_data( $current_id ): array {
			$snapshots_data = array();

			$snapshots_data['id'] = $current_id;

			$snapshots                   = get_post_meta( $current_id, RT_Media_Meta_Box::IMAGES_SLUG );
			$snapshots_data['snapshots'] = '';
			if ( ! empty( $snapshots ) ) {
				$snapshots_data['snapshots'] = $snapshots;
			}

			$snapshots_data['heading'] = __( 'Snapshots', 'screen-time' );

			return $snapshots_data;
		}

		/**
		 * This function is used to fetch the videos data for the single rt-movie post.
		 *
		 * @param int $current_id The current post id.
		 * @return array The snapshots data for the single rt-movie post.
		 */
		public function get_video_data( $current_id ): array {
			$videos_data = array();

			$videos_data['id'] = $current_id;

			$trailer_clips = get_post_meta( $current_id, 'rt-media-meta-videos' );

			$videos_data['videos'] = '';
			if ( ! empty( $trailer_clips ) && ! empty( $trailer_clips[0] ) ) {
				$videos_data['videos'] = $trailer_clips[0];
			}

			$videos_data['heading'] = __( 'Trailer & Clips', 'screen-time' );

			return $videos_data;
		}

		/**
		 * This function is used to fetch the comment data for the single rt-movie post.
		 *
		 * @param int $current_id The current post id.
		 * @return array The comment data for the single rt-movie post.
		 */
		public function get_comment_data( $current_id ): array {
			$comments_data = array();

			$comments_data['id'] = $current_id;

			$post_comments = get_comments(
				array(
					'post_id' => $current_id,
				)
			);

			$comments_data['comments'] = '';
			if ( ! empty( $post_comments ) ) {
				$comments_data['comments'] = $post_comments;
			}

			return $comments_data;
		}
	}

endif;

