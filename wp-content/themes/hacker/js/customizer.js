/**
 * customizer.js
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Site Layout.
	wp.customize('hacker_boxed_layout', function( value ) {
		value.bind( function( to ) {
			if( to == true ) {
				$('body').addClass('l-fixed');
			} else {
				$('body').removeClass('l-fixed');
			}
		} );
	});

} )( jQuery );