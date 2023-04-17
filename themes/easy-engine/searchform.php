<?php
/**
 * Search Form Template.
 *
 * @package EasyEngine
 * @since 1.0.0
 */

/**
 * This is security to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

?>
<div class="search-container">
	<button id="search" class="search-toggle" aria-controls="search-container" aria-expanded="false">
		<i class="fas fa-search fa-lg"></i>
	</button>

	<button id="search-close" class="hidden" aria-controls="primary-menu" aria-expanded="false">
		<i class="fas fa-times fa-lg"></i>
	</button>


	<form class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
		<div class="search-input">
			<label for="search-input" class="screen-reader-text">
				<?php esc_html_e( 'Search', 'easy-engine' ); ?>
			</label>
			<input
				type="search"
				id="search-input"
				class="search-field"
				placeholder="<?php esc_attr_e( 'Search', 'easy-engine' ); ?>"
				value="<?php echo get_search_query(); ?>"
				name="s"
				/>
			<button type="submit" class="search-submit">
				<i class="fas fa-search fa-lg"></i>
			</button>
		</div>
	</form>
</div>
