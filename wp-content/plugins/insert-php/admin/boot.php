<?php
/**
 * Admin boot
 * @author Alex Kovalev <alex.kovalevv@gmail.com>
 * @copyright Alex Kovalev 05.06.2018
 * @version 1.0
 */

/**
 * Enables/Disable safe mode, in which the php code will not be executed.
 */
function wbcr_inp_safe_mode() {
	if ( isset( $_GET['wbcr-php-snippets-safe-mode'] ) ) {
		WINP_Helper::enable_safe_mode();
	}
	if ( isset( $_GET['wbcr-php-snippets-disable-safe-mode'] ) ) {
		WINP_Helper::disable_safe_mode();
	}
}

add_action( 'plugins_loaded', 'wbcr_inp_safe_mode', - 1 );

function wbcr_inp_admin_init() {
	
	$plugin = WINP_Plugin::app();
	
	// Register metaboxes
	require_once( WINP_PLUGIN_DIR . '/admin/metaboxes/base-options.php' );
	Wbcr_FactoryMetaboxes404::registerFor( new WINP_BaseOptionsMetaBox( $plugin ), WINP_SNIPPETS_POST_TYPE, $plugin );
	
	if ( current_user_can( 'install_plugins' ) && ! is_plugin_active( 'robin-image-optimizer/robin-image-optimizer.php' ) ) {
		require_once( WINP_PLUGIN_DIR . '/admin/metaboxes/info.php' );
		Wbcr_FactoryMetaboxes404::registerFor( new WINP_InfoMetaBox( $plugin ), WINP_SNIPPETS_POST_TYPE, $plugin );
	}
	
	$snippet_type = WINP_Helper::get_snippet_type();
	
	if ( $snippet_type !== WINP_SNIPPET_TYPE_PHP ) {
		require_once( WINP_PLUGIN_DIR . '/admin/metaboxes/view-options.php' );
		Wbcr_FactoryMetaboxes404::registerFor( new WINP_ViewOptionsMetaBox( $plugin ), WINP_SNIPPETS_POST_TYPE, $plugin );
	}
	
	// Upgrade up to new version
	$first_activation = get_option( $plugin->getOptionName( 'first_activation' ) );
	$is_upgraded      = get_option( $plugin->getOptionName( 'upgrade_up_to_201' ) );
	
	if ( ! $first_activation && ! $is_upgraded ) {
		$role = get_role( 'administrator' );
		
		if ( ! $role ) {
			return;
		}
		
		$role->add_cap( 'edit_' . WINP_SNIPPETS_POST_TYPE );
		$role->add_cap( 'read_' . WINP_SNIPPETS_POST_TYPE );
		$role->add_cap( 'delete_' . WINP_SNIPPETS_POST_TYPE );
		$role->add_cap( 'edit_' . WINP_SNIPPETS_POST_TYPE . 's' );
		$role->add_cap( 'edit_others_' . WINP_SNIPPETS_POST_TYPE . 's' );
		$role->add_cap( 'publish_' . WINP_SNIPPETS_POST_TYPE . 's' );
		$role->add_cap( 'read_private_' . WINP_SNIPPETS_POST_TYPE . 's' );
		
		update_option( $plugin->getOptionName( 'upgrade_up_to_201' ), 1 );
		update_option( $plugin->getOptionName( 'what_new_210' ), 1 );
		
		// Create a demo snippets with examples of use
		if ( ! get_option( $plugin->getOptionName( 'demo_snippets_created' ) ) ) {
			WINP_Helper::create_demo_snippets();
		}
		
		// Write information about the first activation of plugin
		if ( ! $first_activation ) {
			update_option( $plugin->getOptionName( 'first_activation' ), array(
				'version'   => $plugin->getPluginVersion(),
				'timestamp' => time()
			) );
		}
	}
	
	// If the user has updated the plugin or activated it for the first time,
	// you need to show the page "What's new?"
	
	if ( ! isset( $_GET['wbcr_inp_about_page_viewed'] ) ) {
		if ( WINP_Helper::is_need_show_about_page() ) {
			try {
				$redirect_url = WINP_Plugin::app()->getPluginPageUrl( 'about', array( 'wbcr_inp_about_page_viewed' => 1 ) );
				wp_safe_redirect( $redirect_url );
				die();
			} catch( Exception $e ) {
			}
		}
	} else {
		if ( WINP_Helper::is_need_show_about_page() ) {
			delete_option( $plugin->getOptionName( 'what_new_210' ) );
		}
	}
}

add_action( 'admin_init', 'wbcr_inp_admin_init' );

// ---
// Editor
//

/**
 * Enqueue scripts
 */
