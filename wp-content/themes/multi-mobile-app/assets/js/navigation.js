/* global MultiMobileAppScreenReaderText */
/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */

(function( $ ) {

	// NAVIGATION CALLBACK FOR MAIN MENU
	var ww = jQuery(window).width();
	jQuery(document).ready(function() { 
		jQuery(".menu-section .nav li a").each(function() {
			if (jQuery(this).next().length > 0) {
				jQuery(this).addClass("parent");
			};
		})
		jQuery("button.toggleMenu").click(function(e) { 
			e.preventDefault();
			jQuery(this).toggleClass("active");
			jQuery(".menu-section .nav").slideToggle('fast');
		});
		adjustMenu();
	})

	// navigation orientation resize callbak
	jQuery(window).bind('resize orientationchange', function() {
		ww = jQuery(window).width();
		adjustMenu();
	});

	var adjustMenu = function() {
		if (ww < 720) {
			jQuery("button.toggleMenu").css("display", "block");
			if (!jQuery("button.toggleMenu").hasClass("active")) {
				jQuery(".menu-section .nav").hide();
			} else {
				jQuery(".menu-section .nav").show();
			}
			jQuery(".menu-section .nav li").unbind('mouseenter mouseleave');
		} else {
			jQuery("button.toggleMenu").css("display", "none");
			jQuery(".menu-section .nav").show();
			jQuery(".menu-section .nav li").removeClass("hover");
			jQuery(".menu-section .nav li a").unbind('click');
			jQuery(".menu-section .nav li").unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {
				jQuery(this).toggleClass('hover');
			});
		}
	}

	/**** Hidden search box ***/
	jQuery('document').ready(function($){
		jQuery('.search-box i').click(function(){
	        jQuery(".serach_outer").slideDown(700);
	    });

	    jQuery('.closepop i').click(function(){
	        jQuery(".serach_outer").slideUp(700);
	    });
	});	

	//Testimonial Owl Carousel
	jQuery(document).ready(function() {
		var owl = jQuery('#testimonials .owl-carousel');
			owl.owlCarousel({
				nav: true,
				autoplay:false,
				autoplayTimeout:2000,
				autoplayHoverPause:true,
				loop: true,
				navText : ['<i class="fa fa-lg fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-lg fa-chevron-right" aria-hidden="true"></i>'],
				responsive: {
				  0: {
				    items: 1
				  },
				  600: {
				    items: 2
				  },
				  1000: {
				    items: 2
				}
			}
		})
	})

	//Our Clients Owl Carousel
	jQuery(document).ready(function() {
		var owl = jQuery('#ourclients .owl-carousel');
			owl.owlCarousel({
				nav: true,
				autoplay:true,
				autoplayTimeout:2000,
				autoplayHoverPause:true,
				loop: true,
				navText : ['<i class="fa fa-lg fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-lg fa-chevron-right" aria-hidden="true"></i>'],
				responsive: {
				  0: {
				    items: 1
				  },
				  600: {
				    items: 4
				  },
				  1000: {
				    items: 4
				}
			}
		})
	})

})( jQuery );
