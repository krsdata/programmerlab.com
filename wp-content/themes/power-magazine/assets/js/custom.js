(function ($) {
    'use strict';


    /* back-to-top button */
    $('.back-to-top').hide();
    $('.back-to-top').on("click", function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, 'slow');
    });

    $(window).scroll(function () {
        var scrollheight = 400;
        if ($(window).scrollTop() > scrollheight) {
            $('.back-to-top').fadeIn();

        } else {
            $('.back-to-top').fadeOut();
        }
    });

    /*meanmenu js for responsive menu for header-layout-1*/
    $('.main-navigation').meanmenu({
        meanMenuContainer: '.navbar',
        meanScreenWidth: "768",
        meanRevealPosition: "right",
    });

    //header search
    $('.site-header .search-toggle').on("click",function(){
        $('.site-header .search-section').toggleClass('active');
    });

    /*main slider*/
    $('.main-slider-wrap').slick({
      infinite: true,
      slidesToShow: 1,
      dots: true,
      arrows : false,
      slidesToScroll: 1
    });

    /*video-lists slider*/
    $('.video-lists').slick({
      infinite: true,
      slidesToShow: 1,
      dots: true,
      arrows : false,
      slidesToScroll: 1
    });
    
    //tab js
    $('.header-tab-button .widget-title').on("click", function () {
        var tab_id = $(this).attr('data-tab');
        $('.header-tab-button .widget-title').removeClass('current');
        $('.tab-content').removeClass('current');
        $(this).addClass('current');
        $("#" + tab_id).addClass('current');
    });
    
    /*fashion section*/

    var $fashionGallery = $('.fashion-section .grid');
    $fashionGallery.isotope({
      itemSelector: '.grid-item',
      percentPosition: true,
      masonry: {
        // use outer width of grid-sizer for columnWidth
        columnWidth: '.grid-item'
      },
      isFitWidth: true
    });
    // layout Isotope after each image loads
    $fashionGallery.imagesLoaded().progress( function() {
        $fashionGallery.isotope('layout');
    });
    /*for pop up video*/
    jQuery('.popup-video').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });

    /*sticky sidebar*/
    jQuery('#primary , #secondary').theiaStickySidebar({
      additionalMarginTop: 30
    });

})(jQuery);
