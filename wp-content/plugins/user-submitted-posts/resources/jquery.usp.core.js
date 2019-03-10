/* 
	User Submitted Posts : Core JS : Version 2.0
	@ https://perishablepress.com/user-submitted-posts/
*/
jQuery(document).ready(function($) {
	
	// parsley
	$('.usp-callout-failure').addClass('usp-hidden').hide();
	$('#user-submitted-post').on('click', function() {
		usp_validate();
	});
	
	function usp_validate() {
		// $('#usp_form').parsley().validate();
		if (true === $('#usp_form').parsley().isValid()) {
			$('.usp-callout-failure').addClass('usp-hidden').hide();
			
			// remove empty file inputs
			$('.usp-clone').each(function() {
				var opt = $(this).data('parsley-excluded');
				if (typeof opt !== 'undefined' && opt == true) {
					var val = $(this).val();
					if (!val.trim()) $(this).remove();
				}
			});
		} else {
			$('.usp-callout-failure').removeClass('usp-hidden').show();
		}
	};
	
	// captcha
	$('#usp_form').submit(function(e) {
		usp_captcha_check(e);
		if ($(this).parsley().isValid()) {
			$('.usp-submit').css('cursor', 'wait');
			$('.usp-submit').attr('disabled', true);
		}
	});
	$('.usp-captcha .usp-input').change(function(e) { 
		usp_captcha_check(e);
	});
	function usp_captcha_check(e) {
		if (usp_case_sensitivity === 'true') var usp_casing = '';
		else var usp_casing = 'i';
		var usp_response = new RegExp(usp_challenge_response + '$', usp_casing);
		var usp_captcha = $('.user-submitted-captcha').val();
		if (typeof usp_captcha != 'undefined') {
			if (usp_captcha.match(usp_response)) {
				$('.usp-captcha-error').remove();
				$('.usp-captcha .usp-input').removeClass('parsley-error');
				$('.usp-captcha .usp-input').addClass('parsley-success');
			} else {
				if (e) e.preventDefault();
				$('.usp-captcha-error').remove();
				$('.usp-captcha').append('<ul class="usp-captcha-error parsley-errors-list filled"><li class="parsley-required">'+ usp_parsley_error +'</li></ul>');
				$('.usp-captcha .usp-input').removeClass('parsley-success');
				$('.usp-captcha .usp-input').addClass('parsley-error');
			}
		}
	}
	
	// cookies
	usp_remember();
	usp_forget();
	
	function usp_cookie(selector) {
		$(selector).each(function() {
			var name  = $(this).attr('name');
			if ($.cookie(name)) {
				if (name == usp_custom_checkbox) {
					if ($.cookie(name) == 1) {
						$(this).val(1).prop('checked', 1);
					} else {
						$(this).val(0).prop('checked', 0);
					}
				} else {
					$(this).val($.cookie(name));
				}
			}
			$(this).on('change', function() {
				if (name == usp_custom_checkbox) {
					var value = ($(this).is(":checked")) ? 1 : 0;
					$(this).val(value); 
				} else {
					var value = $(this).val();
				}
				$.cookie(name, value, { path: '/', expires: 365 });
			});	
		});
	}
	function usp_remember() {
		usp_cookie('[name="user-submitted-name"]');
		usp_cookie('[name="user-submitted-email"]');
		usp_cookie('[name="user-submitted-url"]');
		usp_cookie('[name="user-submitted-title"]');
		usp_cookie('[name="user-submitted-tags"]');
		usp_cookie('[name="user-submitted-category"]');
		usp_cookie('[name="user-submitted-content"]');
		usp_cookie('[name="'+ usp_custom_field +'"]');
		usp_cookie('[name="'+ usp_custom_checkbox +'"]');
		usp_cookie('[name="user-submitted-captcha"]');
	}
	function usp_forget() {
		var re = /[?&]success=/;
		if (re.test(location.href)) {
			$.removeCookie('user-submitted-name', { path: '/' });
			$.removeCookie('user-submitted-email', { path: '/' });
			$.removeCookie('user-submitted-url', { path: '/' });
			$.removeCookie('user-submitted-title', { path: '/' });
			$.removeCookie('user-submitted-tags', { path: '/' });
			$.removeCookie('user-submitted-category', { path: '/' });
			$.removeCookie('user-submitted-content', { path: '/' });
			$.removeCookie(usp_custom_field, { path: '/' });
			$.removeCookie(usp_custom_checkbox, { path: '/' });
			$.removeCookie('user-submitted-captcha', { path: '/' });
			$('#usp_form').find('input[type="text"], textarea').val('');
			$('#usp_form option[value=""]').attr('selected', '');
		}
	}
	
	// add another image
	$('#usp_add-another').removeClass('usp-no-js');
	$('#usp_add-another').addClass('usp-js');
	usp_add_another();
	
	function usp_add_another() {
		var x = parseInt($('#usp-min-images').val());
		var y = parseInt($('#usp-max-images').val());
		if (x === 0) x = 1;
		if (x >= y) $('#usp_add-another').hide();
		$('#usp_add-another').click(function(e) {
			e.preventDefault();
			x++;
			var link = $(this);
			var clone = $('#user-submitted-image').find('input:visible:last').clone().val('').attr('style', 'display:block;');
			$('#usp-min-images').val(x);
			if (x < y) {
				link.before(clone.fadeIn(300));
			} else if (x = y) {
				link.before(clone.fadeIn(300));
				link.hide();
			} else {
				link.hide();
			}
			clone.attr('data-parsley-excluded', 'true');
		});
	}
	
});