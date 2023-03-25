<?php
/**
 * This file is used to setup theme enqueue scripts and styles.
 *
 * @package EasyEngine
 */

if ( ! function_exists( 'ee_theme_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	function ee_theme_setup(): void {
		// Make theme available for translation.
		load_theme_textdomain( 'easy-engine', get_template_directory() . '/languages' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Add support for custom logo.
		add_theme_support( 'custom-logo', );

		// Set the default content width.
		$GLOBALS['content_width'] = 580;

		// Register navigation menus uses wp_nav_menu in five places.
		register_nav_menus(
			array(
				'primary-menu'  => __( 'Header Menu', 'screen-time' ),
				'social-menu'   => __( 'Social Menu', 'screen-time' ),
				'documentation' => __( 'Documentation Menu', 'screen-time' ),
				'community'     => __( 'Community Menu', 'screen-time' ),
				'easy-engine'   => __( 'EasyEngine', 'screen-time' ),
				'footer'        => __( 'Footer Menu', 'screen-time' ),
			)
		);

		// Switch default core markup for search form, comment form, and comments
		// to output valid HTML5.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		add_theme_support( 'custom-spacing' );
		add_theme_support( 'custom-units' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'custom-line-height' );
		add_theme_support( 'appearance-tools' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		add_theme_support( 'widgets' );

	}

	add_action( 'after_setup_theme', 'ee_theme_setup' );
endif;

if ( ! function_exists( 'get_breadcrumbs' ) ) :

	/**
	 * Get the breadcrumbs.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	function get_breadcrumbs(): void {
		$show_on_home = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show.
		$delimiter    = '&raquo;'; // delimiter between crumbs.
		$home         = __( 'Home', 'easy-engine' ); // text for the 'Home' link.
		$show_current = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show.
		$before       = '<span class="current">'; // tag before the current crumb.
		$after        = '</span>'; // tag after the current crumb.

		global $post;
		$home_link = get_bloginfo( 'url' );
		if ( is_home() || is_front_page() ) {
			if ( 1 === $show_on_home ) {
				?>
				<div id="breadcrumbs">
					<a href="<?php echo esc_url( $home_link ); ?>">
						<?php esc_html( $home ); ?>
					</a>
				</div>
				<?php
			}
		} else {
			?>
			<div id="breadcrumbs">
				<a href="<?php echo esc_url( $home_link ); ?>"> <?php echo esc_html( $home ); ?></a> <?php echo esc_html( $delimiter ); ?>
			<?php
			if ( is_category() ) {
				$this_cat = get_category( get_query_var( 'cat' ), false );
				if ( 0 !== $this_cat->parent ) {
					echo esc_html( get_category_parents( $this_cat->parent, true, ' ' . $delimiter . ' ' ) );
				}
				echo $before . 'Archive by category "' . single_cat_title( '', false ) . '"' . $after;
			} elseif ( is_search() ) {
				echo $before . 'Search results for "' . get_search_query() . '"' . $after;
			} elseif ( is_day() ) {
				echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
				echo '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a> ' . $delimiter . ' ';
				echo $before . get_the_time( 'd' ) . $after;
			} elseif ( is_month() ) {
				echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
				echo $before . get_the_time( 'F' ) . $after;
			} elseif ( is_year() ) {
				echo $before . get_the_time( 'Y' ) . $after;
			} elseif ( is_single() && ! is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object( get_post_type() );
					$slug      = $post_type->rewrite;
					echo '<a href="' . $home_link . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
					if ( $show_current == 1 ) {
						echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
					}
				} else {
					$cat  = get_the_category();
					$cat  = $cat[0];
					$cats = get_category_parents( $cat, true, ' ' . $delimiter . ' ' );
					if ( $show_current == 0 ) {
						$cats = preg_replace( "#^(.+)\s$delimiter\s$#", '$1', $cats );
					}
					echo $cats;
					if ( $show_current == 1 ) {
						echo $before . get_the_title() . $after;
					}
				}
			} elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
				$post_type = get_post_type_object( get_post_type() );
				echo $before . $post_type->labels->singular_name . $after;
			} elseif ( is_attachment() ) {
				$parent = get_post( $post->post_parent );
				$cat    = get_the_category( $parent->ID );
				$cat    = $cat[0];
				echo get_category_parents( $cat, true, ' ' . $delimiter . ' ' );
				echo '<a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a>';
				if ( $show_current == 1 ) {
					echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
				}
			} elseif ( is_page() && ! $post->post_parent ) {
				if ( $show_current == 1 ) {
					echo $before . get_the_title() . $after;
				}
			} elseif ( is_page() && $post->post_parent ) {
				$parent_id   = $post->post_parent;
				$breadcrumbs = array();
				while ( $parent_id ) {
					$page          = get_post( $parent_id );
					$breadcrumbs[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
					$parent_id     = $page->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
					echo $breadcrumbs[ $i ];
					if ( $i != count( $breadcrumbs ) - 1 ) {
						echo ' ' . $delimiter . ' ';
					}
				}
				if ( $show_current == 1 ) {
					echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
				}
			} elseif ( is_tag() ) {
				echo $before . 'Posts tagged "' . single_tag_title( '', false ) . '"' . $after;
			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata( $author );
				echo $before . 'Articles posted by ' . $userdata->display_name . $after;
			} elseif ( is_404() ) {
				echo $before . 'Error 404' . $after;
			}
			if ( get_query_var( 'paged' ) ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ' (';
				}
				echo __( 'Page' ) . ' ' . get_query_var( 'paged' );
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ')';
				}
			}
			echo '</div>';
		}
	}
endif;

if ( ! function_exists( 'ee_theme_scripts' ) ) :

	/**
	 * Enqueue scripts and styles.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	function ee_theme_scripts(): void {
		// Ignoring the version number because it's a Google font.
		wp_enqueue_style(
			'font-families',
			'https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@100;200;300;400;500;600;700;800;900&family=Heebo:wght@100;200;300;400;500;600;700;800;900&display=swap',
			array(),
			null
		); // phpcs:ignore:WordPress.WP.EnqueuedResourceParameters.MissingVersion
		wp_enqueue_style(
			'font-awesome',
			'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css',
			array(),
			null
		); // phpcs:ignore:WordPress.WP.EnqueuedResourceParameters.MissingVersion

		wp_enqueue_style( 'ee-style', get_template_directory_uri() . '/style.css', array(), filemtime( get_template_directory() . '/style.css' ) );
		wp_enqueue_style( 'ee-common-style', get_template_directory_uri() . '/assets/scss/common.css', array(), filemtime( get_template_directory() . '/assets/scss/common.css' ) );
		wp_enqueue_style( 'ee-header-style', get_template_directory_uri() . '/assets/scss/header.css', array(), filemtime( get_template_directory() . '/assets/scss/header.css' ) );
		wp_enqueue_style( 'ee-footer-style', get_template_directory_uri() . '/assets/scss/footer.css', array(), filemtime( get_template_directory() . '/assets/scss/footer.css' ) );
		wp_enqueue_style( 'ee-blog-style', get_template_directory_uri() . '/assets/scss/blog.css', array(), filemtime( get_template_directory() . '/assets/scss/blog.css' ) );
		wp_enqueue_style( 'ee-single-post-style', get_template_directory_uri() . '/assets/scss/single-post.css', array(), filemtime( get_template_directory() . '/assets/scss/single-post.css' ) );
		wp_enqueue_style( 'ee-front-page-style', get_template_directory_uri() . '/assets/scss/front-page.css', array(), filemtime( get_template_directory() . '/assets/scss/front-page.css' ) );

		wp_enqueue_script( 'ee-expand-menu', get_template_directory_uri() . '/assets/js/expand-menu.js', array(), filemtime( get_template_directory() . '/assets/js/expand-menu.js' ), true );

	}
	add_action( 'wp_enqueue_scripts', 'ee_theme_scripts' );
endif;

