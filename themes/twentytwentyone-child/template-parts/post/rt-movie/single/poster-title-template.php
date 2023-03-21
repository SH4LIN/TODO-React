<?php
/**
 * This file will be used to display the rt-movie post related info like
 * poster, title, rating, synopsis
 * in the single rt-movie post type.
 *
 * @package Twenty_Twenty_One_Child
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
	! isset( $args['trailer'] ) ||
	! isset( $args['directors'] )
) {
	return;
}

?>

<div class="st-sm-info-container"> <!-- info-container -->

	<div class="st-sm-poster-container"> <!-- poster-container -->
		<img src="<?php echo esc_url( $args['poster'] ); ?>" />
	</div>  <!-- /poster-container -->

	<div class="st-sm-info-stats-container"> <!-- info-stats-container -->
		<div class="primary-text-secondary-font st-sm-title"> <!-- title -->
			<?php echo esc_html( $args['name'] ); ?>
		</div> <!-- /title -->

		<div class="st-sm-stats-items"> <!-- stats-items -->
			<?php
			if ( ! empty( $args['rating'] ) ) :
				?>
				<div class="st-sm-stats-list-item st-sm-rating"> <!-- rating -->
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_star.svg' ); ?>" loading="lazy" />
					<span class="primary-text-primary-font st-sm-rating-text"> <!-- rating-text -->
						<?php echo esc_html( $args['rating'] ); ?>
					</span> <!-- /rating-text -->
				</div> <!-- /rating -->
				<?php
			endif;
			?>

			<?php
			if ( ! empty( $args['release_year'] ) ) :
				?>
				<div class="st-sm-stats-list-item st-sm-release-date"> <!-- release-date -->
					<span class="primary-text-primary-font st-sm-release-date-text"> <!-- release-date-text -->
						<?php echo esc_html( $args['release_year'] ); ?>
					</span> <!-- /release-date-text -->
				</div> <!-- /release-date -->
				<?php
			endif;
			?>

			<?php
			if ( ! empty( $args['content_rating'] ) ) :
				?>
				<div class="st-sm-stats-list-item st-sm-content-rating"> <!-- content-rating -->
					<span class="primary-text-primary-font st-sm-content-rating-text"> <!-- content-rating-text -->
						<?php echo esc_html( $args['content_rating'] ); ?>
					</span> <!-- /content-rating-text -->
				</div> <!-- /content-rating -->
				<?php
			endif;
			?>

			<?php
			if ( ! empty( $args['runtime'] ) ) :
				?>
				<div class="st-sm-stats-list-item st-sm-runtime"> <!-- runtime -->
					<span class="primary-text-primary-font st-sm-runtime-text"> <!-- runtime-text -->
						<?php echo esc_html( $args['runtime'] ); ?>
					</span> <!-- /runtime-text -->
				</div> <!-- /runtime -->
				<?php
			endif;
			?>
		</div> <!-- /stats-items -->

		<?php
		if ( ! empty( $args['genres'] ) ) :
			?>
			<div class="st-sm-genres-container"> <!-- genres-container -->
				<?php
				foreach ( $args['genres'] as $genre ) :
					?>
					<a href="<?php echo esc_url( get_term_link( $genre ) ); ?>">
						<p class="primary-text-primary-font"> <!-- genre-item-container -->
							<?php echo esc_html( $genre->name ); ?>
						</p> <!-- /genre-item-container -->
					</a>
					<?php
				endforeach;
				?>
			</div> <!-- /genres-container -->
			<?php
		endif;
		?>

		<?php
		if ( ! empty( $args['synopsis'] ) ) :
			?>
			<div class="primary-text-primary-font st-sm-description-container"> <!-- description-container -->
				<?php echo esc_html( $args['synopsis'] ); ?>
			</div> <!-- /description-container -->
			<?php
		endif;
		?>

		<?php
		if ( ! empty( $args['directors'] ) && ! empty( $args['directors'][0] ) ) :
			?>
			<div class="st-sm-directors-container"> <!-- directors-container -->
				<span class="primary-text-primary-font st-sm-director-text"> <!-- director-text -->
					<?php esc_html_e( 'Directors:', 'screen-time' ); ?>
				</span> <!-- /director-text -->
				<ul class="st-sm-director-list"> <!-- director-list -->
					<?php
					foreach ( $args['directors'][0] as $director ) :
						?>
						<li class="primary-text-primary-font st-sm-director-item"> <!-- director-item -->
							<?php echo esc_html( ( get_the_title( $director ['person_id'] ) ) ); ?>
						</li> <!-- /director-item -->
						<?php
					endforeach;
					?>
				</ul> <!-- /director-list -->
			</div> <!-- /directors-container -->
			<?php
		endif;
		?>

		<?php if ( ! empty( $args['trailer'] ) ) : ?>
			<div class="st-sm-watch-trailer-container" data-src="<?php echo esc_url( wp_get_attachment_url( $args['trailer'] ) ); ?>"> <!-- watch-trailer-container -->
				<div class="ic-play-circle-container"> <!-- ic-play-circle-container -->
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_play.svg' ); ?>"/>
				</div> <!-- /ic-play-circle-container -->

				<div class="st-sm-watch-trailer-text-container"> <!-- watch-trailer-text-container -->
					<p class="primary-text-primary-font"> <!-- watch-trailer-text -->
						<?php esc_html_e( 'Watch Trailer', 'screen-time' ); ?>
					</p> <!-- /watch-trailer-text -->
				</div> <!-- /watch-trailer-text-container -->
			</div> <!-- /watch-trailer-container -->
		<?php endif; ?>
	</div> <!-- /info-stats-container -->
</div> <!-- /info-container -->
