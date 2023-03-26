<?php
/**
 * This file is template for the search result page.
 *
 * @package EasyEngine
 * @since 1.0.0
 */

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
				/* translators: %s: search result count. */
				echo esc_html( sprintf( __( '%s Results Found', 'easy-engine' ), $wp_query->found_posts ) );
				?>
			</div>

			<div class="search-result-list-wrapper">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/blog-template' );
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
				printf( esc_html__( 'No Results Found for: %s', 'easy-engine' ), '<span>' . get_search_query() . '</span>' );
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
