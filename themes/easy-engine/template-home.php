<?php
/**
 * Template Name:Home
 *
 * This file is a template file for the front page.
 *
 * @package EasyEngine
 * @since 1.0.0
 */

get_header();
?>
<section class="front-page-wrapper">
	<div class="content-wrapper">
		<?php
		if ( ! empty( get_the_content() ) ) {
			the_content();
		}
		?>
	</div>
	<div class="details">
		<?php
		$features = new WP_Query(
			array(
				'post_type'     => 'post',
				'category_name' => 'features',
			)
		);
		?>
		<?php if ( $features->have_posts() ) : ?>
			<section class="features-section">
				<h2>
					<?php esc_html_e( 'Features 🎩', 'easy-engine' ); ?>
				</h2>
				<div class="features-wrapper">
					<?php
					while ( $features->have_posts() ) {
						$features->the_post();
						?>
						<div class="feature-post">
							<?php the_title( '<h2 class="post-title">', '</h2>' ); ?>
							<?php the_content(); ?>
						</div>
						<?php
					}
					wp_reset_postdata();
					?>
				</div>
			</section>
		<?php endif; ?>

		<?php
		$advantages = new WP_Query(
			array(
				'post_type'     => 'post',
				'category_name' => 'pros',
			)
		);
		?>
		<?php if ( $advantages->have_posts() ) : ?>
			<section class="advantages-section">
				<h2>
					<?php esc_html_e( 'Developer Friendly 🤓', 'easy-engine' ); ?>
				</h2>
				<div class="advantages-wrapper">
					<?php
					while ( $advantages->have_posts() ) {
						$advantages->the_post();
						?>
						<div class="advantage-post">
							<?php the_title( '<h2 class="post-title">', '</h2>' ); ?>
							<?php the_content(); ?>
						</div>
						<?php
					}
					wp_reset_postdata();
					?>
				</div>
			</section>
		<?php endif; ?>

		<?php
		$ted_talks = new WP_Query(
			array(
				'post_type'     => 'post',
				'category_name' => 'ted-talks',
			)
		);
		?>
		<?php if ( $ted_talks->have_posts() ) : ?>
			<section class="ted-talks-section">
				<h2>
					<?php esc_html_e( 'EasyEngine at Conferences 📢', 'easy-engine' ); ?>
				</h2>
				<div class="ted-talks-wrapper">
					<?php
					while ( $ted_talks->have_posts() ) {
						$ted_talks->the_post();
						?>
						<div class="ted-talks-post">
							<?php the_content(); ?>
						</div>
						<?php
					}
					wp_reset_postdata();
					?>
				</div>
			</section>
		<?php endif; ?>

		<?php
		$testimonials = new WP_Query(
			array(
				'post_type'     => 'post',
				'category_name' => 'testimonial',
			)
		);
		?>
		<?php if ( $testimonials->have_posts() ) : ?>
			<section class="testimonials-section">
				<h2>
					<?php esc_html_e( 'What people are saying about EasyEngine 🤗', 'easy-engine' ); ?>
				</h2>
				<div class="testimonials-wrapper">
					<?php
					while ( $testimonials->have_posts() ) {
						$testimonials->the_post();
						?>
						<div class="testimonials-post">
							<?php the_content(); ?>
						</div>
						<?php
					}
					wp_reset_postdata();
					?>
				</div>
			</section>
		<?php endif; ?>

		<?php
		$need_help = new WP_Query(
			array(
				'post_type'     => 'post',
				'category_name' => 'need-help',
			)
		);
		?>
		<?php if ( $need_help->have_posts() ) : ?>
			<section class="help-section">
				<h2>
					<?php esc_html_e( 'Need help? ⛑️', 'easy-engine' ); ?>
				</h2>
				<div class="help-wrapper">
					<?php
					while ( $need_help->have_posts() ) {
						$need_help->the_post();
						?>
						<div class="help-post">
							<?php the_title( '<h2 class="post-title">', '</h2>' ); ?>
							<?php the_content(); ?>
						</div>
						<?php
					}
					wp_reset_postdata();
					?>
				</div>
			</section>
		<?php endif; ?>

		<div class="get-started-btn-wrapper">
			<div class="get-started-btn">
				<a>Get Started</a>
			</div>
		</div>
	</div>
</section>
<?php
get_footer();


