<?php
/**
 * This file is used to display the trending movies on the archive page of the rt-movie post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

use MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box;
use MovieLib\admin\classes\taxonomies\Movie_Genre;

if ( ! isset( $args['movie'] ) ) {
	return;
}

$movie = $args['movie'];
?>

	<div class= "movie-item"> <!-- trending-movies-list-item -->
		<a href="<?php echo esc_url( get_permalink( $movie->ID ) ); ?>">
			<div class="movie-image-wrapper"> <!-- trending-movies-list-item-image-container -->
				<img src="<?php echo esc_url( get_the_post_thumbnail_url( $movie->ID, 'full' ) ); ?>" loading="lazy" />
			</div> <!-- /trending-movies-list-item-image-container -->
		</a>

		<div class="movie-item-content-wrapper"> <!-- trending-movies-list-item-content-container -->
			<div class="movie-item-content-heading-wrapper"> <!-- trending-movies-list-item-content-heading-container -->
				<a href="<?php echo esc_url( get_permalink( $movie->ID ) ); ?>">
					<p class="primary-text-primary-font movie-title"> <!-- movie-title-text -->
						<?php echo esc_html( get_the_title( $movie->ID ) ); ?>
					</p> <!-- /movie-title-text -->
				</a>

				<?php
				$minutes = get_post_meta( $movie->ID, RT_Movie_Meta_Box::MOVIE_META_BASIC_RUNTIME_SLUG, true );
				if ( ! empty( $minutes ) ) {
					$runtime = intdiv( $minutes, 60 ) . __( ' hr ', 'screen-time' ) . ( $minutes % 60 ) . __( ' min', 'screen-time' );
					?>
					<div class="secondary-text-primary-font movie-runtime"> <!-- runtime-text -->
						<?php echo esc_html( $runtime ); ?>
					</div> <!-- /runtime-text -->
					<?php
				}
				?>
			</div> <!-- /trending-movies-list-item-content-heading-container -->

			<div class="movie-item-content-stats-wrapper"> <!-- trending-movies-list-item-content-stats-container -->
				<div class="genres-wrapper"> <!-- genres-container -->
					<?php
					$genres = get_the_terms( $movie->ID, Movie_Genre::SLUG );
					if ( ! empty( $genres ) ) {
						foreach ( $genres as $genre ) {
							?>
							<a class="secondary-text-primary-font" href="<?php echo esc_url( get_term_link( $genre ) ); ?>">
								<?php echo esc_html( $genre->name ); ?>
							</a>
							<?php
						}
					}
					?>
				</div> <!-- /genres-container -->

				<?php
				$release_year = get_post_meta( $movie->ID, RT_Movie_Meta_Box::MOVIE_META_BASIC_RELEASE_DATE_SLUG, true );
				if ( ! empty( $release_year ) ) {
					$date         = DateTime::createFromFormat( 'Y-m-d', $release_year );
					$release_year = $date->format( 'Y' );
					?>
					<div class="secondary-text-primary-font movie-release-year"> <!-- release-date-text -->
						<?php echo esc_html( $release_year ); ?>
					</div> <!-- /release-date-text -->
					<?php
				}
				?>
			</div> <!-- /trending-movies-list-item-content-stats-container -->
		</div> <!-- /trending-movies-list-item-content-container -->
	</div> <!-- /trending-movies-list-item -->
