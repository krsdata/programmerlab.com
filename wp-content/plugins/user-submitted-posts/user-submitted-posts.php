<?php 
/*
	Plugin Name: User Submitted Posts
	Plugin URI: https://perishablepress.com/user-submitted-posts/
	Description: Enables your visitors to submit posts and images from anywhere on your site.
	Tags: community, content, custom fields, files, form, forms, front end, front-end, frontend, frontend content, frontend publishing, frontend uploader, generated content, guest, images, login, post, posts, public, publish, publishing, publishing, register, share, sharing, submission, submissions, submit, submitted, upload, uploader, user generated, user submit, user submitted, user-generated, user-submit, user-submitted, users, video, visitor
	Author: Jeff Starr
	Author URI: https://plugin-planet.com/
	Donate link: http://m0n.co/donate
	Contributors: specialk
	Requires at least: 4.1
	Tested up to: 4.7
	Stable tag: 20161122
	Version: 20161122
	Text Domain: usp
	Domain Path: /languages
	License: GPL v2 or later
*/

if (!defined('ABSPATH')) die();



define('USP_WP_VERSION', '4.1');
define('USP_VERSION', '20161122');
define('USP_PLUGIN', esc_html__('User Submitted Posts', 'usp'));
define('USP_PATH', plugin_basename(__FILE__));

$usp_options = get_option('usp_options');

require_once('library/template-tags.php');
require_once('library/core-functions.php');
require_once('library/enqueue-scripts.php');
require_once('library/plugin-settings.php');



function usp_i18n_init() {
	
	load_plugin_textdomain('usp', false, dirname(plugin_basename(__FILE__)) .'/languages/');
	
}
add_action('plugins_loaded', 'usp_i18n_init');



function usp_require_wp_version() {
	
	global $wp_version;
	
	if (version_compare($wp_version, USP_WP_VERSION, '<')) {
		
		if (is_plugin_active(USP_PATH)) {
			
			deactivate_plugins(USP_PATH);
			
			$msg  = '<strong>'. USP_PLUGIN .'</strong> ';
			$msg .= esc_html__('requires WordPress ', 'usp') . USP_WP_VERSION;
			$msg .= esc_html__(' or higher, and has been deactivated! ', 'usp');
			$msg .= esc_html__('Please return to the', 'usp') .' <a href="'. admin_url() .'">';
			$msg .= esc_html__('WordPress Admin Area', 'usp') .'</a> ';
			$msg .= esc_html__('to upgrade WordPress and try again.', 'usp');
			
			wp_die($msg);
			
		}
		
	}
	
}
if (isset($_GET['activate']) && $_GET['activate'] == 'true') {
	
	add_action('admin_init', 'usp_require_wp_version');
	
}



if (isset($usp_options['enable_shortcodes']) && $usp_options['enable_shortcodes']) {
	
	// add_filter('the_content', 'do_shortcode', 10);
	add_filter('widget_text', 'do_shortcode', 10); 
	
}



function usp_check_required($field) {
	
	global $usp_options;
	
	if ($usp_options[$field] === 'show') return true;
	
	else return false;
	
}



function usp_get_default_title() {
	
	$time = date_i18n('Ymd', current_time('timestamp')) .'-'. date_i18n('His', current_time('timestamp'));
	
	$title = esc_html__('User Submitted Post', 'usp');
	
	$title = apply_filters('usp_default_title', $title, $time);
	
	return $title;
	
}



