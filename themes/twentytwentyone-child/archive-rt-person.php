<?php
/**
 * This file is used to display the archive page of the rt-person post type.
 *
 * @package Twenty_Twenty_One_Child
 * @since 1.0.0
 */

get_header();
$persons_details = array();

require_once get_stylesheet_directory() . '/classes/class-archive-rt-person-data.php';

if ( isset( $_GET['movie_id'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$movie_id        = sanitize_text_field( wp_unslash( $_GET['movie_id'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$persons_details = Archive_RT_Person_Data::instance()->get_movie_person_archive_data( $movie_id );
} else {
	$persons_details = Archive_RT_Person_Data::instance()->get_person_archive_data();
}

?>
<div class="ap-wrapper">
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
							<a href="<?php echo esc_url( get_permalink( $person['id'] ) ); ?>">
								<div class="st-ap-cast-crew-poster-container">
									<img src="<?php echo esc_url( $person['profile_picture'] ); ?>" loading="lazy" />
								</div>
							</a>

							<div class="st-ap-cast-crew-details-container">
								<a href="<?php echo esc_url( get_permalink( $person['id'] ) ); ?>">
									<div class="primary-text-secondary-font st-ap-cast-crew-name-text">
										<?php echo wp_kses( $person['name'], array( 'span' => array( 'class' => array() ) ) ); ?>
									</div>
								</a>

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

								<a href="<?php echo esc_url( get_permalink( $person['id'] ) ); ?>">
									<div class="primary-text-primary-font st-ap-cast-crew-learn-more-text">
										<?php esc_html_e( 'Learn more', 'screen-time' ); ?>
									</div>
								</a>

							</div>
						</div>

						<?php if ( ! empty( $person['excerpt'] ) ) : ?>
							<div class="primary-text-primary-font st-ap-cast-crew-excerpt-text-mobile">
								<?php echo esc_html( $person['excerpt'] ); ?>
							</div>
						<?php endif; ?>

						<a href="<?php echo esc_url( get_permalink( $person['id'] ) ); ?>">
							<div class="primary-text-primary-font st-ap-cast-crew-learn-more-text-mobile">
								<?php esc_html_e( 'Learn more', 'screen-time' ); ?>
							</div>
						</a>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="st-ap-cast-crew-load-more-container">
				<p class="primary-text-primary-font st-ap-cast-crew-load-more-text">
					<?php esc_html_e( 'Load More', 'screen-time' ); ?>
				</p>
			</div>
		</div>
	<?php endif; ?>
</div>
<?php
get_footer();
