jQuery(function ($) {
    $(document).on('click', '.empower-welcome-notice .notice-dismiss', function () {
        jQuery.post(ajaxurl, {
            'action': 'empower_dismiss_welcome_popup'
        });
    });
});

function empower_close_popup() {
    jQuery('.empower-welcome-notice').fadeOut();
}
