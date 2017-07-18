<?php
/**
 * shared functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package shared
 */

if ( ! function_exists( 'shared_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function shared_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on shared, use a find and replace
	 * to change 'shared' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'shared', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'twentyfourteen-full-width', 1038, 576, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'shared' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'shared_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 250,
		'width'       => 250,
		'flex-width'  => true,
		'flex-height' => true,
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );

	// Add support for featured content.
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'twentyfourteen_get_featured_posts', // TODO: remove 2014
		'max_posts' => 6,
	) );

}
endif;
add_action( 'after_setup_theme', 'shared_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function shared_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'shared_content_width', 640 );
}
add_action( 'after_setup_theme', 'shared_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function shared_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'shared' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'shared' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'shared_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function shared_scripts() {
	wp_enqueue_style( 'shared-style', get_stylesheet_uri() );

	wp_enqueue_script( 'shared-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', false );

	wp_enqueue_script( 'shared-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', false );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'shared_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/* My horrid hacking. */

/**
 * Getter function for Featured Content Plugin.
 *
 * @since Twenty Fourteen 1.0
 *
 * @return array An array of WP_Post objects.
 */
function shared_get_featured_posts() {
	$featured_posts =  get_posts( array(
		'numberposts' => 6,
		'tag' => 'featured',
		'orderby' => 'date',
		'order' => 'DESC'
	) );
	return $featured_posts;
}

function shared_get_featured_posts_ids() {
	$ids = array();
	foreach (shared_get_featured_posts() as $post) {
		$ids[] = $post->ID;
	}
	return $ids;
}

// Deferred load of scripts.
function yg_defer_scripts($url) {
		$defer_scripts = Array(
				'navigation.js',
				'skip-link-focus-fix.js',
				'wp-embed.min.js',
				'jquery.min.js',
		);
		foreach ( $defer_scripts as $script) {
				if ( strpos( $url, $script) !== false ) {
						$url .= "' defer='defer"; # XSS for fun and profit.
						break;
				}
		}
		return $url;
}
add_filter( 'clean_url', 'yg_defer_scripts', 11, 1 );

function yg_replace_core_jquery_version() {
		wp_deregister_script( 'jquery' );
		// Change the URL if you want to load a local copy of jQuery from your own server.
		wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery.min.js', array(), '3.2.1' );
}
add_action( 'wp_enqueue_scripts', 'yg_replace_core_jquery_version' );
