(function (e) {
    "use strict";
    var n = window.TWP_JS || {};
    n.stickyMenu = function () {
        e(window).scrollTop() > 350 ? e("body").addClass("nav-affix") : e("body").removeClass("nav-affix")
    },
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
                if (e('#masthead .main-navigation div.menu > ul').length) {
                    e('#masthead .main-navigation div.menu > ul .sub-menu').parent('li').find('> a').append('<i class="ion-md-arrow-dropdown">');
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

            e('.sidr-class-sidr-button-close').click(function () {
                e.sidr('close', 'sidr-nav');
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
            e(".banner-slider").each(function () {
                e(this).slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplaySpeed: 8000,
                    infinite: true,
                    nextArrow: '<i class="slide-icon slide-next ion-ios-arrow-round-forward"></i>',
                    prevArrow: '<i class="slide-icon slide-prev ion-ios-arrow-round-back"></i>',
                });
            });

            e(".latest-post-slider").slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplaySpeed: 8000,
                infinite: true,
                nextArrow: '<i class="slide-icon slide-next ion-ios-arrow-round-forward"></i>',
                prevArrow: '<i class="slide-icon slide-prev ion-ios-arrow-round-back"></i>',
            });

            var count = 1;
            e(".twp-carousel").each(function () {
                e(this).closest('.home-carousel').find('.slide-prev-1').addClass('slide-prev-1'+count);
                e(this).closest('.home-carousel').find('.slide-next-1').addClass('slide-next-1'+count);
                e(this).slick({
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    autoplaySpeed: 8000,
                    infinite: true,
                    prevArrow: e('.slide-prev-1'+count),
                    nextArrow: e('.slide-next-1'+count),
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
                count++;
            });

            var count1 = 1;
            e(".news-story-vertical").each(function () {

                e(this).closest('.jumbotron-block').find('.slide-prev-2').addClass('slide-prev-2'+count1);
                e(this).closest('.jumbotron-block').find('.slide-next-2').addClass('slide-next-2'+count1);

                e(this).slick({
                    autoplay: true,
                    vertical: true,
                    slidesToShow: 6,
                    slidesToScroll: 1,
                    verticalSwiping: true,
                    autoplaySpeed: 10000,
                    infinite: true,
                    prevArrow: e('.slide-prev-2'+count1),
                    nextArrow: e('.slide-next-2'+count1),
                    responsive: [
                        {
                            breakpoint: 991,
                            settings: {
                                slidesToShow: 4
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 3
                            }
                        },

                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 3
                            }
                        }
                    ]
                });
                count1++;
            });

            e(".drawer-carousel").each(function () {
                e(this).slick({
                    autoplay: true,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    autoplaySpeed: 8000,
                    infinite: true,
                    nextArrow: '<i class="slide-icon slide-icon-box slide-next ion-ios-arrow-round-forward"></i>',
                    prevArrow: '<i class="slide-icon slide-icon-box slide-prev ion-ios-arrow-round-back"></i>',
                    responsive: [
                        {
                            breakpoint: 991,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1
                            }
                        }
                    ]
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
                    nextArrow: '<i class="slide-icon slide-next ion-ios-arrow-round-forward"></i>',
                    prevArrow: '<i class="slide-icon slide-prev ion-ios-arrow-round-back"></i>',
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


        // SCROLL UP //
        n.scroll_up = function () {
            e(".scroll-up").on("click", function () {
                e("html, body").animate({
                    scrollTop: 0
                }, 700);
                return false;
            });
        },
        n.pannel_match_height = function () {
            e('.twp-match-height, .article-wraper .hentry').matchHeight();
        },

        // SHOW/HIDE SCROLL UP //
        n.show_hide_scroll_top = function () {
            if (e(window).scrollTop() > e(window).height() / 2) {
                e(".recommendation-panel-content").addClass('active-scrollpanel').css({'opacity': 1});
            } else {
                e(".recommendation-panel-content").removeClass('active-scrollpanel').css({'opacity': 0});
            }
        },

        n.fixed_drawer = function () {
            e('.recommendation-panel-content').each(function () {
                var post_bar = e(this);
                var post_button = e(this).siblings('.drawer-handle');

                if (post_bar.hasClass("recommendation-panel-content")) {
                    e('html').animate({'padding-bottom': 110}, 200);
                }

                e(this).on('click', '.drawer-handle-close', function () {
                    post_button.addClass('rec-panel-active');
                    e('html').animate({'padding-bottom': 0}, 200);
                    e('html').addClass('recommendation-panel-disabled');
                });

                post_button.on('click', function () {
                    post_button.removeClass('rec-panel-active');
                    e('html').animate({'padding-bottom': 110}, 200);
                    e('html').removeClass('recommendation-panel-disabled');
                });
            })
        },

        n.twp_preloader = function () {
            e('.preloader-status').addClass("preloader-status-loading full-preloader");
            e('.preloader-status > span').width(e(window).width());

            jQuery(window).load(function () {

                setInterval(function () {
                    e('.preloader-status').addClass("preloader-status-loaded");
                }, 500);
                setInterval(function () {
                    e('.preloader-status-wrapper > span').addClass("display-none");
                    e('.preloader-background').fadeOut(400);
                }, 900);
                setInterval(function () {
                    e('.preloader-status-wrapper').addClass("display-none");
                }, 1000);
            });
        },

        n.twp_sticksidebar = function () {
            jQuery('.widget-area').theiaStickySidebar({
                additionalMarginTop: 30
            });

            jQuery('.twp-single-affix').theiaStickySidebar({
                additionalMarginTop: 100
            });
        },

        n.tab_posts = function () {
            e('.twp-nav-tabs .tab').on('click', function (event) {
                var tabid = e(this).attr('id');
                e('.twp-nav-tabs .tab').removeClass('active');
                e(this).addClass('active');
                e('.tab-content .tab-pane').removeClass('active');
                e('#content-' + tabid).addClass('active');
            });

        },

        // Aos Delay
        n.aos_animation = function () {

            var i = 0;
            var delay = 300;
            e('body.no-sidebar .article-wraper article').each(function () {
                if (i == 1) {
                    delay = 500;
                } else if (i == 2) {
                    delay = 700;
                } else {
                    delay = 300;
                }

                e(this).attr('data-aos-delay', delay);

                if (i >= 2) {
                    i = 0;
                } else {
                    i++;
                }

            });

            e('body.right-sidebar .article-wraper article, body.left-sidebar .article-wraper article').each(function () {

                if (i % 2 == 0) {
                    var delay = 300;
                } else {
                    var delay = 500;
                }

                e(this).attr('data-aos-delay', delay);
                i++;

            });

            AOS.init();
        },

        n.toogle_minicart = function () {
            e(".minicart-title-handle").on("click", function () {
                e(".minicart-content").slideToggle();
            });

        },

        n.color_scheme = function () {

            (function (window, document, undefined) {
                'use strict';
                if (!('localStorage' in window)) return;
                var nightMode = localStorage.getItem('gmtNightMode');
                if (nightMode) {
                    document.documentElement.className += ' night-mode';
                }
            })(window, document);


            (function (window, document, undefined) {

                'use strict';

                // Feature test
                if (!('localStorage' in window)) return;

                // Get our newly insert toggle
                var nightMode = document.querySelector('#night-mode');
                if (!nightMode) return;

                // When clicked, toggle night mode on or off
                nightMode.addEventListener('click', function (event) {
                    event.preventDefault();
                    document.documentElement.classList.toggle('night-mode');
                    if (document.documentElement.classList.contains('night-mode')) {
                        localStorage.setItem('gmtNightMode', true);
                        return;
                    }
                    localStorage.removeItem('gmtNightMode');
                }, false);
            })(window, document);

            var daymod = infinity_news_custom_script.daymod
            var nightmod = infinity_news_custom_script.nightmod

            if (e("html").hasClass("night-mode")) {
                e('#night-mode a .twp-tooltip-wrapper').text(daymod);
                e('#night-mode a i').addClass('twp-nav-icon ion-ios-sunny');
            } else {
                e('#night-mode a .twp-tooltip-wrapper').text(nightmod);
                e('#night-mode a i').addClass('twp-nav-icon ion-ios-moon');
            }

            e('#night-mode').click(function () {

                var mode = e(this).find('a .twp-tooltip-wrapper').text();

                if ( mode == nightmod ) {

                    e(this).find('a .twp-tooltip-wrapper').text( daymod );
                    e(this).find('a i').removeClass('twp-nav-icon ion-ios-moon');
                    e(this).find('a i').addClass('twp-nav-icon ion-ios-sunny');

                }else{

                    e(this).find('a .twp-tooltip-wrapper').text(nightmod);
                    e(this).find('a i').removeClass('twp-nav-icon ion-ios-sunny');
                    e(this).find('a i').addClass('twp-nav-icon ion-ios-moon');

                }

            });

        },

        e(document).ready(function () {
            n.mobileMenu.init(), n.TwpOffcanvasNav(), n.TwpBackground(), n.TwpSlider(), n.scroll_up(), n.pannel_match_height(), n.twp_preloader(), n.MagnificPopup(), n.fixed_drawer(), n.twp_sticksidebar(), n.tab_posts(), n.aos_animation(), n.toogle_minicart(), n.color_scheme();
        }), e(window).scroll(function () {
        n.stickyMenu(), n.show_hide_scroll_top();
    })
})(jQuery);