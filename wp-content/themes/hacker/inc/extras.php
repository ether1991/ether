<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Hacker
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function hacker_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

    $boxed_layout = get_theme_mod( 'hacker_boxed_layout', false );
    $theme = get_theme_mod( 'hacker_color_palette', '' );

    if( $boxed_layout ) {
        $classes[] = 'l-fixed';
    }

    if($theme == 'dark') {
        $classes[] = 'theme-dark';
    }

    $classes[] = 'theme-customize';

	return $classes;
}
add_filter( 'body_class', 'hacker_body_classes' );

/**
 * Change default excerpt more text
 */
function hacker_custom_excerpt_more( $more ) {
    return '...';
}
add_filter('excerpt_more', 'hacker_custom_excerpt_more');

/**
 * Change default excerpt length
 */
function hacker_custom_excerpt_length( $length ) {
	$custom_length = get_theme_mod( 'hacker_excerpt_length', 200 );
	return $custom_length;
}
add_filter( 'excerpt_length', 'hacker_custom_excerpt_length', 999 );


function hacker_next_posts_link_class( $attrs ) {
	return $attrs . ' class="Pagination__next"';
}
add_filter('next_posts_link_attributes', 'hacker_next_posts_link_class');

function hacker_prev_posts_link_class( $attrs ) {
	return $attrs . ' class="Pagination__prev"';
}
add_filter('previous_posts_link_attributes', 'hacker_prev_posts_link_class');

/**
 * Sanitizes integer.
 */
function hacker_sanitize_integer( $input ) {
    return absint( $input );
}
/**
 * Sanitizes bool.
 */
function hacker_sanitize_bool( $input ) {
    if($input) {
        return true;
    }
    return false;
}
/**
 * Sanitizes theme color palette
 */
function hacker_palette_sanitize( $input ) {
    if( $input == 'dark' ) {
        return 'dark';
    }

    return 'default';
}

/**
 * Site branding
 */
function hacker_site_branding() {
    $logo = get_theme_mod( 'hacker_logo', '' );
    if( $logo != '' ) {
        printf('<div class="site-logo" style="background-image: url(%s)"></div>', $logo);
    } else {
        if ( is_front_page() && is_home() ) : ?>
            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
        <?php else : ?>
            <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
        <?php
        endif;
    }

    $description = get_bloginfo( 'description', 'display' );
    if ( $description || is_customize_preview() ) {
        printf('<p class="site-description">%s</p>', $description);
    }
    
}


function hacker_set_cookie( $post_id, $type = 'photoRating' ) {
    $cookie = array();
    if( isset( $_COOKIE["hacker"] ) ) {
        $cookie = json_decode( stripslashes( $_COOKIE["hacker"] ) );

        if( isset( $cookie->$type ) )
            array_push( $cookie->$type, $post_id );
        else
            $cookie->$type = array( $post_id );
    } else {
        $cookie[$type] = array( $post_id );
    }

    setcookie( 'hacker', json_encode( $cookie ), time() + (5*365*24*60*60), COOKIEPATH, COOKIE_DOMAIN );
}

/**
 * Get first link in post content
 * @return string url
 */
function hacker_url_grabber() {
    if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) ) {
        return false;
    }

    return esc_url_raw( $matches[1] );
}