function usp_checkForPublicSubmission() {
	
	global $usp_options;
	
	if (isset($_POST['user-submitted-post'], $_POST['usp-nonce']) && !empty($_POST['user-submitted-post']) && wp_verify_nonce($_POST['usp-nonce'], 'usp-nonce')) {
		
		$title = usp_get_default_title();
		
		if (isset($_POST['user-submitted-title']) && ($usp_options['usp_title'] == 'show' || $usp_options['usp_title'] == 'optn')) {
			
			$title = sanitize_text_field($_POST['user-submitted-title']);
			
		}
		
		$files    = isset($_FILES['user-submitted-image']) ? $_FILES['user-submitted-image'] : array();
		
		$ip       = isset($_SERVER['REMOTE_ADDR'])           ? sanitize_text_field($_SERVER['REMOTE_ADDR']) : '';
		
		$author   = isset($_POST['user-submitted-name'])     ? sanitize_text_field($_POST['user-submitted-name'])     : '';
		$url      = isset($_POST['user-submitted-url'])      ? esc_url($_POST['user-submitted-url'])                  : '';
		$email    = isset($_POST['user-submitted-email'])    ? sanitize_email($_POST['user-submitted-email'])         : '';
		$tags     = isset($_POST['user-submitted-tags'])     ? sanitize_text_field($_POST['user-submitted-tags'])     : '';
		$captcha  = isset($_POST['user-submitted-captcha'])  ? sanitize_text_field($_POST['user-submitted-captcha'])  : '';
		$verify   = isset($_POST['user-submitted-verify'])   ? sanitize_text_field($_POST['user-submitted-verify'])   : '';
		$content  = isset($_POST['user-submitted-content'])  ? usp_sanitize_content($_POST['user-submitted-content']) : '';
		$category = isset($_POST['user-submitted-category']) ? intval($_POST['user-submitted-category'])              : '';
		
		$result = usp_createPublicSubmission($title, $files, $ip, $author, $url, $email, $tags, $captcha, $verify, $content, $category);
		
		$post_id = false; 
		
		if (isset($result['id'])) $post_id = $result['id'];
		
		$error = false;
		
		if (isset($result['error'])) $error = array_filter(array_unique($result['error']));
		
		if ($error) {
			
			$e = implode(',', $error);
			$e = trim($e, ',');
			
		} else {
			
			$e = 'error';
			
		}
		
		if ($post_id) {
			
			if (!empty($_POST['redirect-override'])) {
				
				$redirect = $_POST['redirect-override'];
				
				$redirect = remove_query_arg(array('usp-error'), $redirect);
				$redirect = add_query_arg(array('usp_redirect' => '1', 'success' => 1, 'post_id' => $post_id), $redirect);
				
			} else {
				
				$redirect = $_SERVER['REQUEST_URI'];
				
				$redirect = remove_query_arg(array('usp-error'), $redirect);
				$redirect = add_query_arg(array('success' => 1, 'post_id' => $post_id), $redirect);
				
			}
			
			do_action('usp_submit_success', $redirect);
			
		} else {
			
			if (!empty($_POST['redirect-override'])) {
				
				$redirect = $_POST['redirect-override'];
				
				$redirect = remove_query_arg(array('success', 'post_id'), $redirect);
				$redirect = add_query_arg(array('usp_redirect' => '1', 'usp-error' => $e), $redirect);
				
			} else {
				
				$redirect = $_SERVER['REQUEST_URI'];
				
				$redirect = remove_query_arg(array('success', 'post_id'), $redirect);
				$redirect = add_query_arg(array('usp-error' => $e), $redirect);
				
			}
			
			do_action('usp_submit_error', $redirect);
			
		}
		
		wp_redirect(esc_url_raw($redirect));
		
		exit();
		
	}
	
}
add_action('parse_request', 'usp_checkForPublicSubmission', 1);



function usp_sanitize_content($content) {
	
	$allowed_tags = wp_kses_allowed_html('post');
	
	$allowed_tags['iframe'] = array(
		'src'              => array(),
		'height'           => array(),
		'width'            => array(),
		'frameborder'      => array(),
		'allowfullscreen'  => array(),
	);
	
	$allowed_tags['input']  = array(
		'class'            => array(),
		'id'               => array(),
		'name'             => array(),
		'value'            => array(),
		'type'             => array(),
	);
	
	$allowed_tags['select'] = array(
		'class'            => array(),
		'id'               => array(),
		'name'             => array(),
		'value'            => array(),
		'type'             => array(),
	);
	
	$allowed_tags['option'] = array(
		'selected'         => array(),
	);
	
	$allowed_tags['style']  = array(
		'types'            => array(),
	);
	
	return wp_kses(stripslashes($content), $allowed_tags);
	
}



