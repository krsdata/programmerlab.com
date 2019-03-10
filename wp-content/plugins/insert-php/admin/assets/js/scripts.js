(function($){
    $(document).on( 'click', '.winp-enable-php-btn', function(e) {
        e.preventDefault();
        var icon  = $(this).children('i'),
            label = $(this).children('.winp-btn-title'),
            input = $(this).children('.winp-with-php');

        $(this).toggleClass('winp-active');

        if( $(this).hasClass('winp-active') ) {
            icon.attr( 'class', 'dashicons dashicons-edit' );
            label.text( $(this).data( 'disable-text' ) );
            input.val('enabled');
            $('body').addClass( 'winp-snippet-enabled' );
        } else {
            icon.attr( 'class', 'dashicons dashicons-editor-code' );
            label.text( $(this).data( 'enable-text' ) );
            input.val('');
            $('body').removeClass( 'winp-snippet-enabled' );
        }
    });

})(jQuery);