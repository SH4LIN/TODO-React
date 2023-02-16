<?php
/**
 * This file is used to create the meta boxes for the plugin.
 *
 * @package MovieLib\admin\classes
 */

namespace MovieLib\admin\classes;

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'MovieLib\admin\classes\Movie_Library_Meta_Boxes' ) ) {

	/**
	 * @class Movie_Library_Meta_Boxes
	 * This class is used to create the meta boxes for the plugin.
	 */
	class Movie_Library_Meta_Boxes {

		/**
		 * This function is used to add the meta boxes for the plugin.
		 */
		public function add_meta_boxes(): void {

			add_meta_box(
				'movie-library-movie-details',
				__( 'Movie Details', 'movie-library' ),
				array( $this, 'movie_details' ),
				'movie',
				'normal',
				'high'
			);
		}

		/**
		 * This function is used to display the meta box for the movie details.
		 *
		 * @param object $post The post object.
		 */
		public function movie_details( $post ): void {
			$movie_details = get_post_meta( $post->ID, 'movie_details', true );
			$movie_details = wp_parse_args(
				$movie_details,
				array(
					'year'       => '',
					'rating'     => '',
					'genre'      => '',
					'runtime'    => '',
					'director'   => '',
					'writer'     => '',
					'cast'       => '',
					'plot'       => '',
					'poster_url' => '',
				)
			);
			?>
			<div class="movie-library-movie-details">
				<div class="movie-library-movie-details-row">
					<div class="movie-library-movie-details-column">
						<label for="movie-library-year"><?php
							esc_html_e( 'Year', 'movie-library' ); ?></label>
						<input type="text" name="movie_details[year]" id="movie-library-year" value="<?php
						echo esc_attr( $movie_details[ 'year' ] ); ?>"/>
					</div>
					<div class="movie-library-movie-details-column">
						<label for="movie-library-rating"><?php
							esc_html_e( 'Rating', 'movie-library' ); ?></label>
						<input type="text" name="movie_details[rating]" id="movie-library-rating" value="<?php
						echo esc_attr( $movie_details[ 'rating' ] ); ?>"/>
					</div>
					<div class="movie-library-movie-details-column">
						<label for="movie-library-genre"><?php
							esc_html_e( 'Genre', 'movie-library' ); ?></label>
						<input type="text" name="movie_details[genre]" id="movie-library-genre" value="<?php
						echo esc_attr( $movie_details[ 'genre' ] ); ?>"/>
					</div>

				</div>
			</div>
			<?php
		}
	}
}