if (!current_theme_supports('post-thumbnails')) {
	
	add_theme_support('post-thumbnails');
	
}
function usp_display_featured_image() {
	
	global $post, $usp_options;
	
	if (is_object($post) && usp_is_public_submission($post->ID)) {
		
		if ((!has_post_thumbnail()) && ($usp_options['usp_featured_images'] == 1)) {
			
			$args = array(
				'post_type'      => 'attachment', 
				'post_mime_type' =>'image', 
				'posts_per_page' => 0, 
				'post_parent'    => $post->ID, 
				'order'          =>'ASC'
			);
			
			$attachments = get_posts($args);
			
			if ($attachments) {
				
				foreach ($attachments as $attachment) {
					
					set_post_thumbnail($post->ID, $attachment->ID);
					
					break;
					
				}
				
			}
			
		}
		
	}
	
}
add_action('wp', 'usp_display_featured_image');



function usp_add_meta_box() {
	
	global $post;
	
	if (usp_is_public_submission()) {
		
		$screens = array('post', 'page');
		
		$name  = get_post_meta($post->ID, 'user_submit_name', true);
		$email = get_post_meta($post->ID, 'user_submit_email', true);
		$url   = get_post_meta($post->ID, 'user_submit_url', true);
		$ip    = get_post_meta($post->ID, 'user_submit_ip', true); 
		
		if (!empty($name) || !empty($email) || !empty($url) || !empty($ip)) {
			
			foreach ($screens as $screen) {
				
				add_meta_box('usp_section_id', esc_html__('User Submitted Post Info', 'usp'), 'usp_meta_box_callback', $screen);
				
			}
			
		}
		
	}
	
}
add_action('add_meta_boxes', 'usp_add_meta_box');



function usp_meta_box_callback($post) {
	
	global $usp_options; 
	
	if (usp_is_public_submission()) {
		
		wp_nonce_field('usp_meta_box_nonce', 'usp_meta_box_nonce');
		
		$name  = get_post_meta($post->ID, 'user_submit_name', true);
		$email = get_post_meta($post->ID, 'user_submit_email', true);
		$url   = get_post_meta($post->ID, 'user_submit_url', true);
		$ip    = get_post_meta($post->ID, 'user_submit_ip', true); 
		
		if (!empty($name) || !empty($email) || !empty($url) || !empty($ip)) {
			
			echo '<ul style="margin-left:24px;list-style:square outside;">';
			
			if (!empty($name))  echo '<li>'. esc_html__('Submitter Name: ', 'usp')  . $name  .'</li>';
			if (!empty($email)) echo '<li>'. esc_html__('Submitter Email: ', 'usp') . $email .'</li>';
			if (!empty($url))   echo '<li>'. esc_html__('Submitter URL: ', 'usp')   . $url   .'</li>';
			if (!empty($ip) && !$usp_options['disable_ip_tracking']) echo '<li>'. esc_html__('Submitter IP: ', 'usp') . $ip .'</li>';
			
			echo '</ul>';
			
		}
		
	}
	
}



function usp_display_form() {
	
	global $usp_options;
	
	$default = WP_PLUGIN_DIR .'/'. basename(dirname(__FILE__)) .'/views/submission-form.php';
	
	$custom  = get_stylesheet_directory() .'/usp/submission-form.php';
	
	ob_start();
	
	if ($usp_options['usp_form_version'] === 'custom' && file_exists($custom)) include($custom);
	
	else include($default);
	
	return apply_filters('usp_form_shortcode', ob_get_clean());
	
}
add_shortcode ('user-submitted-posts', 'usp_display_form');



function user_submitted_posts() {
	
	echo usp_display_form();
	
}



function usp_outputUserSubmissionLink() {
	
	global $pagenow;
	
	if ($pagenow == 'edit.php') {
		
		$link  = '<a id="usp_admin_filter_posts" class="button" ';
		$link .= 'href="'. admin_url('edit.php?user_submitted=1') .'" ';
		$link .= 'title="'. esc_attr__('Show USP Posts', 'usp') .'">';
		$link .= esc_html__('USP', 'usp') .'</a>';
		
	}
	
	echo $link;
	
}
add_action ('restrict_manage_posts', 'usp_outputUserSubmissionLink');



