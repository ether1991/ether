<?php

function phosphor_options_panel_init() {
	$options_panel = new Phosphor_Options_Panel();
	global $theme_settings;

	$theme_settings = $options_panel->get_options();
}
add_action( 'init', 'phosphor_options_panel_init', 0 );
add_action( 'customize_preview_init', 'phosphor_options_panel_init' );

require_once 'class.options-framework.php';

/**
 * Returns an array of system fonts
 * Feel free to edit this, update the font fallbacks, etc.
 */
function phosphor_supported_os_fonts() {
	// OS Font Defaults
	$os_faces = array(
		'Arial, sans-serif'                                       => 'Arial',
		"'Avant Garde', sans-serif"                               => 'Avant Garde',
		'Cambria, Georgia, serif'                                 => 'Cambria',
		'Copse, sans-serif'                                       => 'Copse',
		"Garamond, 'Hoefler Text', Times New Roman, Times, serif" => 'Garamond',
		'Georgia, serif'                                          => 'Georgia',
		"'Helvetica Neue', Helvetica, sans-serif"                 => 'Helvetica Neue',
		'Tahoma, Geneva, sans-serif'                              => 'Tahoma'
	);

	return $os_faces;
}

/**
 * Returns a select list of Google fonts
 * Feel free to edit this, update the fallbacks, etc.
 */

function phosphor_supported_google_fonts() {
	// Google Font Defaults
	$google_faces = array(
		'Arvo, serif'                     => 'Arvo (Google)',
		'Copse, sans-serif'               => 'Copse (Google)',
		'Droid Sans, sans-serif'          => 'Droid Sans (Google)',
		'Droid Serif, serif'              => 'Droid Serif (Google)',
		'Lobster, cursive'                => 'Lobster (Google)',
		'Nobile, sans-serif'              => 'Nobile (Google)',
		'Open Sans, sans-serif'           => 'Open Sans (Google)',
		'Oswald, sans-serif'              => 'Oswald (Google)',
		'Pacifico, cursive'               => 'Pacifico (Google)',
		'Rokkitt, serif'                  => 'Rokkit (Google)',
		'PT Sans, sans-serif'             => 'PT Sans (Google)',
		'Quattrocento, serif'             => 'Quattrocento (Google)',
		'Raleway, cursive'                => 'Raleway (Google)',
		'Ubuntu, sans-serif'              => 'Ubuntu (Google)',
		'Yanone Kaffeesatz, sans-serif'   => 'Yanone Kaffeesatz (Google)',
		'Bree Serif, serif'               => 'Bree Serif (Google)',
		'Poiret One, cursive'             => 'Poiret One (Google)',
		'PT Serif, serif'                 => 'PT Serif (Google)',
		'Titillium Web, sans-serif'       => 'Titillium Web (Google)',
		'Merriweather, serif'             => 'Merriweather (Google)',
		'Roboto, sans-serif'              => 'Roboto (Google)',
		'Roboto Slab, serif'              => 'Roboto Slab (Google)',
		'Open Sans Condensed, sans-serif' => 'Open Sans Condensed (Google)'
	);
	return $google_faces;
}

/**
*
*/
class Phosphor_Options_Panel extends Phosphor_Options_Framework
{

	function __construct()
	{
		parent::__construct( "phosphor_theme_options" );
	}

	protected function get_settings_sections() {
		return array(
			'general' => __('Phosphor General', 'phosphor'),

			'home'    => __('Phosphor Homepage', 'phosphor'),

			'slider'  => __('Phosphor Slider', 'phosphor'),

			'layouts' => __('Phosphor Layout', 'phosphor'),

			'styling' => __('Phosphor Styling', 'phosphor'),

			'fonts'   => __('Phosphor Fonts', 'phosphor'),

			'social'  => __('Phosphor Social', 'phosphor'),

			'footer'  => __('Phosphor Footer', 'phosphor')
		);
	}

