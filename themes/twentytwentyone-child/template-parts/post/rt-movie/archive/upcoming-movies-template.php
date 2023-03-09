<?php
/**
 * This file is used to display the upcoming movies sections of the archive page of the rt-movie post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */

?>
<div class="st-am-upcoming-movies-container">
			<div class="st-am-upcoming-movies-heading-container">
				<div class="primary-text-heading-font st-sm-plot-heading">
					<?php esc_html_e( 'Upcoming Movies' ); ?>
				</div>
			</div>

			<div class="st-am-upcoming-movies-list-container">
				<div class="st-am-upcoming-movies-list">
					<?php
					if ( have_posts() ) {
						$image_counter = 0;
						while ( have_posts() && $image_counter < 6 ) {
							$image_counter++;
							the_post();
							?>
							<div class="st-am-upcoming-movies-list-item">
								<div class="st-am-upcoming-movies-list-item-image-container">
									<img src="<?php echo esc_url( get_the_post_thumbnail_url() ); ?>" class="st-am-upcoming-movies-list-item-image">
								</div>

								<div class="st-am-upcoming-movies-list-item-content-container">
									<div class="st-am-upcoming-movies-list-item-content-heading-container">
										<div class="primary-text-primary-font st-am-movie-title-text">
											<?php the_title(); ?>
										</div>

										<div class="st-am-genres-container">
											<?php
											$genres = get_the_terms( get_the_ID(), 'rt-movie-genre' );
											if ( ! empty( $genres ) ) {
												foreach ( $genres as $genre ) {
													?>
													<div class="primary-text-primary-font st-am-genre-text">
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
											$release_year = get_post_meta( get_the_ID(), 'rt-movie-meta-basic-release-date', true );
											if ( ! empty( $release_year ) ) {
												$formatted_date = date( 'jS M Y', strtotime( $release_year ) );
												?>
												<div class="st-am-stats-list-item st-am-release-date">
													<span class="primary-text-primary-font st-am-release-date-text"><?php echo esc_html__( 'Release: ' ) . esc_html( $formatted_date ); ?></span>
												</div>
												<?php
											}
											?>

										<?php
										$content_rating = 'PG-13';
										if ( ! empty( $content_rating )
										) {
											?>
											<div class="st-am-stats-list-item st-am-content-rating">
													<span class="primary-text-primary-font st-am-content-rating-text"><?php echo esc_html( $content_rating ); ?></span>
												</div>
											<?php
										}
										?>
									</div>
								</div>
							</div>
							<?php
						}
					}
					?>
				</div>
			</div>
		</div>
