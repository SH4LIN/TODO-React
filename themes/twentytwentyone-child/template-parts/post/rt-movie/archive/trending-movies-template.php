<?php
/**
 * This file is used to display the trending movies on the archive page of the rt-movie post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */
$movies = $args['movies'];
?>
<div class="st-am-trending-movies-container">
			<div class="st-am-trending-movies-heading-container">
				<div class="primary-text-secondary-font section-heading-text">
					<?php esc_html_e( 'Trending Movies' ); ?>
				</div>
			</div>

			<div class="st-am-trending-movies-list-container">
				<div class="st-am-trending-movies-list">
					<?php
					foreach ( $movies as $movie ) {


						?>
							<div class="st-am-trending-movies-list-item">
								<div class="st-am-trending-movies-list-item-image-container">
									<img src="<?php echo esc_url( get_the_post_thumbnail_url( $movie->ID, 'full' ) ); ?>" class="st-am-trending-movies-list-item-image">
								</div>

								<div class="st-am-trending-movies-list-item-content-container">
									<div class="st-am-trending-movies-list-item-content-heading-container">
										<div class="primary-text-primary-font st-am-movie-title-text">
										<?php echo esc_html( get_the_title( $movie->ID ) ); ?>
										</div>

									<?php
									$minutes = get_post_meta( $movie->ID, 'rt-movie-meta-basic-runtime', true );
									if ( ! empty( $minutes ) ) {
										$runtime = intdiv( $minutes, 60 ) . __( ' hr ' ) . ( $minutes % 60 ) . __( ' min' );
										?>
											<div class="st-am-stats-list-item secondary-text-primary-font st-am-runtime-text">
											<?php echo esc_html( $runtime ); ?>
											</div>
											<?php
									}
									?>
									</div>


									<div class="st-am-trending-movies-list-item-content-stats-container">

										<div class="st-am-genres-container">
										<?php
										$genres = get_the_terms( $movie->ID, 'rt-movie-genre' );
										if ( ! empty( $genres ) ) {
											foreach ( $genres as $genre ) {
												?>
													<div class="secondary-text-primary-font st-am-genre-text">
													<?php echo esc_html( $genre->name ); ?>
													</div>
													<?php
											}
										}
										?>
											</div>
										<?php
										$release_year = get_post_meta( $movie->ID, 'rt-movie-meta-basic-release-date', true );
										if ( ! empty( $release_year ) ) {
											$date         = DateTime::createFromFormat( 'Y-m-d', $release_year );
											$release_year = $date->format( 'Y' );
											?>
											<div class="st-am-stats-list-item secondary-text-primary-font st-am-release-date-text">
													<?php echo esc_html( $release_year ); ?>
												</div>
											<?php
										}
										?>
									</div>
								</div>
							</div>
							<?php
					}
					?>
				</div>
			</div>
		</div>
