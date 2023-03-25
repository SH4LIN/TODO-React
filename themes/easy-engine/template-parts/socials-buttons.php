<?php
/**
 * This file is used to display the social share buttons.
 */

?>

<div class="social-buttons">

	<div class="social-buttons__share">
		<span><?php esc_html_e( 'Share this:', 'easy-engine' ); ?></span>
		<div class="share-buttons">
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" target="_blank">
				<button><i class="fa-brands fa-facebook"></i> <?php echo esc_html_e( 'Facebook', 'easy-engine' ); ?> </button>
			</a>
			<a href="https://twitter.com/intent/tweet?text=<?php echo get_the_title(); ?>&url=<?php echo get_permalink(); ?>" target="_blank">
				<button><i class="fa-brands fa-twitter"></i> <?php echo esc_html_e( 'Twitter', 'easy-engine' ); ?> </button>
			</a>
			<a href="https://twitter.com/intent/tweet?text=<?php echo get_the_title(); ?>&url=<?php echo get_permalink(); ?>" target="_blank">
				<button><i class="fa-brands fa-reddit"></i> <?php echo esc_html_e( 'Reddit', 'easy-engine' ); ?> </button>
			</a>
			<a href="https://twitter.com/intent/tweet?text=<?php echo get_the_title(); ?>&url=<?php echo get_permalink(); ?>" target="_blank">
				<button><i class="fa-brands fa-get-pocket"></i> <?php echo esc_html_e( 'Pocket', 'easy-engine' ); ?> </button>
			</a>
			<a href="https://twitter.com/intent/tweet?text=<?php echo get_the_title(); ?>&url=<?php echo get_permalink(); ?>" target="_blank">
				<button><i class="fa-solid fa-print"></i> <?php echo esc_html_e( 'Print', 'easy-engine' ); ?> </button>
			</a>
			<a href="https://twitter.com/intent/tweet?text=<?php echo get_the_title(); ?>&url=<?php echo get_permalink(); ?>" target="_blank">
				<button><i class="fa-solid fa-envelope"></i> <?php echo esc_html_e( 'Email', 'easy-engine' ); ?> </button>
			</a>
		</div>
	</div>

	<div class="social-buttons__like">
		<span><?php esc_html_e( 'Like this:', 'easy-engine' ); ?></span>
		<div class="like-button">
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" target="_blank">
				<button><i class="fa-sharp fa-regular fa-star"></i> <?php esc_html_e( 'Like', 'easy-engine' ); ?> </button>
			</a>
		</div>
		<p><?php esc_html_e( 'Be the first to like this', 'easy-engine' ); ?></p>
	</div>
</div>

