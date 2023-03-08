<?php
/**
 * This file is template for the single rt-movie post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */

get_header();
// Start the Loop.
while ( have_posts() ) :
	the_post();
	?>



	<div class="screen-time-single-movie-info-container">

		<div class="screen-time-single-movie-poster">
			<?php the_post_thumbnail( 'large' ); ?>
		</div>

		<div class="screen-time-single-movie-info-stats-container">
			<div class="primary-text-heading-font screen-time-single-movie-title">
				<?php the_title(); ?>
			</div>

			<ul class="screen-time-single-movie-stats-items">
				<?php
				$rating = get_post_meta( get_the_ID(), 'rt-movie-meta-basic-rating', true );
				if ( ! empty( $rating ) ) {
					$rating = $rating . '/10';
					?>
					<li class="screen-time-single-movie-stats-list-item screen-time-single-movie-rating">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_star.svg' ); ?>"/>
						<span class="primary-text-primary-font screen-time-single-movie-rating-text"><?php echo esc_html( $rating ); ?></span>
					</li>
					<?php
				}
				?>

				<?php
				$release_year = get_post_meta( get_the_ID(), 'rt-movie-meta-basic-release-date', true );
				if ( ! empty( $release_year ) ) {
					$date         = DateTime::createFromFormat( 'Y-m-d', $release_year );
					$release_year = $date->format( 'Y' );
					?>
					<li class="screen-time-single-movie-stats-list-item screen-time-single-movie-release-date">
								<span class="primary-text-primary-font screen-time-single-movie-release-date-text"><?php echo esc_html( $release_year ); ?></span>
							</li>
					<?php
				}
				?>

				<?php
				$content_rating = 'PG-13';
				if ( ! empty( $content_rating ) ) {
					?>
					<li class="screen-time-single-movie-stats-list-item screen-time-single-movie-content-rating">
								<span class="primary-text-primary-font screen-time-single-movie-content-rating-text"><?php echo esc_html( $content_rating ); ?></span>
							</li>
					<?php
				}
				?>

				<?php
				$minutes = get_post_meta( get_the_ID(), 'rt-movie-meta-basic-runtime', true );
				if ( ! empty( $minutes ) ) {
					$runtime = intdiv( $minutes, 60 ) . __( 'H ' ) . ( $minutes % 60 ) . __( 'M' );
					?>
					<li class="screen-time-single-movie-stats-list-item screen-time-single-movie-runtime">
								<span class="primary-text-primary-font screen-time-single-movie-runtime-text"><?php echo esc_html( $runtime ); ?></span>
							</li>
					<?php
				}
				?>
			</ul>

		<div class="primary-text-primary-font screen-time-single-movie-description">
			<?php the_excerpt(); ?>
		</div>

		<div class="screen-time-single-movie-genres-container">
			<?php
			$genres = get_the_terms( get_the_ID(), 'rt-movie-genre' );
			if ( ! empty( $genres ) ) {
				foreach ( $genres as $genre ) {
					?>
					<div class="primary-text-primary-font screen-time-single-movie-genre-item">
						<?php echo esc_html( $genre->name ); ?>
					</div>
					<?php
				}
			}
			?>
		</div>

		<div class="screen-time-single-movie-directors-container">
			<?php
					$directors = get_post_meta( get_the_ID(), 'rt-movie-meta-crew-director' );
			if ( ! empty( $directors ) ) {
				?>
				<span class="primary-text-primary-font screen-time-single-movie-director-text"> <?php esc_html_e( 'Directors:' ); ?></span>
					<?php
					foreach ( $directors[0] as $director ) {
						?>
						<span class="primary-text-primary-font screen-time-single-movie-director-item">
							<?php echo esc_html( ( get_the_title( $director ['person_id'] ) ) ); ?>
						</span>
						<?php
					}
			}
			?>
		</div>

		<div class="screen-time-single-movie-watch-trailer-container">
			<div class="ic-play-circle-container">
				<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_play.svg' ); ?>"/>
			</div>
			<div class="screen-time-single-movie-watch-trailer-text-container">
				<p class="primary-text-primary-font screen-time-single-movie-watch-trailer-text"> <?php esc_html_e( 'Watch Trailer' ); ?></p>
			</div>
		</div>

	</div>
</div>

