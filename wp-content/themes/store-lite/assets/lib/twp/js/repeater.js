jQuery(document).ready(function($) {

    // Show Title Sections While Loadiong.
    $('.store-lite-repeater-field-control').each(function(){

    	var title = $(this).find('.home-section-type option:selected').text();
    	$(this).find('.store-lite-repeater-field-title').text(title);
        var title_key = $(this).find('.home-section-type option:selected').val();

        if( title_key == 'latest-post' || title_key == 'subscribe' ){

            $(this).find('.store-lite-repeater-field-remove').text('');
            $(this).find('.home-section-type select option[value="slide-banner"]').remove();
            $(this).find('.home-section-type select option[value="product-category"]').remove();
            $(this).find('.home-section-type select option[value="tab-block-1"]').remove();
            $(this).find('.home-section-type select option[value="carousel"]').remove();
            $(this).find('.home-section-type select option[value="tab-block-2"]').remove();
            $(this).find('.home-section-type select option[value="cta"]').remove();
            $(this).find('.home-section-type select option[value="best-deal-slide"]').remove();
            $(this).find('.home-section-type select option[value="latest-news"]').remove();
            $(this).find('.home-section-type select option[value="testimonial"]').remove();
            $(this).find('.home-section-type select option[value="client"]').remove();
            $(this).find('.home-section-type select option[value="advertise-area"]').remove();

        }else{
            $(this).find('.home-section-type select option[value="subscribe"]').remove();
            $(this).find('.home-section-type select option[value="latest-post"]').remove();

        }

        if( title_key == 'latest-post' ){
            $(this).find('.home-section-type select option[value="subscribe"]').remove();
        }

        if( title_key == 'subscribe' ){
            $(this).find('.home-section-type select option[value="latest-post"]').remove();
        }


        $(this).find('.home-repeater-fields-hs').hide();
        $(this).find('.'+title_key+'-fields').show();



        if( title_key == 'slide-banner' ){

            var title1 = $(this).find('.home-ac-banner-type option:selected').val();

            if( title1 == 'page' ){

                $(this).find('.prdct-1-ac').hide();
                $(this).find('.prdct-2-ac').hide();
                $(this).find('.prdct-3-ac').hide();
                $(this).find('.post-category-ac').hide();

            }else if( title1 == 'product' ){

                $(this).find('.post-category-ac').hide();
                $(this).find('.banner-lide-page-1-ac').hide();
                $(this).find('.banner-lide-page-2-ac').hide();
                $(this).find('.banner-lide-page-3-ac').hide();
                $(this).find('.banner-slide-link-1-ac').hide();
                $(this).find('.banner-slide-link-2-ac').hide();
                $(this).find('.banner-slide-link-3-ac').hide();
                $(this).find('.btn-lbl-1-ac').hide();
                $(this).find('.btn-lbl-2-ac').hide();
                $(this).find('.btn-lbl-3-ac').hide();

            }else{

                $(this).find('.post-category-ac').show();
                $(this).find('.banner-lide-page-1-ac').hide();
                $(this).find('.banner-lide-page-2-ac').hide();
                $(this).find('.banner-lide-page-3-ac').hide();
                $(this).find('.prdct-1-ac').hide();
                $(this).find('.prdct-2-ac').hide();
                $(this).find('.prdct-3-ac').hide();

            }

        }

        if( title_key == 'cta' ){

            var title2 = $(this).find('.cta-type-ac option:selected').val();

            if( title2 == 'custom' ){

                $(this).find('.banner-lide-page-1-ac').hide();
                $(this).find('.banner-lide-page-2-ac').hide();
                $(this).find('.banner-lide-page-3-ac').hide();

            }else{

                $(this).find('.cta-title-ac').hide();
                $(this).find('.cta-sub-title-ac').hide();
                $(this).find('.cta-bg-ac').hide();

            }

        }

        if( title_key == 'testimonial' ){

            var title3 = $(this).find('.testimonial-content-type-ac option:selected').val();

            if( title3 == 'post-cat' ){

                $(this).find('.banner-lide-page-1-ac').hide();
                $(this).find('.banner-lide-page-2-ac').hide();
                $(this).find('.banner-lide-page-3-ac').hide();
                $(this).find('.banner-lide-page-4-ac').hide();

            }else if( title3 == 'page'){

                $(this).find('.post-category-ac').hide();

            }else{
                $(this).find('.banner-lide-page-1-ac').hide();
                $(this).find('.banner-lide-page-2-ac').hide();
                $(this).find('.banner-lide-page-3-ac').hide();
                $(this).find('.banner-lide-page-4-ac').hide();
                $(this).find('.post-category-ac').hide();
            }

        }

        if( title_key == 'client' ){

            var title4 = $(this).find('.slider-client-type-ac option:selected').val();

            if( title4 == 'page' ){

                $(this).find('.post-category-ac').hide();

            }else{
                $(this).find('.banner-lide-page-1-ac').hide();
                $(this).find('.banner-lide-page-2-ac').hide();
                $(this).find('.banner-lide-page-3-ac').hide();
                $(this).find('.banner-lide-page-4-ac').hide();
                $(this).find('.banner-lide-page-5-ac').hide();
                $(this).find('.banner-lide-page-6-ac').hide();
                $(this).find('.banner-lide-page-7-ac').hide();
                $(this).find('.banner-lide-page-8-ac').hide();
                $(this).find('.banner-lide-page-9-ac').hide();
                $(this).find('.banner-lide-page-10-ac').hide();
            }

        }
       
    });

    // Show Title After Secect Section Type.
    $('.home-section-type select').change(function(){

    	var optionSelected = $("option:selected", this);
     	var textSelected   = optionSelected.text();
        var title_key = optionSelected.val();

        $(this).closest('.store-lite-repeater-field-control').find('.home-repeater-fields-hs').hide();
        $(this).closest('.store-lite-repeater-field-control').find('.'+title_key+'-fields').show();

    	$(this).closest('.store-lite-repeater-field-control').find('.store-lite-repeater-field-title').text( textSelected );

        if( title_key == 'slide-banner' ){

            var title1 = $(this).closest('.store-lite-repeater-field-control').find('.home-ac-banner-type option:selected').val();

            if( title1 == 'page' ){

                $(this).closest('.store-lite-repeater-field-control').find('.prdct-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.prdct-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.prdct-3-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();

            }else if( title1 == 'product' ){

                $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-3-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-3-ac').hide();

            }else{

                $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.prdct-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.prdct-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.prdct-3-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-3-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-3-ac').hide();


            }

        }

        if( title_key == 'cta' ){

            var title2 = $(this).closest('.store-lite-repeater-field-control').find('.cta-type-ac option:selected').val();

            if( title2 == 'custom' ){

                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();

            }else{

                $(this).closest('.store-lite-repeater-field-control').find('.cta-title-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.cta-sub-title-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.cta-bg-ac').hide();

            }

        }

        if( title_key == 'testimonial' ){

            var title3 = $(this).closest('.store-lite-repeater-field-control').find('.testimonial-content-type-ac option:selected').val();

            if( title3 == 'post-cat' ){

                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-4-ac').hide();

            }else if( title3 == 'page'){

                $(this).find('.post-category-ac').hide();

            }else{
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-4-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();
            }

        }

        if( title_key == 'client' ){

            var title4 = $(this).closest('.store-lite-repeater-field-control').find('.slider-client-type-ac option:selected').val();

            if( title4 == 'page' ){

                $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();

            }else{
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-4-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-5-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-6-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-7-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-8-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-9-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-10-ac').hide();
            }

        }

    });

    // Show Title After Secect Section Type.
    $('.home-ac-banner-type select, .cta-type-ac select, .testimonial-content-type-ac select, .slider-client-type-ac select').change(function(){

        var title_key = $(this).closest('.store-lite-repeater-field-control').find('.home-section-type select option:selected').val();

        if( title_key == 'slide-banner' ){

            var title1 = $(this).closest('.store-lite-repeater-field-control').find('.home-ac-banner-type option:selected').val();

            if( title1 == 'page' ){

                $(this).closest('.store-lite-repeater-field-control').find('.prdct-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.prdct-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.prdct-3-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();

                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-1-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-2-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-3-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-1-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-2-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-3-ac').show();

            }else if( title1 == 'product' ){

                $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-3-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-3-ac').hide();

                $(this).closest('.store-lite-repeater-field-control').find('.prdct-1-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.prdct-2-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.prdct-3-ac').show();

            }else{
                
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.prdct-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.prdct-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.prdct-3-ac').hide();

                $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').show();

            }

        }

        if( title_key == 'cta' ){

            var title2 = $(this).closest('.store-lite-repeater-field-control').find('.cta-type-ac option:selected').val();

            if( title2 == 'custom' ){

                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();

                $(this).closest('.store-lite-repeater-field-control').find('.cta-title-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.cta-sub-title-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.cta-button-label-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.cta-button-link-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.cta-bg-ac').show();

            }else{

                $(this).closest('.store-lite-repeater-field-control').find('.cta-title-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.cta-sub-title-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.cta-bg-ac').hide();

                $(this).closest('.store-lite-repeater-field-control').find('.cta-button-label-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.cta-button-link-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').show();
            }

        }

        if( title_key == 'testimonial' ){

            var title3 = $(this).closest('.store-lite-repeater-field-control').find('.testimonial-content-type-ac option:selected').val();

            if( title3 == 'post-cat' ){
                
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-4-ac').hide();

                $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').show();

            }else if( title3 == 'page'){

                $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();

                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-4-ac').show();

            }else{
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-4-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();
            }

        }

        if( title_key == 'client' ){

            var title4 = $(this).closest('.store-lite-repeater-field-control').find('.slider-client-type-ac option:selected').val();

            if( title4 == 'page' ){

                $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();

                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-4-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-5-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-6-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-7-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-8-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-9-ac').show();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-10-ac').show();

            }else{
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-4-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-5-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-6-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-7-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-8-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-9-ac').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-10-ac').hide();

                $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').show();
            }

        }
        
    });

    // Save Value.
    function store_lite_refresh_repeater_values(){

        $(".store-lite-repeater-field-control-wrap").each(function(){
            
            var values = []; 
            var $this = $(this);
            
            $this.find(".store-lite-repeater-field-control").each(function(){
            var valueToPush = {};   

            $(this).find('[data-name]').each(function(){
                var dataName = $(this).attr('data-name');
                var dataValue = $(this).val();
                valueToPush[dataName] = dataValue;
            });

            values.push(valueToPush);
            });

            $this.next('.store-lite-repeater-collector').val( JSON.stringify( values ) ).trigger('change');
        });

    }
    var appenditem = $(".store-lite-repeater-field-control:first").html();

    /*jshint -W065 */
    $('.twp-select-customizer select').each(function(){
        $(this).selectize();
    });

    $("body").on("click",'.store-lite-add-control-field', function(){

        var $this = $(this).parent();
        if(typeof $this != 'undefined') {

            var field = $('.store-lite-repeater-field-control-wrap').append('<li class="store-lite-repeater-field-control ui-sortable-handle twp-sortable-active extended">'+appenditem+'</li>');

            if(typeof field != 'undefined'){

                store_lite_refresh_repeater_values();
            }

            // Show Title After Secect Section Type.
            $('.home-section-type select').change(function(){
                var optionSelected = $("option:selected", this);
                var textSelected   = optionSelected.text();
                var title_key = optionSelected.val();

                $(this).closest('.store-lite-repeater-field-control').find('.home-repeater-fields-hs').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.'+title_key+'-fields').show();

                $(this).closest('.store-lite-repeater-field-control').find('.store-lite-repeater-field-title').text(textSelected);

            });

            $('.store-lite-repeater-field-control-wrap li:last-child').find('.home-repeater-fields-hs').hide();
            $('.store-lite-repeater-field-control-wrap li:last-child').find('.slide-banner-fields').show();

            $('.store-lite-repeater-field-control-wrap li').removeClass('twp-sortable-active');
            $('.store-lite-repeater-field-control-wrap li:last-child').addClass('twp-sortable-active');
            $('.store-lite-repeater-field-control-wrap li:last-child .store-lite-repeater-fields').addClass('twp-sortable-active extended');
            $('.store-lite-repeater-field-control-wrap li:last-child .store-lite-repeater-fields').show();

            $('.store-lite-repeater-field-control.twp-sortable-active .title-rep-wrap').click(function(){
                $(this).next('.store-lite-repeater-fields').slideToggle();
            }); 

            $('.store-lite-repeater-field-control-wrap li:last-child .store-lite-repeater-field-title').text(store_lite_repeater.new_section);
            $this.find(".store-lite-repeater-field-control:last .home-section-type select").empty().append( store_lite_repeater.optionns);

            /*jshint -W065 */
            $('.twp-sortable-active .twp-select-customizer select').each(function(){
                $(this).selectize();
            });

            $('.store-lite-repeater-field-control-wrap li:last-child').find('.banner-lide-page-1-ac').hide();
            $('.store-lite-repeater-field-control-wrap li:last-child').find('.banner-lide-page-2-ac').hide();
            $('.store-lite-repeater-field-control-wrap li:last-child').find('.banner-lide-page-3-ac').hide();
            $('.store-lite-repeater-field-control-wrap li:last-child').find('.prdct-1-ac').hide();
            $('.store-lite-repeater-field-control-wrap li:last-child').find('.prdct-2-ac').hide();
            $('.store-lite-repeater-field-control-wrap li:last-child').find('.prdct-3-ac').hide();

            $('.store-lite-repeater-field-control-wrap li:last-child').find('.post-category-ac').show();

            $('.home-ac-banner-type select, .cta-type-ac select, .testimonial-content-type-ac select, .slider-client-type-ac select').change(function(){

                var title_key = $(this).closest('.store-lite-repeater-field-control').find('.home-section-type select option:selected').val();

                if( title_key == 'slide-banner' ){

                    var title1 = $(this).closest('.store-lite-repeater-field-control').find('.home-ac-banner-type option:selected').val();

                    if( title1 == 'page' ){

                        $(this).closest('.store-lite-repeater-field-control').find('.prdct-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.prdct-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.prdct-3-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();

                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-1-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-2-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-3-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-1-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-2-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-3-ac').show();

                    }else if( title1 == 'product' ){

                        $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-3-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-3-ac').hide();

                        $(this).closest('.store-lite-repeater-field-control').find('.prdct-1-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.prdct-2-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.prdct-3-ac').show();

                    }else{
                        
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.prdct-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.prdct-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.prdct-3-ac').hide();

                        $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').show();

                    }

                }

                if( title_key == 'cta' ){

                    var title2 = $(this).closest('.store-lite-repeater-field-control').find('.cta-type-ac option:selected').val();

                    if( title2 == 'custom' ){

                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();

                        $(this).closest('.store-lite-repeater-field-control').find('.cta-title-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.cta-sub-title-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.cta-button-label-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.cta-button-link-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.cta-bg-ac').show();

                    }else{

                        $(this).closest('.store-lite-repeater-field-control').find('.cta-title-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.cta-sub-title-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.cta-bg-ac').hide();

                        $(this).closest('.store-lite-repeater-field-control').find('.cta-button-label-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.cta-button-link-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').show();

                    }

                }

                if( title_key == 'testimonial' ){

                    var title3 = $(this).closest('.store-lite-repeater-field-control').find('.testimonial-content-type-ac option:selected').val();

                    if( title3 == 'post-cat' ){
                        
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-4-ac').hide();

                        $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').show();

                    }else if( title3 == 'page'){

                        $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();

                        $(this).closest('.store-lite-repeater-field-control').show('.banner-lide-page-1-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').show('.banner-lide-page-2-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').show('.banner-lide-page-3-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').show('.banner-lide-page-4-ac').show();

                    }else{
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-4-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();
                    }

                }

                if( title_key == 'client' ){

                    var title4 = $(this).closest('.store-lite-repeater-field-control').find('.slider-client-type-ac option:selected').val();

                    if( title4 == 'page' ){

                        $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();

                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-4-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-5-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-6-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-7-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-8-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-9-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-10-ac').show();

                    }else{
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-4-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-5-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-6-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-7-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-8-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-9-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-10-ac').hide();

                        $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').show();
                    }

                }
                
            });

            // Show Title After Secect Section Type.
            $('.home-section-type select').change(function(){

                var optionSelected = $("option:selected", this);
                var textSelected   = optionSelected.text();
                var title_key = optionSelected.val();

                $(this).closest('.store-lite-repeater-field-control').find('.home-repeater-fields-hs').hide();
                $(this).closest('.store-lite-repeater-field-control').find('.'+title_key+'-fields').show();

                $(this).closest('.store-lite-repeater-field-control').find('.store-lite-repeater-field-title').text( textSelected );

                if( title_key == 'slide-banner' ){

                    var title1 = $(this).closest('.store-lite-repeater-field-control').find('.home-ac-banner-type option:selected').val();

                    if( title1 == 'page' ){

                        $(this).closest('.store-lite-repeater-field-control').find('.prdct-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.prdct-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.prdct-3-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();

                    }else if( title1 == 'product' ){

                        $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-3-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-3-ac').hide();

                    }else{

                        $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').show();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.prdct-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.prdct-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.prdct-3-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-slide-link-3-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.btn-lbl-3-ac').hide();


                    }

                }

                if( title_key == 'cta' ){

                    var title2 = $(this).closest('.store-lite-repeater-field-control').find('.cta-type-ac option:selected').val();

                    if( title2 == 'custom' ){

                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();

                    }else{

                        $(this).closest('.store-lite-repeater-field-control').find('.cta-title-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.cta-sub-title-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.cta-bg-ac').hide();

                    }

                }

                if( title_key == 'testimonial' ){

                    var title3 = $(this).closest('.store-lite-repeater-field-control').find('.testimonial-content-type-ac option:selected').val();

                    if( title3 == 'post-cat' ){

                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-4-ac').hide();

                    }else if( title3 == 'page'){

                        $(this).find('.post-category-ac').hide();

                    }else{
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-4-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();
                    }

                }

                if( title_key == 'client' ){

                    var title4 = $(this).closest('.store-lite-repeater-field-control').find('.slider-client-type-ac option:selected').val();

                    if( title4 == 'page' ){

                        $(this).closest('.store-lite-repeater-field-control').find('.post-category-ac').hide();

                    }else{
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-1-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-2-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-3-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-4-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-5-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-6-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-7-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-8-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-9-ac').hide();
                        $(this).closest('.store-lite-repeater-field-control').find('.banner-lide-page-10-ac').hide();
                    }

                }

            });

        }
        return false;
    });
    
    $('.store-lite-repeater-field-control .title-rep-wrap').click(function(){
        $(this).next('.store-lite-repeater-fields').slideToggle().toggleClass('extended');
    });

    //MultiCheck box Control JS
    $( 'body' ).on( 'change', '.store-lite-type-multicategory input[type="checkbox"]' , function() {
        var checkbox_values = $( this ).parents( '.store-lite-type-multicategory' ).find( 'input[type="checkbox"]:checked' ).map(function(){
            return $( this ).val();
        }).get().join( ',' );
        $( this ).parents( '.store-lite-type-multicategory' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
        store_lite_refresh_repeater_values();
    });

    //Checkbox Multiple Control
    $( '.customize-control-checkbox-multiple input[type="checkbox"]' ).on( 'change', function() {
        checkbox_values = $( this ).parents( '.customize-control' ).find( 'input[type="checkbox"]:checked' ).map(
            function() {
                return this.value;
            }
        ).get().join( ',' );

        $( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
    });

    // ADD IMAGE LINK
    $('.customize-control-repeater').on( 'click', '.twp-img-upload-button', function( event ){
        event.preventDefault();

        var imgContainer = $(this).closest('.twp-img-fields-wrap').find( '.thumbnail-image'),
        placeholder = $(this).closest('.twp-img-fields-wrap').find( '.placeholder'),
        imgIdInput = $(this).siblings('.upload-id');

        // Create a new media frame
        frame = wp.media({
            title: store_lite_repeater.upload_image,
            button: {
            text: store_lite_repeater.use_imahe
            },
            multiple: false  // Set to true to allow multiple files to be selected
        });

        // When an image is selected in the media frame...
        frame.on( 'select', function() {

        // Get media attachment details from the frame state
        var attachment = frame.state().get('selection').first().toJSON();

        // Send the attachment URL to our custom image input field.
        imgContainer.html( '<img src="'+attachment.url+'" style="max-width:100%;"/>' );
        placeholder.addClass('hidden');

        // Send the attachment id to our hidden input
        imgIdInput.val( attachment.url ).trigger('change');

        });

        // Finally, open the modal on click
        frame.open();
    });
    // DELETE IMAGE LINK
    $('.customize-control-repeater').on( 'click', '.twp-img-delete-button', function( event ){

        event.preventDefault();
        var imgContainer = $(this).closest('.twp-img-fields-wrap').find( '.thumbnail-image'),
        placeholder = $(this).closest('.twp-img-fields-wrap').find( '.placeholder'),
        imgIdInput = $(this).siblings('.upload-id');

        // Clear out the preview image
        imgContainer.find('img').remove();
        placeholder.removeClass('hidden');

        // Delete the image id from the hidden input
        imgIdInput.val( '' ).trigger('change');

    });

    $("#customize-theme-controls").on("click", ".store-lite-repeater-field-remove",function(){
        if( typeof  $(this).parent() != 'undefined'){
            $(this).closest('.store-lite-repeater-field-control').slideUp('normal', function(){
                $(this).remove();
                store_lite_refresh_repeater_values();
            });
            
        }
        return false;
    });

    $('#customize-theme-controls').on('click', '.store-lite-repeater-field-close', function(){
        $(this).closest('.store-lite-repeater-fields').slideUp();
        $(this).closest('.store-lite-repeater-field-control').toggleClass('expanded');
    });

    /*Drag and drop to change order*/
    $(".store-lite-repeater-field-control-wrap").sortable({
        axis: 'y',
        orientation: "vertical",
        update: function( event, ui ) {
            store_lite_refresh_repeater_values();
        }
    });

    $("#customize-theme-controls").on('keyup change', '[data-name]',function(){
         store_lite_refresh_repeater_values();
         return false;
    });

    $("#customize-theme-controls").on('change', 'input[type="checkbox"][data-name]',function(){
        if($(this).is(":checked")){
            $(this).val('yes');
        }else{
            $(this).val('no');
        }
        store_lite_refresh_repeater_values();
        return false;
    });

});

