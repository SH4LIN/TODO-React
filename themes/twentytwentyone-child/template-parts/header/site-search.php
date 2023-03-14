<?php
/**
 * This file is used to show the search icon and text in the header of the website.
 *
 * @package WordPress
 * @subpackage TwentyTwentyOneChild
 * @since 1.0.0
 */

?>
<div class="st-header-search-container"> <!-- header-search-container -->
	<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_search.svg' ); ?>">
	<span class="primary-text-primary-font st-header-text st-header-search-text">
		<?php esc_html_e( 'Search', 'screen-time' ); ?>
	</span>
</div> <!-- /header-search-container -->
