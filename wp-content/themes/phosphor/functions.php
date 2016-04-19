<?php
/**
 * Phosphor functions and definitions
 *
 * @package Phosphor
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1000; /* pixels */
}

if ( ! function_exists( 'phosphor_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function phosphor_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Phosphor, use a find and replace
	 * to change 'phosphor' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'phosphor', get_template_directory() . '/languages' );

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
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'phosphor' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );
}
endif; // phosphor_setup
add_action( 'after_setup_theme', 'phosphor_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function phosphor_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'phosphor' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'phosphor_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function phosphor_scripts() {
	global $theme_settings;

	wp_enqueue_style( 'phosphor-style', get_stylesheet_uri() );

	wp_enqueue_style( "phosphor-fontawesome", get_stylesheet_directory_uri() . "/css/font-awesome.min.css", null, "4.3.0", "all" );

	wp_register_script( "phosphor-owl-carousel", get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), '1.3.2', true );

	wp_localize_script( "phosphor-owl-carousel", 'phosphor_slider_options', $theme_settings['slider'] );

	wp_enqueue_script( "phosphor-script", get_template_directory_uri() . '/js/script.js', array('jquery'), '1', true );

	wp_enqueue_script( 'phosphor-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if( !$theme_settings['fonts']['font_family']['value'] ){
		// We need to enqueue a font that will be used throughout the site. If the user has already chosen one that can replace this then there is no need to enqueue it.
		wp_enqueue_style( "open-sans", "http://fonts.googleapis.com/css?family=Open+Sans:400,300", null, "1.0", "all" );
	}
}
add_action( 'wp_enqueue_scripts', 'phosphor_scripts' );

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
 * Load theme options panel.
 */
require get_template_directory() . '/inc/options-panel.php';

/**
 * Load theme custom Menu Walker.
 */
require get_template_directory() . '/inc/nav-walker.php';

/**
 * Load theme custom page walker.
 */
require get_template_directory() . '/inc/page-walker.php';