function wbcr_inp_enqueue_scripts() {
	global $pagenow;
	
	$screen = get_current_screen();
	
	if ( ( 'post-new.php' == $pagenow || 'post.php' == $pagenow ) && WINP_SNIPPETS_POST_TYPE == $screen->post_type ) {
		wp_enqueue_script( 'wbcr-inp-admin-scripts', WINP_PLUGIN_URL . '/admin/assets/js/scripts.js', array(
			'jquery',
			'jquery-ui-tooltip'
		), WINP_Plugin::app()->getPluginVersion() );
	}
}

/**
 * Asset scripts for the tinymce editor
 *
 * @param string $hook
 */
function wbcr_inp_enqueue_tinymce_assets( $hook ) {
	$pages = array(
		'post.php',
		'post-new.php',
		'widgets.php'
	);
	
	if ( ! in_array( $hook, $pages ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	
	wp_enqueue_script( 'wbcr-inp-tinymce-button-widget', WINP_PLUGIN_URL . '/admin/assets/js/tinymce4.4.js', array( 'jquery' ), WINP_Plugin::app()->getPluginVersion(), true );
}

add_action( 'admin_enqueue_scripts', 'wbcr_inp_enqueue_tinymce_assets' );
add_action( 'admin_enqueue_scripts', 'wbcr_inp_enqueue_scripts' );

/**
 * Adds js variable required for shortcodes.
 *
 * @see before_wp_tiny_mce
 * @since 1.1.0
 */
function wbcr_inp_tinymce_data( $hook ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	
	// styles for the plugin shorcodes
	$shortcode_icon  = WINP_PLUGIN_URL . '/admin/assets/img/shortcode-icon5.png';
	$shortcode_title = __( 'Woody ad snippets', 'insert-php' );
	
	$result                  = WINP_Helper::get_shortcode_data();
	$shortcode_snippets_json = json_encode( $result );
	
	?>
    <!-- <?= WINP_Plugin::app()->getPluginTitle() ?> for tinymce -->
    <style>
        i.wbcr-inp-shortcode-icon {
            background: url("<?php echo $shortcode_icon ?>") center no-repeat;
        }
    </style>
    <script>
		var wbcr_inp_tinymce_snippets_button_title = '<?php echo $shortcode_title ?>';
		var wbcr_inp_post_tinymce_nonce = '<?php echo wp_create_nonce( 'wbcr_inp_tinymce_post_nonce' ) ?>';
		var wbcr_inp_shortcode_snippets = <?= $shortcode_snippets_json ?>;
    </script>
    <!-- /end <?= WINP_Plugin::app()->getPluginTitle() ?> for tinymce -->
	<?php
}

add_action( 'admin_print_scripts-post.php', 'wbcr_inp_tinymce_data' );
add_action( 'admin_print_scripts-post-new.php', 'wbcr_inp_tinymce_data' );
add_action( 'admin_print_scripts-widgets.php', 'wbcr_inp_tinymce_data' );

/**
 * Deactivate snippet on trashed
 *
 * @param $post_id
 *
 * @since 2.0.6
 */
function wbcr_inp_trash_post( $post_id ) {
	$post_type = get_post_type( $post_id );
	if ( $post_type == WINP_SNIPPETS_POST_TYPE ) {
		WINP_Helper::updateMetaOption( $post_id, 'snippet_activate', 0 );
	}
}

add_action( 'wp_trash_post', 'wbcr_inp_trash_post' );

/**
 * Removes the default 'new item' from the admin menu to add own page 'new item' later.
 *
 * @see menu_order
 *
 * @param $menu
 *
 * @return mixed
 */
function wbcr_inp_remove_new_item( $menu ) {
	global $submenu;
	
	if ( ! isset( $submenu[ 'edit.php?post_type=' . WINP_SNIPPETS_POST_TYPE ] ) ) {
		return $menu;
	}
	unset( $submenu[ 'edit.php?post_type=' . WINP_SNIPPETS_POST_TYPE ][10] );
	
	return $menu;
}

add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', 'wbcr_inp_remove_new_item' );

/**
 * If the user tried to get access to the default 'new item',
 * redirects forcibly to our page 'new item'.
 *
 * @see current_screen
 */
function wbcr_inp_redirect_to_new_item() {
	$screen = get_current_screen();
	
	if ( empty( $screen ) ) {
		return;
	}
	if ( 'add' !== $screen->action || 'post' !== $screen->base || WINP_SNIPPETS_POST_TYPE !== $screen->post_type ) {
		return;
	}
	if ( isset( $_GET['winp_item'] ) ) {
		return;
	}
	
	$url = admin_url( 'edit.php?post_type=' . WINP_SNIPPETS_POST_TYPE . '&page=new-item-' . WINP_Plugin::app()->getPluginName() );
	
	wp_safe_redirect( $url );
	
	exit;
}

add_action( 'current_screen', 'wbcr_inp_redirect_to_new_item' );