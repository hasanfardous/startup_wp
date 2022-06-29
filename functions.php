<?php
/**
 * Startup WP functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Startup_WP
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
	define( 'TEMPLATE_DIR', get_template_directory_uri() );
	define( 'TEMPLATE_CSS_DIR', get_template_directory_uri() . '/css' );
	define( 'TEMPLATE_JS_DIR', get_template_directory_uri() . '/js' );
	define( 'TEMPLATE_IMG_DIR', get_template_directory_uri() . '/img' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function startup_wp_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Startup WP, use a find and replace
		* to change 'startup_wp' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'startup_wp', get_template_directory() . '/languages' );

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
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'startup_wp' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
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

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'startup_wp_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'startup_wp_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function startup_wp_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'startup_wp_content_width', 640 );
}
add_action( 'after_setup_theme', 'startup_wp_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function startup_wp_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'startup_wp' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'startup_wp' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'startup_wp_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function startup_wp_scripts() {
	// Enqueue CSS Files
	wp_enqueue_style( 'startup_wp-font-awesome', TEMPLATE_CSS_DIR . '/font-awesome.min.css', array(), _S_VERSION );
	wp_enqueue_style( 'startup_wp-owl-carousel', TEMPLATE_CSS_DIR . '/owl.carousel.min.css', array(), _S_VERSION );
	wp_enqueue_style( 'startup_wp-animate-css', TEMPLATE_CSS_DIR . '/animate.min.css', array(), _S_VERSION );
	wp_enqueue_style( 'startup_wp-bootstrap-css', TEMPLATE_CSS_DIR . '/bootstrap.min.css', array(), _S_VERSION );
	wp_enqueue_style( 'startup_wp-style-css', TEMPLATE_CSS_DIR . '/style.css', array(), _S_VERSION );
	wp_enqueue_style( 'startup_wp-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'startup_wp-style', 'rtl', 'replace' );

	// Enqueue JS Files
	wp_enqueue_script( 'startup_wp_bootstrap-js', TEMPLATE_JS_DIR . '/bootstrap.bundle.min.js', array('jquery'), _S_VERSION, true );
	wp_enqueue_script( 'startup_wp_wow-js', TEMPLATE_JS_DIR . '/wow.min.js', array('jquery'), _S_VERSION, true );
	wp_enqueue_script( 'startup_wp_waypoint-js', TEMPLATE_JS_DIR . '/waypoints.min.js', array('jquery'), _S_VERSION, true );
	wp_enqueue_script( 'startup_wp_counterup-js', TEMPLATE_JS_DIR . '/counterup.min.js', array('jquery'), _S_VERSION, true );
	wp_enqueue_script( 'startup_wp_owl-carousel-js', TEMPLATE_JS_DIR . '/owl.carousel.min.js', array('jquery'), _S_VERSION, true );
	wp_enqueue_script( 'startup_wp-navigation', TEMPLATE_JS_DIR . '/navigation.js', array('jquery'), _S_VERSION, true );
	wp_enqueue_script( 'startup_wp-main-js', TEMPLATE_JS_DIR . '/main.js', array('jquery'), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'startup_wp_scripts' );

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