function usp_addSubmittedStatusClause($wp_query) {
	
	global $pagenow;
	
	if (isset($_GET['user_submitted']) && $_GET['user_submitted'] === '1') {
		
		if (is_admin() && $pagenow == 'edit.php') {
			
			set_query_var('meta_key', 'is_submission');
			set_query_var('meta_value', 1);
			
		}
		
	}
	
}
add_action ('parse_query', 'usp_addSubmittedStatusClause');



function usp_replaceAuthor($author) {
	
	global $post, $usp_options;

	$isSubmission     = get_post_meta($post->ID, 'is_submission', true);
	$submissionAuthor = get_post_meta($post->ID, 'user_submit_name', true);

	if ($isSubmission && !empty($submissionAuthor)) $author = $submissionAuthor;
	
	return apply_filters('usp_post_author', $author);
	
}
add_filter ('the_author', 'usp_replaceAuthor');



function usp_get_author($author) {
	
	global $usp_options;
	
	$error = false;
	
	$author_id = $usp_options['author'];
	
	if (!empty($author)) {
		
		if ($usp_options['usp_use_author']) {
			
			$author_info = get_user_by('login', $author);
			
			if ($author_info) {
				
				$author_id = $author_info->ID;
				
				$author = get_the_author_meta('display_name', $author_id);
				
			}
			
		}
		
	} else {
		
		if ($usp_options['usp_name'] == 'show') {
			
			$error = 'required-name';
			
		} else {
			
			$author = get_the_author_meta('display_name', $author_id);
			
		}
		
	}
	
	$author_data = array('author' => $author, 'author_id' => $author_id, 'error' => $error);
	
	return $author_data;
	
}



if (!function_exists('exif_imagetype')) {
	
	function exif_imagetype($filename) {
		
		if ((list($width, $height, $type, $attr) = getimagesize($filename)) !== false) {
			
			return $type;
			
		}
		
		return false;
		
	}
	
} 



function usp_check_images($files, $newPost) {
	
	global $usp_options;
	
	$temp = false; $errr = false; $error = array();
	
	if (isset($files['tmp_name'])) $temp = array_filter($files['tmp_name']);
	if (isset($files['error']))    $errr = array_filter($files['error']);
	
	$file_count = 0;
	
	if (!empty($temp)) {
		
		foreach ($temp as $key => $value) if (is_uploaded_file($value)) $file_count++;
		
	}
	
	if ($usp_options['usp_images'] == 'show') {
		
		if ($file_count < $usp_options['min-images']) $error[] = 'file-min';
		if ($file_count > $usp_options['max-images']) $error[] = 'file-max';
		
		for ($i = 0; $i < $file_count; $i++) {
			
			$image = @getimagesize($temp[$i]);
			
			if (false === $image) {
				
				$error[] = 'file-type';
				
				break;
				
			} else {
				
				if (isset($temp[$i]) && !exif_imagetype($temp[$i])) {
					
					$error[] = 'file-type';
					
					break;
					
				}
				
				if (isset($image[0]) && !usp_width_min($image[0])) {
					
					$error[] = 'width-min';
					
					break;
					
				}
				
				if (isset($image[0]) && !usp_width_max($image[0])) {
					
					$error[] = 'width-max';
					
					break;
					
				}
				
				if (isset($image[1]) && !usp_height_min($image[1])) {
					
					$error[] = 'height-min';
					
					break;
					
				}
				
				if (isset($image[1]) && !usp_height_max($image[1])) {
					
					$error[] = 'height-max';
					
					break;
					
				}
				
				if (isset($errr[$i]) && $errr[$i] == 4) {
					
					$error[] = 'file-error';
					
					break;
					
				}
				
			}
			
		}
		
	} else {
		
		$files = false;
		
	}
	
	$file_data = array('error' => $error, 'file_count' => $file_count);
	
	return $file_data;
	
}



