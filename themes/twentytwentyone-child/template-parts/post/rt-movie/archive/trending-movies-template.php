<?php
/**
 * This file is used to display the trending movies on the archive page of the rt-movie post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

if ( ! isset( $args['movies'] ) ) {
	return;
}

$movies = $args['movies'];
?>
<div class="st-am-trending-movies-container"> <!-- trending-movies-container -->
			<div class="st-am-trending-movies-heading-container"> <!-- trending-movies-heading-container -->
				<div class="primary-text-secondary-font section-heading-text"> <!-- trending-movies-heading -->
					<?php esc_html_e( 'Trending Movies', 'screen-time' ); ?>
				</div> <!-- /trending-movies-heading -->
			</div> <!-- /trending-movies-heading-container -->

			<div class="st-am-trending-movies-list-container"> <!-- trending-movies-list-container -->
				<div class="st-am-trending-movies-list"> <!-- trending-movies-list -->
					<?php
					foreach ( $movies as $movie ) :

						?>
						<a href="<?php echo esc_url( get_permalink( $movie->ID ) ); ?>">
							<div class="st-am-trending-movies-list-item"> <!-- trending-movies-list-item -->
								<div class="st-am-trending-movies-list-item-image-container"> <!-- trending-movies-list-item-image-container -->
									<img src="<?php echo esc_url( get_the_post_thumbnail_url( $movie->ID, 'full' ) ); ?>" class="st-am-trending-movies-list-item-image">
								</div> <!-- /trending-movies-list-item-image-container -->

								<div class="st-am-trending-movies-list-item-content-container"> <!-- trending-movies-list-item-content-container -->
									<div class="st-am-trending-movies-list-item-content-heading-container"> <!-- trending-movies-list-item-content-heading-container -->
										<div class="primary-text-primary-font st-am-movie-title-text"> <!-- movie-title-text -->
											<?php echo esc_html( get_the_title( $movie->ID ) ); ?>
										</div> <!-- /movie-title-text -->

									<?php
									$minutes = get_post_meta( $movie->ID, 'rt-movie-meta-basic-runtime', true );
									if ( ! empty( $minutes ) ) {
										$runtime = intdiv( $minutes, 60 ) . __( ' hr ', 'screen-time' ) . ( $minutes % 60 ) . __( ' min', 'screen-time' );
										?>
											<div class="st-am-stats-list-item secondary-text-primary-font st-am-runtime-text"> <!-- runtime-text -->
												<?php echo esc_html( $runtime ); ?>
											</div> <!-- /runtime-text -->
											<?php
									}
									?>
									</div> <!-- /trending-movies-list-item-content-heading-container -->


									<div class="st-am-trending-movies-list-item-content-stats-container"> <!-- trending-movies-list-item-content-stats-container -->

										<div class="st-am-genres-container"> <!-- genres-container -->
										<?php
										$genres = get_the_terms( $movie->ID, 'rt-movie-genre' );
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
										<?php
										$release_year = get_post_meta( $movie->ID, 'rt-movie-meta-basic-release-date', true );
										if ( ! empty( $release_year ) ) {
											$date         = DateTime::createFromFormat( 'Y-m-d', $release_year );
											$release_year = $date->format( 'Y' );
											?>
											<div class="st-am-stats-list-item secondary-text-primary-font st-am-release-date-text"> <!-- release-date-text -->
													<?php echo esc_html( $release_year ); ?>
												</div> <!-- /release-date-text -->
											<?php
										}
										?>
									</div> <!-- /trending-movies-list-item-content-stats-container -->
								</div> <!-- /trending-movies-list-item-content-container -->
							</div> <!-- /trending-movies-list-item -->
						</a>
						<?php
					endforeach;
					?>
				</div> <!-- /trending-movies-list -->
			</div> <!-- /trending-movies-list-container -->
		</div> <!-- /trending-movies-container -->
