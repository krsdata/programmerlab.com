/**
 * File customizer.js.
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
	wp.customize( 'header_bgcolor', function( value ) {
		value.bind( function( to ) {
			$( 'header.site-header' ).css( {
					'background-color': to
				} );
		} );
	} );
	wp.customize( 'content_bg_color', function( value ) {
		value.bind( function( to ) {
			$( '.hentry, .comments-area, .site-main section, .site-main .post-navigation, .site-main .posts-navigation, .paging-navigation, .widget' ).css( {
					'background-color': to
				} );
		} );
	} );
	wp.customize( 'theme_layout', function( value ) {
		value.bind( function( to ) {
			$( '#content.site-content' ).removeClass('left-sidebar right-sidebar full-width');
			$( '#content.site-content' ).addClass(to);
		} );
	} );
	wp.customize( 'theme_color', function( value ) {
		value.bind( function( to ) {
			$( 'html body' ).removeClass('theme-blue theme-green theme-black theme-indigo theme-brown theme-bluegrey');
			$( 'html body' ).addClass(to);
		} );
	} );
	wp.customize( 'logo_position', function( value ) {
		value.bind( function( to ) {
			$( '.baby-container.site-branding' ).removeClass('logo-left logo-center logo-right');
			$( '.baby-container.site-branding' ).addClass(to);
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );
	
	wp.customize( 'footer_text', function( value ) {
		value.bind( function( to ) {
			$( 'footer .site-info' ).text( to );
		} );
	} );
	
} )( jQuery );
