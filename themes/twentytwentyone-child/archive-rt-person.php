<?php
/**
 * This file is used to display the archive page of the rt-person post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\admin\classes\meta_boxes\RT_Person_Meta_Box;


get_header();

if ( isset( $_GET['movie_id'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$movie_id = sanitize_text_field( wp_unslash( $_GET['movie_id'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
} else {
	$movie_id = false;
}

$persons_details = array();
if ( false === $movie_id ) {
	$person_args  = array(
		'post_type'      => RT_Person::SLUG,
		'posts_per_page' => '12',
		'fields'         => 'ids',
	);
	$person_query = new WP_Query( $person_args );
	$actors       = $person_query->posts;
} else {
	$actors = get_movie_meta( $movie_id, 'rt-movie-meta-crew-actor' );
	if ( ! empty( $actors ) ) {
		$actors = $actors[0];
	}
}

if ( ! empty( $actors ) ) {

	foreach ( $actors as $actor ) {
		$person = array();

		if ( $movie_id ) {
			$person['id'] = $actor['person_id'];
		} else {
			$person['id'] = $actor;
		}
		$attachment_url = get_the_post_thumbnail_url( $person['id'] );

		$person['profile_picture'] = get_stylesheet_directory_uri() . '/assets/images/placeholder.webp';

		if ( $attachment_url ) {
			$person['profile_picture'] = $attachment_url;
		}

		if ( $movie_id ) {
			if ( ! empty( $actor['character_name'] ) ) {
				$character_name_html =
					sprintf(
						'<span class="ap-cast-crew-character-name-text">(%1$s)</span>',
						$actor['character_name']
					);
				$person['name']      =
					sprintf( '%1$s%2$s', $actor['person_name'], $character_name_html, );
			} else {
				$person['name'] = sprintf( '%1$s', $actor['person_name'] );
			}
		} else {
			$person['name'] = get_the_title( $person['id'] );
		}

		$birth_date_str       = get_person_meta( $person['id'], RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_DATE_SLUG, true );
		$person['birth_date'] = '';

		if ( ! empty( $birth_date_str ) ) {
			$birth_date = DateTime::createFromFormat( 'Y-m-d', $birth_date_str )->format( 'd F Y' );

			// translators: %1$s is the birth date.
			$born_birth_date_str  = sprintf( __( 'Born - %1$s', 'screen-time' ), $birth_date );
			$person['birth_date'] = $born_birth_date_str;
		}

		$persons_details[] = $person;
	}
}
?>
<div class="ap-wrapper">
	<?php if ( count( $persons_details ) > 0 ) : ?>
		<div class="ap-cast-crew-wrapper">
			<div class="ap-cast-crew-heading-wrapper">
				<p class="primary-text-secondary-font">
					<?php esc_html_e( 'Cast & Crew', 'screen-time' ); ?>
				</p>
			</div>

			<div class="ap-cast-crew-list-wrapper">
				<?php foreach ( $persons_details as $person ) : ?>
					<div class="ap-cast-crew-list-mobile">
						<div class="ap-cast-crew-item">
							<a href="<?php echo esc_url( get_permalink( $person['id'] ) ); ?>">
								<div class="ap-cast-crew-poster-wrapper">
									<img src="<?php echo esc_url( $person['profile_picture'] ); ?>" loading="lazy" />
								</div>
							</a>

							<div class="ap-cast-crew-details-wrapper">
								<a href="<?php echo esc_url( get_permalink( $person['id'] ) ); ?>">
									<div class="primary-text-secondary-font ap-cast-crew-name">
										<?php echo wp_kses( $person['name'], array( 'span' => array( 'class' => array() ) ) ); ?>
									</div>
								</a>

								<?php if ( ! empty( $person['birth_date'] ) ) : ?>
									<div class="secondary-text-primary-font ap-cast-crew-birth-date">
										<?php echo esc_html( $person['birth_date'] ); ?>
									</div>
								<?php endif; ?>

								<?php if ( has_excerpt( $person['id'] ) ) : ?>
									<div class="primary-text-primary-font ap-cast-crew-excerpt">
										<?php get_the_excerpt( $person['id'] ); ?>
									</div>
								<?php endif; ?>

								<a href="<?php echo esc_url( get_permalink( $person['id'] ) ); ?>">
									<div class="primary-text-primary-font ap-cast-crew-learn-more">
										<?php esc_html_e( 'Learn more', 'screen-time' ); ?>
									</div>
								</a>

							</div>
						</div>

						<?php if ( has_excerpt( $person['id'] ) ) : ?>
							<div class="primary-text-primary-font ap-cast-crew-excerpt-mobile">
								<?php get_the_excerpt( $person['id'] ); ?>
							</div>
						<?php endif; ?>

						<a href="<?php echo esc_url( get_permalink( $person['id'] ) ); ?>">
							<div class="primary-text-primary-font ap-cast-crew-learn-more-mobile">
								<?php esc_html_e( 'Learn more', 'screen-time' ); ?>
							</div>
						</a>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="ap-cast-crew-load-more-wrapper">
				<p class="primary-text-primary-font ap-cast-crew-load-more">
					<?php esc_html_e( 'Load More', 'screen-time' ); ?>
				</p>
			</div>
		</div>
	<?php endif; ?>
</div>
<?php
get_footer();
