<?php
/**
 * This file is used to display the trending movies on the archive page of the rt-movie post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */

?>
<div class="st-am-trending-movies-container">
			<div class="st-am-trending-movies-heading-container">
				<div class="primary-text-heading-font st-sm-plot-heading">
					<?php esc_html_e( 'Trending Movies' ); ?>
				</div>
			</div>

			<div class="st-am-trending-movies-list-container">
				<div class="st-am-trending-movies-list">
					<?php
					if ( have_posts() ) {
						$image_counter = 0;
						while ( have_posts() && $image_counter < 6 ) {
							$image_counter++;
							the_post();
							?>
							<div class="st-am-trending-movies-list-item">
								<div class="st-am-trending-movies-list-item-image-container">
									<img src="<?php echo esc_url( get_the_post_thumbnail_url() ); ?>" class="st-am-trending-movies-list-item-image">
								</div>

								<div class="st-am-trending-movies-list-item-content-container">
									<div class="st-am-trending-movies-list-item-content-heading-container">
										<div class="primary-text-primary-font st-am-movie-title-text">
											<?php the_title(); ?>
										</div>

										<?php
										$minutes = get_post_meta( get_the_ID(), 'rt-movie-meta-basic-runtime', true );
										if ( ! empty( $minutes ) ) {
											$runtime = intdiv( $minutes, 60 ) . __( ' hr ' ) . ( $minutes % 60 ) . __( ' min' );
											?>
											<div class="st-am-stats-list-item st-am-runtime">
												<span class="primary-text-primary-font st-am-runtime-text"><?php echo esc_html( $runtime ); ?></span>
											</div>
											<?php
										}
										?>
									</div>


									<div class="st-am-trending-movies-list-item-content-stats-container">

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
										<?php
										$release_year = get_post_meta( get_the_ID(), 'rt-movie-meta-basic-release-date', true );
										if ( ! empty( $release_year ) ) {
											$date         = DateTime::createFromFormat( 'Y-m-d', $release_year );
											$release_year = $date->format( 'Y' );
											?>
											<div class="st-am-stats-list-item st-am-release-date">
													<span class="primary-text-primary-font st-am-release-date-text"><?php echo esc_html( $release_year ); ?></span>
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
