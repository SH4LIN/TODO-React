<?php
/**
 * This file is used to setup theme enqueue scripts and styles.
 *
 * @package EasyEngine
 * @since 1.0.0
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
		add_theme_support( 'custom-logo' );

		// Set the default content width.
		$GLOBALS['content_width'] = 580;

		// Register navigation menus uses wp_nav_menu in five places.
		register_nav_menus(
			array(
				'primary-menu'  => __( 'Header Menu', 'easy-engine' ),
				'social-menu'   => __( 'Social Menu', 'easy-engine' ),
				'documentation' => __( 'Documentation Menu', 'easy-engine' ),
				'community'     => __( 'Community Menu', 'easy-engine' ),
				'easy-engine'   => __( 'EasyEngine', 'easy-engine' ),
				'footer'        => __( 'Footer Menu', 'easy-engine' ),
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

		add_theme_support(
			'custom-logo',
			array(
				'width'       => 180,
				'height'      => 60,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Customize Selective Refresh Widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

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

require_once get_template_directory() . '/settings/settings-page.php';
add_action( 'admin_menu', 'add_ee_sub_menu' );

if ( ! function_exists( 'get_breadcrumbs' ) ) :

	/**
	 * Get the breadcrumbs.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	function get_breadcrumbs() {
		// breadcrumb function.
		$delimiter = '&nbsp;&#187;&nbsp;';
		?>
		<div class="breadcrumbs">
			<a href="<?php echo esc_url( home_url() ); ?>" rel="nofollow">
				<?php esc_html_e( 'Home', 'easy-engine' ); ?>
			</a>
			<?php
			if ( is_home() ) {
				// translators: %s is the delimiter.
				echo esc_html( sprintf( __( '%1$s Blog', 'easy-engine' ), $delimiter ) );
			}

			if ( is_category() || is_single() ) {
				if ( is_single() ) {
					?>
					<?php
					$cat           = get_the_category()[0];
					$cat_parent_id = $cat->parent;
					if ( 0 !== $cat_parent_id ) {
						// translators: 1. %s is the delimiter, 2. %s is the category name.
						echo esc_html( sprintf( '%1$s %2$s', $delimiter, get_category( $cat_parent_id )->name ) );
					} else {
						// translators: 1. %s is the delimiter, 2. %s is the category name.
						echo esc_html( sprintf( '%1$s %2$s', $delimiter, $cat->name ) );
					}

					?>

					<span class="current">
						<?php
						echo esc_html( $delimiter );
						the_title();
						?>
					</span>
					<?php
				} else {
					?>
					<span class="current">
						<?php
						// translators: 1. %s is the delimiter, 2. %s is the category name.
						echo esc_html( $delimiter );
						$category = get_the_category();
						if ( $category[0] ) {
							$category_name = $category[0]->name;
							echo esc_html( $category_name );
						}
						?>
					</span>
					<?php
				}
			} elseif ( is_page() ) {
				?>
				<span class="current">
					<?php
					echo esc_html( $delimiter );
					the_title();
					?>
				</span>
							<?php
			} elseif ( is_search() ) {
				?>
				<span class="current">
					<?php
					echo esc_html( $delimiter );
					?>
					<em>
						<?php the_search_query(); ?>
					</em>
				</span>
				<?php
			}
			?>
		</div>
		<?php
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
		wp_enqueue_style( // phpcs:ignore:WordPress.WP.EnqueuedResourceParameters.MissingVersion
			'font-families',
			'https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@100;200;300;400;500;600;700;800;900&family=Heebo:wght@100;200;300;400;500;600;700;800;900&display=swap',
			array(),
			null
		);
		wp_enqueue_style( // phpcs:ignore:WordPress.WP.EnqueuedResourceParameters.MissingVersion
			'font-awesome',
			'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css',
			array(),
			null
		); // phpcs:ignore:WordPress.WP.EnqueuedResourceParameters.MissingVersion

		wp_enqueue_style( 'ee-style', get_template_directory_uri() . '/style.css', array(), filemtime( get_template_directory() . '/style.css' ) );
		wp_enqueue_style( 'ee-common-style', get_template_directory_uri() . '/assets/css/common.css', array(), filemtime( get_template_directory() . '/assets/css/common.css' ) );
		wp_enqueue_style( 'ee-header-style', get_template_directory_uri() . '/assets/css/header.css', array(), filemtime( get_template_directory() . '/assets/css/header.css' ) );
		wp_enqueue_style( 'ee-footer-style', get_template_directory_uri() . '/assets/css/footer.css', array(), filemtime( get_template_directory() . '/assets/css/footer.css' ) );

		if ( ( is_home() || is_archive() ) && ! is_admin() ) {
			wp_enqueue_style( 'ee-blog-style', get_template_directory_uri() . '/assets/css/blog.css', array(), filemtime( get_template_directory() . '/assets/css/blog.css' ) );
		}

		if ( is_single() ) {
			wp_enqueue_style( 'ee-single-post-style', get_template_directory_uri() . '/assets/css/single-post.css', array(), filemtime( get_template_directory() . '/assets/css/single-post.css' ) );
			wp_enqueue_style( 'ee-comment-style', get_template_directory_uri() . '/assets/css/comments.css', array(), filemtime( get_template_directory() . '/assets/css/comments.css' ) );
		}

		if ( is_front_page() && ! is_admin() ) {
			wp_enqueue_style( 'ee-front-page-style', get_template_directory_uri() . '/assets/css/front-page.css', array(), filemtime( get_template_directory() . '/assets/css/front-page.css' ) );

		}

		if ( is_search() ) {
			wp_enqueue_style( 'ee-search-style', get_template_directory_uri() . '/assets/css/search.css', array(), filemtime( get_template_directory() . '/assets/css/search.css' ) );
		}

		if ( is_category() ) {
			wp_enqueue_style( 'ee-category-style', get_template_directory_uri() . '/assets/css/category.css', array(), filemtime( get_template_directory() . '/assets/css/category.css' ) );

		}

		wp_enqueue_script( 'ee-expand-menu', get_template_directory_uri() . '/assets/js/expand-menu.js', array(), filemtime( get_template_directory() . '/assets/js/expand-menu.js' ), true );
		wp_enqueue_script( 'ee-search-form', get_template_directory_uri() . '/assets/js/search-form.js', array(), filemtime( get_template_directory() . '/assets/js/search-form.js' ), true );
		wp_enqueue_script( 'ee-share-buttons', get_template_directory_uri() . '/assets/js/share-buttons.js', array( 'wp-i18n' ), filemtime( get_template_directory() . '/assets/js/share-buttons.js' ), true );

	}
	add_action( 'wp_enqueue_scripts', 'ee_theme_scripts' );
endif;

if ( ! function_exists( 'change_blog_posts' ) ) :

	/**
	 * Change the category of post to display on the blog page.
	 *
	 * @param WP_Query $query The query object.
	 * @return void
	 * @since 1.0.0
	 */
	function change_blog_posts( $query ) {
		/*
		if ( $query->is_main_query() && ! is_admin() && is_home() ) {
			$query->set( 'category_name', 'blog' );
			$query->set( 'ignore_sticky_posts', true );
		}*/

	}
	add_action( 'pre_get_posts', 'change_blog_posts' );

endif;

