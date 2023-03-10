<?php
/**
 * This file is used to display the single rt-person post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */

use Cassandra\Date;
use MovieLib\admin\classes\custom_post_types\RT_Movie;
use MovieLib\admin\classes\meta_boxes\RT_Media_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Movie_Meta_Box;
use MovieLib\admin\classes\meta_boxes\RT_Person_Meta_Box;
use MovieLib\admin\classes\taxonomies\Movie_Genre;
use MovieLib\admin\classes\taxonomies\Movie_Person;
use MovieLib\admin\classes\taxonomies\Person_Career;

$current_id    = get_the_ID();
$current_title = get_the_title();
$full_name     = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_BASIC_FULL_NAME_SLUG, true );
$birth_place   = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_PLACE_SLUG, true );
$career        = get_the_terms( $current_id, Person_Career::SLUG );
$occupation    = '';

if ( ! empty( $career ) ) {

	if ( is_array( $career ) ) {

		$careers = array();

		foreach ( $career as $value ) {

			$careers[] = $value->name;

		}

		$occupation = implode( ', ', $careers );

	} else {

		$occupation = $career->title;

	}
}

$birth_date_str    = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_DATE_SLUG, true );
$birth_date_format = DateTime::createFromFormat( 'Y-m-d', $birth_date_str );
$today             = new DateTime(); // The current date and time.
$age               = '';
try {
	$diff = $today->diff( $birth_date_format ); // The difference between the two dates.
	$age  = $diff->y; // The number of whole years in the difference.
} catch ( Exception $e ) {
	new WP_Error( $e->getMessage() );
}

$birth_date     = $birth_date_format->format( 'j F Y' );
$birth_date_age = sprintf( __( '%1$s (age %2$s years)' ), $birth_date, $age );

$start_year_str     = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_BASIC_START_YEAR_SLUG, true );
$start_year_format  = DateTime::createFromFormat( 'Y-m-d', $start_year_str );
$start_year         = $start_year_format->format( 'Y' );
$start_year_present = sprintf( __( '%1$s-present' ), $start_year );

try {
	$diff = $today->diff( $birth_date_format ); // The difference between the two dates.
	$age  = $diff->y; // The number of whole years in the difference.
} catch ( Exception $e ) {
	new WP_Error( $e->getMessage() );
}

$search_query = array(
	array(
		'taxonomy' => Movie_Person::SLUG,
		'field'    => 'slug',
		'terms'    => array( $current_id ),
	),
);

$query = new WP_Query(
	array(
		'post_type' => RT_Movie::SLUG,
		'tax_query' => $search_query, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
	)
);

$movies_worked = $query->posts;
$popular_movies = null;
if( count( $movies_worked ) > 4 ) {
	$popular_movies = array_slice( $query->posts, 0, 4);
} else {
	$popular_movies = array_slice( $query->posts, 0);
}


/**
 * This function is used to sort the movie array by release date.
 *
 * @param WP_Post $a This will be the one of the WP_Post object from the array.
 * @param WP_Post $b This will be the one of the WP_Post object from the array.
 *
 * @return int
 */
function sort_by_release_date( $a, $b ): int {

	$date1_str = $a['release_date'];
	if ( empty( $date1_str ) ) {
		return 1;
	}

	$date2_str = $b['release_date'];
	if ( empty( $date2_str ) ) {
		return -1;
	}

	$date1 = DateTime::createFromFormat( 'Y-m-d', $date1_str );
	$date2 = DateTime::createFromFormat( 'Y-m-d', $date2_str );

	if ( $date1 > $date2 ) {
		return 1;
	} elseif ( $date1 < $date2 ) {
		return -1;
	}
	return 0;
}

$movie_name_release_date = array();
foreach ( $movies_worked as $movie ) {
	$movie_name_release_date [] = array(
		'movie_name'   => $movie->post_title,
		'release_date' => get_post_meta( $movie->ID, RT_Movie_Meta_Box::MOVIE_META_BASIC_RELEASE_DATE_SLUG, true ),
	);
}