<div class="screen-time-single-movie-plot-quick-links-container">
	<div class="st-sm-plot-container">
		<div class="primary-text-heading-font st-sm-plot-heading">
			<?php esc_html_e( 'Plot' ); ?>
		</div>
		<div class="primary-text-primary-font st-sm-plot-text">
			<?php the_content(); ?>
		</div>
	</div>

	<div class="st-sm-quick-links-container">
		<div class="primary-text-heading-font st-sm-quick-links-heading">
			<?php esc_html_e( 'Quick Links' ); ?>
		</div>
		<div class="st-sm-quick-links-list-container">
			<ul class="st-sm-quick-links-list">
				<li class="st-sm-quick-links-list-item">
					<a href="#" class="primary-text-primary-font st-sm-quick-links-list-item-link">
						<?php esc_html_e( 'Synopsis' ); ?>
					</a>
				</li>
				<li class="st-sm-quick-links-list-item">
					<a href="#" class="primary-text-primary-font st-sm-quick-links-list-item-link">
						<?php esc_html_e( 'Cast & Crew' ); ?>
					</a>
				</li>
				<li class="st-sm-quick-links-list-item">
					<a href="#" class="primary-text-primary-font st-sm-quick-links-list-item-link">
						<?php esc_html_e( 'Snapshots' ); ?>
					</a>
				</li>
				<li class="st-sm-quick-links-list-item">
					<a href="#" class="primary-text-primary-font st-sm-quick-links-list-item-link">
						<?php esc_html_e( 'Trailer & Clips' ); ?>
					</a>
				</li>
				<li class="st-sm-quick-links-list-item">
					<a href="#" class="primary-text-primary-font st-sm-quick-links-list-item-link">
						<?php esc_html_e( 'Reviews' ); ?>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>

<div class="st-sm-cast-crew-container">
	<div class="st-sm-cast-crew-heading-container">
		<div class="primary-text-heading-font st-sm-cast-crew-heading">
			<?php esc_html_e( 'Cast & Crew' ); ?>
		</div>

		<div class="st-sm-cast-crew-view-all-container">
			<a href="#" class="primary-text-primary-font st-sm-cast-crew-view-all-link">
				<?php esc_html_e( 'View All' ); ?>
			</a>
		</div>
	</div>

	<div class="st-sm-cast-crew-list-container">
		<div class="st-sm-cast-crew-list-items">
			<?php
			$cast = get_post_meta( get_the_ID(), 'rt-movie-meta-crew-actor' );
			if ( ! empty( $cast ) ) {
				foreach ( $cast[0] as $cast_member ) {
					?>
					<div class="st-sm-cast-crew-list-item">
						<div class="st-sm-cast-crew-list-item-image-container">
							<img src="<?php echo esc_url( get_the_post_thumbnail_url( $cast_member['person_id'] ) ); ?>" class="st-sm-cast-crew-list-item-image"/>
						</div>
						<div class="st-sm-cast-crew-list-item-name-container">
							<span class="primary-text-primary-font st-sm-cast-crew-list-item-name">
								<?php echo esc_html( get_the_title( $cast_member['person_id'] ) ); ?>
							</span>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
</div>

<div class="st-sm-snapshots-container">
	<div class="st-sm-snapshots-heading-container">
		<div class="primary-text-heading-font st-sm-snapshots-heading">
			<?php esc_html_e( 'Snapshots' ); ?>
		</div>
	</div>

	<div class="st-sm-snapshots-list-container">
		<div class="st-sm-snapshots-list-items">
			<?php
			$snapshots = get_post_meta( get_the_ID(), 'rt-media-meta-images' );
			if ( ! empty( $snapshots ) ) {
				foreach ( $snapshots[0] as $snapshot ) {
					?>
					<div class="st-sm-snapshots-list-item">
						<div class="st-sm-snapshots-list-item-image-container">
							<img src="<?php echo esc_url( wp_get_attachment_url( $snapshot ) ); ?>" class="st-sm-snapshots-list-item-image"/>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
</div>

<div class="st-sm-trailer-clips-container">
	<div class="st-sm-trailer-clips-heading-container">
		<div class="primary-text-heading-font st-sm-trailer-clips-heading">
			<?php esc_html_e( 'Trailer & Clips' ); ?>
		</div>
	</div>

	<div class="st-sm-trailer-clips-list-container">
		<div class="st-sm-trailer-clips-list-items">
			<?php
			$trailer_clips = get_post_meta( get_the_ID(), 'rt-media-meta-videos' );
			if ( ! empty( $trailer_clips ) ) {
				foreach ( $trailer_clips[0] as $trailer_clip ) {
					?>
					<div class="st-sm-trailer-clips-list-item">
						<div class="st-sm-trailer-clips-list-item-image-container">
							<img src="<?php echo esc_url( wp_get_attachment_url( $trailer_clip ) ); ?>" class="st-sm-trailer-clips-list-item-image"/>
						</div>

					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
</div>

<div class="st-sm-reviews-container">
	<div class="st-sm-reviews-heading-container">
		<div class="primary-text-heading-font st-sm-reviews-heading">
			<?php esc_html_e( 'Reviews' ); ?>
		</div>
	</div>

	<div class="st-sm-reviews-list-container">
		<div class="st-sm-reviews-list-items">
			<?php
			$reviews = get_post_meta( get_the_ID(), 'rt-movie-meta-reviews' );
			if ( ! empty( $reviews ) ) {
				foreach ( $reviews[0] as $review ) {
					?>
					<div class="st-sm-reviews-list-item">
						<div class="st-sm-reviews-list-item-image-container">
							<img src="<?php echo esc_url( $review['image'] ); ?>" class="st-sm-reviews-list-item-image"/>
						</div>
						<div class="st-sm-reviews-list-item-content-container">
							<div class="st-sm-reviews-list-item-content">
								<?php echo esc_html( $review['content'] ); ?>
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
	<?php
	endwhile; // End the loop.
get_footer();
?>
