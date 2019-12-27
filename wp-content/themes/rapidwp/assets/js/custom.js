jQuery(document).ready(function($) {

    if(rapidwp_ajax_object.secondary_menu_active){

    $(".rapidwp-nav-secondary .rapidwp-secondary-nav-menu").addClass("rapidwp-secondary-responsive-menu").before('<div class="rapidwp-secondary-responsive-menu-icon"></div>');

    $(".rapidwp-secondary-responsive-menu-icon").click(function(){
        $(this).next(".rapidwp-nav-secondary .rapidwp-secondary-nav-menu").slideToggle();
    });

    $(window).resize(function(){
        if(window.innerWidth > 1112) {
            $(".rapidwp-nav-secondary .rapidwp-secondary-nav-menu, nav .sub-menu, nav .children").removeAttr("style");
            $(".rapidwp-secondary-responsive-menu > li").removeClass("rapidwp-secondary-menu-open");
        }
    });

    $(".rapidwp-secondary-responsive-menu > li").click(function(event){
        if (event.target !== this)
        return;
        $(this).find(".sub-menu:first").slideToggle(function() {
            $(this).parent().toggleClass("rapidwp-secondary-menu-open");
        });
        $(this).find(".children:first").slideToggle(function() {
            $(this).parent().toggleClass("rapidwp-secondary-menu-open");
        });
    });

    $("div.rapidwp-secondary-responsive-menu > ul > li").click(function(event) {
        if (event.target !== this)
            return;
        $(this).find("ul:first").slideToggle(function() {
            $(this).parent().toggleClass("rapidwp-secondary-menu-open");
        });
    });

    }

    if(rapidwp_ajax_object.primary_menu_active){

    if(rapidwp_ajax_object.sticky_menu){
    // grab the initial top offset of the navigation 
    var rapidwpstickyNavTop = $('.rapidwp-primary-menu-container').offset().top;
    
    // our function that decides weather the navigation bar should have "fixed" css position or not.
    var rapidwpstickyNav = function(){
        var rapidwpscrollTop = $(window).scrollTop(); // our current vertical position from the top
             
        // if we've scrolled more than the navigation, change its position to fixed to stick to top,
        // otherwise change it back to relative

        if(rapidwp_ajax_object.sticky_menu_mobile){
            if (rapidwpscrollTop > rapidwpstickyNavTop) {
                $('.rapidwp-primary-menu-container').addClass('rapidwp-fixed');
            } else {
                $('.rapidwp-primary-menu-container').removeClass('rapidwp-fixed');
            }
        } else {
            if(window.innerWidth > 1112) {
                if (rapidwpscrollTop > rapidwpstickyNavTop) {
                    $('.rapidwp-primary-menu-container').addClass('rapidwp-fixed');
                } else {
                    $('.rapidwp-primary-menu-container').removeClass('rapidwp-fixed'); 
                }
            }
        }
    };

    rapidwpstickyNav();
    // and run it again every time you scroll
    $(window).scroll(function() {
        rapidwpstickyNav();
    });
    }

    $(".rapidwp-nav-primary .rapidwp-nav-primary-menu").addClass("rapidwp-primary-responsive-menu").before('<div class="rapidwp-primary-responsive-menu-icon"></div>');

    $(".rapidwp-primary-responsive-menu-icon").click(function(){
        $(this).next(".rapidwp-nav-primary .rapidwp-nav-primary-menu").slideToggle();
    });

    $(window).resize(function(){
        if(window.innerWidth > 1112) {
            $(".rapidwp-nav-primary .rapidwp-nav-primary-menu, nav .sub-menu, nav .children").removeAttr("style");
            $(".rapidwp-primary-responsive-menu > li").removeClass("rapidwp-primary-menu-open");
        }
    });

    $(".rapidwp-primary-responsive-menu > li").click(function(event){
        if (event.target !== this)
        return;
        $(this).find(".sub-menu:first").slideToggle(function() {
            $(this).parent().toggleClass("rapidwp-primary-menu-open");
        });
        $(this).find(".children:first").slideToggle(function() {
            $(this).parent().toggleClass("rapidwp-primary-menu-open");
        });
    });

    $("div.rapidwp-primary-responsive-menu > ul > li").click(function(event) {
        if (event.target !== this)
            return;
        $(this).find("ul:first").slideToggle(function() {
            $(this).parent().toggleClass("rapidwp-primary-menu-open");
        });
    });

    }

    $(".rapidwp-social-icon-search").on('click', function (e) {
        e.preventDefault();
        document.getElementById("rapidwp-search-overlay-wrap").style.display = "block";
    });

    $(".rapidwp-search-closebtn").on('click', function (e) {
        e.preventDefault();
        document.getElementById("rapidwp-search-overlay-wrap").style.display = "none";
    });

    $(".post").fitVids();

    $( 'body' ).prepend( '<div class="rapidwp-scroll-top"></div>');
    var scrollButtonEl = $( '.rapidwp-scroll-top' );
    scrollButtonEl.hide();

    $( window ).scroll( function () {
        if ( $( window ).scrollTop() < 20 ) {
            $( '.rapidwp-scroll-top' ).fadeOut();
        } else {
            $( '.rapidwp-scroll-top' ).fadeIn();
        }
    } );

    scrollButtonEl.click( function () {
        $( "html, body" ).animate( { scrollTop: 0 }, 300 );
        return false;
    } );

    if(rapidwp_ajax_object.slider_active){

    if ( $().owlCarousel ) {
        var rapidwpcarouselwrapper = $('.rapidwp-posts-carousel');
        var rapidwpcarouselimgload = imagesLoaded(rapidwpcarouselwrapper);
        rapidwpcarouselimgload.on( 'always', function() {
            rapidwpcarouselwrapper.each(function(){
                    var $this = $(this);
                    $this.find('.owl-carousel').owlCarousel({
                        autoplay: true,
                        loop: true,
                        margin: 10,
                        smartSpeed: 250,
                        dots: true,
                        nav: false,
                        autoplayTimeout: 4000,
                        autoHeight: false,
                        navText: [ '<i class="fa fa-arrow-left"></i>', '<i class="fa fa-arrow-right"></i>' ],
                        responsive:{
                        0:{
                            items: 1
                        },
                        480:{
                            items: 1
                        },
                        991:{
                            items: 1
                        },
                        1024:{
                            items: 1
                        }
                    }
                });
            });
        });
    } // end if

    }

    if(rapidwp_ajax_object.sticky_sidebar){
    $('.rapidwp-main-wrapper, .rapidwp-sidebar-one-wrapper, .rapidwp-sidebar-two-wrapper').theiaStickySidebar({
        containerSelector: ".rapidwp-content-wrapper",
        additionalMarginTop: 0,
        additionalMarginBottom: 0,
        minWidth: 960,
    });
    }

});