function usp_prepare_post($title, $content, $author_id, $author, $ip) {
	
	global $usp_options;
	
	$postData = array();
	$postData['post_title']   = $title;
	$postData['post_content'] = $content;
	$postData['post_author']  = $author_id;
	$postData['post_status']  = apply_filters('usp_post_status', 'pending');
	
	$numberApproved = $usp_options['number-approved'];
	
	if ($numberApproved == 0) {
		
		$postData['post_status'] = apply_filters('usp_post_publish', 'publish');
		
	} elseif ($numberApproved == -1) {
		
		$postData['post_status'] = apply_filters('usp_post_moderate', 'pending');
		
	} elseif ($numberApproved == -2) {
		
		$postData['post_status'] = apply_filters('usp_post_draft', 'draft');
		
	} else {
		
		$posts = get_posts(array('post_status' => 'publish', 'meta_key' => 'user_submit_name', 'meta_value' => $author));
		
		$counter = 0;
		
		foreach ($posts as $post) {
			
			$submitterName = get_post_meta($post->ID, 'user_submit_name', true);
			$submitterIp   = get_post_meta($post->ID, 'user_submit_ip', true);
			
			if ($submitterName == $author && $submitterIp == $ip) $counter++;
			
		}
		
		if ($counter >= $numberApproved) $postData['post_status'] = apply_filters('usp_post_approve', 'publish');
		
	}
	
	return apply_filters('usp_post_data', $postData);
	
}



function usp_check_duplicates($title) {
	
	global $usp_options;
	
	if ($usp_options['titles_unique']) {
		
		$check_post = get_page_by_title($title, OBJECT, 'post');
		
		if ($check_post && $check_post->ID) return false;
		
	}
	
	return true;
	
}



function usp_createPublicSubmission($title, $files, $ip, $author, $url, $email, $tags, $captcha, $verify, $content, $category) {
	
	global $usp_options;
	
	// check errors
	$newPost = array('id' => false, 'error' => false);
	
	$author_data        = usp_get_author($author);
	$author             = $author_data['author'];
	$author_id          = $author_data['author_id'];
	$newPost['error'][] = $author_data['error'];
	
	$file_data          = usp_check_images($files, $newPost);
	$file_count         = $file_data['file_count'];
	$newPost['error']   = array_unique(array_merge($file_data['error'], $newPost['error']));
	
	if (isset($usp_options['usp_title'])    && ($usp_options['usp_title']    == 'show') && empty($title))    $newPost['error'][] = 'required-title';
	if (isset($usp_options['usp_url'])      && ($usp_options['usp_url']      == 'show') && empty($url))      $newPost['error'][] = 'required-url';
	if (isset($usp_options['usp_tags'])     && ($usp_options['usp_tags']     == 'show') && empty($tags))     $newPost['error'][] = 'required-tags';
	if (isset($usp_options['usp_category']) && ($usp_options['usp_category'] == 'show') && empty($category)) $newPost['error'][] = 'required-category';
	if (isset($usp_options['usp_content'])  && ($usp_options['usp_content']  == 'show') && empty($content))  $newPost['error'][] = 'required-content';
	
	if (isset($usp_options['usp_captcha']) && ($usp_options['usp_captcha'] == 'show') && !usp_spamQuestion($captcha)) $newPost['error'][] = 'required-captcha';
	if (isset($usp_options['usp_email'])   && ($usp_options['usp_email']   == 'show') && !usp_validateEmail($email))  $newPost['error'][] = 'required-email';
	
	if (isset($usp_options['titles_unique']) && $usp_options['titles_unique'] && !usp_check_duplicates($title)) $newPost['error'][] = 'duplicate-title';
	if (!empty($verify)) $newPost['error'][] = 'spam-verify';
	
	foreach ($newPost['error'] as $e) {
		
		if (!empty($e)) {
			
			unset($newPost['id']);
			
			return $newPost;
			
		}
		
	}
	
	// submit post
	$postData = usp_prepare_post($title, $content, $author_id, $author, $ip);
	
	do_action('usp_insert_before', $postData);
	$newPost['id'] = wp_insert_post($postData);
	do_action('usp_insert_after', $newPost);
	
	if ($newPost['id']) {
		
		$post_id = $newPost['id'];
		
		wp_set_post_tags($post_id, $tags);
		
		wp_set_post_categories($post_id, array($category));
		
		usp_send_mail_alert($post_id, $title);
		
		do_action('usp_files_before', $files);
		
		$attach_ids = array();
		
		if ($files && $file_count > 0) {
			
			usp_include_deps();
			
			for ($i = 0; $i < $file_count; $i++) {
				
				$key = apply_filters('usp_file_key', 'user-submitted-image-{$i}');
				
				$_FILES[$key]             = array();
				$_FILES[$key]['name']     = $files['name'][$i];
				$_FILES[$key]['tmp_name'] = $files['tmp_name'][$i];
				$_FILES[$key]['type']     = $files['type'][$i];
				$_FILES[$key]['error']    = $files['error'][$i];
				$_FILES[$key]['size']     = $files['size'][$i];
				
				$attach_id = media_handle_upload($key, $post_id);
				
				if (!is_wp_error($attach_id) && wp_attachment_is_image($attach_id)) {
					
					$attach_ids[] = $attach_id;
					
					add_post_meta($post_id, 'user_submit_image', wp_get_attachment_url($attach_id));
					
				} else {
					
					wp_delete_attachment($attach_id);
					
					wp_delete_post($post_id, true);
					
					$newPost['error'][] = 'file-upload';
					
					unset($newPost['id']);
					
					return $newPost;
					
				}
				
			}
			
		}
		
		do_action('usp_files_after', $attach_ids);
		
		update_post_meta($post_id, 'is_submission', true);
		
		if (!empty($author)) update_post_meta($post_id, 'user_submit_name', $author);
		if (!empty($email))  update_post_meta($post_id, 'user_submit_email', $email);
		if (!empty($url))    update_post_meta($post_id, 'user_submit_url', $url);
		
		if (!empty($ip) && !$usp_options['disable_ip_tracking']) update_post_meta($post_id, 'user_submit_ip', $ip); 
		 
	} else {
		
		$newPost['error'][] = 'post-fail';
		
	}
	
	return apply_filters('usp_new_post', $newPost);
	
}



