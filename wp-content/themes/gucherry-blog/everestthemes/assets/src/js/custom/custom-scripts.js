(function($) {

    'use strict';

    $(document).ready(function() {


        /*
        ============================
        = Prevent click
        ========================================
        */


        $("a.footer-btp").on('click', function(e) {

            // stop its defaut behaviour
            e.preventDefault();
        });


        /*
        ============================
        = Init Nice select
        ========================================
        */


        $('select').niceSelect();



        /*
        ========================
        =
        = Overlay search
        = 
        ====================================
        */


        $('.search-trigger, .close-search-overlay').click(function(e) {

            e.preventDefault();
            $('.search-wrapper').toggleClass('visible');

        });

        /*
        =========================
        = Canvas toggle aside
        ========================================
        */

        // offcanvas toggle sidebar 

        var $CanvasRevelBtn = $('.canvas-trigger');
        var $CanvasAside = $('.canvas-sidebar');
        var $SideCanvasMask = $('.site-overlay');
        var $CloseCanvas = $('.close-canvas');

        function removeCanvasClasses() {

            $CanvasAside.removeClass('visible');
            $SideCanvasMask.removeClass('visible');
            $('body').removeClass('offcanvas-active');

        }

        function addCanvasClasses() {

            $CanvasAside.addClass('visible');
            $SideCanvasMask.addClass('visible');
            $('body').addClass('offcanvas-active');
        }

        $CanvasRevelBtn.on('click', function() {

            addCanvasClasses();
        });

        $SideCanvasMask.on('click', function() {

            removeCanvasClasses();
        });

        $CloseCanvas.on('click', function() {

            removeCanvasClasses();
        });



        /*
        =========================
        = Nice scroll for canvas
        ==================================
        */


        $(".canvas-sidebar").niceScroll({

        });




        /*
        ===========================
        = Main navigation
        ====================================
        */


        $('.menu-toggle').on('click', function(e) {

            $('#site-navigation').slideToggle('medium');

            $('body').toggleClass('menu-toggle-active'); // add class to body

        });

        $('#site-navigation .menu-item-has-children').append('<span class="sub-toggle"> <i class="fa fa-caret-down" aria-hidden="true"></i> </span>');

        $('#site-navigation .page_item_has_children').append('<span class="sub-toggle"> <i class="fa fa-caret-down" aria-hidden="true"></i> </span>');


        $('#site-navigation .sub-toggle').on('click', function() {

            $(this).toggleClass('active-submenu');

            $(this).parent('.menu-item-has-children').children('ul.sub-menu').first().slideToggle('medium');

            $(this).parent('.page_item_has_children').children('ul.children').first().slideToggle('medium');

            if ($(this).hasClass('active-submenu')) {

                $(this).find('.fa').removeClass('fa-caret-down').addClass('fa-caret-up');

            } else {

                $(this).find('.fa').removeClass('fa-caret-up').addClass('fa-caret-down');
            }

        });




        /*
        ===========================
        = Sticky sidebar
        ==========================================
        */

        if (window.matchMedia("(max-width: 991px)").matches) {

            $(".col-lg-8").removeClass("sticky-portion");

        } else {

            $('.sticky-portion').theiaStickySidebar({

                additionalMarginTop: 30

            });

        }


        /*
        ===========================
        = Banner sliders
        ====================================
        */


        // Banner slider style 1

        $('.gc-banner-slider-s1').owlCarousel({

            items: 1,
            loop: true,
            lazyLoad: false,
            margin: 0,
            smartSpeed: 1000,
            nav: false,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
        });


        // gallery post format


        $('.is-gallery-format').owlCarousel({

            items: 1,
            loop: true,
            lazyLoad: false,
            margin: 0,
            smartSpeed: 800,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
        });




        /* 
        =============================
        = Append back to top btn 
        =====================================
        */


        $(window).on('scroll', function() {

            if ($(this).scrollTop() != 0) {

                $('#gc-backtotop').fadeIn();
            } else {
                $('#gc-backtotop').fadeOut();
            }
        });

        $("body").on('click', '#gc-backtotop, .footer-btp', function() {

            $("html, body").animate({ scrollTop: 0 }, 1200);
            return false;

        });

    });

})(jQuery);