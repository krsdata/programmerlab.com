/**
 * Customizer Live Preview
 *
 * Reloads changes on Theme Customizer Preview asynchronously for better usability
 *
 * @package Donovan
 */

( function( $ ) {

	// Site Title textfield.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	// Site Description textfield.
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Site Title checkbox.
	wp.customize( 'donovan_theme_options[site_title]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				hideElement( '.site-title' );
			} else {
				showElement( '.site-title' );
			}
		} );
	} );

	// Site Description checkbox.
	wp.customize( 'donovan_theme_options[site_description]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				hideElement( '.site-description' );
			} else {
				showElement( '.site-description' );
			}
		} );
	} );

	// Theme Layout.
	wp.customize( 'donovan_theme_options[theme_layout]', function( value ) {
		value.bind( function( newval ) {
			if ( 'boxed' === newval ) {
				$( 'body' ).addClass( 'boxed-theme-layout' );
				$( 'body' ).removeClass( 'centered-theme-layout' );
			} else if ( 'centered' === newval ) {
				$( 'body' ).addClass( 'centered-theme-layout' );
				$( 'body' ).removeClass( 'boxed-theme-layout' );
			} else {
				$( 'body' ).removeClass( 'centered-theme-layout' );
				$( 'body' ).removeClass( 'boxed-theme-layout' );
			}
		} );
	} );

	// Sidebar Position.
	wp.customize( 'donovan_theme_options[sidebar_position]', function( value ) {
		value.bind( function( newval ) {
			if ( 'left-sidebar' === newval && false === $( 'body' ).hasClass( 'no-sidebar' ) ) {
				$( 'body' ).addClass( 'sidebar-left' );
			} else {
				$( 'body' ).removeClass( 'sidebar-left' );
			}
		} );
	} );

	// Blog Title textfield.
	wp.customize( 'donovan_theme_options[blog_title]', function( value ) {
		value.bind( function( to ) {
			$( '.blog-header .blog-title' ).text( to );
		} );
	} );

	// Blog Description textfield.
	wp.customize( 'donovan_theme_options[blog_description]', function( value ) {
		value.bind( function( to ) {
			$( '.blog-header .blog-description' ).text( to );
		} );
	} );

	// Read More textfield.
	wp.customize( 'donovan_theme_options[read_more_text]', function( value ) {
		value.bind( function( to ) {
			$( 'a.more-link' ).text( to );
		} );
	} );

	// Blog Layout.
	wp.customize( 'donovan_theme_options[blog_layout]', function( value ) {
		value.bind( function( newval ) {
			if ( 'list' === newval ) {
				$( 'body' ).addClass( 'blog-list-layout' );
				$( 'body' ).removeClass( 'blog-grid-layout' );
			} else if ( 'grid' === newval ) {
				$( 'body' ).addClass( 'blog-grid-layout' );
				$( 'body' ).removeClass( 'blog-list-layout' );
			} else {
				$( 'body' ).removeClass( 'blog-grid-layout' );
				$( 'body' ).removeClass( 'blog-list-layout' );
			}
		} );
	} );

	// Post Date checkbox.
	wp.customize( 'donovan_theme_options[meta_date]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				$( 'body' ).addClass( 'date-hidden' );
			} else {
				$( 'body' ).removeClass( 'date-hidden' );
			}
		} );
	} );

	// Post Author checkbox.
	wp.customize( 'donovan_theme_options[meta_author]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				$( 'body' ).addClass( 'author-hidden' );
			} else {
				$( 'body' ).removeClass( 'author-hidden' );
			}
		} );
	} );

	// Post Category checkbox.
	wp.customize( 'donovan_theme_options[meta_category]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				$( 'body' ).addClass( 'categories-hidden' );
			} else {
				$( 'body' ).removeClass( 'categories-hidden' );
			}
		} );
	} );

	// Post Tags checkbox.
	wp.customize( 'donovan_theme_options[meta_tags]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				$( 'body' ).addClass( 'tags-hidden' );
			} else {
				$( 'body' ).removeClass( 'tags-hidden' );
			}
		} );
	} );

	// Post Navigation checkbox.
	wp.customize( 'donovan_theme_options[post_navigation]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				hideElement( '.single-post .site-main .post-navigation' );
			} else {
				showElement( '.single-post .site-main .post-navigation' );
			}
		} );
	} );

	// Post Thumbnails checkbox.
	wp.customize( 'donovan_theme_options[post_image_archives]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				$( 'body' ).addClass( 'post-thumbnails-hidden' );
			} else {
				$( 'body' ).removeClass( 'post-thumbnails-hidden' );
			}
		} );
	} );

	// Single Post Thumbnail checkbox.
	wp.customize( 'donovan_theme_options[post_image_single]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				$( 'body' ).addClass( 'post-thumbnail-hidden' );
			} else {
				$( 'body' ).removeClass( 'post-thumbnail-hidden' );
			}
		} );
	} );

	// Credit Link checkbox.
	wp.customize( 'donovan_theme_options[credit_link]', function( value ) {
		value.bind( function( newval ) {
			if ( false === newval ) {
				hideElement( '.site-info .credit-link' );
			} else {
				showElement( '.site-info .credit-link' );
			}
		} );
	} );

	function hideElement( element ) {
		$( element ).css({
			clip: 'rect(1px, 1px, 1px, 1px)',
			position: 'absolute',
			width: '1px',
			height: '1px',
			overflow: 'hidden'
		});
	}

	function showElement( element ) {
		$( element ).css({
			clip: 'auto',
			position: 'relative',
			width: 'auto',
			height: 'auto',
			overflow: 'visible'
		});
	}

} )( jQuery );
