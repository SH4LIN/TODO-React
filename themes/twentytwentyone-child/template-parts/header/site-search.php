<?php
/**
 * This file is used to show the search icon and text in the header of the website.
 *
 * @package WordPress
 * @subpackage TwentyTwentyOneChild
 * @since Twenty Twenty-One Child 1.0
 */

?>
<div class="search-container">
	<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/ic_search.svg' ); ?>">
	<span class="primary-text-primary-font heading-text search-text"><?php esc_html_e( 'Search' ); ?></span>
</div>
