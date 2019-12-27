jQuery(document).ready( function($) {
    
    "use scrict";

    var ajaxurl = store_lite_ajax.ajax_url;
    
    $('body').on('click', '.loadmore', function() {

        var loading     = store_lite_ajax.loading;
        var loadmore    = store_lite_ajax.loadmore;
        var nomore      = store_lite_ajax.nomore;
        var cat         = $(this).attr('data-cat');
        var repeat_time = $(this).attr('repeat-time');
        var paged = $(this).attr('paged');

        $('.ajax-added-posts').each(function(){
            $(this).removeClass('ajax-added-posts');
        });

        $(this).addClass('loading');
        $(this).html('<span class="ajax-loader"></span><span>'+loading+'</span>');

        var data = {
            'action': 'store_lite_latest_posts',
            'page': paged,
            'category': cat,
        };
 
        $.post( ajaxurl, data, function( response ) {

            $('.twp-latest-post-'+repeat_time+' .latest-blog-wrapper').append(response);

            paged++;
            $('.twp-latest-post-'+repeat_time+' .loadmore').attr('paged',paged);

            if( !$.trim(response) ){

                $('.twp-latest-post-'+repeat_time+' .loadmore').addClass('no-more-post');
                $('.twp-latest-post-'+repeat_time+' .loadmore').html(nomore);

            }else{

                $('.twp-latest-post-'+repeat_time+' .loadmore').html(loadmore);

            }

            $('.twp-latest-post-'+repeat_time+' .loadmore').removeClass('loading');
            
            var pageSection = $(".data-bg");
            pageSection.each( function () {

                
                if ( $(this).attr("data-background")) {

                    $(this).css("background-image", "url(" + $(this).data("background") + ")");
                    $('.latest-news-article').matchHeight();
                }

            });


            var WOWajax = new WOW({
                boxClass:     'ajax-added-posts',      // animated element css class (default is wow)
            });
            WOWajax.init();

            

        });

    });

    $('.twp-tabs-vertical li a, .twp-tabs-horizontal li a').click(function(){

        var cat_slug = $(this).attr('main-cat');
        var tab_id = $(this).attr('aria-controls');
        var indicator = $(this).attr('indicator');
        var tab_layout = $(this).attr('tab-layout');

        if ( !$(this).hasClass("content-added") ) {

            $('.tab-content #'+tab_id+' ul').append( '<div class="twp-content-loading"><div class="content-loader-spinner"></div></div>' );
            $(this).addClass('content-added');

            var data = {
                'action': 'store_lite_tab_posts',
                'cat_slug': cat_slug,
                'tab_id': tab_id,
                'indicator': indicator,
                'tab_layout': tab_layout,
            };
     
            $.post(ajaxurl, data, function(response) {

                $('.tab-content #'+tab_id+' ul').html( '');
                $('.tab-content #'+tab_id+' ul').append( response );
                $('.twp-products-list .individual-product-wrapper').matchHeight();

            });

        }

    });

    $('body').on( 'added_to_wishlist removed_from_wishlist', function(){

            var data = {
                'action': 'store_lite_update_wishlist_count',
            };
     
            $.post(ajaxurl, data, function(response) {

               $('.twp-wishlist-count .twp-wishlist-count').html(response);
               
            });

    } );

});