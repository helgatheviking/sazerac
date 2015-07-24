/**
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

	wp.customize( 'criticalink_footer_left', function( value ) {
	    value.bind( function( to ) {
	        $( '.footer-left' ).text( to );
	    });
	});
	wp.customize( 'criticalink_footer_right', function( value ) {
	    value.bind( function( to ) {
	        $( '.footer-right' ).text( to );
	    });
	});

} )( jQuery );
