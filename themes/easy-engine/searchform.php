<?php
/**
 * Search Form Template.
 */

?>
<div class="search-container">
	<button id="search" class="search-toggle" aria-controls="search-container" aria-expanded="false">
		<i class="fas fa-search fa-lg"></i>
	</button>

	<button id="search-close" class="hidden" aria-controls="primary-menu" aria-expanded="false">
		<i class="fas fa-times fa-lg"></i>
	</button>


	<form class="search-form">
		<div class="search-input">
			<input type="search" id="search-input" class="search-field" placeholder="<?php esc_attr_e( 'Search', 'easy-engine' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
			<button type="submit" class="search-submit">
				<i class="fas fa-search fa-lg"></i>
			</button>
		</div>
	</form>
</div>

