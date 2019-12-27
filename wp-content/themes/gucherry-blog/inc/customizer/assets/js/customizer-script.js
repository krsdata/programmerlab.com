(function( $ ) {

	wp.customize.bind( 'ready', function() {

		function customizer_label( id, title ) {

			if ( id === 'custom_logo' || id === 'site_icon' || id === 'background_image' || id === 'background_color' ) {
				$( '#customize-control-'+ id ).prepend('<p class="option-group-title customize-control"><strong>'+ title +'</strong></p>');
			} else {
				$( '#customize-control-'+ id ).prepend('<p class="option-group-title customize-control"><strong>'+ title +'</strong></p>');
			}
		}

		// Site Identity
		customizer_label( 'custom_logo', gucherry_blog.custom_logo );
		customizer_label( 'site_icon', gucherry_blog.site_icon );
        
        customizer_label( 'background_color', gucherry_blog.background_color );

        customizer_label( 'header_image', gucherry_blog.header_image );
        
        customizer_label( 'gucherry_blog_header_display_social_links', gucherry_blog.gucherry_blog_header_display_social_links );
        
        customizer_label( 'gucherry_blog_site_banner_post_category', gucherry_blog.gucherry_blog_site_banner_post_category );
        
        customizer_label( 'gucherry_blog_site_pages_blog_page_display_post_featured_image', gucherry_blog.gucherry_blog_site_pages_blog_page_display_post_featured_image );
        customizer_label( 'gucherry_blog_site_pages_blog_page_sidebar_position', gucherry_blog.gucherry_blog_site_pages_blog_page_sidebar_position );
        
        customizer_label( 'gucherry_blog_site_pages_archive_page_display_post_featured_image', gucherry_blog.gucherry_blog_site_pages_archive_page_display_post_featured_image );
        customizer_label( 'gucherry_blog_site_pages_archive_page_sidebar_position', gucherry_blog.gucherry_blog_site_pages_archive_page_sidebar_position );
        
        customizer_label( 'gucherry_blog_site_pages_search_page_display_post_featured_image', gucherry_blog.gucherry_blog_site_pages_search_page_display_post_featured_image );
        customizer_label( 'gucherry_blog_site_pages_search_page_sidebar_position', gucherry_blog.gucherry_blog_site_pages_search_page_sidebar_position );
        
        customizer_label( 'gucherry_blog_site_pages_post_single_display_post_featured_image', gucherry_blog.gucherry_blog_site_pages_post_single_display_post_featured_image );
        customizer_label( 'gucherry_blog_site_pages_post_single_display_post_author_section', gucherry_blog.gucherry_blog_site_pages_post_single_display_post_author_section );
        customizer_label( 'gucherry_blog_site_pages_post_single_display_related_posts_section', gucherry_blog.gucherry_blog_site_pages_post_single_display_related_posts_section );
        
        customizer_label( 'gucherry_blog_site_footer_upload_footer_logo', gucherry_blog.gucherry_blog_site_footer_upload_footer_logo );

		/**
		 *	Toogle Custom Control's Script
		 */

		var customize = this; // Customize object alias.
		// Array with the control names
		// TODO: Replace #CONTROLNAME01#, #CONTROLNAME02# etc with the real control names.
		var toggleControls = [
			'#CONTROLNAME01#',
			'#CONTROLNAME02#'
		];
		$.each( toggleControls, function( index, control_name ) {

			customize( control_name, function( value ) {

				var controlTitle = customize.control( control_name ).container.find( '.customize-control-title' ); // Get control  title.
				// 1. On loading.
				controlTitle.toggleClass( 'disabled-control-title', !value.get() );
				// 2. Binding to value change.
				value.bind( function( to ) {
					controlTitle.toggleClass( 'disabled-control-title', !value.get() );
				} );
			} );
		} );
		
	});
}) ( jQuery );