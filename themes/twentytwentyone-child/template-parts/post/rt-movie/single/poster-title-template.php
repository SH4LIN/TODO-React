<?php
/**
 * This file will be used to display the rt-movie post related info like
 * poster, title, rating, synopsis
 * in the single rt-movie post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since 1.0.0
 */

if (
	! isset( $args['id'] ) ||
	! isset( $args['name'] ) ||
	! isset( $args['poster'] ) ||
	! isset( $args['rating'] ) ||
	! isset( $args['release_year'] ) ||
	! isset( $args['content_rating'] ) ||
	! isset( $args['runtime'] ) ||
	! isset( $args['genres'] ) ||
	! isset( $args['synopsis'] ) ||
	! isset( $args['directors'] )
) {
	return;
}

?>

<div class="st-sm-info-container">

		<div class="st-sm-poster-container">
			<img src="<?php echo esc_url( $args['poster'] ); ?>" />
		</div>

		<div class="st-sm-info-stats-container">
			<div class="primary-text-secondary-font st-sm-title">
				<?php echo esc_html( $args['name'] ); ?>
			</div>

			<div class="st-sm-stats-items">
				<?php
				if ( ! empty( $args['rating'] ) ) :
					?>
					<div class="st-sm-stats-list-item st-sm-rating">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_star.svg' ); ?>"/>
						<span class="primary-text-primary-font st-sm-rating-text"><?php echo esc_html( $args['rating'] ); ?></span>
					</div>
					<?php
				endif;
				?>

				<?php
				if ( ! empty( $args['release_year'] ) ) :
					?>
					<div class="st-sm-stats-list-item st-sm-release-date">
						<span class="primary-text-primary-font st-sm-release-date-text"><?php echo esc_html( $args['release_year'] ); ?></span>
					</div>
					<?php
				endif;
				?>

				<?php
				if ( ! empty( $args['content_rating'] ) ) :
					?>
					<div class="st-sm-stats-list-item st-sm-content-rating">
						<span class="primary-text-primary-font st-sm-content-rating-text"><?php echo esc_html( $args['content_rating'] ); ?></span>
					</div>
					<?php
				endif;
				?>

				<?php
				if ( ! empty( $args['runtime'] ) ) :
					?>
					<div class="st-sm-stats-list-item st-sm-runtime">
						<span class="primary-text-primary-font st-sm-runtime-text"><?php echo esc_html( $args['runtime'] ); ?></span>
					</div>
					<?php
				endif;
				?>
			</div>


			<?php
			if ( ! empty( $args['genres'] ) ) :
				?>
				<div class="st-sm-genres-container">
					<?php
					foreach ( $args['genres'] as $genre ) :
						?>
						<div class="primary-text-primary-font st-sm-genre-item-container">
							<?php echo esc_html( $genre->name ); ?>
						</div>
						<?php
					endforeach;
					?>
				</div>
				<?php
			endif;
			?>


			<?php
			if ( ! empty( $args['synopsis'] ) ) :
				?>
				<div class="primary-text-primary-font st-sm-description-container">
					<?php echo esc_html( $args['synopsis'] ); ?>
				</div>
				<?php
			endif;
			?>



			<?php
			if ( ! empty( $args['directors'] ) && ! empty( $args['directors'][0] ) ) :
				?>
				<div class="st-sm-directors-container">
					<span class="primary-text-primary-font st-sm-director-text"> <?php esc_html_e( 'Directors:', 'screen-time' ); ?></span>
					<ul class="st-sm-director-list">
						<?php
						foreach ( $args['directors'][0] as $director ) :
							?>
							<li class="primary-text-primary-font st-sm-director-item">
								<?php echo esc_html( ( get_the_title( $director ['person_id'] ) ) ); ?>
							</li>
							<?php
						endforeach;
						?>
					</ul>
				</div>
				<?php
			endif;
			?>


			<div class="st-sm-watch-trailer-container">
				<div class="ic-play-circle-container">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_play.svg' ); ?>"/>
				</div>
				<div class="st-sm-watch-trailer-text-container">
					<p class="primary-text-primary-font st-sm-watch-trailer-text"> <?php esc_html_e( 'Watch Trailer', 'screen-time' ); ?></p>
				</div>
			</div>

	</div>
</div>