	protected function get_settings_fields() {

		$fonts = array_merge(phosphor_supported_os_fonts(), phosphor_supported_google_fonts());
		asort($fonts);
		$fonts = array_merge(array('' => 'Inherit'), $fonts);

		$layouts = array(
			''                => __('Inherit', 'phosphor'),
			'content-sidebar' => __('Right Sidebar', 'phosphor'),
			'sidebar-content' => __('Left Sidebar', 'phosphor'),
			'fullwidth'       => __('Fullwidth', 'phosphor')
		);

		$skins = array(
			'' 					=> 'Emerald Water',
			'lemon-twist' 		=> 'Lemon Twist',
			'cherry' 			=> 'Cherry',
			'sunrise' 			=> 'Sunrise',
			'bloody-mary' 		=> 'Bloody Mary',
			'amethyst' 			=> 'Amethyst',
			'rose-water' 		=> 'Rose Water',
			'aqua-marine' 		=> 'Aqua Marine',
			'mango-pulp' 		=> 'Mango Pulp',
			'electric-violet' 	=> 'Electric Violet',
			'mojito' 			=> 'Mojito',
			'virgin-america' 	=> 'Virgin America'
		);

		return array(
			'general' => array(
				'custom_favicon' => array(
					'label'     => __('Favicon', 'phosphor'),
					'type'      => 'media_url'
				),

				'logo' 		=> array(
					'label'     => __('Logo URL', 'phosphor'),
					'type'      => 'media_url'
				),

				'custom_css' => array(
					'label' => __('Custom CSS', 'phosphor'),
					'type'  => 'textarea'
				)
			),

			'layouts' => array(
				'sidebar_width' => array(
					'label'   => __('Sidebar Width', 'phosphor'),
					'type'      => 'select',
					'choices' => array(
						'' 				=> '25%',
						'sidebar-30' 	=> '30%',
						'sidebar-35' 	=> '35%',
						'sidebar-40' 	=> '40%'
					)
				),

				'general' 	=> array(
					'label'      => __('Layout', 'phosphor'),
					'type'       => 'select',
					'choices'    => $layouts
				),

				'single' => array(
					'label'      => __('Single Layout', 'phosphor'),
					'type'       => 'select',
					'choices'    => $layouts
				),

				'single_post' => array(
					'label'      => __('Single Post Layout', 'phosphor'),
					'type'       => 'select',
					'choices'    => $layouts
				),

				'single_page' => array(
					'label'      => __('Single Page Layout', 'phosphor'),
					'type'       => 'select',
					'choices'    => $layouts
				),

				'archive' => array(
					'label'      => __('Archive Layout', 'phosphor'),
					'type'       => 'select',
					'choices'    => $layouts
				),

				'archive_category' => array(
					'label'      => __('Category Archive Layout', 'phosphor'),
					'type'       => 'select',
					'choices'    => $layouts
				),

				'archive_tag' => array(
					'label'      => __('Tag Archive Layout', 'phosphor'),
					'type'       => 'select',
					'choices'    => $layouts
				)
			),

			'home' => array(
				'show_excerpts' => array(
					'label'     => __('Show Excerpts', 'phosphor'),
					'type'      => 'checkbox'
				),
			),

			'slider' => array(
				'disable_slider' => array(
					'label'     => __('Disable slider?', 'phosphor'),
					'type'      => 'checkbox'
				),

				'slides' 	=> array(
					'label'  => __('Slider Images', 'phosphor'),
					'type'   => 'media_items'
				),

				'transitionStyle' => array(
					'label'   => __('Transition Style', 'phosphor'),
					'type'    => 'select',
					'choices' => array('' => __('Slide', 'phosphor'), 'fade' => __('Fade', 'phosphor'), 'backSlide' => __('Back Slide', 'phosphor'), 'goDown' => __('Go Down', 'phosphor'), 'fadeUp' => __('Fade Up', 'phosphor')),
				),

				'pagination' => array(
					'label'     => __('Display Pagination', 'phosphor'),
					'type'      => 'checkbox',
					'default'   => true
				),

				'autoPlay' => array(
					'label'     => __('Auto Play', 'phosphor'),
					'type'      => 'checkbox',
					'default'   => false
				),

				'stopOnHover' => array(
					'label'     => __('Stop On Hover', 'phosphor'),
					'type'      => 'checkbox',
					'default'   => false
				),

				'navigation'  => array(
					'label'     => __('Display Navigation', 'phosphor'),
					'type'      => 'checkbox',
					'default'   => false
				)
			),

			'styling' => array(
				'skin' 	=> array(
					'label'      => __('Skin', 'phosphor'),
					'type'       => 'select',
					'choices'    => $skins
				),
			),

			'fonts' => array(
				'font_size' => array(
					'type'   => 'nested',
					'items'  => array (
						'format' => array(
							'type'       => 'hidden',
							'default'    => 'body, button, input, select, textarea{font-size:%spx;}',
							'customizer' => false
						),
						'value' => array(
							'label'     => __('Font Size', 'phosphor'),
							'type'      => 'number',
							'default'   => 16
						)
					)
				),

				'font_family'	=> array(
					'type' 	=> 'nested',
					'items' 	=> array(
						'format' 	=> array(
							'type'       => 'hidden',
							'default'    => 'body, button, input, select, textarea{font-family:%s;}',
							'customizer' => false
						),
						'value' 	=> array(
							'label'     => __('Basic Font', 'phosphor'),
							'type'      => 'select',
							'choices'   => $fonts
						)
					)
				),

				'headings_font_family' 	=> array(
					'type' 	=> 'nested',
					'items' 	=> array(
						'format' 	=> array(
							'type'       => 'hidden',
							'default'    => 'h1,h2,h3,h4,h5,h6{font-family:%s;}',
							'customizer' => false
						),
						'value' 	=> array(
							'label'     => __('Headings Font', 'phosphor'),
							'type'      => 'select',
							'choices'   => $fonts
						)
					)
				),

				'site_title_font_family' 	=> array(
					'type' 	=> 'nested',
					'items' 	=> array(
						'format' 	=> array(
							'type'       => 'hidden',
							'default'    => '.site-title{font-family:%s;}',
							'customizer' => false
						),
						'value' 	=> array(
							'label'     => __('Site Title Font', 'phosphor'),
							'type'      => 'select',
							'choices'   => $fonts
						)
					)
				),

				'post_title_font_family' 	=> array(
					'type' 	=> 'nested',
					'items' 	=> array(
						'format' 	=> array(
							'type'       => 'hidden',
							'default'    => '.entry-title{font-family:%s;}',
							'customizer' => false
						),
						'value' 	=> array(
							'label'     => __('Post Title Font', 'phosphor'),
							'type'      => 'select',
							'choices'   => $fonts
						)
					)
				),

				'widget_title_font_family' 	=> array(
					'type' 	=> 'nested',
					'items' 	=> array(
						'format' 	=> array(
							'type'       => 'hidden',
							'default'    => '.widget-title{font-family:%s;}',
							'customizer' => false
						),
						'value' 	=> array(
							'label'     => __('Widget Title Font', 'phosphor'),
							'type'      => 'select',
							'choices'   => $fonts
						)
					)
				),
			),

			'social' => array(
				'twitter' => array(
					'label'     => __('Twitter URL', 'phosphor'),
					'type'      => 'url'
				),

				'fb' 	=> array(
					'label'     => __('Facebook URL', 'phosphor'),
					'type'      => 'url'
				),

				'google_plus' => array(
					'label'     => __('Google Plus URL', 'phosphor'),
					'type'      => 'url'
				),

				'instagram' => array(
					'label'     => __('Instagram URL', 'phosphor'),
					'type'      => 'url'
				),

				'pinterest' => array(
					'label'     => __('Pinterest URL', 'phosphor'),
					'type'      => 'url'
				),

				'youtube' => array(
					'label'     => __('Youtube URL', 'phosphor'),
					'type'      => 'url'
				),

				'feedburner' => array(
					'label'     => __('Feedburner URL', 'phosphor'),
					'type'      => 'url'
				)
			),

			'footer' => array(
				'footer_text' => array(
					'label'      => __('Footer Copyright Text', 'phosphor'),
					'type'       => 'text',
					'default'    => '&copy; ' . get_bloginfo('name')
				),

				'hide_credits' => array(
					'label'     => __('Hide credit link?', 'phosphor'),
					'type'      => 'checkbox'
				)
			)
		);
	}
}