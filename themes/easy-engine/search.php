<?php
/**
 * This file is template for the search result page.
 *
 * @package EasyEngine
 * @since 1.0.0
 */

/**
 * This is security to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="search-result-wrapper">

	<div class="breadcrumb-wrapper">
		<?php get_breadcrumbs(); ?>
	</div>

	<div class="content-wrapper">
		<?php
		if ( have_posts() ) :
			?>
			<h1 class="search-result-title">
				<?php
				/* translators: %s: search query. */
				echo esc_html( sprintf( __( 'Search Results for: %s', 'easy-engine' ), get_search_query() ) );
				?>
			</h1>
			<div class="search-result-count">
				<?php
				echo esc_html(
					sprintf(
					/* translators: %s: search result count. */
						_n(
							'%s Result Found',
							'%s Results Found',
							$wp_query->found_posts,
							'easy-engine'
						),
						number_format_i18n( $wp_query->found_posts )
					)
				);
				?>
			</div>

			<div class="search-result-list-wrapper">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<div class="post-wrapper">
					<div class="post-date">
						<!-- Using get_the_date() because the_date() was not giving the date of multiple post of the same date -->
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
									<?php esc_html_e( 'Posted by', 'easy-engine' ); ?>  <span><?php the_author_link(); ?></span>
								</div>
								<?php
							endif;
							?>

							<?php
							if ( has_category() ) :
								?>
								<div class="post-category">
									<?php esc_html_e( 'Category', 'easy-engine' ); ?>

									<?php the_category( ', ' ); ?>
								</div>
								<?php
							endif;
							?>

							<?php
							if ( has_tag() ) :
								?>
								<div class="post-tag">
									<?php esc_html_e( 'Tagged', 'easy-engine' ); ?>

									<?php the_tags( '', ', ' ); ?>
								</div>
								<?php
							endif;
							?>
						</div>
					</div>
				</div>
				<?php
			endwhile;
			// Previous/next page navigation.
			the_posts_pagination(
				array(
					'mid_size'  => 2,
					'prev_text' => __( '&laquo; Previous', 'easy-engine' ),
					'next_text' => __( 'Next &raquo;', 'easy-engine' ),
				)
			);
			?>
			</div>
			<?php
		else :
			?>
			<h1 class="search-result-title">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'No Results Found for: %s', 'easy-engine' ), get_search_query() );
				?>
			</h1>
			<?php
		endif;
		?>
	</div>
</section>

<?php
wp_reset_postdata();
get_footer();
