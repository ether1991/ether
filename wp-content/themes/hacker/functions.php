<?php
/**
 * Hacker functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Hacker
 */

if ( ! function_exists( 'hacker_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hacker_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Hacker, use a find and replace
	 * to change 'hacker' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'hacker', get_template_directory() . '/languages' );

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
	set_post_thumbnail_size( 700, 0, true );
	add_image_size( '1920w', 1920, 0, true );
	add_image_size( '1280w', 1280, 0, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'hacker' ),
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

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'image',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'hacker_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'hacker_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function hacker_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hacker_content_width', 700 );
}
add_action( 'after_setup_theme', 'hacker_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function hacker_scripts() {
	$theme = get_theme_mod( 'hacker_color_palette', 'default' );

	wp_enqueue_style( 'hacker-style', get_stylesheet_uri() );

	if($theme == 'dark') {
		wp_enqueue_style( 'hacker-theme-dark', get_template_directory_uri() . '/css/theme-dark.css' );
	}

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'main-js', get_template_directory_uri() . '/js/main.js', array('jquery'), null, true );

	wp_localize_script( 'main-js', 'hacker_object', array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'rating_nonce' => wp_create_nonce( 'rating_post_nonce' ),
		'liked_text' => __('You already liked this post!', 'hacker')
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hacker_scripts' );

/**
 * Add Editor Style
 */
function hacker_admin_init() {
	add_editor_style( get_template_directory_uri() . '/css/editor-style.css' );
}
add_action( 'admin_init', 'hacker_admin_init' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load customize responsive image.
 */
require get_template_directory() . '/inc/responsive-image.php';


