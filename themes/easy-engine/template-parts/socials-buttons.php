<?php
/**
 * This file is used to display the social share buttons.
 */

$facebook_share_link = 'https://www.facebook.com/sharer/sharer.php?u=' . get_permalink();
$twitter_share_link  = 'https://twitter.com/intent/tweet?text=' . get_the_title() . '&url=' . get_permalink();
$reddit_share_link   = 'https://www.reddit.com/submit?url=' . get_permalink() . '&title=' . get_the_title();
$pocket_share_link   = 'https://getpocket.com/save?url=' . get_permalink() . '&title=' . get_the_title();

?>

<div class="social-buttons">
	<div class="social-buttons__share">
		<span><?php esc_html_e( 'Share this:', 'easy-engine' ); ?></span>
		<div class="share-buttons">
			<a href="<?php echo esc_url( $facebook_share_link ); ?>" target="_blank">
				<button><i class="fa-brands fa-facebook"></i> <?php esc_html_e( 'Facebook', 'easy-engine' ); ?> </button>
			</a>
			<a href="<?php echo esc_url( $twitter_share_link ); ?>" target="_blank">
				<button><i class="fa-brands fa-twitter"></i> <?php esc_html_e( 'Twitter', 'easy-engine' ); ?> </button>
			</a>
			<a href="<?php echo esc_url( $reddit_share_link ); ?>" target="_blank">
				<button><i class="fa-brands fa-reddit"></i> <?php esc_html_e( 'Reddit', 'easy-engine' ); ?> </button>
			</a>
			<a href="<?php echo esc_url( $pocket_share_link ); ?>" target="_blank">
				<button><i class="fa-brands fa-get-pocket"></i> <?php esc_html_e( 'Pocket', 'easy-engine' ); ?> </button>
			</a>
			<button id="print"><i class="fa-solid fa-print"></i> <?php esc_html_e( 'Print', 'easy-engine' ); ?> </button>
			<div class="email-wrapper">
				<button id="email"><i class="fa-solid fa-envelope"></i> <?php esc_html_e( 'Email', 'easy-engine' ); ?> </button>

				<div class="email-dialog">
					<form class="email-form">
						<?php wp_nonce_field( 'send_email', 'send_email_nonce' ); ?>
						<label for="destination-email"><?php esc_html_e( 'Send to Email Address', 'easy-engine' ); ?></label>
						<input type="email" name="destination-email" id="destination-email" ?>
						<label for="name"><?php esc_html_e( 'Your Name', 'easy-engine' ); ?></label>
						<input type="text" name="name" id="name" ">
						<label for="your-email"><?php esc_html_e( 'Your Email', 'easy-engine' ); ?></label>
						<input type="email" name="your-email" id="your-email" ">

						<div class="button-container">
							<button id="send-email"><?php esc_html_e( 'Send Email', 'easy-engine' ); ?></button>

							<a id="cancel-email"><?php esc_html_e( 'Cancel', 'easy-engine' ); ?></a>
						</div>

						<div class="email-error-message"></div>
					</form>

					<div class="email-success">
						<div class="email-success-message"></div>
						<a id="close-success-message"><?php esc_html_e( 'Close', 'easy-engine' ); ?></a>
					</div>
				</div>
			</div>


		</div>
	</div>

	<div class="social-buttons__like">
		<span><?php esc_html_e( 'Like this:', 'easy-engine' ); ?></span>
		<div class="like-button">
			<button id="like"><i id="like-icon" class="fa-sharp fa-regular fa-star"></i> <?php esc_html_e( 'Like', 'easy-engine' ); ?> </button>
		</div>
		<p><?php esc_html_e( 'Be the first to like this', 'easy-engine' ); ?></p>
	</div>
</div>