usort( $movie_name_release_date, 'sort_by_release_date' );

$debut_movie_name = $movie_name_release_date[0]['movie_name'];
$debut_movie_date = $movie_name_release_date[0]['release_date'];
$debut_movie_year = DateTime::createFromFormat( 'Y-m-d', $debut_movie_date )->format( 'Y' );

$debut_movie_name_year = sprintf( '%1$s (%2$s)', $debut_movie_name, $debut_movie_year );

function get_upcoming_movies( $value ) {
	$current_date = gmdate( 'Y-m-d' );
	if ( empty( $value['release_date'] ) ) {
		return false;
	}

	$movie_date = $value['release_date'];

	return $movie_date > $current_date;

}

$upcoming_movies_array = array_filter( $movie_name_release_date, 'get_upcoming_movies' );
$upcoming_movies       = '';

if ( count( $upcoming_movies_array ) > 0 ) {
	$upcoming_movies_array = array_values( $upcoming_movies_array );
	foreach ( $upcoming_movies_array as $upcoming_movie ) {
		$release_year     = DateTime::createFromFormat( 'Y-m-d', $upcoming_movie['release_date'] )->format( 'Y' );
		$upcoming_movies .= sprintf( '%1$s (%2$s), ', $upcoming_movie['movie_name'], $release_year );
	}
}

$twitter_url   = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_SOCIAL_TWITTER_SLUG, true );
$facebook_url  = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_SOCIAL_FACEBOOK_SLUG, true );
$instagram_url = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_SOCIAL_INSTAGRAM_SLUG, true );
$web_url       = get_post_meta( $current_id, RT_Person_Meta_Box::PERSON_META_SOCIAL_WEB_SLUG, true );

$social_urls = array();

if ( ! empty( $twitter_url ) ) {
	$social_urls[] = array(
		'social' => 'twitter',
		'url'    => $twitter_url,
	);
}

if ( ! empty( $facebook_url ) ) {
	$social_urls[] = array(
		'social' => 'facebook',
		'url'    => $facebook_url,
	);
}

if ( ! empty( $instagram_url ) ) {
	$social_urls[] = array(
		'social' => 'instagram',
		'url'    => $instagram_url,
	);
}

if ( ! empty( $web_url ) ) {
	$social_urls[] = array(
		'social' => 'web',
		'url'    => $web_url,
	);
}

$snapshots = get_post_meta( $current_id, RT_Media_Meta_Box::IMAGES_SLUG );
$videos = get_post_meta( $current_id, RT_Media_Meta_Box::VIDEOS_SLUG );

get_header();
?>