function usp_include_deps() {
	
	if (!function_exists('media_handle_upload')) {
		
		require_once (ABSPATH .'/wp-admin/includes/media.php');
		require_once (ABSPATH .'/wp-admin/includes/file.php');
		require_once (ABSPATH .'/wp-admin/includes/image.php');
		
	}
	
}



function usp_width_min($width) {
	
	global $usp_options;
	
	if (intval($width) < intval($usp_options['min-image-width'])) return false;
	
	else return true;
	
}



function usp_width_max($width) {
	
	global $usp_options;
	
	if (intval($width) > intval($usp_options['max-image-width'])) return false;
	
	else return true;
	
}



function usp_height_min($height) {
	
	global $usp_options;
	
	if (intval($height) < intval($usp_options['min-image-height'])) return false;
	
	else return true;
	
}



function usp_height_max($height) {
	
	global $usp_options;
	
	if (intval($height) > intval($usp_options['max-image-height'])) return false;
	
	else return true;
	
}



function usp_validateEmail($email) {
	
	if (!is_email($email)) return false;
	
	$bad_stuff = array("\r", "\n", "mime-version", "content-type", "cc:", "to:");
	
	foreach ($bad_stuff as $bad) {
		
		if (strpos(strtolower($email), strtolower($bad)) !== false) {
			
			return false;
			
		}
		
	}
	
	return true;
	
}



