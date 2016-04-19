<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Phosphor
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function phosphor_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Add the layout class.
	$effective_layout = phosphor_get_effective_layout();
	if( $effective_layout )
		$classes[] = sanitize_html_class($effective_layout);

	global $theme_settings;

	// Add the sidebar width class.
	if( $theme_settings['layouts']['sidebar_width'] ) {
		$classes[] = sanitize_html_class($theme_settings['layouts']['sidebar_width']);
	}

	// Add the skin class.
	if( $theme_settings['styling']['skin'] ) {
		$classes[] = sanitize_html_class($theme_settings['styling']['skin']);
	}

	return $classes;
}
add_filter( 'body_class', 'phosphor_body_classes' );

/**
 * Adds custom classes to the array of post classes.
 *
 * @param array $classes Classes for the post element.
 * @return array
 */
function phosphor_post_classes( $classes ) {
	// Clearfix.
	$classes[] = 'clear';
	return $classes;
}
add_filter( 'post_class', 'phosphor_post_classes' );

/*
* Adds items to the head section.
*/
function phosphor_head() {
	global $theme_settings;
	?>

	<?php if( $theme_settings['general']['custom_favicon'] ): ?>

		<link rel="icon" type="image" href="<?php echo esc_url($theme_settings['general']['custom_favicon']); ?>" />
		<!--[if IE]><link rel="shortcut icon" href="<?php echo esc_url($theme_settings['general']['custom_favicon']); ?>"/><![endif]-->

	<?php endif; ?>

	<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo get_template_directory_uri().'/js/html5shiv.min.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri().'/js/html5shiv-printshiv.min.js'; ?>"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri().'/js/respond.min.js'; ?>"></script>
	<![endif]-->
	<?php
}
add_action('wp_head', 'phosphor_head');

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function phosphor_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'phosphor' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'phosphor_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function phosphor_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'phosphor_render_title' );
endif;

/**
 * Adds CSS provided by the user to the head section.
 */
function phosphor_user_css() {
	global $theme_settings;
	?>
		<style type='text/css'>
			<?php echo phosphor_minify_css( esc_html( $theme_settings['general']['custom_css'] ) ); ?>
		</style>
	<?php
}
add_action( 'wp_head', 'phosphor_user_css', 99 );

/**
 * Adds CSS for theme customizations.
 */
function phosphor_customization_css() {
	global $theme_settings;
	$styles = $theme_settings['fonts'];
	$css = '';

	foreach($styles as $item){
		if( $item['value'] ){
			$css .= sprintf($item['format'], $item['value']);
		}
	}

	?>
		<style type='text/css'>
			<?php echo phosphor_minify_css( $css ); ?>
		</style>
	<?php
}
add_action( 'wp_head', 'phosphor_customization_css', 10 );

/**
 * Minifies CSS for better performance.
 *
 * @param string $css Raw CSS.
 * @return string Minified CSS.
 */
function phosphor_minify_css($css){
	$css = preg_replace(array('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '!\s+!'), ' ', $css);
	$css = str_replace(array(': ', ' :'), ':', $css);
	$css = str_replace(array('; ', ' ;'), ';', $css);
	$css = str_replace(array('{ ', ' {'), '{', $css);
	$css = str_replace(array('} ', ' }'), '}', $css);
	return $css;
}

/*
* Dynamically checks which fonts are required by the theme and enqueues them.
*/
function phosphor_enqueue_google_fonts() {
	global $theme_settings;
	$url = "http://fonts.googleapis.com/css?family=";
	$fonts = array();
	foreach ($theme_settings['fonts'] as $key => $item) {
		$face = $item['value'];

		if( strpos($key, 'font_family') !== false && array_key_exists($item['value'], phosphor_supported_google_fonts()) ) {

			if( strpos($face, ',') ){
				$face = explode(',', $item['value']);
				$face = $face[0];
				$face = str_replace("'", '', $face);
			}

			$face = str_replace(' ', '+', $face);

			if( !in_array($face, $fonts) ){
				$fonts[] = $face;
			}
		}
	}

	if( count($fonts) ){
		wp_enqueue_style( 'phosphor-google-fonts', $url . implode('|', $fonts) );
	}
}
add_action( 'wp_enqueue_scripts', 'phosphor_enqueue_google_fonts' );

/*
* Finds out which layout should be used for the current page.
*/
function phosphor_get_effective_layout() {
	global $theme_settings;

	$effective_layout = '';

	if( $theme_settings['layouts']['general'] ) {
		$effective_layout = $theme_settings['layouts']['general'];
	}

	if( is_singular() ){
		if( $theme_settings['layouts']['single'] )
			$effective_layout = $theme_settings['layouts']['single'];

		if( is_single() && $theme_settings['layouts']['single_post'] ){
			$effective_layout = $theme_settings['layouts']['single_post'];
		}

		if( is_page() && $theme_settings['layouts']['single_page'] ){
			$effective_layout = $theme_settings['layouts']['single_page'];
		}

		$post = get_queried_object();
		$post_meta = get_post_meta($post->ID, 'phosphor_options', true);

		if( isset($post_meta['layout']) && $post_meta['layout'] ) {
			$effective_layout = $post_meta['layout'];
		}
	}

	if( is_archive() ){
		if( $theme_settings['layouts']['archive'] )
			$effective_layout = $theme_settings['layouts']['archive'];

		if( is_category() && $theme_settings['layouts']['archive_category'] ){
			$effective_layout = $theme_settings['layouts']['archive_category'];
		}

		if( is_tag() && $theme_settings['layouts']['archive_tag'] ){
			$effective_layout = $theme_settings['layouts']['archive_tag'];
		}
	}

	return ($effective_layout) ? $effective_layout : false;
}

function phosphor_dropdown_nav_wrapper(){
	$option_name = __('Select a page', 'phosphor');
	return '<select id="drop-nav" autocomplete="off"><option value="">' . $option_name . '...</option>%3$s</select>';
}

function phosphor_dropdown_pages(){
	$walker_page = new Phosphor_Walker_Page_Dropdown();
	$pages = get_pages(
		array(
			'sort_column' => 'menu_order, post_title'
		)
	);

	$options = $walker_page->walk($pages, 0);
	printf(
		phosphor_dropdown_nav_wrapper(),
		null,
		null,
		$options
	);
}