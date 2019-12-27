(function($) {
    "use strict";
   if ($.fn.stellarNav) {
        $('.stellarnav').stellarNav({
            theme: 'light',
            breakpoint: 960,
            sticky: false,
            position: 'static',
            mobileMode: false,
        });
    }
	$('table').addClass('table-bordered table').wrap('<div class="table-responsive"></div>');
	$(window).on('scroll', function(){
        var topspace = $(this).scrollTop();
        if (topspace > 1) {
            $('.menu-area').addClass("sticky-menu");
        } else {
            $('.menu-area').removeClass("sticky-menu");
        }
        if (topspace > 300) {
            $('.scrooltotop').css('display', 'block');
        }else{
            $('.scrooltotop').css('display', 'none');
        }
    });
    
    jQuery(window).on('load', function(){
        $('.scrooltotop').css('display', 'none');
        $('.masonaryactive').masonry({
            itemSelector : '.blog-grid-layout',
        });
        $('#preloader').fadeOut('slow', function() {
            $(this).remove();
        });
    });
    $('.scrooltotop').click(function(){ 
        $('html,body').animate({ scrollTop: 0 }, 'slow');
        return false; 
    });

    $('.contact-form').parents('.entry-content').addClass('contact-form-parent');


    $('.tagcloud a').removeAttr('style');


    $('.related-post-sldider').owlCarousel({
        items:2,
        nav: true,
        autoplay: true,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        smartSpeed: 1000,
        margin: 30,
        rewind: true,
        dots: false,
        responsive : {
                
                0 : {
                    items: 1,
                },
                // breakpoint from 480 up
                480 : {
                   items: 1,
                   margin: 15
                },
                // breakpoint from 768 up
                768 : {
                   items: 1,
                },
                992 : {
                   items: 2,
                }
            }
    });
    $('.flickr_gallery').owlCarousel({
        items:8,
        nav: true,
        autoplay: true,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        smartSpeed: 1000,
        margin: 0,
        rewind: true,
        dots: false,
        responsive : {
                
                0 : {
                    items: 2,
                },
                // breakpoint from 480 up
                480 : {
                   items: 1,
                   margin: 0
                },
                // breakpoint from 768 up
                768 : {
                   items: 4,
                },
                992 : {
                   items: 8,
                }
            }
    });

    $('.navigation.pagination').addClass('Page navigation example');

    $('.navigation.pagination div.nav-links').wrapInner('<ul class="pagination"></ul>');
    $('div.nav-links ul.pagination *').wrap('<li class="page-item"></li>');

})(jQuery);
