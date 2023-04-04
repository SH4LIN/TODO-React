<?php
/**
 * This file is used to display the movie card on the dashboard widget.
 *
 * @package MovieLib\admin\classes\partials
 */

/**
 * This is a security measure to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

?>
<ul>
	<?php
	foreach ( $movies as $movie ) {
		?>
		<li>
			<a href="<?php echo esc_url( $movie['poster'] ); ?>">
				<div class="poster-wrapper">
					<img src="<?php echo esc_url( $movie['poster'] ); ?>" alt="<?php echo esc_attr( $movie['title'] ); ?>">
					<div class="overlay"></div>
					<p><?php echo esc_html( $movie['title'] ); ?></p>
				</div>

			</a>
			<div class="widget-action-buttons">
				<?php if ( ! empty( $movie['edit_link'] ) ) { ?>
					<a href="<?php echo esc_url( $movie['edit_link'] ); ?>" class="button button-primary"><?php esc_html_e( 'Edit', 'movie-library' ); ?></a>
				<?php } ?>

				<?php if ( ! empty( $movie['view_link'] ) ) { ?>
					<a href="<?php echo esc_url( $movie['view_link'] ); ?>" class="button button-secondary"><?php esc_html_e( 'View', 'movie-library' ); ?></a>
				<?php } ?>
			</div>
		</li>
		<?php
	}
	?>
</ul>
