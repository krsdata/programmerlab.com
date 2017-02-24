<?php // User Submitted Posts - Plugin Settings

if (!defined('ABSPATH')) die();



function usp_add_options_page() {
	
	// add_options_page($page_title, $menu_title, $capability, $menu_slug, $function)
	add_options_page(USP_PLUGIN, USP_PLUGIN, 'manage_options', USP_PATH, 'usp_render_form');
	
}
add_action ('admin_menu', 'usp_add_options_page');



function usp_init() {
	
	// register_setting($option_group, $option_name, $sanitize_callback)
	register_setting('usp_plugin_options', 'usp_options', 'usp_validate_options');
	
}
add_action ('admin_init', 'usp_init');



function usp_plugin_action_links($links, $file) {
	
	if ($file == USP_PATH) {
		
		$usp_links = '<a href="'. get_admin_url() .'options-general.php?page='. USP_PATH .'">'. esc_html__('Settings', 'usp') .'</a>';
		
		array_unshift($links, $usp_links);
		
	}
	
	return $links;
	
}
add_filter('plugin_action_links', 'usp_plugin_action_links', 10, 2);



function add_usp_links($links, $file) {
	
	if ($file == USP_PATH) {
		
		$rate_href  = 'https://wordpress.org/support/plugin/user-submitted-posts/reviews/?rate=5#new-post';
		$rate_title = esc_attr__('Give USP a 5-star rating at WordPress.org', 'usp');
		$rate_text  = esc_html__('Rate this plugin', 'usp');
		
		$pro_href   = 'https://plugin-planet.com/usp-pro/';
		$pro_title  = esc_attr__('Get USP Pro!', 'usp');
		$pro_text   = esc_html__('Go Pro', 'usp') .'&nbsp;&raquo;';
		
		$links[] = '<a target="_blank" href="'. $rate_href .'" title="'. $rate_title .'">'. $rate_text .'</a>';
		$links[] = '<strong><a target="_blank" href="'. $pro_href .'" title="'. $pro_title .'">'. $pro_text .'</a></strong>';
		
	}
	
	return $links;
	
}
add_filter('plugin_row_meta', 'add_usp_links', 10, 2);



// http://bit.ly/1MJWrau
function usp_filter_safe_styles($styles) {
	
	 $styles[] = 'display'; 
	 
	 return $styles;
	 
}
add_filter('safe_style_css', 'usp_filter_safe_styles');



function usp_form_version() {
	
	$form_version = array(
		
		'current' => array(
			'value' => 'current',
			'label' => esc_html__('HTML5 Form + Default CSS', 'usp') .' <small>'. esc_html__('(Recommended)', 'usp') .'</small>',
		),
		'disable' => array(
			'value' => 'disable',
			'label' => esc_html__('HTML5 Form + Disable CSS', 'usp') .' <small>'. esc_html__('(Provide your own styles)', 'usp') .'</small>',
		),
		'custom' => array(
			'value' => 'custom',
			'label' => esc_html__('Custom Form + Custom CSS', 'usp') .' <small>'. esc_html__('(Provide your own form template &amp; styles)', 'usp') .'</small>',
		),
	);
	
	return $form_version;
	
}



function usp_image_display() {
	
	$image_display = array(
		
		'before' => array(
			'value' => 'before',
			'label' => esc_html__('Auto-display before post content', 'usp')
		),
		'after' => array(
			'value' => 'after',
			'label' => esc_html__('Auto-display after post content', 'usp')
		),
		'disable' => array(
			'value' => 'disable',
			'label' => esc_html__('Do not auto-display submitted images', 'usp')
		),
	);
	
	return $image_display;
	
}



function usp_email_display() {
	
	$email_display = array(
		
		'before' => array(
			'value' => 'before',
			'label' => esc_html__('Auto-display before post content', 'usp')
		),
		'after' => array(
			'value' => 'after',
			'label' => esc_html__('Auto-display after post content', 'usp')
		),
		'disable' => array(
			'value' => 'disable',
			'label' => esc_html__('Do not auto-display submitted email', 'usp')
		),
	);
	
	return $email_display;
	
}


function usp_url_display() {
	
	$url_display = array(
		
		'before' => array(
			'value' => 'before',
			'label' => esc_html__('Auto-display before post content', 'usp')
		),
		'after' => array(
			'value' => 'after',
			'label' => esc_html__('Auto-display after post content', 'usp')
		),
		'disable' => array(
			'value' => 'disable',
			'label' => esc_html__('Do not auto-display submitted URL', 'usp')
		),
	);
	
	return $url_display;
	
}



function usp_form_display_options() {
	
	global $usp_options;
	
	$usp_form_version = usp_form_version();
	
	if (!isset($checked)) $checked = '';
	
	foreach ($usp_form_version as $usp_form) {
		
		$radio_setting = $usp_options['usp_form_version'];
		
		if ('' != $radio_setting) {
			
			if ($usp_options['usp_form_version'] == $usp_form['value']) {
				
				$checked = 'checked="checked"';
				
			} else {
				
				$checked = '';
				
			}
			
		} 
		
		?>
		
		<div class="mm-radio-inputs">
			<input type="radio" name="usp_options[usp_form_version]" class="usp<?php if ($usp_form['value'] == 'custom') echo '-custom'; ?>-form" value="<?php echo esc_attr($usp_form['value']); ?>" <?php echo $checked; ?> /> 
			<?php echo $usp_form['label']; ?>
		</div>
		
<?php }
	
}



function usp_auto_display_options($item) {
	
	global $usp_options;
	
	$usp_image_display = usp_image_display();
	$usp_email_display = usp_email_display();
	$usp_url_display   = usp_url_display();
	
	if ($item === 'images') {
		
		$array = $usp_image_display;
		$key = 'auto_display_images';
		
	} elseif ($item === 'email') {
		
		$array = $usp_email_display;
		$key = 'auto_display_email';
		
	} elseif ($item === 'url') {
		
		$array = $usp_url_display;
		$key = 'auto_display_url';
	}
	
	if (!isset($checked)) $checked = '';
	
	foreach ($array as $arr) {
		
		$radio_setting = $usp_options[$key];
		
		if ('' != $radio_setting) {
			
			if ($usp_options[$key] == $arr['value']) {
				
				$checked = 'checked="checked"';
				
			} else {
				
				$checked = '';
				
			}
		} 
		
		?>
		
		<div class="mm-radio-inputs">
			<input type="radio" name="usp_options[<?php echo $key; ?>]" value="<?php echo esc_attr($arr['value']); ?>" <?php echo $checked; ?> /> 
			<?php echo $arr['label']; ?>
		</div>
		
<?php }
	
}