function usp_send_mail_alert($post_id, $title) {
	
	global $usp_options;
	
	if ($usp_options['usp_email_alerts'] == true) {
		
		$from       = get_bloginfo('admin_email');
		$blog_url   = get_bloginfo('url');         // %%blog_url%%
		$blog_name  = get_bloginfo('name');        // %%blog_name%%
		$post_url   = get_permalink($post_id);     // %%post_url%%
		$admin_url  = admin_url();                 // %%admin_url%%
		$post_title = $title;                      // %%post_title%%
		
		$patterns = array();
		$patterns[0]  = "/%%blog_url%%/";
		$patterns[1]  = "/%%blog_name%%/";
		$patterns[2]  = "/%%post_url%%/";
		$patterns[3]  = "/%%admin_url%%/";
		$patterns[4]  = "/%%post_title%%/";
		
		$replacements = array();
		$replacements[0]  = $blog_url;
		$replacements[1]  = $blog_name;
		$replacements[2]  = $post_url;
		$replacements[3]  = $admin_url;
		$replacements[4]  = $post_title;
		
		$subject_default = $blog_name .': New user-submitted post!';
		$subject = (isset($usp_options['email_alert_subject']) && !empty($usp_options['email_alert_subject'])) ? $usp_options['email_alert_subject'] : $subject_default;
		$subject = preg_replace($patterns, $replacements, $subject);
		$subject = apply_filters('usp_mail_subject', $subject);
		
		$message_default = 'Hello, there is a new user-submitted post:'. "\r\n\n" . 'Title: '. $post_title . "\r\n\n" .'Visit Admin Area: '. $admin_url;
		$message = (isset($usp_options['email_alert_message']) && !empty($usp_options['email_alert_message'])) ? $usp_options['email_alert_message'] : $message_default;
		$message = preg_replace($patterns, $replacements, $message);
		$message = apply_filters('usp_mail_message', $message);
		
		$headers  = 'X-Mailer: User Submitted Posts'. "\n";
		$headers .= 'From: '. $blog_name .' <'. $from .'>'. "\n";
		$headers .= 'Reply-To: '. $blog_name .' <'. $from .'>'. "\n";
		$headers .= 'Content-Type: text/plain; charset='. get_option('blog_charset', 'UTF-8') . "\n";
		
		$address = $usp_options['usp_email_address'];
		
		if (!empty($address)) {
			
			$return = true;
			$address = explode(',', $address);
			
			foreach ($address as $to) {
				
				$to = trim($to);
				
				if (wp_mail($to, $subject, $message, $headers)) $return = true;
				else $return = false;
				
			}
			
			if ($return) return true;
			
		}
		
	}
	
	return false;
	
}



function usp_spamQuestion($input) {
	
	global $usp_options;
	
	$response = $usp_options['usp_response'];
	
	$response = sanitize_text_field($response);
	
	if ($usp_options['usp_casing'] == false) {
		
		return (strtoupper($input) == strtoupper($response));
		
	} else {
		
		return ($input == $response);
		
	}
	
}



