<?php
/**
 * This file is used to display the upcoming movies sections of the archive page of the rt-movie post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */
$movies = $args['movies'];
?>
<div class="st-am-upcoming-movies-container">
			<div class="st-am-upcoming-movies-heading-container">
				<div class="primary-text-secondary-font section-heading-text">
					<?php esc_html_e( 'Upcoming Movies' ); ?>
				</div>
			</div>

			<div class="st-am-upcoming-movies-list-container">
				<div class="st-am-upcoming-movies-list">
					<?php

					foreach ( $movies as $movie ) {
						?>
							<div class="st-am-upcoming-movies-list-item">
								<div class="st-am-upcoming-movies-list-item-image-container">
									<img src="<?php echo esc_url( get_the_post_thumbnail_url( $movie->ID, 'full' ) ); ?>" class="st-am-upcoming-movies-list-item-image">
								</div>

								<div class="st-am-upcoming-movies-list-item-content-container">
									<div class="st-am-upcoming-movies-list-item-content-heading-container">
										<div class="primary-text-primary-font st-am-movie-title-text">
											<?php echo esc_html( get_the_title( $movie->ID ) ); ?>
										</div>

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
									</div>


									<div class="st-am-upcoming-movies-list-item-content-stats-container">
										<?php
										$release_year = get_post_meta( $movie->ID, 'rt-movie-meta-basic-release-date', true );
										if ( ! empty( $release_year ) ) {
											$formatted_date = date( 'jS M Y', strtotime( $release_year ) );
											?>
												<div class="st-am-stats-list-item secondary-text-primary-font st-am-release-date-text">
													<?php echo esc_html__( 'Release: ' ) . esc_html( $formatted_date ); ?>
												</div>
												<?php
										}
										?>

										<?php
										$content_rating = 'PG-13';
										if ( ! empty( $content_rating )
										) {
											?>
											<div class="st-am-stats-list-item secondary-text-primary-font st-am-content-rating-text">
													<?php echo esc_html( $content_rating ); ?>
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