<div class="st-sp-container">
	<div class="st-sp-hero-container">
		<div class="st-sp-profile-container">
			<?php
			if ( has_post_thumbnail( $current_id ) ) {
				the_post_thumbnail();
			}
			?>
		</div>

		<div class="st-sp-identification-container">
			<div class= "st-sp-name-container">
				<p class="primary-text-secondary-font font-32-bold-lh-40">
					<?php echo esc_html( get_the_title() ); ?>
				</p>
			</div>

			<div class="st-sp-full-name-container">
				<p class="primary-text-primary-font font-14-normal-lh-14">
					<?php echo esc_html( $full_name ); ?>
				</p>
			</div>
		</div>

		<div class="st-sp-personal-details-container">
			<?php if ( ! empty( $occupation ) ) : ?>
			<div class="st-sp-occupation-details-container">
				<div class="st-sp-occupation-text-container">
					<p class="primary-text-primary-font font-14-normal">
						<?php esc_html_e( 'Occupation: ' ); ?>
					</p>
				</div>

				<div class= "st-sp-occupation-container">
					<p class="primary-text-primary-font font-14-normal">
						<?php echo esc_html( $occupation ); ?>
					</p>
				</div>
			</div>
			<?php endif; ?>

			<?php if ( ! empty( $birth_date_str ) ) : ?>
			<div class="st-sp-birth-date-details-container">
				<div class= "st-sp-birth-date-text-container">
					<p class="primary-text-primary-font font-14-normal">
						<?php esc_html_e( 'Born: ' ); ?>
					</p>
				</div>

				<div class= "st-sp-birth-date-container">
					<p class="primary-text-primary-font font-14-normal">
						<?php echo esc_html( $birth_date_age ); ?>
					</p>
				</div>
			</div>
			<?php endif; ?>

			<?php if ( ! empty( $birth_place ) ) : ?>
			<div class="st-sp-birth-place-details-container">
				<div class= "st-sp-birth-place-text-container">
					<p class="primary-text-primary-font font-14-normal">
						<?php esc_html_e( 'Birthplace: ' ); ?>
					</p>
				</div>

				<div class= "st-sp-birth-place-container">
					<p class="primary-text-primary-font font-14-normal">
						<?php echo esc_html( $birth_place ); ?>
					</p>
				</div>
			</div>
			<?php endif; ?>

			<?php if ( ! empty( $start_year_present ) ) : ?>
			<div class="st-sp-years-active-details-container">
				<div class= "st-sp-years-active-text-container">
					<p class="primary-text-primary-font font-14-normal">
						<?php esc_html_e( 'Years active: ' ); ?>
					</p>
				</div>

				<div class= "st-sp-years-active-container">
					<p class="primary-text-primary-font font-14-normal">
						<?php echo esc_html( $start_year_present ); ?>
					</p>
				</div>
			</div>
			<?php endif; ?>

			<?php if ( ! empty( $debut_movie_name_year ) ) : ?>
			<div class="st-sp-debut-movie-details-container">
				<div class= "st-sp-debut-movie-text-container">
					<p class="primary-text-primary-font font-14-normal">
						<?php esc_html_e( 'Debut Movie: ' ); ?>
					</p>
				</div>

				<div class= "st-sp-debut-movie-container">
					<p class="primary-text-primary-font font-14-normal">
						<?php echo esc_html( $debut_movie_name_year ); ?>
					</p>
				</div>
			</div>
			<?php endif; ?>

			<?php if ( ! empty( $upcoming_movies ) ) : ?>
			<div class="st-sp-upcoming-movies-details-container">
				<div class= "st-sp-upcoming-movies-text-container">
					<p class="primary-text-primary-font font-14-normal">
						<?php esc_html_e( 'Upcoming Movies: ' ); ?>
					</p>
				</div>

				<div class= "st-sp-upcoming-movies-container">
					<p class="primary-text-primary-font font-14-normal">
						<?php echo esc_html( $upcoming_movies ); ?>
					</p>
				</div>
			</div>
			<?php endif; ?>

			<?php if (  count( $social_urls ) > 0 ) : ?>
			<div class="st-sp-social-details-container">
				<div class= "st-sp-social-text-container">
					<p class="primary-text-primary-font font-14-normal">
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

	<div class="st-sp-about-container">
		<div class="st-sp-about-heading-container">
			<p class="primary-text-secondary-font font-24-bold">
				<?php esc_html_e( 'About' ); ?>
			</p>
		</div>

		<div class="st-sp-about-content-container">

			<span class="primary-text-primary-font font-14-normal">
				<?php echo wp_kses_post( the_content() ); ?>
			</span>
		</div>
	</div>

	<?php if ( count( $popular_movies ) > 0 ) : ?>
	<div class="st-sp-popular-movies-container">
		<div class="st-sp-popular-movies-heading-container">
			<p class="primary-text-secondary-font font-24-bold">
				<?php esc_html_e( 'Popular Movies' ); ?>
			</p>
		</div>

		<div class="st-sp-popular-movies-items-container">
			<?php foreach ( $popular_movies as $popular_movie) : ?>
			<div class="st-sp-popular-movie-item-container">
				<div class="st-sp-popular-movie-item-poster-container">
					<?php
					if ( has_post_thumbnail( $popular_movie->ID ) ) {
						echo wp_kses_post( get_the_post_thumbnail( $popular_movie->ID ) );
					} else {
						?> <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/placeholder.webp' ) ?>" /> <?php
					}
					?>
				</div>

				<div class="st-sp-popular-movie-item-info-container">
					<div class="st-sp-popular-movie-item-name-runtime-container">
						<div class="st-sp-popular-movie-item-name-container">
							<p class="primary-text-primary-font font-12-bold">
								<?php echo esc_html( get_the_title( $popular_movie->ID ) ) ?>
							</p>
						</div>

						<div class="st-sp-popular-movie-item-runtime-container">
							<p class="secondary-text-primary-font font-8-normal">
								<?php
								$minutes = get_post_meta( $popular_movie->ID, RT_Movie_Meta_Box::MOVIE_META_BASIC_RUNTIME_SLUG, true );
								$hours = floor($minutes / 60);
								$remaining_minutes = $minutes % 60;

								$formatted_time = sprintf("%d hr %02d min", $hours, $remaining_minutes);

								echo esc_html( $formatted_time );
								?>
							</p>
						</div>
					</div>

					<div class="st-sp-popular-movie-item-genre-release-container">
						<?php
						$genres = get_the_terms( $popular_movie->ID, Movie_Genre::SLUG );
						if ( is_array($genres) && count( $genres ) > 0) :
						?>
						<div class="st-sp-popular-movie-item-genre-container">
							<ul class="st-sp-popular-movie-item-genre-list">
							<?php
							foreach ($genres as $genre ) :
								?>
								<li class="st-sp-popular-movie-item-genre-item secondary-text-primary-font font-8-normal">
									<?php echo esc_html( $genre->name ); ?>
								</li>
								<?php

							endforeach;

							?>
							</ul>
						</div>
						<?php endif; ?>

						<div class="st-sp-popular-movie-item-release-container">
							<p class="secondary-text-primary-font font-8-normal">
								<?php
								$release_date_str = get_post_meta( $popular_movie->ID, RT_Movie_Meta_Box::MOVIE_META_BASIC_RELEASE_DATE_SLUG, true);

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

	<?php
	if ( $snapshots && is_array( $snapshots ) && count( $snapshots ) > 0) :
		?>

		<div class="st-sp-snapshots-container">
			<div class="st-sp-snapshots-heading-container">
				<p class="primary-text-secondary-font font-24-bold">
					<?php esc_html_e( 'Snapshots' ); ?>
				</p>
			</div>

			<div class="st-sp-snapshots-list-container">
				<div class="st-sp-snapshots-list">
					<?php
					foreach ( $snapshots[0] as $snapshot ) :
						?>

						<div class="st-sp-snapshots-list-item">
							<img src="<?php echo wp_get_attachment_image_url( $snapshot ); ?>" />
						</div>

						<?php

					endforeach;
					?>
				</div>
			</div>

		</div>

		<?php
	endif;
	?>

	<?php
	if ( $videos && is_array( $videos ) && count( $videos ) > 0) :
		?>

		<div class="st-sp-videos-container">
			<div class="st-sp-videos-heading-container">
				<p class="primary-text-secondary-font font-24-bold">
					<?php esc_html_e( 'Videos' ); ?>
				</p>
			</div>

			<div class="st-sp-videos-list-container">
				<div class="st-sp-videos-list">
					<?php
					foreach ( $videos[0] as $video ) :
						?>

						<div class="st-sp-videos-list-item">
							<img src="<?php echo wp_get_attachment_image_url( $video ); ?>" />
							<div class="st-sp-videos-play-button">
								<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_play.svg'); ?>" />
							</div>
						</div>

					<?php

					endforeach;
					?>
				</div>
			</div>

		</div>

	<?php
	endif;
	?>
</div>


