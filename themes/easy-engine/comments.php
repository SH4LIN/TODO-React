<?php
/**
 * This file is used to display the comments.
 */

if ( have_comments() ) :
	?>
	<div class="comments-wrapper">
		<h3 class="comments-title">
			<?php
			$comments_number = get_comments_number();

			echo esc_html(
				sprintf(
					/* translators: 1: number of comments, 2: post title */
					_nx(
						'%1$s response to &ldquo;%2$s&rdquo;',
						'%1$s responses to &ldquo;%2$s&rdquo;',
						$comments_number,
						'comments title',
						'easy-engine'
					),
					number_format_i18n( $comments_number ),
					get_the_title()
				)
			);
			?>
		</h3>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'             => 'article',
					'short_ping'        => true,
					'avatar_size'       => 32,
					'edit_comment_link' => __( 'Edit', 'easy-engine' ),
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => __( '&laquo; Previous', 'easy-engine' ),
				'next_text' => __( 'Next &raquo;', 'easy-engine' ),
			)
		);
		?>
	</div>
<?php endif; // Check for have_comments(). ?>
