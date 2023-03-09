<?php
/**
 * This file is used to display the slider on the archive page of the rt-movie post type.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One_Child
 * @since Twenty Twenty-One Child 1.0
 */

?>
<div class="st-am-slider-container">
	<div class="st-am-slider">
		<?php

		if ( have_posts() ) {
			$image_counter = 0;
			while ( have_posts() && $image_counter < 4 ) {
				$image_counter++;
				the_post();
				?>
					<div class="st-am-slider-item">
						<div class="st-am-slider-item-image-container">
							<img src="<?php echo esc_url( get_the_post_thumbnail_url() ); ?>" class="st-am-slider-item-image">
						</div>
					</div>
					<?php
			}
		}
		?>
	</div>
</div>
