<?php
/**
 * This file is used to display the blog posts from blog page or from the search page.
 *
 * @package EasyEngine
 * @since 1.0.0
 */

?>

<div class="post-wrapper">
	<div class="post-date">
		<a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_date() ); ?></a>
	</div>

	<div class="post-data">
		<?php
		if ( ! empty( get_the_title() ) ) :
			?>
			<div class="post-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</div>
			<?php
		endif;
		?>

		<div class="post-meta">
			<?php
			if ( ! empty( get_the_author() ) ) :
				?>
				<div class="post-author">
					<?php esc_html_e( 'Posted by', 'easy-engine' ); ?>  <?php the_author_link(); ?>
				</div>
				<?php
			endif;
			?>

			<?php
			if ( has_category() ) :
				?>
				<div class="post-category">
					<?php esc_html_e( 'Category', 'easy-engine' ); ?> <?php the_category( ', ' ); ?>
				</div>
				<?php
			endif;
			?>

			<?php
			if ( has_tag() ) :
				?>
				<div class="post-tag">
					<?php esc_html_e( 'Tagged', 'easy-engine' ); ?> <?php the_tags( '', ', ' ); ?>
				</div>
				<?php
			endif;
			?>
		</div>
	</div>
</div>
