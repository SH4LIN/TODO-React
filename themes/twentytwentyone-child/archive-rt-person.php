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
<div class="ap-wrapper"> <!-- ap-container -->
	<?php if ( count( $persons_details ) > 0 ) : ?>
		<div class="st-ap-cast-crew-container"> <!-- cast-crew-container -->
			<div class="st-ap-cast-crew-heading-container"> <!-- cast-crew-heading-container -->
				<div class="primary-text-secondary-font st-ap-cast-crew-heading-text"> <!-- cast-crew-heading-text -->
					<?php esc_html_e( 'Cast & Crew', 'screen-time' ); ?>
				</div>  <!-- /cast-crew-heading-text -->
			</div> <!-- /cast-crew-heading-container -->

			<div class="st-ap-cast-crew-list-container"> <!-- cast-crew-list-container -->
				<?php foreach ( $persons_details as $person ) : ?>
					<a href="<?php echo esc_url( get_permalink( $person['id'] ) ); ?>">
					<div class="st-ap-cast-crew-list-mobile"> <!-- cast-crew-list-mobile -->
						<div class="st-ap-cast-crew-list-item"> <!-- cast-crew-list-item -->
							<div class="st-ap-cast-crew-poster-container"> <!-- cast-crew-poster-container -->
								<img src="<?php echo esc_url( $person['profile_picture'] ); ?>" loading="lazy" />
							</div> <!-- /cast-crew-poster-container -->

							<div class="st-ap-cast-crew-details-container"> <!-- cast-crew-details-container -->
								<div class="primary-text-secondary-font st-ap-cast-crew-name-text"> <!-- cast-crew-name-text -->
									<?php echo wp_kses( $person['name'], array( 'span' => array( 'class' => array() ) ) ); ?>
								</div> <!-- /cast-crew-name-text -->

								<?php if ( ! empty( $person['birth_date'] ) ) : ?>
									<div class="secondary-text-primary-font st-ap-cast-crew-birth-date-text"> <!-- cast-crew-birth-date-text -->
										<?php echo esc_html( $person['birth_date'] ); ?>
									</div> <!-- /cast-crew-birth-date-text -->
								<?php endif; ?>

								<?php if ( ! empty( $person['excerpt'] ) ) : ?>
									<div class="primary-text-primary-font st-ap-cast-crew-excerpt-text"> <!-- cast-crew-excerpt-text -->
										<?php echo esc_html( $person['excerpt'] ); ?>
									</div> <!-- /cast-crew-excerpt-text -->
								<?php endif; ?>

								<div class="primary-text-primary-font st-ap-cast-crew-learn-more-text"> <!-- cast-crew-learn-more-text -->
									<?php esc_html_e( 'Learn more', 'screen-time' ); ?>
								</div> <!-- /cast-crew-learn-more-text -->

							</div> <!-- /cast-crew-details-container -->
						</div> <!-- /cast-crew-list-item -->

						<?php if ( ! empty( $person['excerpt'] ) ) : ?>
							<div class="primary-text-primary-font st-ap-cast-crew-excerpt-text-mobile"> <!-- cast-crew-excerpt-text-mobile -->
								<?php echo esc_html( $person['excerpt'] ); ?>
							</div> <!-- /cast-crew-excerpt-text-mobile -->
						<?php endif; ?>

						<div class="primary-text-primary-font st-ap-cast-crew-learn-more-text-mobile"> <!-- cast-crew-learn-more-text-mobile -->
							<?php esc_html_e( 'Learn more', 'screen-time' ); ?>
						</div> <!-- /cast-crew-learn-more-text-mobile -->
					</div> <!-- /cast-crew-list-mobile -->
				</a>
				<?php endforeach; ?>
			</div> <!-- /cast-crew-list-container -->

			<div class="st-ap-cast-crew-load-more-container"> <!-- cast-crew-load-more-container -->
				<div class="primary-text-primary-font st-ap-cast-crew-load-more-text"> <!-- cast-crew-load-more-text -->
					<?php esc_html_e( 'Load More', 'screen-time' ); ?>
				</div> <!-- /cast-crew-load-more-text -->
			</div> <!-- /cast-crew-load-more-container -->
		</div> <!-- /cast-crew-container -->
	<?php endif; ?>
</div> <!-- /ap-container -->
<?php
get_footer();
