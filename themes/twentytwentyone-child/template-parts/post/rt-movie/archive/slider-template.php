<?php
/**
 * This file is used to display the slider on the archive page of the rt-movie post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */

use MovieLib\admin\classes\meta_boxes\RT_Media_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box;
use MovieLib\admin\classes\taxonomies\Movie_Genre;

$movies        = $args['movies'];
$movie_details = array();

foreach ( $movies as $movie ) {
	$movie_detail = array();

	$movie_detail['id']    = $movie->ID;
	$movie_detail['title'] = $movie->post_title;

	$movie_detail['synopsis'] = null;
	if ( ! empty( $movie->post_excerpt ) ) {
		$movie_detail['synopsis'] = $movie->post_excerpt;
	}

	$movie_detail['release_year'] = null;

	$release_date_str = get_post_meta( $movie->ID, RT_Movie_Meta_Box::MOVIE_META_BASIC_RELEASE_DATE_SLUG, true );

	if ( ! empty( $release_date_str ) ) {
		$release_year = DateTime::createFromFormat( 'Y-m-d', $release_date_str )->format( 'Y' );

		$movie_detail['release_year'] = $release_year;
	}

	$movie_detail['age_rating'] = 'PG-13';

	$movie_detail['runtime'] = null;

	$minutes = get_post_meta( $movie->ID, RT_Movie_Meta_Box::MOVIE_META_BASIC_RUNTIME_SLUG, true );
	if ( ! empty( $minutes ) ) {
		$hours             = floor( $minutes / 60 );
		$remaining_minutes = $minutes % 60;

		$formatted_time = sprintf( '%dH %02dM', $hours, $remaining_minutes );

		$movie_detail['runtime'] = $formatted_time;
	}


	$movie_detail['genre'] = null;

	$genres = get_the_terms( $movie->ID, Movie_Genre::SLUG );

	if ( $genres && is_array( $genres ) && count( $genres ) > 0 ) {
		$movie_detail['genre'] = $genres;
	}

	$movie_detail['banner'] = get_stylesheet_directory_uri() . '/assets/images/placeholder-banner.png';

	$banner_image = get_post_meta( $movie->ID, RT_Media_Meta_Box::BANNER_IMAGES_SLUG, true );

	if ( ! empty( $banner_image ) ) {
		$banner_image_url = wp_get_attachment_image_url( $banner_image[0], 'full' );
		if ( $banner_image_url ) {
			$movie_detail['banner'] = $banner_image_url;
		}
	}

	$movie_details[] = $movie_detail;
}

$count = count( $movie_details );

?>
<div class="st-am-slider-container">
	<ul class="st-am-slider">
		<?php
		$i = 0;
		foreach ( $movie_details as $movie ) :
			?>
			<li class="st-am-slider-item">
				<div class="st-am-slider-item-image-container">
					<img src="<?php echo esc_url( $movie['banner'] ); ?>" class="st-am-slider-item-image">
				</div>

				<div class="st-am-slider-item-movie-info-container">
					<div class="primary-text-secondary-font st-am-slider-item-image-title">
						<?php echo esc_html( $movie['title'] ); ?>
					</div>

					<?php if ( ! empty( $movie['synopsis'] ) ) : ?>
						<div class="primary-text-primary-font st-am-slider-item-image-synopsis">
							<?php echo esc_html( $movie['synopsis'] ); ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $movie['release_year'] ) || ! empty( $movie['age_rating'] ) || ! empty( $movie['runtime'] ) ) : ?>
						<div class="st-am-slider-item-movie-stats-container">
							<ul class="st-am-slider-item-movie-stats">
								<?php if ( ! empty( $movie['release_year'] ) ) : ?>
								<li class="primary-text-primary-font st-am-slider-item-movie-stat">
									<?php echo esc_html( $movie['release_year'] ); ?>
								</li>
								<?php endif; ?>

								<?php if ( ! empty( $movie['age_rating'] ) ) : ?>
									<li class="primary-text-primary-font st-am-slider-item-movie-stat">
										<?php echo esc_html( $movie['age_rating'] ); ?>
									</li>
								<?php endif; ?>

								<?php if ( ! empty( $movie['runtime'] ) ) : ?>
									<li class="primary-text-primary-font st-am-slider-item-movie-stat">
										<?php echo esc_html( $movie['runtime'] ); ?>
								</li>
								<?php endif; ?>
							</ul>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $movie['genre'] ) ) : ?>
						<div class="st-am-slider-item-movie-genre-container">
							<?php foreach ( $movie['genre'] as $genre ) : ?>
								<div class="primary-text-primary-font st-am-slider-item-movie-genre">
									<?php echo esc_html( $genre->name ); ?>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>

			</li>
			<?php
			++$i;
		endforeach;
		?>
	</ul>

	<div class="slider-dots-container">
		<?php
		for ( $i = 0; $i < $count; $i++ ) {
			?>
			<div class="st-am-slider-dots 
			<?php
			if ( $i === 0 ) :
				echo esc_attr( 'active' );
			endif;
			?>
			" data-position="<?php echo esc_attr( $i ); ?>">

			</div>
			<?php
		}
		?>
	</div>
</div>
