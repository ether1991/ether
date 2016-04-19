<?php
/**
 * Hacker Theme Customizer.
 *
 * @package Hacker
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function hacker_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	/* ##Hacker Theme Customize
	---------------------------------*/
	$wp_customize->add_section( 'hacker_section' , array(
        'title' => __( 'Hacker Customize', 'hacker' )
    ) );

	// Primary Color
    $wp_customize->add_setting( 'hacker_primary_color',
        array(
            'default' => '#F03838', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'sanitize_hex_color'
        ) 
    );
    $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
        $wp_customize, //Pass the $wp_customize object (required)
        'hacker_primary_color', //Set a unique ID for the control
        array(
            'label' => __( 'Primary Color', 'hacker' ), //Admin-visible name of the control
            'section' => 'hacker_section', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'hacker_primary_color', //Which setting to load and manipulate (serialized is okay)
        ) 
    ) );

    // Post excerpt length
    $wp_customize->add_setting( 'hacker_excerpt_length',
        array(
            'default' => 200, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'hacker_sanitize_integer'
        ) 
    );
    $wp_customize->add_control( new WP_Customize_Control( //Instantiate the color control class
        $wp_customize, //Pass the $wp_customize object (required)
        'hacker_excerpt_length', //Set a unique ID for the control
        array(
            'label' => __( 'Post excerpt length', 'hacker' ), //Admin-visible name of the control
            'section' => 'hacker_section', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'hacker_excerpt_length', //Which setting to load and manipulate (serialized is okay)
            'type' => 'number'
        ) 
    ) );

    // Color Palette
    $wp_customize->add_setting( 'hacker_color_palette',
        array(
            'default' => 'default', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh',
            'sanitize_callback' => 'hacker_palette_sanitize'
        )
    );
    $wp_customize->add_control(
    	'hacker_color_palette',
    	array(
    		'label' => __('Color Palette', 'hacker'),
    		'section'  => 'hacker_section',
			'settings' => 'hacker_color_palette',
			'type'     => 'select',
			'choices'  => array(
				'default'  => __('Default', 'hacker'),
				'dark' => __('Dark', 'hacker')
			),
    	)
    );

    // Boxed Layout
    $wp_customize->add_setting( 'hacker_boxed_layout',
        array(
            'default' => false, //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage',
            'sanitize_callback' => 'hacker_sanitize_bool'
        )
    );
    $wp_customize->add_control(
    	'hacker_boxed_layout',
    	array(
    		'label' => __('Boxed Layout', 'hacker'),
    		'section'  => 'hacker_section',
			'settings' => 'hacker_boxed_layout',
			'type'     => 'checkbox'
    	)
    );

    // LOGO
    $wp_customize->add_setting( 'hacker_logo',
        array(
            'default' => '', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'esc_url_raw'
        ) 
    );
    $wp_customize->add_control( new WP_Customize_Image_Control( //Instantiate the color control class
        $wp_customize, //Pass the $wp_customize object (required)
        'hacker_logo', //Set a unique ID for the control
        array(
            'label' => __( 'LOGO', 'hacker' ), //Admin-visible name of the control
            'section' => 'hacker_section', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'hacker_logo', //Which setting to load and manipulate (serialized is okay)
        ) 
    ) );

    // favicon
    $wp_customize->add_setting( 'hacker_favicon',
        array(
            'default' => '', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'refresh', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            'sanitize_callback' => 'esc_url_raw'
        ) 
    );
    $wp_customize->add_control( new WP_Customize_Image_Control( //Instantiate the color control class
        $wp_customize, //Pass the $wp_customize object (required)
        'hacker_favicon', //Set a unique ID for the control
        array(
            'label' => __( 'Favicon', 'hacker' ), //Admin-visible name of the control
            'section' => 'hacker_section', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'hacker_favicon', //Which setting to load and manipulate (serialized is okay)
        ) 
    ) );
}
add_action( 'customize_register', 'hacker_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function hacker_customize_preview_js() {
	wp_enqueue_script( 'hacker_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'hacker_customize_preview_js' );

/**
 * Adjusting color
 * @param  [type] $hex   color need to be adjusted
 * @param  [type] $steps adjust by step
 * @return [type]        hex color
 */
function hacker_adjustBrightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Normalize into a six character long hex string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Split into three parts: R, G and B
    $color_parts = str_split($hex, 2);
    $return = '#';

    foreach ($color_parts as $color) {
        $color   = hexdec($color); // Convert to decimal
        $color   = max(0,min(255,$color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
    }

    return $return;
}

/**
 * Convert hexdec color string to rgb(a) string
 */
function hacker_hex2rgba($color, $opacity = false) {
 
    $default = 'rgb(0,0,0)';
 
    //Return default if no color provided
    if(empty($color))
          return $default; 
 
    //Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}
/**
 * Customize site <head>
 */
function hacker_customize_head() {
	$primary_color = strtolower( get_theme_mod( 'hacker_primary_color', '#f03838' ) );
    $lang = get_bloginfo('language');
    $favicon = get_theme_mod( 'hacker_favicon', '' );

    if( strlen($favicon) > 0 ) {
        printf( '<link rel="shortcut icon" href="%s" type="image/x-icon">', esc_url($favicon) );
    }
?>
    <style type="text/css" media="screen">
    <?php if($lang == 'zh-CN') : ?>
        body,
        h1, h2, h3, h4, h5, h6 {
            font-family: "Segoe UI", "Lucida Grande", Helvetica, "Microsoft YaHei", FreeSans, Arimo, "Droid Sans","wenquanyi micro hei","Hiragino Sans GB", "Hiragino Sans GB W3", Arial, sans-serif;
        }
    <?php endif; ?>
    <?php if($primary_color != '#f03838' && $primary_color ): ?>
        body.theme-customize .main-navigation ul a,
        a {
            color: <?php echo $primary_color; ?>;
        }
        body.theme-customize .Article__meta a:hover,
        body.theme-customize .main-navigation ul a:hover,
        a:hover {
            color: <?php echo hacker_adjustBrightness($primary_color, -25); ?>;
        }
        body.theme-customize .Article__title a:hover span {
            box-shadow: inset 0 -2px 0 <?php echo hacker_hex2rgba($primary_color, 0.4); ?>;
        }
        body.theme-customize .site-branding a {
            background-color: <?php echo $primary_color; ?>;
        }
        body.theme-customize .Pagination__prev:hover,
        body.theme-customize .Pagination__next:hover {
            color: #fff;
            background-color: <?php echo $primary_color; ?>;
            border-color: <?php echo $primary_color; ?>;
        }
        body.theme-customize .sticky-mark {
            background-color: <?php echo $primary_color; ?>;
        }
        body.theme-customize .sticky-mark:before {
            border-color: <?php echo $primary_color; ?> transparent transparent transparent;
        }
        body.theme-customize .sticky-mark:after {
            border-color: transparent <?php echo $primary_color; ?> transparent transparent;
        }
        ::selection {
            background-color: <?php echo hacker_hex2rgba($primary_color, 0.45); ?>;
        }
    <?php endif; ?>
    </style>
<?php
}
add_action( 'wp_head', 'hacker_customize_head', 20 );


