<?php
/**
 * This file is used to display the hero section of the rt-person post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */

$args = wp_parse_args( $args, array(
	'current_id'            => '',
	'full_name'             => '',
	'occupation'            => '',
	'birth_date_str'        => '',
	'birth_date_age'        => '',
	'birth_place'           => '',
	'start_year_present'    => '',
	'debut_movie_name_year' => '',
	'upcoming_movies'       => '',
	'social_urls'           => '',
) );

$current_id = $args['current_id'];
$full_name = $args['full_name'];
$occupation = $args['occupation'];
$birth_date_str = $args['birth_date_str'];
$birth_date_age = $args['birth_date_age'];
$birth_place = $args['birth_place'];
$start_year_present = $args['start_year_present'];
$debut_movie_name_year = $args['debut_movie_name_year'];
$upcoming_movies = $args['upcoming_movies'];
$social_urls = $args['social_urls'];

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
						<?php echo esc_html( get_the_title() ); ?>
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
							<?php esc_html_e( 'Occupation: ' ); ?>
						</p>
					</div>

					<div class= "st-sp-occupation-container">
						<p class="primary-text-primary-font personal-details-text">
							<?php echo esc_html( $occupation ); ?>
						</p>
					</div>
				</div>
				<?php endif; ?>

				<?php if ( ! empty( $birth_date_str ) ) : ?>
					<div class="st-sp-birth-date-details-container">
					<div class= "st-sp-birth-date-text-container">
						<p class="primary-text-tag-font personal-details-text">
							<?php esc_html_e( 'Born: ' ); ?>
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
							<?php esc_html_e( 'Birthplace: ' ); ?>
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
							<?php esc_html_e( 'Years active: ' ); ?>
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
							<?php esc_html_e( 'Debut Movie: ' ); ?>
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
							<?php esc_html_e( 'Upcoming Movies: ' ); ?>
						</p>
					</div>

					<div class= "st-sp-upcoming-movies-container">
						<p class="primary-text-primary-font personal-details-text">
							<?php echo esc_html( $upcoming_movies ); ?>
						</p>
					</div>
				</div>
				<?php endif; ?>

				<?php if (  count( $social_urls ) > 0 ) : ?>
					<div class="st-sp-social-details-container">
					<div class= "st-sp-social-text-container">
						<p class="primary-text-tag-font personal-details-text">
							<?php esc_html_e( 'Socials: ' ); ?>
						</p>
					</div>

					<div class= "st-sp-social-container">
						<?php
						foreach( $social_urls as $social_url ) {
							if ( $social_url['social'] === 'twitter' ){
								?>
								<div class="st-sp-social-items">
									<a href="<?php echo esc_url($social_url['url']) ?>" >
										<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_twitter.svg'); ?>">
									</a>
								</div>
								<?php
							}

							if ( $social_url['social'] === 'facebook' ){
								?>
								<div class="st-sp-social-items">
									<a href="<?php echo esc_url($social_url['url']) ?>" >
										<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_twitter.svg'); ?>">
									</a>
								</div>
								<?php
							}

							if ( $social_url['social'] === 'instagram' ){
								?>
								<div class="st-sp-social-items">
									<a href="<?php echo esc_url($social_url['url']) ?>" >
										<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_instagram.svg'); ?>">
									</a>
								</div>
								<?php
							}

							if ( $social_url['social'] === 'web' ){
								?>
								<div class="st-sp-social-items">
									<a href="<?php echo esc_url($social_url['url']) ?>" >
										<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_twitter.svg'); ?>">
									</a>
								</div>
								<?php
							}
						}
						?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
</div>

