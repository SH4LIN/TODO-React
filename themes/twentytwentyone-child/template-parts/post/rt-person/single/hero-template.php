<?php
/**
 * This file is used to display the hero section of the rt-person post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

if ( ! isset( $args['id'] ) ||
	! isset( $args['name'] ) ||
	! isset( $args['full_name'] ) ||
	! isset( $args['occupation'] ) ||
	! isset( $args['birth_date_age'] ) ||
	! isset( $args['birth_place'] ) ||
	! isset( $args['start_year_present'] ) ||
	! isset( $args['debut_movie_name_year'] ) ||
	! isset( $args['upcoming_movies'] ) ||
	! isset( $args['social_urls'] ) ) {
	return;
}

$current_id            = $args['id'];
$name                  = $args['name'];
$full_name             = $args['full_name'];
$occupation            = $args['occupation'];
$birth_date_age        = $args['birth_date_age'];
$birth_place           = $args['birth_place'];
$start_year_present    = $args['start_year_present'];
$debut_movie_name_year = $args['debut_movie_name_year'];
$upcoming_movies       = $args['upcoming_movies'];
$social_urls           = $args['social_urls'];

$post_thumbnail_id = get_post_thumbnail_id( $current_id );
$poster_url        = '';
if ( $post_thumbnail_id ) {
	$poster_url = wp_get_attachment_image_url( $post_thumbnail_id, 'full' );
} else {
	$poster_url = get_stylesheet_directory_uri() . '/assets/src/images/placeholder.webp';
}

?>
<div class="hero-wrapper">
	<div class="profile-wrapper">
		<img src="<?php echo esc_url( $poster_url ); ?>" />
	</div>

	<div class="data-wrapper">
		<div class="identification-wrapper">
			<div class="name-wrapper">
				<p class="primary-text-secondary-font identification-section-text name-text">
					<?php echo esc_html( $name ); ?>
				</p>
			</div>

			<div class="full-name-wrapper">
				<p class="primary-text-primary-font identification-section-text full-name-text">
					<?php echo esc_html( $full_name ); ?>
				</p>
			</div>
		</div>

		<div class="personal-details-wrapper">
			<?php if ( ! empty( $occupation ) ) : ?>
				<div class="occupation-details-wrapper">
					<div class="occupation-text-wrapper">
						<p class="primary-text-tag-font personal-details-text">
							<?php esc_html_e( 'Occupation: ', 'screen-time' ); ?>
						</p>
					</div>

					<div class= "occupation-wrapper">
						<p class="primary-text-primary-font personal-details-text">
							<?php echo esc_html( $occupation ); ?>
						</p>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $birth_date_age ) ) : ?>
				<div class="birth-date-details-wrapper">
					<div class= "birth-date-text-wrapper">
						<p class="primary-text-tag-font personal-details-text">
							<?php esc_html_e( 'Born: ', 'screen-time' ); ?>
						</p>
					</div>

					<div class= "birth-date-wrapper">
						<p class="primary-text-primary-font personal-details-text">
							<?php echo esc_html( $birth_date_age ); ?>
						</p>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $birth_place ) ) : ?>
				<div class="birth-place-details-wrapper">
					<div class= "birth-place-text-wrapper">
						<p class="primary-text-tag-font personal-details-text">
							<?php esc_html_e( 'Birthplace: ', 'screen-time' ); ?>
						</p>
					</div>

					<div class= "birth-place-wrapper">
						<p class="primary-text-primary-font personal-details-text">
							<?php echo esc_html( $birth_place ); ?>
						</p>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $start_year_present ) ) : ?>
				<div class="years-active-details-wrapper">
					<div class= "years-active-text-wrapper">
						<p class="primary-text-tag-font personal-details-text">
							<?php esc_html_e( 'Years active: ', 'screen-time' ); ?>
						</p>
					</div>

					<div class= "years-active-wrapper">
						<p class="primary-text-primary-font personal-details-text">
							<?php echo esc_html( $start_year_present ); ?>
						</p>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $debut_movie_name_year ) ) : ?>
				<div class="debut-movie-details-wrapper">
					<div class= "debut-movie-text-wrapper">
						<p class="primary-text-tag-font personal-details-text">
							<?php esc_html_e( 'Debut Movie: ', 'screen-time' ); ?>
						</p>
					</div>

					<div class= "debut-movie-wrapper">
						<p class="primary-text-primary-font personal-details-text">
							<?php echo esc_html( $debut_movie_name_year ); ?>
						</p>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $upcoming_movies ) ) : ?>
				<div class="upcoming-movies-details-wrapper">
					<div class= "upcoming-movies-text-wrapper">
						<p class="primary-text-tag-font personal-details-text">
							<?php esc_html_e( 'Upcoming Movies: ', 'screen-time' ); ?>
						</p>
					</div>

					<div class= "st-sp-upcoming-movies-wrapper">
						<p class="primary-text-primary-font personal-details-text">
							<?php echo esc_html( $upcoming_movies ); ?>
						</p>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( count( $social_urls ) > 0 ) : ?>
				<div class="social-details-wrapper">
					<div class= "social-text-wrapper">
						<p class="primary-text-tag-font personal-details-text">
							<?php esc_html_e( 'Socials: ', 'screen-time' ); ?>
						</p>
					</div>

					<div class= "social-wrapper">
						<?php
						foreach ( $social_urls as $social_url ) :
							if ( 'twitter' === $social_url['social'] ) :
								?>
								<div class="social-item">
									<a href="<?php echo esc_url( $social_url['url'] ); ?>" >
										<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_twitter.svg' ); ?>">
									</a>
								</div>
								<?php
							endif;

							if ( 'facebook' === $social_url['social'] ) :
								?>
								<div class="social-item">
									<a href="<?php echo esc_url( $social_url['url'] ); ?>" >
										<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_twitter.svg' ); ?>">
									</a>
								</div>
								<?php
							endif;

							if ( 'instagram' === $social_url['social'] ) :
								?>
								<div class="social-item">
									<a href="<?php echo esc_url( $social_url['url'] ); ?>" >
										<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_instagram.svg' ); ?>">
									</a>
								</div>
								<?php
							endif;

							if ( 'web' === $social_url['social'] ) :
								?>
								<div class="social-item">
									<a href="<?php echo esc_url( $social_url['url'] ); ?>" >
										<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_twitter.svg' ); ?>">
									</a>
								</div>
								<?php
							endif;
						endforeach;
						?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

