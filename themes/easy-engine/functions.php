<?php
/**
 * This file is used to setup theme enqueue scripts and styles.
 *
 * @package EasyEngine
 * @since 1.0.0
 */

/**
 * This is security to prevent direct access to the file.
 */
defined( 'ABSPATH' ) || exit;

require_once get_template_directory() . '/settings/settings-page.php';

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

		add_theme_support( 'custom-logo', );

		// Customize Selective Refresh Widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support( 'custom-spacing' );
		add_theme_support( 'custom-units' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'custom-line-height' );
		add_theme_support( 'appearance-tools' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

	}
endif;
add_action( 'after_setup_theme', 'ee_theme_setup' );

add_action( 'admin_menu', 'add_ee_sub_menu' );

if ( ! function_exists( 'ee_get_breadcrumbs' ) ) :

	/**
	 * Get the breadcrumbs.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	function ee_get_breadcrumbs() {
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
				echo esc_html( sprintf( __( '%sBlog', 'easy-engine' ), $delimiter ) );
			}

			if ( is_category() || is_single() || is_tag() ) {
				if ( is_single() ) {
					?>
					<?php
					$cat = get_the_category()[0];
					// translators: 1. %s is the delimiter, 2. %s is the category name.
					echo esc_html( sprintf( '%1$s%2$s', $delimiter, $cat->name ) );
					?>

					<span class="current">
						<?php
						echo esc_html( $delimiter );
						the_title();
						?>
					</span>
					<?php
				} else {
					if ( is_category() ) {
						?>
						<span class="current">
							<?php
							echo esc_html( $delimiter );
							echo esc_html( single_cat_title() );
							?>
						</span>
						<?php
					} else {
						?>
						<span class="current">
							<?php
							echo esc_html( $delimiter );
							echo esc_html( single_tag_title() );
							?>
						</span>
						<?php
					}
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
		wp_enqueue_style( // phpcs:ignore:WordPress.WP.EnqueuedResourceParameters.MissingVersion -- Ignoring the version number because it's a Google font.
			'font-families',
			'https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@100;200;300;400;500;600;700;800;900&family=Heebo:wght@100;200;300;400;500;600;700;800;900&display=swap',
			array(),
			null
		);
		wp_enqueue_style( // phpcs:ignore:WordPress.WP.EnqueuedResourceParameters.MissingVersion -- Ignoring the version number because it's a Font Awesome.
			'font-awesome',
			'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css',
			array(),
			null
		);

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

		wp_enqueue_script( 'ee-expand-menu', get_template_directory_uri() . '/assets/js/expand-menu.js', array(), filemtime( get_template_directory() . '/assets/js/expand-menu.js' ), true );
		wp_enqueue_script( 'ee-search-form', get_template_directory_uri() . '/assets/js/search-form.js', array(), filemtime( get_template_directory() . '/assets/js/search-form.js' ), true );
		wp_enqueue_script( 'ee-share-buttons', get_template_directory_uri() . '/assets/js/share-buttons.js', array( 'wp-i18n' ), filemtime( get_template_directory() . '/assets/js/share-buttons.js' ), true );
		wp_set_script_translations( 'ee-share-buttons', 'easy-engine' );

	}
endif;
add_action( 'wp_enqueue_scripts', 'ee_theme_scripts' );
