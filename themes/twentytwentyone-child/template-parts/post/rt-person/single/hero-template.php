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

?>
<div class="st-sp-hero-container">
	<div class="st-sp-profile-container">
		<?php
		if ( has_post_thumbnail( $current_id ) ) {
			the_post_thumbnail();
		}
		?>
	</div>

	<div class="st-sp-data-container">
		<div class="st-sp-identification-container">
			<div class= "st-sp-name-container">
				<p class="primary-text-secondary-font identification-section-text name-text">
					<?php echo esc_html( $name ); ?>
				</p>
			</div>

			<div class="st-sp-full-name-container">
				<p class="primary-text-primary-font identification-section-text full-name-text">
					<?php echo esc_html( $full_name ); ?>
				</p>
			</div>
		</div>

		<div class="st-sp-personal-details-container">
			<?php if ( ! empty( $occupation ) ) : ?>
				<div class="st-sp-occupation-details-container">
					<div class="st-sp-occupation-text-container">
						<p class="primary-text-tag-font personal-details-text">
							<?php esc_html_e( 'Occupation: ', 'screen-time' ); ?>
						</p>
					</div>

					<div class= "st-sp-occupation-container">
						<p class="primary-text-primary-font personal-details-text">
							<?php echo esc_html( $occupation ); ?>
						</p>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $birth_date_age ) ) : ?>
				<div class="st-sp-birth-date-details-container">
					<div class= "st-sp-birth-date-text-container">
						<p class="primary-text-tag-font personal-details-text">
							<?php esc_html_e( 'Born: ', 'screen-time' ); ?>
						</p>
					</div>

					<div class= "st-sp-birth-date-container">
						<p class="primary-text-primary-font personal-details-text">
							<?php echo esc_html( $birth_date_age ); ?>
						</p>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $birth_place ) ) : ?>
				<div class="st-sp-birth-place-details-container">
					<div class= "st-sp-birth-place-text-container">
						<p class="primary-text-tag-font personal-details-text">
							<?php esc_html_e( 'Birthplace: ', 'screen-time' ); ?>
						</p>
					</div>

					<div class= "st-sp-birth-place-container">
						<p class="primary-text-primary-font personal-details-text">
							<?php echo esc_html( $birth_place ); ?>
						</p>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $start_year_present ) ) : ?>
				<div class="st-sp-years-active-details-container">
					<div class= "st-sp-years-active-text-container">
						<p class="primary-text-tag-font personal-details-text">
							<?php esc_html_e( 'Years active: ', 'screen-time' ); ?>
						</p>
					</div>

					<div class= "st-sp-years-active-container">
						<p class="primary-text-primary-font personal-details-text">
							<?php echo esc_html( $start_year_present ); ?>
						</p>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $debut_movie_name_year ) ) : ?>
				<div class="st-sp-debut-movie-details-container">
					<div class= "st-sp-debut-movie-text-container">
						<p class="primary-text-tag-font personal-details-text">
							<?php esc_html_e( 'Debut Movie: ', 'screen-time' ); ?>
						</p>
					</div>

					<div class= "st-sp-debut-movie-container">
						<p class="primary-text-primary-font personal-details-text">
							<?php echo esc_html( $debut_movie_name_year ); ?>
						</p>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $upcoming_movies ) ) : ?>
				<div class="st-sp-upcoming-movies-details-container">
					<div class= "st-sp-upcoming-movies-text-container">
						<p class="primary-text-tag-font personal-details-text">
							<?php esc_html_e( 'Upcoming Movies: ', 'screen-time' ); ?>
						</p>
					</div>

					<div class= "st-sp-upcoming-movies-container">
						<p class="primary-text-primary-font personal-details-text">
							<?php echo esc_html( $upcoming_movies ); ?>
						</p>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( count( $social_urls ) > 0 ) : ?>
				<div class="st-sp-social-details-container">
					<div class= "st-sp-social-text-container">
						<p class="primary-text-tag-font personal-details-text">
							<?php esc_html_e( 'Socials: ', 'screen-time' ); ?>
						</p>
					</div>

					<div class= "st-sp-social-container">
						<?php
						foreach ( $social_urls as $social_url ) :
							if ( 'twitter' === $social_url['social'] ) :
								?>
								<div class="st-sp-social-items">
									<a href="<?php echo esc_url( $social_url['url'] ); ?>" >
										<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_twitter.svg' ); ?>">
									</a>
								</div>
								<?php
							endif;

							if ( 'facebook' === $social_url['social'] ) :
								?>
								<div class="st-sp-social-items">
									<a href="<?php echo esc_url( $social_url['url'] ); ?>" >
										<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_twitter.svg' ); ?>">
									</a>
								</div>
								<?php
							endif;

							if ( 'instagram' === $social_url['social'] ) :
								?>
								<div class="st-sp-social-items">
									<a href="<?php echo esc_url( $social_url['url'] ); ?>" >
										<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_instagram.svg' ); ?>">
									</a>
								</div>
								<?php
							endif;

							if ( 'web' === $social_url['social'] ) :
								?>
								<div class="st-sp-social-items">
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