function usp_add_defaults() {
	
	$currentUser = wp_get_current_user();
	
	$admin_mail = get_bloginfo('admin_email');
	
	$tmp = get_option('usp_options');
	
	if(($tmp['default_options'] == '1') || (!is_array($tmp))) {
		
		$arr = array(
			'version_alert'       => 0,
			'default_options'     => 0,
			'author'              => $currentUser->ID,
			'categories'          => array(get_option('default_category')),
			'number-approved'     => -1,
			'redirect-url'        => '',
			'error-message'       => esc_html__('There was an error. Please ensure that you have added a title, some content, and that you have uploaded only images.', 'usp'),
			'min-images'          => 0,
			'max-images'          => 1,
			'min-image-height'    => 0,
			'min-image-width'     => 0,
			'max-image-height'    => 1500,
			'max-image-width'     => 1500,
			'usp_name'            => 'show',
			'usp_url'             => 'show',
			'usp_email'           => 'hide',
			'usp_title'           => 'show',
			'usp_tags'            => 'show',
			'usp_category'        => 'show',
			'usp_images'          => 'hide',
			'upload-message'      => esc_html__('Please select your image(s) to upload.', 'usp'),
			'usp_question'        => '1 + 1 =',
			'usp_response'        => '2',
			'usp_casing'          => 0,
			'usp_captcha'         => 'show',
			'usp_content'         => 'show',
			'success-message'     => esc_html__('Success! Thank you for your submission.', 'usp'),
			'usp_form_version'    => 'current',
			'usp_email_alerts'    => 1,
			'usp_email_address'   => $admin_mail,
			'usp_use_author'      => 0,
			'usp_use_url'         => 0,
			'usp_use_cat'         => 0,
			'usp_use_cat_id'      => '',
			'usp_include_js'      => 1,
			'usp_display_url'     => '',
			'usp_form_content'    => '',
			'usp_richtext_editor' => 0,
			'usp_featured_images' => 0,
			'usp_add_another'     => '',
			'disable_required'    => 0,
			'titles_unique'       => 0,
			'enable_shortcodes'   => 0,
			'disable_ip_tracking' => 0,
			'email_alert_subject' => '',
			'email_alert_message' => '',
			'auto_display_images' => 'disable',
			'auto_display_email'  => 'disable', 
			'auto_display_url'    => 'disable', 
			'auto_image_markup'   => '<a href="%%full%%"><img src="%%thumb%%" width="%%width%%" height="%%height%%" alt="%%title%%" style="display:inline-block;" /></a> ',
			'auto_email_markup'   => '<p><a href="mailto:%%email%%">'. esc_html__('Email', 'usp') .'</a></p>',
			'auto_url_markup'     => '<p><a href="%%url%%">'. esc_html__('URL', 'usp') .'</a></p>',
			'logged_in_users'     => 0,
		);
		
		update_option('usp_options', $arr);
		
	}
	
}
register_activation_hook(dirname(dirname(__FILE__)).'/user-submitted-posts.php', 'usp_add_defaults');



function usp_delete_plugin_options() {
	
	delete_option('usp_options');
	
}
if ($usp_options['default_options'] == 1) {
	
	register_uninstall_hook (dirname(dirname(__FILE__)).'/user-submitted-posts.php', 'usp_delete_plugin_options');
	
}



