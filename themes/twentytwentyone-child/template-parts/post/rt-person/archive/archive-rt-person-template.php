<?php
/**
 * This file is template file for the archive rt-person post type. It will call all the other template parts
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since 1.0.0
 */

use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\admin\classes\meta_boxes\RT_Person_Meta_Box;

$persons_details = array();

if ( isset( $_GET['movie_id'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$movie_id = sanitize_text_field( wp_unslash( $_GET['movie_id'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$actors   = get_post_meta( $movie_id, 'rt-movie-meta-crew-actor' );

	if ( $actors && ! empty( $actors ) && ! empty( $actors[0] ) ) {

		foreach ( $actors[0] as $actor ) {
			$person = array();

			$person['id'] = $actor['person_id'];
			$thumbnail_id   = get_post_thumbnail_id( $actor['person_id'] );
			$attachment_url = wp_get_attachment_url( $thumbnail_id );

			$person['profile_picture'] = get_stylesheet_directory_uri() . '/assets/images/placeholder.webp';

			if ( $attachment_url ) {
				$person['profile_picture'] = $attachment_url;
			}



			if ( ! empty( $actor['character_name'] ) ) {
				$character_name_html  = '<span class="st-ap-cast-crew-character-name-text">';
				$character_name_html .= '(' . $actor['character_name'] . ')';
				$character_name_html .= '</span>';
				$person['name']       = sprintf( '%1$s%2$s', $actor['person_name'], $character_name_html, );
			} else {
				$person['name'] = sprintf( '%1$s', $actor['person_name'] );
			}



			$birth_date_str       = get_post_meta( $actor['person_id'], RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_DATE_SLUG, true );
			$person['birth_date'] = '';

			if ( ! empty( $birth_date_str ) ) {
				$birth_date           = DateTime::createFromFormat( 'Y-m-d', $birth_date_str )->format( 'd F Y' );
				$born_birth_date_str  = sprintf( __( 'Born - %1$s', 'screen-time' ), $birth_date );
				$person['birth_date'] = $born_birth_date_str;
			}

			$excerpt           = get_the_excerpt( $actor['person_id'] );
			$person['excerpt'] = '';

			if ( ! empty( $excerpt ) ) {
				$person['excerpt'] = $excerpt;
			}

			$persons_details[] = $person;
		}
	}
} else {
	$person_args = array(
		'post_type'      => RT_Person::SLUG,
		'posts_per_page' => '12',
	);

	$person_query = new WP_Query( $person_args );
	$persons      = $person_query->posts;

	if ( $persons && is_array( $persons ) && count( $persons ) > 0 ) {
		foreach ( $persons as $person_data ) {
			$person = array();

			$person['id'] = $person_data->ID;

			$thumbnail_id   = get_post_thumbnail_id( $person_data->ID );
			$attachment_url = wp_get_attachment_url( $thumbnail_id );

			$person['profile_picture'] = get_stylesheet_directory_uri() . '/assets/images/placeholder.webp';

			if ( $attachment_url ) {
				$person['profile_picture'] = $attachment_url;
			}

			$person['name'] = $person_data->post_title;

			$birth_date_str       = get_post_meta( $person_data->ID, RT_Person_Meta_Box::PERSON_META_BASIC_BIRTH_DATE_SLUG, true );
			$person['birth_date'] = '';

			if ( ! empty( $birth_date_str ) ) {
				$birth_date           = DateTime::createFromFormat( 'Y-m-d', $birth_date_str )->format( 'd F Y' );
				$born_birth_date_str  = sprintf( __( 'Born - %1$s', 'screen-time' ), $birth_date );
				$person['birth_date'] = $born_birth_date_str;
			}

			$excerpt           = $person_data->post_excerpt;
			$person['excerpt'] = '';

			if ( ! empty( $excerpt ) ) {
				$person['excerpt'] = $excerpt;
			}

			$persons_details[] = $person;
		}
	}
}

?>
<div class="st-ap-container">
	<?php if ( count( $persons_details ) > 0 ) : ?>
		<div class="st-ap-cast-crew-container">
		<div class="st-ap-cast-crew-heading-container">
			<div class="primary-text-secondary-font st-ap-cast-crew-heading-text">
				<?php esc_html_e( 'Cast & Crew', 'screen-time' ); ?>
			</div>
		</div>

		<div class="st-ap-cast-crew-list-container">
			<?php foreach ( $persons_details as $person ) : ?>
			<a href="<?php echo esc_url( get_permalink( $person['id'] ) ); ?>">
				<div class="st-ap-cast-crew-list-mobile">
					<div class="st-ap-cast-crew-list-item">
						<div class="st-ap-cast-crew-poster-container">
							<img src="<?php echo esc_url( $person['profile_picture'] ); ?>"/>
						</div>

						<div class="st-ap-cast-crew-details-container">

							<div class="primary-text-secondary-font st-ap-cast-crew-name-text">
								<?php echo wp_kses( $person['name'], array( 'span' => array( 'class' => array() ) ) ); ?>
							</div>

							<?php if ( ! empty( $person['birth_date'] ) ) : ?>
								<div class="secondary-text-primary-font st-ap-cast-crew-birth-date-text">
									<?php echo esc_html( $person['birth_date'] ); ?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $person['excerpt'] ) ) : ?>
								<div class="primary-text-primary-font st-ap-cast-crew-excerpt-text">
									<?php echo esc_html( $person['excerpt'] ); ?>
								</div>
							<?php endif; ?>

							<div class="primary-text-primary-font st-ap-cast-crew-learn-more-text">
								<?php esc_html_e( 'Learn more', 'screen-time' ); ?>
							</div>

						</div>
					</div>

					<?php if ( ! empty( $person['excerpt'] ) ) : ?>
						<div class="primary-text-primary-font st-ap-cast-crew-excerpt-text-mobile">
							<?php echo esc_html( $person['excerpt'] ); ?>
						</div>
					<?php endif; ?>

					<div class="primary-text-primary-font st-ap-cast-crew-learn-more-text-mobile">
						<?php esc_html_e( 'Learn more', 'screen-time' ); ?>
					</div>
				</div>
			</a>
			<?php endforeach; ?>
		</div>

		<div class="st-ap-cast-crew-load-more-container">
			<div class="primary-text-primary-font st-ap-cast-crew-load-more-text">
				<?php esc_html_e( 'Load More', 'screen-time' ); ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>
