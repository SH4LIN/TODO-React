<?php
/**
 * This file is used to display the popular movies of the specific person from the rt-person post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

use MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box;
use MovieLib\admin\classes\taxonomies\Movie_Genre;

if ( ! isset( $args['id'] ) || ! isset( $args['movies'] ) ) {
	return;
}

$popular_movies = $args['movies'];

if ( ! empty( $popular_movies ) ) : ?>
	<div class="st-sp-popular-movies-container">
		<div class="st-sp-popular-movies-heading-container">
			<p class="primary-text-secondary-font section-heading-text">
				<?php esc_html_e( 'Popular Movies', 'screen-time' ); ?>
			</p>
		</div>

		<div class="st-sp-popular-movies-items-container">
			<?php foreach ( $popular_movies as $popular_movie ) : ?>
				<div class="st-sp-popular-movie-item-container">
					<div class="st-sp-popular-movie-item-poster-container">
						<?php
						if ( has_post_thumbnail( $popular_movie->ID ) ) {
							echo wp_kses_post( get_the_post_thumbnail( $popular_movie->ID ) );
						} else {
							?>
							<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/placeholder.webp' ); ?>" />
							<?php
						}
						?>
					</div>

					<div class="st-sp-popular-movie-item-info-container">
						<div class="st-sp-popular-movie-item-name-runtime-container">
							<div class="st-sp-popular-movie-item-name-container">
								<p class="primary-text-primary-font st-sp-popular-movie-title">
									<?php echo esc_html( get_the_title( $popular_movie->ID ) ); ?>
								</p>
							</div>

							<div class="st-sp-popular-movie-item-runtime-container">
								<p class="secondary-text-primary-font st-sp-popular-movie-runtime">
								<?php
								$minutes           = get_post_meta( $popular_movie->ID, RT_Movie_Meta_Box::MOVIE_META_BASIC_RUNTIME_SLUG, true );
								$hours             = floor( $minutes / 60 );
								$remaining_minutes = $minutes % 60;

								$formatted_time = sprintf( '%d hr %02d min', $hours, $remaining_minutes );

								echo esc_html( $formatted_time );
								?>
								</p>
							</div>
						</div>

						<div class="st-sp-popular-movie-item-genre-release-container">
							<?php
							$genres = get_the_terms( $popular_movie->ID, Movie_Genre::SLUG );
							if ( is_array( $genres ) && count( $genres ) > 0 ) :
								?>
								<div class="st-sp-popular-movie-item-genre-container">
									<ul class="st-sp-popular-movie-item-genre-list">
										<?php
										foreach ( $genres as $genre ) :
											?>
											<li class="st-sp-popular-movie-item-genre-item secondary-text-primary-font st-sp-popular-movie-item-genre">
												<?php echo esc_html( $genre->name ); ?>
											</li>
											<?php
										endforeach;
										?>
									</ul>
								</div>
							<?php endif; ?>

							<div class="st-sp-popular-movie-item-release-container">
								<p class="secondary-text-primary-font st-sp-popular-movie-release">
									<?php
									$release_date_str = get_post_meta( $popular_movie->ID, RT_Movie_Meta_Box::MOVIE_META_BASIC_RELEASE_DATE_SLUG, true );

									$release_year = DateTime::createFromFormat( 'Y-m-d', $release_date_str )->format( 'Y' );

									echo esc_html( $release_year );
									?>
								</p>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>
