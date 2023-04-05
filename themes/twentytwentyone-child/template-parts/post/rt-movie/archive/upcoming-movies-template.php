<?php
/**
 * This file is used to display the upcoming movies sections of the archive page of the rt-movie post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

use MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box;
use MovieLib\admin\classes\taxonomies\Movie_Genre;

if ( ! isset( $args['movies'] ) ) {
	return;
}

$movies = $args['movies'];
?>
<div class="upcoming-movies-wrapper"> <!-- upcoming-movies-container -->
	<div class="upcoming-movies-heading-wrapper"> <!-- upcoming-movies-heading-container -->
		<div class="primary-text-secondary-font section-heading"> <!-- upcoming-movies-heading -->
			<?php esc_html_e( 'Upcoming Movies', 'screen-time' ); ?>
		</div> <!-- /upcoming-movies-heading -->
	</div> <!-- /upcoming-movies-heading-container -->

	<div class="upcoming-movies-list-wrapper"> <!-- upcoming-movies-list-container -->
		<div class="upcoming-movies-list"> <!-- upcoming-movies-list -->
			<?php
			foreach ( $movies as $movie ) :
				?>

				<div class= "upcoming-movie-item"> <!-- upcoming-movies-list-item -->
					<a href="<?php echo esc_url( get_permalink( $movie->ID ) ); ?>">
						<div class="upcoming-movie-item-image-wrapper"> <!-- upcoming-movies-list-item-image-container -->
							<img src="<?php echo esc_url( get_the_post_thumbnail_url( $movie->ID, 'full' ) ); ?>" loading="lazy" />
						</div> <!-- /upcoming-movies-list-item-image-container -->
					</a>

					<div class="upcoming-movie-item-content-wrapper"> <!-- upcoming-movies-list-item-content-container -->
						<div class="upcoming-movie-item-content-heading-wrapper"> <!-- upcoming-movies-list-item-content-heading-container -->
							<a href="<?php echo esc_url( get_permalink( $movie->ID ) ); ?>">
								<div class="primary-text-primary-font upcoming-movie-title"> <!-- movie-title-text -->
									<?php echo esc_html( get_the_title( $movie->ID ) ); ?>
								</div> <!-- /movie-title-text -->
							</a>

							<div> <!-- genres-container -->
								<?php
								$genres = get_the_terms( $movie->ID, Movie_Genre::SLUG );
								if ( ! empty( $genres ) ) {
									?>
									<a href="<?php echo esc_url( get_term_link( $genres[0] ) ); ?>">
										<div class="secondary-text-primary-font upcoming-movie-genre"> <!-- genre-text -->
											<?php echo esc_html( $genres[0]->name ); ?>
										</div> <!-- /genre-text -->
									</a>
									<?php
								}
								?>
							</div> <!-- /genres-container -->
						</div> <!-- /upcoming-movies-list-item-content-heading-container -->

						<div class="upcoming-movie-item-stats-wrapper"> <!-- upcoming-movies-list-item-content-stats-container -->
							<?php
							$release_year = get_movie_meta( $movie->ID, RT_Movie_Meta_Box::MOVIE_META_BASIC_RELEASE_DATE_SLUG, true );
							if ( ! empty( $release_year ) ) {
								$formatted_date = gmdate( 'jS M Y', strtotime( $release_year ) );
								?>
								<div class="secondary-text-primary-font movie-release-date"> <!-- release-date-text -->

									<?php
									// Translators: %s is the release date of the movie.
									echo esc_html( sprintf( __( 'Release: %1$s', 'screen-time' ), $formatted_date ) );
									?>
								</div> <!-- /release-date-text -->
								<?php
							}
							?>

							<?php
							$content_rating = 'PG-13';
							if ( ! empty( $content_rating ) ) {
								?>
								<div class="secondary-text-primary-font movie-age-rating"> <!-- content-rating-text -->
									<?php echo esc_html( $content_rating ); ?>
								</div> <!-- /content-rating-text -->
								<?php
							}
							?>
						</div> <!-- /upcoming-movies-list-item-content-stats-container -->
					</div> <!-- /upcoming-movies-list-item-content-container -->
				</div> <!-- /upcoming-movies-list-item -->
				<?php
			endforeach;
			?>
		</div> <!-- /upcoming-movies-list -->
	</div> <!-- /upcoming-movies-list-container -->
</div> <!-- /upcoming-movies-container -->