function usp_error_message() {
	
	global $usp_options;
	
	$min = $usp_options['min-images'];
	$max = $usp_options['max-images'];
	
	if ((int) $min > 1) $min = ' ('. $min . esc_html__(' files required', 'usp') .')';
	else $min = ' ('. $min . esc_html__(' file required', 'usp') .')';
	
	if ((int) $max > 1) $max = ' (limit: '. $max . esc_html__(' files', 'usp') .')';
	else $max = ' (limit: '. $max . esc_html__(' file', 'usp') .')';
	
	$min_width  = ' ('. $usp_options['min-image-width']  . esc_html__(' pixels', 'usp') .')';
	$max_width  = ' ('. $usp_options['max-image-width']  . esc_html__(' pixels', 'usp') .')';
	$min_height = ' ('. $usp_options['min-image-height'] . esc_html__(' pixels', 'usp') .')';
	$max_height = ' ('. $usp_options['max-image-height'] . esc_html__(' pixels', 'usp') .')';
	
	if (!empty($usp_options['error-message'])) $general_error = $usp_options['error-message'];
	else $general_error = esc_html__('An error occurred. Please go back and try again.', 'usp');
	
	if (isset($_GET['usp-error']) && !empty($_GET['usp-error'])) {
		
		$error_string = sanitize_text_field($_GET['usp-error']);
		$error_array = explode(',', $error_string);
		$error = array();
		
		foreach ($error_array as $e) {
			
			if     ($e == 'required-login')    $error[] = esc_html__('User login required', 'usp');
			elseif ($e == 'required-name')     $error[] = esc_html__('User name required', 'usp');
			elseif ($e == 'required-title')    $error[] = esc_html__('Post title required', 'usp');
			elseif ($e == 'required-url')      $error[] = esc_html__('User URL required', 'usp');
			elseif ($e == 'required-tags')     $error[] = esc_html__('Post tags required', 'usp');
			elseif ($e == 'required-category') $error[] = esc_html__('Post category required', 'usp');
			elseif ($e == 'required-content')  $error[] = esc_html__('Post content required', 'usp');
			elseif ($e == 'required-captcha')  $error[] = esc_html__('Correct captcha required', 'usp');
			elseif ($e == 'required-email')    $error[] = esc_html__('User email required', 'usp');
			elseif ($e == 'spam-verify')       $error[] = esc_html__('Non-empty value for hidden field', 'usp');
			elseif ($e == 'file-min')          $error[] = esc_html__('Minimum number of images not met', 'usp') . $min;
			elseif ($e == 'file-max')          $error[] = esc_html__('Maximum number of images exceeded ', 'usp') . $max;
			elseif ($e == 'width-min')         $error[] = esc_html__('Minimum image width not met', 'usp') . $min_width;
			elseif ($e == 'width-max')         $error[] = esc_html__('Image width exceeds maximum', 'usp') . $max_width;
			elseif ($e == 'height-min')        $error[] = esc_html__('Minimum image height not met', 'usp') . $min_height;
			elseif ($e == 'height-max')        $error[] = esc_html__('Image height exceeds maximum', 'usp') . $max_height;
			elseif ($e == 'file-type')         $error[] = esc_html__('File type not allowed (please upload images only)', 'usp');
			elseif ($e == 'file-error')        $error[] = esc_html__('The selected files could not be uploaded to the server', 'usp'); // general file(s) error
			
			// check permissions on /uploads/ directory, check error log for the following error:
			// PHP Warning: mysql_real_escape_string() expects parameter 1 to be string, object given in /wp-includes/wp-db.php
			elseif ($e == 'file-upload')       $error[] = esc_html__('The file(s) could not be uploaded', 'usp'); 
			
			elseif ($e == 'post-fail')         $error[] = esc_html__('Post not created. Please contact the site administrator for help.', 'usp');
			elseif ($e == 'duplicate-title')   $error[] = esc_html__('Duplicate post title. Please try again.', 'usp');
			
			elseif ($e == 'error')             $error[] = $general_error;
			
		}
		
		$output = '';
		
		foreach ($error as $e) {
			
			$output .= "\t\t\t".'<div class="usp-error">'. esc_html__('Error: ', 'usp') . $e .'</div>'."\n";
			
		}
		
		$return = '<div id="usp-error-message">'."\n". $output ."\t\t".'</div>'."\n";
		
		return apply_filters('usp_error_message', $return);
		
	}
	
	return false;
	
}



function usp_redirect_message($content = '') {
	
	global $usp_options;
	
	$url = (isset($usp_options['redirect-url']) && !empty($usp_options['redirect-url'])) ? true : false;
	
	$enable = (!is_admin() && (isset($_GET['usp_redirect']) && $_GET['usp_redirect'] == '1')) ? true : false;
	
	$referrer = (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) ? esc_url($_SERVER['HTTP_REFERER']) : false;
	
	$link = $referrer ? '<p><a href="'. $referrer .'">'. esc_html__('Return to form', 'usp') .'</a></p>' : '';
	
	$message = '';
	
	if ($url && $enable) {
		
		if (isset($_GET['success']) && $_GET['success'] == '1') {
			
			$message = '<p id="usp-success-message"><strong>'. $usp_options['success-message'] .'</strong></p>';
			
		} else {
			
			$message = usp_error_message() . $link;
			
		}
		
	}
	
	return $message . $content;
	
}



function usp_login_required_message() {
	
	$message  = '<p>'. esc_html__('Please', 'usp');
	$message .= ' <a href="'. wp_login_url() .'">'. esc_html__('log in', 'usp') .'</a> ';
	$message .= esc_html__('to submit content!', 'usp') .'</p>';
	
	$message = apply_filters('usp_require_login', $message);
	
	return $message;
	
}


