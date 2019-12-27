(function ($) {
	"use strict";
    
    //document ready function
    jQuery(document).ready(function($){
		var menu      =  $('#baby-menu');
        menu.slicknav();

        //search form show hide 
		$('.search-icon i').click(function() {
		  $('.header-search-form').toggleClass('show');
		});
		$('.slicknav_icon').click(function() {
		  $('.search-icon i').toggleClass('hide');
		});
		$('.site-branding, .site-content,.home-feature-slider').click(function() {
		  $('.header-search-form').removeClass('show');
		});

        }); // end document ready

}(jQuery));	