function usp_validate_options($input) {
	
	global $usp_options;
	
	if (!isset($input['version_alert'])) $input['version_alert'] = null;
	$input['version_alert'] = ($input['version_alert'] == 1 ? 1 : 0);
	
	if (!isset($input['default_options'])) $input['default_options'] = null;
	$input['default_options'] = ($input['default_options'] == 1 ? 1 : 0);
	
	$input['categories']       = is_array($input['categories']) && !empty($input['categories']) ? array_unique($input['categories']) : array(get_option('default_category'));
	$input['number-approved']  = is_numeric($input['number-approved']) ? intval($input['number-approved']) : -1;
	
	$input['min-images']       = is_numeric($input['min-images']) ? intval($input['min-images']) : $input['max-images'];
	$input['max-images']       = (is_numeric($input['max-images']) && ($usp_options['min-images'] <= abs($input['max-images']))) ? intval($input['max-images']) : $usp_options['max-images'];
	
	$input['min-image-height'] = is_numeric($input['min-image-height']) ? intval($input['min-image-height']) : $usp_options['min-image-height'];
	$input['min-image-width']  = is_numeric($input['min-image-width'])  ? intval($input['min-image-width'])  : $usp_options['min-image-width'];
	
	$input['max-image-height'] = (is_numeric($input['max-image-height']) && ($usp_options['min-image-height'] <= $input['max-image-height'])) ? intval($input['max-image-height']) : $usp_options['max-image-height'];
	$input['max-image-width']  = (is_numeric($input['max-image-width'])  && ($usp_options['min-image-width']  <= $input['max-image-width']))  ? intval($input['max-image-width'])  : $usp_options['max-image-width'];
	
	$usp_form_version = usp_form_version();
	if (!isset($input['usp_form_version'])) $input['usp_form_version'] = null;
	if (!array_key_exists($input['usp_form_version'], $usp_form_version)) $input['usp_form_version'] = null;
	
	$usp_image_display = usp_image_display();
	if (!isset($input['auto_display_images'])) $input['auto_display_images'] = null;
	if (!array_key_exists($input['auto_display_images'], $usp_image_display)) $input['auto_display_images'] = null;
	
	$usp_email_display = usp_email_display();
	if (!isset($input['auto_display_email'])) $input['auto_display_email'] = null;
	if (!array_key_exists($input['auto_display_email'], $usp_email_display)) $input['auto_display_email'] = null;
	
	$usp_url_display = usp_url_display();
	if (!isset($input['auto_display_url'])) $input['auto_display_url'] = null;
	if (!array_key_exists($input['auto_display_url'], $usp_url_display)) $input['auto_display_url'] = null;
	
	$input['author']              = wp_filter_nohtml_kses($input['author']);
	$input['usp_name']            = wp_filter_nohtml_kses($input['usp_name']);
	$input['usp_url']             = wp_filter_nohtml_kses($input['usp_url']);
	$input['usp_email']           = wp_filter_nohtml_kses($input['usp_email']);
	$input['usp_title']           = wp_filter_nohtml_kses($input['usp_title']);
	$input['usp_tags']            = wp_filter_nohtml_kses($input['usp_tags']);
	$input['usp_category']        = wp_filter_nohtml_kses($input['usp_category']);
	$input['usp_images']          = wp_filter_nohtml_kses($input['usp_images']);
	$input['usp_question']        = wp_filter_nohtml_kses($input['usp_question']);
	$input['usp_captcha']         = wp_filter_nohtml_kses($input['usp_captcha']);
	$input['usp_content']         = wp_filter_nohtml_kses($input['usp_content']);
	$input['usp_email_address']   = wp_filter_nohtml_kses($input['usp_email_address']);
	$input['usp_use_cat_id']      = wp_filter_nohtml_kses($input['usp_use_cat_id']);
	$input['usp_display_url']     = wp_filter_nohtml_kses($input['usp_display_url']);
	$input['redirect-url']        = wp_filter_nohtml_kses($input['redirect-url']);
	$input['email_alert_subject'] = wp_filter_nohtml_kses($input['email_alert_subject']);
	
	// dealing with kses
	global $allowedposttags;
	$allowed_atts = array(
		'align'      => array(),
		'class'      => array(),
		'type'       => array(),
		'id'         => array(),
		'dir'        => array(),
		'lang'       => array(),
		'style'      => array(),
		'xml:lang'   => array(),
		'src'        => array(),
		'alt'        => array(),
		'href'       => array(),
		'rel'        => array(),
		'rev'        => array(),
		'target'     => array(),
		'novalidate' => array(),
		'type'       => array(),
		'value'      => array(),
		'name'       => array(),
		'tabindex'   => array(),
		'action'     => array(),
		'method'     => array(),
		'for'        => array(),
		'width'      => array(),
		'height'     => array(),
		'data'       => array(),
		'title'      => array(),
	);
	$allowedposttags['form']     = $allowed_atts;
	$allowedposttags['label']    = $allowed_atts;
	$allowedposttags['input']    = $allowed_atts;
	$allowedposttags['textarea'] = $allowed_atts;
	$allowedposttags['iframe']   = $allowed_atts;
	$allowedposttags['script']   = $allowed_atts;
	$allowedposttags['style']    = $allowed_atts;
	$allowedposttags['strong']   = $allowed_atts;
	$allowedposttags['small']    = $allowed_atts;
	$allowedposttags['table']    = $allowed_atts;
	$allowedposttags['span']     = $allowed_atts;
	$allowedposttags['abbr']     = $allowed_atts;
	$allowedposttags['code']     = $allowed_atts;
	$allowedposttags['pre']      = $allowed_atts;
	$allowedposttags['div']      = $allowed_atts;
	$allowedposttags['img']      = $allowed_atts;
	$allowedposttags['h1']       = $allowed_atts;
	$allowedposttags['h2']       = $allowed_atts;
	$allowedposttags['h3']       = $allowed_atts;
	$allowedposttags['h4']       = $allowed_atts;
	$allowedposttags['h5']       = $allowed_atts;
	$allowedposttags['h6']       = $allowed_atts;
	$allowedposttags['ol']       = $allowed_atts;
	$allowedposttags['ul']       = $allowed_atts;
	$allowedposttags['li']       = $allowed_atts;
	$allowedposttags['em']       = $allowed_atts;
	$allowedposttags['hr']       = $allowed_atts;
	$allowedposttags['br']       = $allowed_atts;
	$allowedposttags['tr']       = $allowed_atts;
	$allowedposttags['td']       = $allowed_atts;
	$allowedposttags['p']        = $allowed_atts;
	$allowedposttags['a']        = $allowed_atts;
	$allowedposttags['b']        = $allowed_atts;
	$allowedposttags['i']        = $allowed_atts;
	
	$input['usp_form_content']    = wp_kses_post($input['usp_form_content'],    $allowedposttags);
	$input['error-message']       = wp_kses_post($input['error-message'],       $allowedposttags);
	$input['upload-message']      = wp_kses_post($input['upload-message'],      $allowedposttags);
	$input['success-message']     = wp_kses_post($input['success-message'],     $allowedposttags);
	$input['usp_add_another']     = wp_kses_post($input['usp_add_another'],     $allowedposttags);
	$input['email_alert_message'] = wp_kses_post($input['email_alert_message'], $allowedposttags);
	$input['auto_image_markup']   = wp_kses_post($input['auto_image_markup'],   $allowedposttags);
	$input['auto_email_markup']   = wp_kses_post($input['auto_email_markup'],   $allowedposttags);
	$input['auto_url_markup']     = wp_kses_post($input['auto_url_markup'],     $allowedposttags);
	
	if (!isset($input['usp_casing'])) $input['usp_casing'] = null;
	$input['usp_casing'] = ($input['usp_casing'] == 1 ? 1 : 0);
	
	if (!isset($input['usp_email_alerts'])) $input['usp_email_alerts'] = null;
	$input['usp_email_alerts'] = ($input['usp_email_alerts'] == 1 ? 1 : 0);
	
	if (!isset($input['usp_use_author'])) $input['usp_use_author'] = null;
	$input['usp_use_author'] = ($input['usp_use_author'] == 1 ? 1 : 0);
	
	if (!isset($input['usp_use_url'])) $input['usp_use_url'] = null;
	$input['usp_use_url'] = ($input['usp_use_url'] == 1 ? 1 : 0);
	
	if (!isset($input['usp_use_cat'])) $input['usp_use_cat'] = null;
	$input['usp_use_cat'] = ($input['usp_use_cat'] == 1 ? 1 : 0);
	
	if (!isset($input['usp_include_js'])) $input['usp_include_js'] = null;
	$input['usp_include_js'] = ($input['usp_include_js'] == 1 ? 1 : 0);
	
	if (!isset($input['usp_richtext_editor'])) $input['usp_richtext_editor'] = null;
	$input['usp_richtext_editor'] = ($input['usp_richtext_editor'] == 1 ? 1 : 0);
	
	if (!isset($input['usp_featured_images'])) $input['usp_featured_images'] = null;
	$input['usp_featured_images'] = ($input['usp_featured_images'] == 1 ? 1 : 0);
	
	if (!isset($input['disable_required'])) $input['disable_required'] = null;
	$input['disable_required'] = ($input['disable_required'] == 1 ? 1 : 0);
	
	if (!isset($input['titles_unique'])) $input['titles_unique'] = null;
	$input['titles_unique'] = ($input['titles_unique'] == 1 ? 1 : 0);
	
	if (!isset($input['enable_shortcodes'])) $input['enable_shortcodes'] = null;
	$input['enable_shortcodes'] = ($input['enable_shortcodes'] == 1 ? 1 : 0);
	
	if (!isset($input['disable_ip_tracking'])) $input['disable_ip_tracking'] = null;
	$input['disable_ip_tracking'] = ($input['disable_ip_tracking'] == 1 ? 1 : 0);
	
	if (!isset($input['logged_in_users'])) $input['logged_in_users'] = null;
	$input['logged_in_users'] = ($input['logged_in_users'] == 1 ? 1 : 0);
	
	return apply_filters('usp_input_validate', $input);
}



