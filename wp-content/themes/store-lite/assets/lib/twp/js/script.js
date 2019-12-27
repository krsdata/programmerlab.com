(function (e) {
    "use strict";
    var n = window.TWP_JS || {};
    n.mobileMenu = {
        init: function () {
            this.menuMobile(), this.toggleIcon(), this.menuDesktoparrow(), this.menuMobilearrow()
        },

        menuMobile: function () {
            e('.offcanvas-toggle, .offcanvas-close').on('click', function (event) {
                e('body').toggleClass('offcanvas-menu-open');
            });
            jQuery('body').append('<div class="offcanvas-overlay"></div>');
        },

        toggleIcon: function () {
            e('#offcanvas-menu .offcanvas-navigation').on('click', 'li a i', function (event) {
                event.preventDefault();
                var ethis = e(this),
                    eparent = ethis.closest('li'),
                    esub_menu = eparent.find('> .sub-menu');
                if (esub_menu.css('display') == 'none') {
                    esub_menu.slideDown('300');
                    ethis.addClass('active');
                } else {
                    esub_menu.slideUp('300');
                    ethis.removeClass('active');
                }
                return false;
            });
        },

        menuDesktoparrow: function () {
            if (e('#masthead .main-navigation div.menu > ul.menu > li').length) {
                e('#masthead .main-navigation div.menu > ul.menu > li > .sub-menu').parent('li').find('> a').append('<i class="ion ion-ios-arrow-down">');
            }
        },

        menuMobilearrow: function () {
            if (e('#offcanvas-menu .offcanvas-navigation div.menu > ul').length) {
                e('#offcanvas-menu .offcanvas-navigation div.menu > ul .sub-menu').parent('li').find('> a').append('<i class="ion-md-arrow-dropdown">');
            }
        }
    },

        n.TwpOffcanvasNav = function () {
            if (e("body").hasClass("rtl")) {
                e('#widgets-nav').sidr({
                    name: 'sidr-nav',
                    side: 'right'
                });
            } else {
                e('#widgets-nav').sidr({
                    name: 'sidr-nav',
                    side: 'left'
                });
            }

            if (e("body").hasClass("rtl")) {
                e('#hamburger-one').sidr({
                    name: 'twp-dropdown-categories',
                    side: 'right'
                });
            } else {
                e('#hamburger-one').sidr({
                    name: 'twp-dropdown-categories',
                    side: 'left'
                });
            }

            var windowsize = e(window).width();
            if (windowsize < 991) {
                e('.twp-header-area').addClass('twp-offcanval-toggle');
                e('#twp-dropdown-categories').addClass('twp-offcanval-toggle');
            }

            e(window).resize(function () {

                windowsize = e(window).width();

                if (windowsize < 991) {
                    e('.twp-header-area').addClass('twp-offcanval-toggle');
                    e('#twp-dropdown-categories').addClass('twp-offcanval-toggle');
                } else {
                    e('.twp-header-area').removeClass('twp-offcanval-toggle');
                    e('#twp-dropdown-categories').removeClass('twp-offcanval-toggle');
                }
            });
        },

        n.TwpBackground = function () {
            var pageSection = e(".data-bg");
            pageSection.each(function (indx) {
                if (e(this).attr("data-background")) {
                    e(this).css("background-image", "url(" + e(this).data("background") + ")");
                }
            });

            e('.bg-image').each(function () {
                var src = e(this).children('img').attr('src');
                e(this).css('background-image', 'url(' + src + ')').children('img').hide();
            });
        },

        n.TwpSlider = function () {

            e(".main-slider").each(function () {
                var lopcount1 = e(this).attr('loop-count');
                e(this).slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplaySpeed: 8000,
                    infinite: true,
                    prevArrow: e('.slide-prev-primary-' + lopcount1),
                    nextArrow: e('.slide-next-primary-' + lopcount1)
                });

            });

            e(".twp-lead-slider").each(function () {
                e(this).slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplaySpeed: 8000,
                    infinite: true,
                    nextArrow: '<i class="slide-icon slide-next ion-ios-arrow-forward"></i>',
                    prevArrow: '<i class="slide-icon slide-prev ion-ios-arrow-back"></i>'
                });
            });

            e(".latest-slider").slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplaySpeed: 8000,
                infinite: true,
                nextArrow: '<i class="slide-icon slide-next ion-ios-arrow-forward"></i>',
                prevArrow: '<i class="slide-icon slide-prev ion-ios-arrow-back"></i>',
            });

            e(".twp-carousel").each(function () {
                var lopcount2 = e(this).attr('loop-count');
                e(this).slick({
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    autoplaySpeed: 8000,
                    infinite: true,
                    prevArrow: e('.slide-prev-1-' + lopcount2),
                    nextArrow: e('.slide-next-1-' + lopcount2),
                    responsive: [
                        {
                            breakpoint: 991,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            });

            e(".testimonials-slider").each(function () {
                e(this).slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplaySpeed: 8000,
                    fade: true,
                    infinite: true,
                    nextArrow: '<i class="slide-icon slide-next ion-ios-arrow-forward"></i>',
                    prevArrow: '<i class="slide-icon slide-prev ion-ios-arrow-back"></i>'
                });
            });

            e(".testimonials-carousal").each(function () {
                e(this).slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    autoplaySpeed: 8000,
                    infinite: true,
                    nextArrow: '<i class="slide-icon slide-next ion-ios-arrow-forward"></i>',
                    prevArrow: '<i class="slide-icon slide-prev ion-ios-arrow-back"></i>',
                    responsive: [
                        {
                            breakpoint: 991,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            });


            e(".twp-clients-carousal").each(function () {
                e(this).slick({
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    autoplaySpeed: 8000,
                    infinite: true,
                    nextArrow: '<i class="slide-icon slide-next ion-ios-arrow-forward"></i>',
                    prevArrow: '<i class="slide-icon slide-prev ion-ios-arrow-back"></i>',
                    responsive: [
                        {
                            breakpoint: 991,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            });

            e(".twp-deals-slider").each(function () {
                var lopcount3 = e(this).attr('loop-count');
                e(this).slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplaySpeed: 8000,
                    infinite: false,
                    prevArrow: e('.slide-prev-2-' + lopcount3),
                    nextArrow: e('.slide-next-2-' + lopcount3)
                });
            });

            e(".bestdeal-comment-slider").each(function () {
                e(this).slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplaySpeed: 8000,
                    infinite: false,
                    arrows : false,
                    dots:true
                });
            });

            e(".twp-vertical-slider").each(function () {
                e(this).slick({
                    autoplay: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    verticalSwiping: true,
                    autoplaySpeed: 10000,
                    infinite: true
                });
            });

            e(".flex-control-nav").each(function () {
                e(this).slick({
                    autoplay: true,
                    vertical: true,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    verticalSwiping: true,
                    autoplaySpeed: 10000,
                    infinite: false,
                    nextArrow: '<i class="slide-icon-verticle ion-ios-arrow-down"></i>',
                    prevArrow: '<i class="slide-icon-verticle ion-ios-arrow-up"></i>'
                });
            });

            e(".wp-block-gallery.columns-1, .gallery-columns-1").each(function () {
                e(this).slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    fade: true,
                    autoplay: true,
                    autoplaySpeed: 8000,
                    infinite: true,
                    nextArrow: '<i class="slide-icon slide-next ion-ios-arrow-forward"></i>',
                    prevArrow: '<i class="slide-icon slide-prev ion-ios-arrow-back"></i>',
                    dots: false
                });
            });
        },

        n.MagnificPopup = function () {
            e('.widget .gallery, .entry-content .gallery, .wp-block-gallery').each(function () {
                e(this).magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    closeOnContentClick: false,
                    closeBtnInside: false,
                    mainClass: 'mfp-with-zoom mfp-img-mobile',
                    image: {
                        verticalFit: true,
                        titleSrc: function (item) {
                            return item.el.attr('title');
                        }
                    },
                    gallery: {
                        enabled: true
                    },
                    zoom: {
                        enabled: true,
                        duration: 300,
                        opener: function (element) {
                            return element.find('img');
                        }
                    }
                });
            });
        },


        // SHOW/HIDE SCROLL UP //
        n.show_hide_scroll_top = function () {
            if (e(window).scrollTop() > e(window).height() / 2) {
                e(".scroll-up").fadeIn(300);
            } else {
                e(".scroll-up").fadeOut(300);
            }
        },

        // SCROLL UP //
        n.scroll_up = function () {
            e(".scroll-up").on("click", function () {
                e("html, body").animate({
                    scrollTop: 0
                }, 700);
                return false;
            });
        },

        n.twp_preloader = function () {
            e(window).load(function () {
                e("body").addClass("page-loaded");
            });
        },

        n.twp_sticksidebar = function () {
            jQuery('.widget-area').theiaStickySidebar({
                additionalMarginTop: 30
            });
        },

        n.tab_posts = function () {
            e('.twp-nav-tabs .tab').on('click', function (event) {
                var tabid = e(this).attr('id');
                e(this).closest('.tabbed-container').find('.tab').removeClass('active');
                e(this).addClass('active');
                e(this).closest('.tabbed-container').find('.tab-pane').removeClass('active');
                e('#content-' + tabid).addClass('active');
            });

        },

        // Aos Delay
        n.wow_animation = function () {

            var i = 0;
            var delay = '0.3s';
            e('body.no-sidebar .twp-main-container article').each(function () {
                if (i == 1) {
                    delay = '0.5s';
                } else if (i == 2) {
                    delay = '0.7s';
                } else {
                    delay = '0.3s';
                }

                e(this).attr('data-wow-delay', delay);

                if (i >= 2) {
                    i = 0;
                } else {
                    i++;
                }

            });

            e('body.right-sidebar .twp-main-container article, body.left-sidebar .twp-main-container article').each(function () {

                if (i % 2 == 0) {
                    var delay = '0.3s';
                } else {
                    var delay = '0.5s';
                }

                e(this).attr('data-wow-delay', delay);
                i++;

            });

            i = 0;
            delay = '0.3s';
            e('.latest-blog-wrapper .latest-news-load').each(function () {
                if (i == 1) {
                    delay = '0.5s';
                } else if (i == 2) {
                    delay = '0.7s';
                } else {
                    delay = '0.3s';
                }

                e(this).attr('data-wow-delay', delay);

                if (i >= 2) {
                    i = 0;
                } else {
                    i++;
                }

            });

            new WOW().init();
        },

        n.toogle_minicart = function () {
            e(".minicart-title-handle").on("click", function () {
                e(".minicart-content").slideToggle();
            });

            e('[data-toggle="tooltip"]').tooltip();

        },
        n.wishlist_button_cls_change = function () {
            e('.quicknav-item-wishlist').click(function () {
                e(this).find('.ion').removeClass('ion-ios-heart-empty');
                e(this).find('.ion').addClass('ion-ios-heart');
            });
        },

        n.pannel_match_height = function () {
            e('.twp-products-list .individual-product-wrapper').matchHeight();
            e('.latest-news-article').matchHeight();
            e('.twp-main-container .hentry').matchHeight();
        },

        n.add_cart_popup = function () {
            e('body').on('added_to_cart', function (a, data) {

                var Product_name = e('div.widget_shopping_cart_content ul li:last-child .twp-minicart-product').html();
                e('#twp-popup-addtocart h4 span').empty();
                e('#twp-popup-addtocart h4 span').html(Product_name);
                e("#twp-popup-addtocart").fadeIn().delay(1500).fadeOut();

                e('#twp-close-popup').click(function () {
                    e("#twp-popup-addtocart").hide();
                });

            });
        },

        n.Twp_product_quantity = function () {

            e('.single-product .input-text.qty.text').attr("type", "text");
            e('form.cart').on('click', 'button.twp-plus-upward, button.twp-minus-downward', function () {

                // Get current quantity values
                var qty = e(this).closest('form.cart').find('.qty');
                var val = parseFloat(qty.val());
                var max = parseFloat(qty.attr('max'));
                var min = parseFloat(qty.attr('min'));
                var step = parseFloat(qty.attr('step'));

                // Change the value if plus or minus
                if (e(this).is('.twp-plus-upward')) {
                    if (max && (max <= val)) {
                        qty.val(max);
                    } else {
                        qty.val(val + step);
                    }
                } else {
                    if (min && (min >= val)) {
                        qty.val(min);
                    } else if (val > 1) {
                        qty.val(val - step);
                    }
                }

            });
        },

    e(document).ready(function () {
        n.mobileMenu.init(), n.TwpOffcanvasNav(), n.add_cart_popup(), n.TwpBackground(), n.TwpSlider(), n.scroll_up(), n.twp_preloader(), n.MagnificPopup(), n.twp_sticksidebar(), n.tab_posts(), n.wow_animation(), n.toogle_minicart(), n.pannel_match_height(), n.Twp_product_quantity(), n.wishlist_button_cls_change();
    }), e(window).scroll(function () {
        n.show_hide_scroll_top();
    })
})(jQuery);