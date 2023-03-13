<?php
/**
 * This file is used to display the archive page of the rt-person post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */

use MovieLib\admin\classes\custom_post_types\RT_Person;
use MovieLib\admin\classes\meta_boxes\RT_Person_Meta_Box;

$person_args = array(
	'post_type'      => RT_Person::SLUG,
	'posts_per_page' => '12',
);

$person_query = new WP_Query( $person_args );
$persons      = $person_query->posts;

$persons_details = array();

if ( $persons && is_array( $persons ) && count( $persons ) > 0 ) {
	foreach ( $persons as $person_data ) {
		$person = array();

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

get_header();
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
			<div class="st-ap-cast-crew-list-mobile">
				<div class="st-ap-cast-crew-list-item">
					<div class="st-ap-cast-crew-poster-container">
						<img src="<?php echo esc_url( $person['profile_picture'] ); ?>"/>
					</div>

					<div class="st-ap-cast-crew-details-container">

						<div class="primary-text-secondary-font st-ap-cast-crew-name-text">
							<?php echo esc_html( $person['name'] ); ?>
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
							<?php echo esc_html_e( 'Learn more', 'screen-time' ); ?>
						</div>

					</div>
				</div>

				<?php if ( ! empty( $person['excerpt'] ) ) : ?>
					<div class="primary-text-primary-font st-ap-cast-crew-excerpt-text-mobile">
						<?php echo esc_html( $person['excerpt'] ); ?>
					</div>
				<?php endif; ?>

				<div class="primary-text-primary-font st-ap-cast-crew-learn-more-text-mobile">
					<?php echo esc_html_e( 'Learn more', 'screen-time' ); ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>

		<div class="st-ap-cast-crew-load-more-container">
			<div class="primary-text-primary-font st-ap-cast-crew-load-more-text">
				<?php esc_html_e( 'Load More','screen-time' ); ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>
<?php
get_footer();
wp_reset_postdata();

