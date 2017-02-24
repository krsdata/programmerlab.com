<?php // User Submitted Posts - Enqueue Script & Style

if (!defined('ABSPATH')) die();



function usp_enqueueResources() {
	
	global $usp_options;
	
	$min_images   = $usp_options['min-images'];
	$include_js   = $usp_options['usp_include_js'];
	$form_type    = $usp_options['usp_form_version'];
	$display_url  = $usp_options['usp_display_url'];
	$usp_response = $usp_options['usp_response']; 
	$usp_casing   = $usp_options['usp_casing'];
	
	$protocol = is_ssl() ? 'https://' : 'http://';
	
	$display_url = esc_url_raw(trim($display_url));
	$current_url = esc_url_raw($protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	$current_url = remove_query_arg(array('submission-error', 'error', 'success', 'post_id'), $current_url);
	
	$plugin_url  = plugins_url() .'/'. basename(dirname(dirname(__FILE__)));
	
	$custom_url  = get_stylesheet_directory_uri() .'/usp/usp.css';
	$custom_path = get_stylesheet_directory() .'/usp/usp.css';
	
	$usp_css = ($form_type === 'custom' && file_exists($custom_path)) ? $custom_url : $plugin_url . '/resources/usp.css';
	
	$display_js = false;
	$display_css = false;
	
	if (empty($display_url) || strpos($current_url, $display_url) !== false) {
		
		if ($include_js == true)      $display_js = true;
		if ($form_type !== 'disable') $display_css = true;
		
	}
	
	if ($display_css) {
		
		wp_enqueue_style('usp_style', $usp_css, false, null, 'all');
		
	}
	
	if ($display_js) {
		
		wp_enqueue_script('usp_cookie',  $plugin_url .'/resources/jquery.cookie.js',      array('jquery'), null);
		wp_enqueue_script('usp_parsley', $plugin_url .'/resources/jquery.parsley.min.js', array('jquery'), null);
		wp_enqueue_script('usp_core',    $plugin_url .'/resources/jquery.usp.core.js',    array('jquery'), null);
		
		$print_casing = $usp_casing ? 'true' : 'false';
		
		$script  = 'window.ParsleyConfig = { excluded: ".exclude" }; ';
		$script .= 'var usp_case_sensitivity = '. json_encode($print_casing) .'; ';
		$script .= 'var usp_challenge_response = '. json_encode($usp_response) .';';
		
		wp_add_inline_script('usp_core', $script, 'before');
		
		if ($min_images > 0) {
			
			// wp_enqueue_script('usp_files', $plugin_url .'/resources/jquery.usp.files.js', array('jquery'), null);
			
		}
		
	}
	
}
add_action('wp_enqueue_scripts', 'usp_enqueueResources');



function usp_load_admin_styles($hook) {
	
	global $pagenow;
	
	/*
		wp_enqueue_style($handle, $src, $deps, $ver, $media)
		wp_enqueue_script($handle, $src, $deps, $ver, $in_footer)
	*/
	
	$base = plugins_url() .'/'. basename(dirname(dirname(__FILE__)));
	
	if ($hook === 'settings_page_user-submitted-posts/user-submitted-posts') {
		
		wp_enqueue_style('usp_admin_styles', $base .'/resources/usp-admin.css', array(), USP_VERSION, 'all');
		wp_enqueue_script('usp_admin_script', $base .'/resources/jquery.usp.admin.js', array('jquery'), USP_VERSION, false);
		
	}
	
	if ($pagenow === 'edit.php') {
		
		wp_enqueue_style('usp_posts_styles', $base .'/resources/usp-posts.css', array(), USP_VERSION, 'all');
		
	}
	
}
add_action('admin_enqueue_scripts', 'usp_load_admin_styles');


