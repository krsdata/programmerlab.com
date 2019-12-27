/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
( function( $ ) {
 "use strict";

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.logo-area .logo-text span' ).html(  to );
		} );
	} );

	// Site tagline.
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.logo-area p' ).text( to );
		} );
	} );

	// Header text color. 
	wp.customize( 'site_title_text_color', function( value ) {
		value.bind( function( to ) { 
			if ( 'blank' === to ) {
				$( '.logo-text' ).css({
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute'
				});
				// Add class for different logo styles if title and description are hidden.
				$( 'body' ).addClass( 'title-tagline-hidden' );
			} else {
 
				$( '.logo-text' ).css({
					clip: 'auto',
					position: 'relative'
				}); 
				// Add class for different logo styles if title and description are visible.
				$( 'body' ).removeClass( 'title-tagline-hidden' );
			} 
			$( '.logo-area .logo-text span, .logo-area p' ).css( 'color', to );  
		} );
	} );


	// logo 
	wp.customize( 'custom_logo', function( value ) {
		value.bind( function( to ) {
			if(to==''){
				$( '.logo-area a' ).remove();  
			}else{
				$( '.logo-area a img' ).attr( 'src', to );
			} 
		} );
	} );
  
	// copyright text
	wp.customize( 'v_copyright_text', function( value ) {
	  value.bind( function( to ) {
	    $( '.copyright_area p' ).html( to );
	  } );
	} );


} )( jQuery );