function usp_render_form() {
	global $wpdb, $usp_options; 
	
	$display_alert = ' style="display:block;"';
	if (isset($usp_options['version_alert']) && $usp_options['version_alert']) $display_alert = ' style="display:none;"'; ?>
	
	<style type="text/css">#mm-plugin-options .usp-custom-form-info { <?php if ($usp_options['usp_form_version'] !== 'custom') echo 'display: none;'; ?> }</style>
	
	<div id="mm-plugin-options" class="wrap">
		
		<h1><?php echo USP_PLUGIN; ?> <small><?php echo 'v'. USP_VERSION; ?></small></h1>
		<div id="mm-panel-toggle"><a href="<?php get_admin_url() .'options-general.php?page='. USP_PATH; ?>"><?php esc_html_e('Toggle all panels', 'usp'); ?></a></div>
		
		<form method="post" action="options.php">
			<?php $usp_options = get_option('usp_options'); settings_fields('usp_plugin_options'); ?>
			
			<div class="metabox-holder">
				<div class="meta-box-sortables ui-sortable">
					
					<div id="mm-panel-alert"<?php echo $display_alert; ?> class="postbox">
						<h2><?php esc_html_e('We need your support!', 'usp'); ?></h2>
						<div class="toggle">
							<div class="mm-panel-alert">
								<p>
									<?php esc_html_e('Please', 'usp'); ?> <a target="_blank" href="http://m0n.co/donate" title="<?php esc_attr_e('Make a donation via PayPal', 'usp'); ?>"><?php esc_html_e('make a donation', 'usp'); ?></a> <?php esc_html_e('and/or', 'usp'); ?> 
									<a target="_blank" href="https://wordpress.org/support/plugin/user-submitted-posts/reviews/?rate=5#new-post" title="<?php esc_attr_e('Rate and review at the Plugin Directory', 'usp'); ?>">
										<?php esc_html_e('give this plugin a 5-star rating', 'usp'); ?>&nbsp;&raquo;
									</a>
								</p>
								<p>
									<?php esc_html_e('Your generous support enables continued development of this free plugin. Thank you!', 'usp'); ?>
								</p>
								<div class="dismiss-alert">
									<div class="dismiss-alert-wrap">
										<input class="input-alert" name="usp_options[version_alert]" type="checkbox" value="1" <?php if (isset($usp_options['version_alert'])) checked('1', $usp_options['version_alert']); ?> />
										<label class="description" for="usp_options[version_alert]"><?php esc_html_e('Check this box if you have shown support', 'usp') ?></label>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div id="mm-panel-overview" class="postbox">
						<h2><?php esc_html_e('Overview', 'usp'); ?></h2>
						<div class="toggle">
							<div class="mm-panel-overview clear">
								<p class="mm-overview-intro">
									<strong><abbr title="<?php echo USP_PLUGIN; ?>">USP</abbr></strong> <?php esc_html_e('enables your visitors to submit posts and upload images from the front-end of your site. ', 'usp'); ?> 
									<?php esc_html_e('For advanced functionality and unlimited forms, check out', 'usp'); ?> <strong><a href="https://plugin-planet.com/usp-pro/" target="_blank">USP Pro</a></strong> 
									<?php esc_html_e('&mdash; the ultimate solution for user-generated content.', 'usp'); ?>
								</p>
								<div class="mm-left-div">
									<ul>
										<li><a id="mm-panel-primary-link" href="#mm-panel-primary"><?php esc_html_e('Plugin Settings', 'usp'); ?></a></li>
										<li><a id="mm-panel-secondary-link" href="#mm-panel-secondary"><?php esc_html_e('Display the form', 'usp'); ?></a></li>
										<li><a target="_blank" href="https://wordpress.org/plugins/user-submitted-posts/"><?php esc_html_e('Plugin Homepage', 'usp'); ?>&nbsp;&raquo;</a></li>
									</ul>
									<p>
										<?php esc_html_e('If you like this plugin, please', 'usp'); ?> 
										<a target="_blank" href="https://wordpress.org/support/plugin/user-submitted-posts/reviews/?rate=5#new-post" title="<?php esc_attr_e('THANK YOU for your support!', 'usp'); ?>"><?php esc_html_e('give it a 5-star rating', 'usp'); ?>&nbsp;&raquo;</a>
									</p>
								</div>
								<div class="mm-right-div">
									<a target="_blank" class="mm-pro-blurb" href="https://plugin-planet.com/usp-pro/" title="<?php esc_attr_e('Unlimited front-end forms', 'usp'); ?>"><?php esc_html_e('Get USP Pro', 'usp'); ?></a>
								</div>
							</div>
						</div>
					</div>
					
					<div id="mm-panel-primary" class="postbox">
						
						<h2><?php esc_html_e('Plugin Settings', 'usp'); ?></h2>
						
						<div class="toggle<?php if (!isset($_GET['settings-updated'])) { echo ' default-hidden'; } ?>">
							
							<p><?php esc_html_e('Configure your settings for User Submitted Posts.', 'usp'); ?></p>
							
							<h3><?php esc_html_e('Form Fields', 'usp'); ?></h3>
							
							<div class="mm-table-wrap mm-table-less-padding">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_name]"><?php esc_html_e('User Name', 'usp'); ?></label></th>
										<td>
											<select name="usp_options[usp_name]" id="usp_options[usp_name]">
												<option <?php if ($usp_options['usp_name'] == 'show') echo 'selected="selected"'; ?> value="show"><?php esc_html_e('Display and require', 'usp'); ?></option>
												<option <?php if ($usp_options['usp_name'] == 'optn') echo 'selected="selected"'; ?> value="optn"><?php esc_html_e('Display but do not require', 'usp'); ?></option>
												<option <?php if ($usp_options['usp_name'] == 'hide') echo 'selected="selected"'; ?> value="hide"><?php esc_html_e('Disable this field', 'usp'); ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_email]"><?php esc_html_e('User Email', 'usp'); ?></label></th>
										<td>
											<select name="usp_options[usp_email]" id="usp_options[usp_email]">
												<option <?php if ($usp_options['usp_email'] == 'show') echo 'selected="selected"'; ?> value="show"><?php esc_html_e('Display and require', 'usp'); ?></option>
												<option <?php if ($usp_options['usp_email'] == 'optn') echo 'selected="selected"'; ?> value="optn"><?php esc_html_e('Display but do not require', 'usp'); ?></option>
												<option <?php if ($usp_options['usp_email'] == 'hide') echo 'selected="selected"'; ?> value="hide"><?php esc_html_e('Disable this field', 'usp'); ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_url]"><?php esc_html_e('User URL', 'usp'); ?></label></th>
										<td>
											<select name="usp_options[usp_url]" id="usp_options[usp_url]">
												<option <?php if ($usp_options['usp_url'] == 'show') echo 'selected="selected"'; ?> value="show"><?php esc_html_e('Display and require', 'usp'); ?></option>
												<option <?php if ($usp_options['usp_url'] == 'optn') echo 'selected="selected"'; ?> value="optn"><?php esc_html_e('Display but do not require', 'usp'); ?></option>
												<option <?php if ($usp_options['usp_url'] == 'hide') echo 'selected="selected"'; ?> value="hide"><?php esc_html_e('Disable this field', 'usp'); ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_title]"><?php esc_html_e('Post Title', 'usp'); ?></label></th>
										<td>
											<select name="usp_options[usp_title]" id="usp_options[usp_title]">
												<option <?php if ($usp_options['usp_title'] == 'show') echo 'selected="selected"'; ?> value="show"><?php esc_html_e('Display and require', 'usp'); ?></option>
												<option <?php if ($usp_options['usp_title'] == 'optn') echo 'selected="selected"'; ?> value="optn"><?php esc_html_e('Display but do not require', 'usp'); ?></option>
												<option <?php if ($usp_options['usp_title'] == 'hide') echo 'selected="selected"'; ?> value="hide"><?php esc_html_e('Disable this field', 'usp'); ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_tags]"><?php esc_html_e('Post Tags', 'usp'); ?></label></th>
										<td>
											<select name="usp_options[usp_tags]" id="usp_options[usp_tags]">
												<option <?php if ($usp_options['usp_tags'] == 'show') echo 'selected="selected"'; ?> value="show"><?php esc_html_e('Display and require', 'usp'); ?></option>
												<option <?php if ($usp_options['usp_tags'] == 'optn') echo 'selected="selected"'; ?> value="optn"><?php esc_html_e('Display but do not require', 'usp'); ?></option>
												<option <?php if ($usp_options['usp_tags'] == 'hide') echo 'selected="selected"'; ?> value="hide"><?php esc_html_e('Disable this field', 'usp'); ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_category]"><?php esc_html_e('Post Category', 'usp'); ?></label></th>
										<td>
											<select name="usp_options[usp_category]" id="usp_options[usp_category]">
												<option <?php if ($usp_options['usp_category'] == 'show') echo 'selected="selected"'; ?> value="show"><?php esc_html_e('Display and require', 'usp'); ?></option>
												<option <?php if ($usp_options['usp_category'] == 'optn') echo 'selected="selected"'; ?> value="optn"><?php esc_html_e('Display but do not require', 'usp'); ?></option>
												<option <?php if ($usp_options['usp_category'] == 'hide') echo 'selected="selected"'; ?> value="hide"><?php esc_html_e('Disable this field', 'usp'); ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_content]"><?php esc_html_e('Post Content', 'usp'); ?></label></th>
										<td>
											<select name="usp_options[usp_content]" id="usp_options[usp_content]">
												<option <?php if ($usp_options['usp_content'] == 'show') echo 'selected="selected"'; ?> value="show"><?php esc_html_e('Display and require', 'usp'); ?></option>
												<option <?php if ($usp_options['usp_content'] == 'optn') echo 'selected="selected"'; ?> value="optn"><?php esc_html_e('Display but do not require', 'usp'); ?></option>
												<option <?php if ($usp_options['usp_content'] == 'hide') echo 'selected="selected"'; ?> value="hide"><?php esc_html_e('Disable this field', 'usp'); ?></option>
											</select>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_captcha]"><?php esc_html_e('Challenge Question', 'usp'); ?></label></th>
										<td>
											<select name="usp_options[usp_captcha]" id="usp_options[usp_captcha]">
												<option <?php if ($usp_options['usp_captcha'] == 'show') echo 'selected="selected"'; ?> value="show"><?php esc_html_e('Display and require', 'usp'); ?></option>
												<option <?php if ($usp_options['usp_captcha'] == 'hide') echo 'selected="selected"'; ?> value="hide"><?php esc_html_e('Disable this field', 'usp'); ?></option>
											</select> 
											<span class="mm-item-caption"><?php esc_html_e('(Visit', 'usp'); ?> <a href="#usp-challenge-question "><?php esc_html_e('Challenge Question', 'usp'); ?></a> <?php esc_html_e('to configure options)', 'usp'); ?></span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_images]"><?php esc_html_e('Post Images', 'usp'); ?></label></th>
										<td>
											<select name="usp_options[usp_images]" id="usp_options[usp_images]">
												<option <?php if ($usp_options['usp_images'] == 'show') echo 'selected="selected"'; ?> value="show"><?php esc_html_e('Display', 'usp'); ?></option>
												<option <?php if ($usp_options['usp_images'] == 'hide') echo 'selected="selected"'; ?> value="hide"><?php esc_html_e('Disable', 'usp'); ?></option>
											</select> 
											<span class="mm-item-caption"><?php esc_html_e('(Visit', 'usp'); ?> <a href="#usp-image-uploads"><?php esc_html_e('Image Uploads', 'usp'); ?></a> <?php esc_html_e('to configure options)', 'usp'); ?></span>
										</td>
									</tr>
								</table>
							</div>
							
							<h3><?php esc_html_e('General Settings', 'usp'); ?></h3>
							
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_form_version]"><?php esc_html_e('Form Style', 'usp'); ?></label></th>
										<td>
											<?php usp_form_display_options(); ?>
											
											<div class="usp-custom-form-info">
												<p><?php esc_html_e('With this option, you can copy the plugin&rsquo;s default templates:', 'usp'); ?></p>
												<ul>
													<li><code>/user-submitted-posts/resources/usp.css</code></li>
													<li><code>/user-submitted-posts/views/submission-form.php</code></li>
												</ul>
												<p><?php esc_html_e('..and upload them into a directory named', 'usp'); ?> <code>/usp/</code> <?php esc_html_e('in your theme:', 'usp'); ?></p>
												<ul>
													<li><code>/wp-content/themes/your-theme/usp/usp.css</code></li>
													<li><code>/wp-content/themes/your-theme/usp/submission-form.php</code></li>
												</ul>
												<p>
													<?php esc_html_e('That will enable you to customize the form and styles as desired. For more info, check out the "Custom Submission Form" section in the', 'usp'); ?> 
													<a target="_blank" href="https://wordpress.org/plugins/user-submitted-posts/installation/"><?php esc_html_e('Installation Docs', 'usp'); ?></a>. 
													<?php esc_html_e('FYI: here is a', 'usp'); ?> <a target="_blank" href="http://m0n.co/e"><?php esc_html_e('list of USP CSS selectors', 'usp'); ?>&nbsp;&raquo;</a> 
												</p>
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_include_js]"><?php esc_html_e('Include JavaScript', 'usp'); ?></label></th>
										<td><input type="checkbox" value="1" name="usp_options[usp_include_js]" <?php if (isset($usp_options['usp_include_js'])) { checked('1', $usp_options['usp_include_js']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('Check this box if you want to include the external JavaScript files (recommended).', 'usp'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_display_url]"><?php esc_html_e('Targeted Loading', 'usp'); ?></label></th>
										<td><input type="text" size="45" maxlength="200" name="usp_options[usp_display_url]" value="<?php echo esc_attr($usp_options['usp_display_url']); ?>" />
										<div class="mm-item-caption"><?php esc_html_e('When enabled, external CSS &amp; JavaScript files are loaded on every page. Here you may specify the URL of the USP form to load resources only on that page. Note: leave blank to load on all pages.', 'usp'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[number-approved]"><?php esc_html_e('Auto Publish', 'usp'); ?></label></th>
										<td>
											<select name="usp_options[number-approved]">
												<option <?php selected(-1, $usp_options['number-approved']); ?> value="-2"><?php esc_html_e('Always moderate via Draft', 'usp'); ?></option>
												<option <?php selected(-1, $usp_options['number-approved']); ?> value="-1"><?php esc_html_e('Always moderate via Pending', 'usp'); ?></option>
												<option <?php selected( 0, $usp_options['number-approved']); ?> value="0"><?php esc_html_e('Always publish immediately', 'usp'); ?></option>
												<?php foreach(range(1, 20) as $value) { ?>
												<option <?php selected($value, $usp_options['number-approved']); ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
												<?php } ?>
											</select>
											<div class="mm-item-caption"><?php esc_html_e('Post Status for submitted posts: moderate (recommended), publish immediately, or publish after any number of approved posts.', 'usp'); ?></div>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[redirect-url]"><?php esc_html_e('Redirect URL', 'usp'); ?></label></th>
										<td><input type="text" size="45" maxlength="200" name="usp_options[redirect-url]" value="<?php echo esc_attr($usp_options['redirect-url']); ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Specify a URL to redirect the user after post-submission. Leave blank to redirect back to current page.', 'usp'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[success-message]"><?php esc_html_e('Success Message', 'usp'); ?></label></th>
										<td><textarea class="textarea" rows="3" cols="50" name="usp_options[success-message]"><?php echo esc_attr($usp_options['success-message']); ?></textarea> 
										<div class="mm-item-caption"><?php esc_html_e('Success message that is displayed if post-submission is successful. Basic markup is allowed.', 'usp'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[error-message]"><?php esc_html_e('Error Message', 'usp'); ?></label></th>
										<td><textarea class="textarea" rows="3" cols="50" name="usp_options[error-message]"><?php echo esc_attr($usp_options['error-message']); ?></textarea> 
										<div class="mm-item-caption"><?php esc_html_e('General error message that is displayed if post-submission fails. Basic markup is allowed.', 'usp'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_form_content]"><?php esc_html_e('Custom Content', 'usp'); ?></label></th>
										<td><textarea class="textarea" rows="3" cols="50" name="usp_options[usp_form_content]"><?php echo esc_attr($usp_options['usp_form_content']); ?></textarea> 
										<div class="mm-item-caption"><?php esc_html_e('Custom text/markup to be included before the submission form. Leave blank to disable.', 'usp'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_richtext_editor]"><?php esc_html_e('Rich Text Editor', 'usp'); ?></label></th>
										<td><input type="checkbox" value="1" name="usp_options[usp_richtext_editor]" <?php if (isset($usp_options['usp_richtext_editor'])) { checked('1', $usp_options['usp_richtext_editor']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('Check this box if you want to enable WP rich text editing for submitted posts.', 'usp'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[titles_unique]"><?php esc_html_e('Unique Titles', 'usp'); ?></label></th>
										<td><input type="checkbox" value="1" name="usp_options[titles_unique]" <?php if (isset($usp_options['titles_unique'])) { checked('1', $usp_options['titles_unique']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('Require submitted post titles to be unique (useful for preventing multiple/duplicate submitted posts).', 'usp'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[disable_required]"><?php esc_html_e('Disable Required', 'usp'); ?></label></th>
										<td><input type="checkbox" value="1" name="usp_options[disable_required]" <?php if (isset($usp_options['disable_required'])) { checked('1', $usp_options['disable_required']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('Disable all required attributes on default form fields (useful for troubleshooting error messages).', 'usp'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[disable_ip_tracking]"><?php esc_html_e('Disable IP Tracking', 'usp'); ?></label></th>
										<td><input type="checkbox" value="1" name="usp_options[disable_ip_tracking]" <?php if (isset($usp_options['disable_ip_tracking'])) { checked('1', $usp_options['disable_ip_tracking']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('By default USP records the IP address with each submitted post. Check this box to disable all IP tracking.', 'usp'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[enable_shortcodes]"><?php esc_html_e('Enable Shortcodes', 'usp'); ?></label></th>
										<td><input name="usp_options[enable_shortcodes]" type="checkbox" value="1" <?php if (isset($usp_options['enable_shortcodes'])) checked('1', $usp_options['enable_shortcodes']); ?> /> 
										<span class="mm-item-caption"><?php esc_html_e('Enable shortcodes in widgets. By default, WordPress does not enable shortcodes in widgets. ', 'usp'); ?>
										<?php esc_html_e('This setting enables any/all shortcodes in widgets (even shortcodes from other plugins).', 'usp'); ?></span></td>
									</tr>
								</table>
							</div>
							
							<h3><?php esc_html_e('Categories', 'usp'); ?></h3>
							
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description"><?php esc_html_e('Categories', 'usp'); ?></label></th>
										<td>
											<div class="mm-item-desc">
												<a href="#" class="usp-cat-toggle-link"><?php esc_html_e('Select which categories may be assigned to submitted posts (click to toggle)', 'usp'); ?></a>
											</div>
											<div class="usp-cat-toggle-div default-hidden">
												
												<?php $categories = get_categories(array('hide_empty' => 0)); foreach($categories as $category) : ?>
												<div class="mm-radio-inputs">
													<label class="description">
														<input <?php checked(true, in_array($category->term_id, $usp_options['categories'])); ?> type="checkbox" name="usp_options[categories][]" value="<?php echo $category->term_id; ?>" /> 
														<span><?php echo sanitize_text_field($category->name); ?></span>
													</label>
												</div>
												<?php endforeach; ?>
												
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_use_cat]"><?php esc_html_e('Hidden/Default Category', 'usp'); ?></label></th>
										<td><input type="checkbox" value="1" name="usp_options[usp_use_cat]" <?php if (isset($usp_options['usp_use_cat'])) { checked('1', $usp_options['usp_use_cat']); } ?> /> 
										<span class="mm-item-caption"><?php esc_html_e('Use a hidden field for the post category. This may be used to specify a default category when the category field is disabled.', 'usp'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_use_cat_id]"><?php esc_html_e('Category ID for Hidden Field', 'usp'); ?></label></th>
										<td><input class="input-short" type="text" size="45" maxlength="100" name="usp_options[usp_use_cat_id]" value="<?php echo esc_attr($usp_options['usp_use_cat_id']); ?>" /> 
										<span class="mm-item-caption"><?php esc_html_e('Specify the ID of the category to use for the &ldquo;Hidden/Default Category&rdquo; option.', 'usp'); ?></span></td>
									</tr>
								</table>
							</div>
							
							<h3><?php esc_html_e('Users', 'usp'); ?></h3>
							
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="usp_options[author]"><?php esc_html_e('Assigned Author', 'usp'); ?></label></th>
										<td>
											<select id="usp_options[author]" name="usp_options[author]">
												
												<?php $allAuthors = $wpdb->get_results("SELECT ID, display_name FROM {$wpdb->users}"); foreach($allAuthors as $author) : ?>
												<option <?php selected($usp_options['author'], $author->ID); ?> value="<?php echo $author->ID; ?>"><?php echo $author->display_name; ?></option>
												<?php endforeach; ?>
												
											</select>
											<span class="mm-item-caption"><?php esc_html_e('Specify the user that should be assigned as author for user-submitted posts.', 'usp'); ?></span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_use_author]"><?php esc_html_e('Registered Username', 'usp'); ?></label></th>
										<td><input type="checkbox" value="1" name="usp_options[usp_use_author]" <?php if (isset($usp_options['usp_use_author'])) { checked('1', $usp_options['usp_use_author']); } ?> /> 
										<span class="mm-item-caption"><?php esc_html_e('Use registered username as post author. Valid when the person submitting the form is logged in to WordPress.', 'usp'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_use_url]"><?php esc_html_e('User Profile URL', 'usp'); ?></label></th>
										<td><input type="checkbox" value="1" name="usp_options[usp_use_url]" <?php if (isset($usp_options['usp_use_url'])) { checked('1', $usp_options['usp_use_url']); } ?> /> 
										<span class="mm-item-caption"><?php esc_html_e('Use registered user&rsquo;s Profile URL as the value of the URL field. Valid when the person submitting the form is logged in to WordPress.', 'usp'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[logged_in_users]"><?php esc_html_e('Require User Login', 'usp'); ?></label></th>
										<td><input type="checkbox" value="1" name="usp_options[logged_in_users]" <?php if (isset($usp_options['logged_in_users'])) { checked('1', $usp_options['logged_in_users']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('Require users to be logged in to WordPress to view/submit the form', 'usp'); ?></span></td>
									</tr>
								</table>
							</div>
							
							<h3 id="usp-challenge-question"><?php esc_html_e('Challenge Question', 'usp'); ?></h3>
							
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_question]"><?php esc_html_e('Challenge Question', 'usp'); ?></label></th>
										<td><input type="text" size="45" name="usp_options[usp_question]" value="<?php echo esc_attr($usp_options['usp_question']); ?>" />
										<div class="mm-item-caption"><?php esc_html_e('To prevent spam, enter a question that users must answer before submitting the form.', 'usp'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_response]"><?php esc_html_e('Challenge Response', 'usp'); ?></label></th>
										<td><input type="text" size="45" name="usp_options[usp_response]" value="<?php echo esc_attr($usp_options['usp_response']); ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Enter the *only* correct answer to the challenge question.', 'usp'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_casing]"><?php esc_html_e('Case-sensitivity', 'usp'); ?></label></th>
										<td><input type="checkbox" value="1" name="usp_options[usp_casing]" <?php if (isset($usp_options['usp_casing'])) { checked('1', $usp_options['usp_casing']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('Check this box if you want the challenge response to be case-sensitive.', 'usp'); ?></span></td>
									</tr>
								</table>
							</div>
							
							<h3><?php esc_html_e('Email Alerts', 'usp'); ?></h3>
							
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_email_alerts]"><?php esc_html_e('Receive Email Alert', 'usp'); ?></label></th>
										<td><input type="checkbox" value="1" name="usp_options[usp_email_alerts]" <?php if (isset($usp_options['usp_email_alerts'])) { checked('1', $usp_options['usp_email_alerts']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('Check this box if you want to be notified via email for new post submissions.', 'usp'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_email_address]"><?php esc_html_e('Email Address for Alerts', 'usp'); ?></label></th>
										<td><input type="text" size="45" maxlength="200" name="usp_options[usp_email_address]" value="<?php echo esc_attr($usp_options['usp_email_address']); ?>" />
										<div class="mm-item-caption"><?php esc_html_e('If you checked the box to receive email alerts, indicate here the address(es) to which the emails should be sent.', 'usp'); ?> 
										<?php esc_html_e('Multiple recipients may be included using a comma, like so:', 'usp'); ?> <code>email1@example.com</code>, <code>email2@example.com</code>, <code>email3@example.com</code></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[email_alert_subject]"><?php esc_html_e('Email Alert Subject', 'usp'); ?></label></th>
										<td><input type="text" size="45" name="usp_options[email_alert_subject]" value="<?php echo esc_attr($usp_options['email_alert_subject']); ?>" />
										<div class="mm-item-caption"><?php esc_html_e('Subject line for email alerts. Leave blank to use the default subject line. Note: you can use the following variables: ', 'usp'); ?>
										<code>%%post_title%%</code>, <code>%%admin_url%%</code>, <code>%%blog_name%%</code>, <code>%%post_url%%</code>, <code>%%blog_url%%</code></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[email_alert_message]"><?php esc_html_e('Email Alert Message', 'usp'); ?></label></th>
										<td><textarea class="textarea" rows="3" cols="50" name="usp_options[email_alert_message]"><?php echo esc_attr($usp_options['email_alert_message']); ?></textarea> 
										<div class="mm-item-caption"><?php esc_html_e('Message for email alerts. Leave blank to use the default message. Note: you can use the following variables: ', 'usp'); ?>
										<code>%%post_title%%</code>, <code>%%admin_url%%</code>, <code>%%blog_name%%</code>, <code>%%post_url%%</code>, <code>%%blog_url%%</code></div></td>
									</tr>
								</table>
							</div>
							
							<h3 id="usp-image-uploads"><?php esc_html_e('Image Uploads', 'usp'); ?></h3>
							
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_featured_images]"><?php esc_html_e('Featured Image', 'usp'); ?></label></th>
										<td><input type="checkbox" value="1" name="usp_options[usp_featured_images]" <?php if (isset($usp_options['usp_featured_images'])) { checked('1', $usp_options['usp_featured_images']); } ?> />
										<span class="mm-item-caption"><?php esc_html_e('Set submitted images as Featured Images. Requires theme support for Featured Images (aka Post Thumbnails).', 'usp'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[upload-message]"><?php esc_html_e('Upload Message', 'usp'); ?></label></th>
										<td><textarea class="textarea" rows="3" cols="50" name="usp_options[upload-message]"><?php echo esc_attr($usp_options['upload-message']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('Message that appears next to the upload field. Useful for stating your upload guidelines/policy/etc. Basic markup allowed.', 'usp'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[usp_add_another]"><?php esc_html_e('&ldquo;Add another image&rdquo; link', 'usp'); ?></label></th>
										<td><textarea class="textarea" rows="3" cols="50" name="usp_options[usp_add_another]"><?php echo esc_attr($usp_options['usp_add_another']); ?></textarea>
										<div class="mm-item-caption"><?php esc_html_e('Custom markup for the &ldquo;Add another image&rdquo; link. Leave blank to use the default markup (recommended).', 'usp'); ?></div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[min-images]"><?php esc_html_e('Minimum number of images', 'usp'); ?></label></th>
										<td>
											<input name="usp_options[min-images]" type="number" step="1" min="0" max="999" maxlength="3" value="<?php echo $usp_options['min-images']; ?>" />
											<span class="mm-item-caption"><?php esc_html_e('Specify the minimum number of images.', 'usp'); ?></span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[max-images]"><?php esc_html_e('Maximum number of images', 'usp'); ?></label></th>
										<td>
											<input name="usp_options[max-images]" type="number" step="1" min="0" max="999" maxlength="3" value="<?php echo $usp_options['max-images']; ?>" />
											<span class="mm-item-caption"><?php esc_html_e('Specify the maximum number of images.', 'usp'); ?></span>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[min-image-width]"><?php esc_html_e('Minimum image width', 'usp'); ?></label></th>
										<td><input class="input-short" type="text" size="5" maxlength="100" name="usp_options[min-image-width]" value="<?php echo esc_attr($usp_options['min-image-width']); ?>" />
										<span class="mm-item-caption"><?php esc_html_e('Specify a minimum width (in pixels) for uploaded images.', 'usp'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[min-image-height]"><?php esc_html_e('Minimum image height', 'usp'); ?></label></th>
										<td><input class="input-short" type="text" size="5" maxlength="100" name="usp_options[min-image-height]" value="<?php echo esc_attr($usp_options['min-image-height']); ?>" />
										<span class="mm-item-caption"><?php esc_html_e('Specify a minimum height (in pixels) for uploaded images.', 'usp'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[max-image-width]"><?php esc_html_e('Maximum image width', 'usp'); ?></label></th>
										<td><input class="input-short" type="text" size="5" maxlength="100" name="usp_options[max-image-width]" value="<?php echo esc_attr($usp_options['max-image-width']); ?>" />
										<span class="mm-item-caption"><?php esc_html_e('Specify a maximum width (in pixels) for uploaded images.', 'usp'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[max-image-height]"><?php esc_html_e('Maximum image height', 'usp'); ?></label></th>
										<td><input class="input-short" type="text" size="5" maxlength="100" name="usp_options[max-image-height]" value="<?php echo esc_attr($usp_options['max-image-height']); ?>" />
										<span class="mm-item-caption"><?php esc_html_e('Specify a maximum height (in pixels) for uploaded images.', 'usp'); ?></span></td>
									</tr>
									<tr>
										<th scope="row"><label class="description"><?php esc_html_e('More Options', 'usp'); ?></label></th>
										<td>
											<span class="mm-item-caption">
												<?php esc_html_e('For more options, like the ability to upload other file types (like PDF, Word, Zip, videos, and more), check out', 'usp'); ?> 
												<a target="_blank" href="https://plugin-planet.com/usp-pro/" title="<?php esc_attr__('Go Pro!', 'usp'); ?>"><?php esc_html_e('USP Pro', 'usp'); ?>&nbsp;&raquo;</a>
											</span>
										</td>
									</tr>
								</table>
							</div>
							
							<h3><?php esc_html_e('Auto-Display Content', 'usp'); ?></h3>
							
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="usp_options[auto_display_images]"><?php esc_html_e('Images Auto-Display', 'usp'); ?></label></th>
										<td>
											<span class="mm-item-desc"><?php esc_html_e('Auto-display user-submitted images:', 'usp'); ?></span>
											<?php usp_auto_display_options('images') ; ?>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[auto_image_markup]"><?php esc_html_e('Image Markup', 'usp'); ?></label></th>
										<td><textarea class="textarea" rows="3" cols="50" name="usp_options[auto_image_markup]"><?php echo esc_attr($usp_options['auto_image_markup']); ?></textarea> 
										<div class="mm-item-caption"><?php esc_html_e('Markup to use for each submitted image (when auto-display is enabled). Can use', 'usp'); ?> 
										<code>%%width%%</code>, <code>%%height%%</code>, <code>%%thumb%%</code>, <code>%%medium%%</code>, <code>%%large%%</code>, 
										<code>%%full%%</code>, <code>%%custom%%</code>, <?php esc_html_e('and', 'usp'); ?> <code>%%title%%</code>.</div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[auto_display_email]"><?php esc_html_e('Email Auto-Display', 'usp'); ?></label></th>
										<td>
											<span class="mm-item-desc"><?php esc_html_e('Auto-display user-submitted email:', 'usp'); ?></span>
											<?php usp_auto_display_options('email') ; ?>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[auto_email_markup]"><?php esc_html_e('Email Markup', 'usp'); ?></label></th>
										<td><textarea class="textarea" rows="3" cols="50" name="usp_options[auto_email_markup]"><?php echo esc_attr($usp_options['auto_email_markup']); ?></textarea> 
										<div class="mm-item-caption"><?php esc_html_e('Markup to use for the submitted email address (when auto-display is enabled). Can use', 'usp'); ?> <code>%%email%%</code>.</div></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[auto_display_url]"><?php esc_html_e('URL Auto-Display', 'usp'); ?></label></th>
										<td>
											<span class="mm-item-desc"><?php esc_html_e('Auto-display user-submitted URL:', 'usp'); ?></span>
											<?php usp_auto_display_options('url') ; ?>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="usp_options[auto_url_markup]"><?php esc_html_e('URL Markup', 'usp'); ?></label></th>
										<td><textarea class="textarea" rows="3" cols="50" name="usp_options[auto_url_markup]"><?php echo esc_attr($usp_options['auto_url_markup']); ?></textarea> 
										<div class="mm-item-caption"><?php esc_html_e('Markup to use for the submitted URL (when auto-display is enabled). Can use', 'usp'); ?> <code>%%url%%</code>.</div></td>
									</tr>
								</table>
							</div>
							
							<input type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'usp'); ?>" />
						</div>
					</div>
					
					<div id="mm-panel-secondary" class="postbox">
						<h2><?php esc_html_e('Shortcode &amp; Template Tag', 'usp'); ?></h2>
						<div class="toggle<?php if (!isset($_GET['settings-updated'])) { echo ' default-hidden'; } ?>">
							
							<p><?php esc_html_e('To implement USP, first configure the plugin settings, then use the shortcode or template to display the form on the front-end as desired.', 'usp'); ?></p>
							
							<h3><?php esc_html_e('Shortcode', 'usp'); ?></h3>
							<p><?php esc_html_e('Use this shortcode to display the USP Form on any WP Post or Page:', 'usp'); ?></p>
							<p><code class="mm-code">[user-submitted-posts]</code></p>

							<h3><?php esc_html_e('Template tag', 'usp'); ?></h3>
							<p><?php esc_html_e('Use this template tag to display the USP Form anywhere in your theme template:', 'usp'); ?></p>
							<p><code class="mm-code">&lt;?php if (function_exists('user_submitted_posts')) user_submitted_posts(); ?&gt;</code></p>
						</div>
					</div>
					
					<div id="mm-restore-settings" class="postbox">
						<h2><?php esc_html_e('Restore Defaults', 'usp'); ?></h2>
						<div class="toggle<?php if (!isset($_GET['settings-updated'])) { echo ' default-hidden'; } ?>">
							<p>
								<input name="usp_options[default_options]" type="checkbox" value="1" id="mm_restore_defaults" <?php if (isset($usp_options['default_options'])) { checked('1', $usp_options['default_options']); } ?> /> 
								<label class="description" for="usp_options[default_options]"><?php esc_html_e('Restore default options upon plugin deactivation/reactivation.', 'usp'); ?></label>
							</p>
							<p>
								<small>
									<strong><?php esc_html_e('Tip:', 'usp'); ?></strong> 
									<?php esc_html_e('leave this option unchecked to remember your settings.', 'usp'); ?> 
									<?php esc_html_e('Or, to go ahead and restore all default options, check the box, save your settings, and then deactivate/reactivate the plugin.', 'usp'); ?>
								</small>
							</p>
							<input type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'usp'); ?>" />
						</div>
					</div>
					
					<div id="mm-panel-current" class="postbox">
						<h2><?php esc_html_e('Show Support', 'usp'); ?></h2>
						<div class="toggle">
							<div id="mm-iframe-wrap">
								<iframe src="https://perishablepress.com/current/index-usp.html"></iframe>
							</div>
						</div>
					</div>
					
				</div>
			</div>
			
			<div id="mm-credit-info">
				<a target="_blank" href="https://perishablepress.com/user-submitted-posts/" title="<?php esc_attr_e('Plugin Homepage', 'usp'); ?>"><?php echo USP_PLUGIN; ?></a> <?php esc_html_e('by', 'usp'); ?> 
				<a target="_blank" href="https://twitter.com/perishable" title="<?php esc_attr_e('Jeff Starr on Twitter', 'usp'); ?>">Jeff Starr</a> @ 
				<a target="_blank" href="http://monzillamedia.com/" title="<?php esc_attr_e('Obsessive Web Design &amp; Development', 'usp'); ?>">Monzilla Media</a>
			</div>
		</form>
	</div>
	
	<script type="text/javascript">
		jQuery(document).ready(function($){
			
			// dismiss alert
			if (!$('.dismiss-alert-wrap input').is(':checked')){
				$('.dismiss-alert-wrap input').one('click', function(){
					$('.dismiss-alert-wrap').after('<input type="submit" class="button-secondary" value="<?php esc_attr_e('Save Preference', 'gap'); ?>" />');
				});
			}
			
			// prevent accidents
			if (!$("#mm_restore_defaults").is(":checked")){
				$('#mm_restore_defaults').click(function(event){
					var r = confirm("<?php esc_html_e('Are you sure you want to restore all default options? (this action cannot be undone)', 'usp'); ?>");
					if (r == true) $("#mm_restore_defaults").attr('checked', true);
					else $("#mm_restore_defaults").attr('checked', false);
				});
			}
			
		});
	</script>

<?php }


