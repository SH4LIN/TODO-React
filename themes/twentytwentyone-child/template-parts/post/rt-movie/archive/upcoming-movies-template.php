<?php
/**
 * This file is used to display the upcoming movies sections of the archive page of the rt-movie post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

use MovieLib\admin\classes\taxonomies\Movie_Genre;

if ( ! isset( $args['movies'] ) ) {
	return;
}

$movies = $args['movies'];
?>
<div class="st-am-upcoming-movies-container"> <!-- upcoming-movies-container -->
	<div class="st-am-upcoming-movies-heading-container"> <!-- upcoming-movies-heading-container -->
		<div class="primary-text-secondary-font section-heading-text"> <!-- upcoming-movies-heading -->
			<?php esc_html_e( 'Upcoming Movies', 'screen-time' ); ?>
		</div> <!-- /upcoming-movies-heading -->
	</div> <!-- /upcoming-movies-heading-container -->

	<div class="st-am-upcoming-movies-list-container"> <!-- upcoming-movies-list-container -->
		<div class="st-am-upcoming-movies-list"> <!-- upcoming-movies-list -->
			<?php
			foreach ( $movies as $movie ) :
				?>
				<a href="<?php echo esc_url( get_permalink( $movie->ID ) ); ?>">
					<div class="st-am-upcoming-movies-list-item"> <!-- upcoming-movies-list-item -->
						<div class="st-am-upcoming-movies-list-item-image-container"> <!-- upcoming-movies-list-item-image-container -->
							<img src="<?php echo esc_url( get_the_post_thumbnail_url( $movie->ID, 'full' ) ); ?>" class="st-am-upcoming-movies-list-item-image">
						</div> <!-- /upcoming-movies-list-item-image-container -->

						<div class="st-am-upcoming-movies-list-item-content-container"> <!-- upcoming-movies-list-item-content-container -->
							<div class="st-am-upcoming-movies-list-item-content-heading-container"> <!-- upcoming-movies-list-item-content-heading-container -->
								<div class="primary-text-primary-font st-am-movie-title-text"> <!-- movie-title-text -->
									<?php echo esc_html( get_the_title( $movie->ID ) ); ?>
								</div> <!-- /movie-title-text -->

								<div class="st-am-genres-container"> <!-- genres-container -->
									<?php
									$genres = get_the_terms( $movie->ID, Movie_Genre::SLUG );
									if ( ! empty( $genres ) ) {
										foreach ( $genres as $genre ) {
											?>
											<div class="secondary-text-primary-font st-am-genre-text"> <!-- genre-text -->
												<?php echo esc_html( $genre->name ); ?>
											</div> <!-- /genre-text -->
											<?php
										}
									}
									?>
								</div> <!-- /genres-container -->
							</div> <!-- /upcoming-movies-list-item-content-heading-container -->

							<div class="st-am-upcoming-movies-list-item-content-stats-container"> <!-- upcoming-movies-list-item-content-stats-container -->
								<?php
								$release_year = get_post_meta( $movie->ID, 'rt-movie-meta-basic-release-date', true );
								if ( ! empty( $release_year ) ) {
									$formatted_date = gmdate( 'jS M Y', strtotime( $release_year ) );
									?>
									<div class="st-am-stats-list-item secondary-text-primary-font st-am-release-date-text"> <!-- release-date-text -->
										<?php echo esc_html__( 'Release: ', 'screen-time' ) . esc_html( $formatted_date ); ?>
									</div> <!-- /release-date-text -->
									<?php
								}
								?>

								<?php
								$content_rating = 'PG-13';
								if ( ! empty( $content_rating ) ) {
									?>
									<div class="st-am-stats-list-item secondary-text-primary-font st-am-content-rating-text"> <!-- content-rating-text -->
										<?php echo esc_html( $content_rating ); ?>
									</div> <!-- /content-rating-text -->
									<?php
								}
								?>
							</div> <!-- /upcoming-movies-list-item-content-stats-container -->
						</div> <!-- /upcoming-movies-list-item-content-container -->
					</div> <!-- /upcoming-movies-list-item -->
				</a>
				<?php
			endforeach;
			?>
		</div> <!-- /upcoming-movies-list -->
	</div> <!-- /upcoming-movies-list-container -->
</div> <!-- /upcoming-movies-container -->
