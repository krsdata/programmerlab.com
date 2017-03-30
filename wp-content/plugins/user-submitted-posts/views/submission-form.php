<?php // User Submitted Posts - Submission Form

if (!defined('ABSPATH')) die();



if ($usp_options['logged_in_users'] && !is_user_logged_in()) : 

	echo usp_login_required_message();

else : 

	$usp_current_user = wp_get_current_user();
	$usp_user_name    = $usp_current_user->user_login;
	$usp_user_url     = $usp_current_user->user_url;
	
	if ($usp_options['disable_required']) {
		
		$usp_required = ''; 
		$usp_captcha  = '';
		$usp_files    = '';
		
	} else {
		
		$usp_required = ' data-required="true" required';
		$usp_captcha  = ' user-submitted-captcha'; 
		$usp_files    = ' usp-required-file';
		
	} 
	
	$usp_display_name = (is_user_logged_in() && $usp_options['usp_use_author']) ? false : true;
	$usp_display_url  = (is_user_logged_in() && $usp_options['usp_use_url'])    ? false : true;
	
?>

<!-- User Submitted Posts @ http://m0n.co/usp -->

<div id="user-submitted-posts">
	<?php if ($usp_options['usp_form_content'] !== '') echo $usp_options['usp_form_content']; ?>
	
	<form id="usp_form" method="post" enctype="multipart/form-data" data-parsley-validate action="">
		<div id="usp-error-message" class="usp-callout-failure usp-hidden"><?php esc_html_e('Please complete the required fields.', 'usp'); ?></div>
		<?php echo usp_error_message();
		
		if (isset($_GET['success']) && $_GET['success'] == '1') :
			echo '<div id="usp-success-message">'. $usp_options['success-message'] .'</div>';
		else :
		
		if (($usp_options['usp_name'] == 'show' || $usp_options['usp_name'] == 'optn') && ($usp_display_name)) { ?>
		
		<fieldset class="usp-name">
			<label for="user-submitted-name"><?php esc_html_e('Your Name', 'usp'); ?></label>
			<input id="user-submitted-name" name="user-submitted-name" type="text" value="" placeholder="<?php esc_attr_e('Your Name', 'usp'); ?>"<?php if (usp_check_required('usp_name')) echo $usp_required; ?> class="usp-input">
		</fieldset>
		<?php } if (($usp_options['usp_url'] == 'show' || $usp_options['usp_url'] == 'optn') && ($usp_display_url)) { ?>
		
		<fieldset class="usp-url">
			<label for="user-submitted-url"><?php esc_html_e('Your URL', 'usp'); ?></label>
			<input id="user-submitted-url" name="user-submitted-url" type="text" value="" placeholder="<?php esc_attr_e('Your URL', 'usp'); ?>"<?php if (usp_check_required('usp_url')) echo $usp_required; ?> class="usp-input">
		</fieldset>
		<?php } if ($usp_options['usp_email'] == 'show' || $usp_options['usp_email'] == 'optn') { ?>
		
		<fieldset class="usp-email">
			<label for="user-submitted-email"><?php esc_html_e('Your Email', 'usp'); ?></label>
			<input id="user-submitted-email" name="user-submitted-email" type="text" value="" placeholder="<?php esc_attr_e('Your Email', 'usp'); ?>"<?php if (usp_check_required('usp_email')) echo $usp_required; ?> class="usp-input">
		</fieldset>
		<?php } if ($usp_options['usp_title'] == 'show' || $usp_options['usp_title'] == 'optn') { ?>
		
		<fieldset class="usp-title">
			<label for="user-submitted-title"><?php esc_html_e('Post Title', 'usp'); ?></label>
			<input id="user-submitted-title" name="user-submitted-title" type="text" value="" placeholder="<?php esc_attr_e('Post Title', 'usp'); ?>"<?php if (usp_check_required('usp_title')) echo $usp_required; ?> class="usp-input">
		</fieldset>
		<?php } if ($usp_options['usp_tags'] == 'show' || $usp_options['usp_tags'] == 'optn') { ?>
		
		<fieldset class="usp-tags">
			<label for="user-submitted-tags"><?php esc_html_e('Post Tags', 'usp'); ?></label>
			<input id="user-submitted-tags" name="user-submitted-tags" type="text" value="" placeholder="<?php esc_attr_e('Post Tags', 'usp'); ?>"<?php if (usp_check_required('usp_tags')) echo $usp_required; ?> class="usp-input">
		</fieldset>
		<?php } if ($usp_options['usp_captcha'] == 'show') { ?>
		
		<fieldset class="usp-captcha">
			<label for="user-submitted-captcha"><?php echo $usp_options['usp_question']; ?></label>
			<input id="user-submitted-captcha" name="user-submitted-captcha" type="text" value="" placeholder="<?php esc_attr_e('Antispam Question', 'usp'); ?>"<?php echo $usp_required; ?> class="usp-input exclude<?php echo $usp_captcha; ?>">
		</fieldset>
		<?php } if (($usp_options['usp_category'] == 'show' || $usp_options['usp_category'] == 'optn') && ($usp_options['usp_use_cat'] == false)) { ?>
		
		<fieldset class="usp-category">
			<label for="user-submitted-category"><?php esc_html_e('Post Category', 'usp'); ?></label>
			<select id="user-submitted-category" name="user-submitted-category"<?php if (usp_check_required('usp_category')) echo $usp_required; ?> class="usp-select">
				<option value=""><?php esc_html_e('Please select a category..', 'usp'); ?></option>
				<?php foreach($usp_options['categories'] as $categoryId) { $category = get_category($categoryId); if (!$category) { continue; } ?>
				
				<option value="<?php echo $categoryId; ?>"><?php $category = get_category($categoryId); echo sanitize_text_field($category->name); ?></option>
				<?php } ?>
				
			</select>
		</fieldset>
		<?php } if ($usp_options['usp_content'] == 'show' || $usp_options['usp_content'] == 'optn') { ?>
		
		<fieldset class="usp-content">
			<?php if ($usp_options['usp_richtext_editor'] == true) { ?>
			
			<div class="usp_text-editor">
			<?php $usp_rte_settings = array(
				    'wpautop'          => true,  // enable rich text editor
				    'media_buttons'    => true,  // enable add media button
				    'textarea_name'    => 'user-submitted-content', // name
				    'textarea_rows'    => '10',  // number of textarea rows
				    'tabindex'         => '',    // tabindex
				    'editor_css'       => '',    // extra CSS
				    'editor_class'     => 'usp-rich-textarea', // class
				    'teeny'            => false, // output minimal editor config
				    'dfw'              => false, // replace fullscreen with DFW
				    'tinymce'          => true,  // enable TinyMCE
				    'quicktags'        => true,  // enable quicktags
				    'drag_drop_upload' => true,  // enable drag-drop
				);
				wp_editor('', 'uspcontent', apply_filters('usp_editor_settings', $usp_rte_settings)); ?>
				
			</div>
			<?php } else { ?>
				
			<label for="user-submitted-content"><?php esc_html_e('Post Content', 'usp'); ?></label>
			<textarea id="user-submitted-content" name="user-submitted-content" rows="5" placeholder="<?php esc_attr_e('Post Content', 'usp'); ?>"<?php if (usp_check_required('usp_content')) echo $usp_required; ?> class="usp-textarea"></textarea>
			<?php } ?>
			
		</fieldset>
		<?php } if ($usp_options['usp_images'] == 'show') { ?>
		<?php if ($usp_options['max-images'] !== 0) { ?>
		
		<fieldset class="usp-images">
			<label for="user-submitted-image"><?php esc_html_e('Upload an Image', 'usp'); ?></label>
			<div id="usp-upload-message"><?php echo $usp_options['upload-message']; ?></div>
			<div id="user-submitted-image">
			<?php // upload files
				
			$usp_minImages = intval($usp_options['min-images']);
			$usp_maxImages = intval($usp_options['max-images']);
			$usp_addAnother = $usp_options['usp_add_another'];
			
			if (empty($usp_addAnother)) $usp_addAnother = '<a href="#" id="usp_add-another" class="usp-no-js">'. esc_html__('Add another image', 'usp') .'</a>';
			
			if ($usp_minImages > 0) : ?>
				<?php for ($i = 0; $i < $usp_minImages; $i++) : ?>
						
				<input name="user-submitted-image[]" type="file" size="25"<?php echo $usp_required; ?> class="usp-input usp-clone<?php echo $usp_files; ?> exclude">
				<?php endfor; ?>
				<?php if ($usp_minImages < $usp_maxImages) : echo $usp_addAnother; endif; ?>
			<?php else : ?>
				
				<input name="user-submitted-image[]" type="file" size="25" class="usp-input usp-clone exclude">
				<?php echo $usp_addAnother; ?>
			<?php endif; ?>
				
			</div>
			<input type="hidden" class="usp-hidden exclude" id="usp-min-images" name="usp-min-images" value="<?php echo $usp_options['min-images']; ?>">
			<input type="hidden" class="usp-hidden exclude" id="usp-max-images" name="usp-max-images" value="<?php echo $usp_options['max-images']; ?>">
		</fieldset>
		<?php } ?>
		<?php } ?>
		
		<fieldset id="coldform_verify" style="display:none;">
			<label for="user-submitted-verify"><?php esc_html_e('Human verification: leave this field empty.', 'usp'); ?></label>
			<input id="user-submitted-verify" name="user-submitted-verify" type="text" class="exclude" value="">
		</fieldset>
		
		<div id="usp-submit">
			<?php if (!empty($usp_options['redirect-url'])) { ?>
			
			<input type="hidden" class="usp-hidden exclude" name="redirect-override" value="<?php echo $usp_options['redirect-url']; ?>">
			<?php } ?>
			<?php if (!$usp_display_name) { ?>
			
			<input type="hidden" class="usp-hidden exclude" name="user-submitted-name" value="<?php echo $usp_user_name; ?>">
			<?php } ?>
			<?php if (!$usp_display_url) { ?>
			
			<input type="hidden" class="usp-hidden exclude" name="user-submitted-url" value="<?php echo $usp_user_url; ?>">
			<?php } ?>
			<?php if ($usp_options['usp_use_cat'] == true) { ?>
			
			<input type="hidden" class="usp-hidden exclude" name="user-submitted-category" value="<?php echo $usp_options['usp_use_cat_id']; ?>">
			<?php } ?>
			
			<input type="submit" class="exclude" id="user-submitted-post" name="user-submitted-post" value="<?php esc_attr_e('Submit Post', 'usp'); ?>">
			<?php wp_nonce_field('usp-nonce', 'usp-nonce', false); ?>
			
		</div>
		<?php endif; ?>

	</form>
</div>
<script>(function(){var e = document.getElementById('coldform_verify'); if(e) e.parentNode.removeChild(e);})();</script>

<?php endif; ?>