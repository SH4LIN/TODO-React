<?php
/**
 * This file will be used to display the rt-movie post related info like
 * poster, title, rating, synopsis
 * in the single rt-movie post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */

?>

<div class="st-sm-info-container">

		<div class="st-sm-poster">
			<?php the_post_thumbnail( 'large' ); ?>
		</div>

		<div class="st-sm-info-stats-container">
			<div class="primary-text-heading-font st-sm-title">
				<?php the_title(); ?>
			</div>

			<ul class="st-sm-stats-items">
				<?php
				$rating = get_post_meta( get_the_ID(), 'rt-movie-meta-basic-rating', true );
				if ( ! empty( $rating ) ) {
					$rating = $rating . '/10';
					?>
					<li class="st-sm-stats-list-item st-sm-rating">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_star.svg' ); ?>"/>
						<span class="primary-text-primary-font st-sm-rating-text"><?php echo esc_html( $rating ); ?></span>
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
					<li class="st-sm-stats-list-item st-sm-release-date">
								<span class="primary-text-primary-font st-sm-release-date-text"><?php echo esc_html( $release_year ); ?></span>
							</li>
					<?php
				}
				?>

				<?php
				$content_rating = 'PG-13';
				if ( ! empty( $content_rating ) ) {
					?>
					<li class="st-sm-stats-list-item st-sm-content-rating">
								<span class="primary-text-primary-font st-sm-content-rating-text"><?php echo esc_html( $content_rating ); ?></span>
							</li>
					<?php
				}
				?>

				<?php
				$minutes = get_post_meta( get_the_ID(), 'rt-movie-meta-basic-runtime', true );
				if ( ! empty( $minutes ) ) {
					$runtime = intdiv( $minutes, 60 ) . __( 'H ' ) . ( $minutes % 60 ) . __( 'M' );
					?>
					<li class="st-sm-stats-list-item st-sm-runtime">
								<span class="primary-text-primary-font st-sm-runtime-text"><?php echo esc_html( $runtime ); ?></span>
							</li>
					<?php
				}
				?>
			</ul>

		<div class="primary-text-primary-font st-sm-description">
			<?php the_excerpt(); ?>
		</div>

		<div class="st-sm-genres-container">
			<?php
			$genres = get_the_terms( get_the_ID(), 'rt-movie-genre' );
			if ( ! empty( $genres ) ) {
				foreach ( $genres as $genre ) {
					?>
					<div class="primary-text-primary-font st-sm-genre-item">
						<?php echo esc_html( $genre->name ); ?>
					</div>
					<?php
				}
			}
			?>
		</div>

		<div class="st-sm-directors-container">
			<?php
			$directors = get_post_meta( get_the_ID(), 'rt-movie-meta-crew-director' );
			if ( ! empty( $directors ) ) {
				?>
				<span class="primary-text-primary-font st-sm-director-text"> <?php esc_html_e( 'Directors:' ); ?></span>
					<?php
					foreach ( $directors[0] as $director ) {
						?>
					<span class="primary-text-primary-font st-sm-director-item">
							<?php echo esc_html( ( get_the_title( $director ['person_id'] ) ) ); ?>
						</span>
						<?php
					}
			}
			?>
		</div>

		<div class="st-sm-watch-trailer-container">
			<div class="ic-play-circle-container">
				<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_play.svg' ); ?>"/>
			</div>
			<div class="st-sm-watch-trailer-text-container">
				<p class="primary-text-primary-font st-sm-watch-trailer-text"> <?php esc_html_e( 'Watch Trailer' ); ?></p>
			</div>
		</div>

	</div>
</div>
