<?php
/**
 * Plugin Name: Woody ad snippets (PHP snippets | Insert PHP)
 * Plugin URI: http://woody-ad-snippets.webcraftic.com/
 * Description: Executes PHP code, uses conditional logic to insert ads, text, media content and external service’s code. Ensures no content duplication.
 * Author: Will Bontrager Software, LLC <will@willmaster.com>, Webcraftic <wordpress.webraftic@gmail.com>
 * Version: 2.1.91
 * Text Domain: insert-php
 * Domain Path: /languages/
 * Author URI: http://woody-ad-snippets.webcraftic.com/
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



require_once( dirname( __FILE__ ) . '/libs/factory/core/includes/class.requirements.php' );

$wbcr_inp_plugin_info = array(
	'prefix'       => 'wbcr_inp_',
	'plugin_name'  => 'wbcr_insert_php',
	'plugin_title' => __( 'Woody ad snippets', 'insert-php' ),
	'plugin_build' => 'free',
	'updates'      => dirname( __FILE__ ) . '/migrations/'
);

/**
 * Checks compatibility with Wordpress, php and other plugins.
 */
$wbcr_inp_plugin_requirements = new Wbcr_Factory410_Requirements( __FILE__, array_merge( $wbcr_inp_plugin_info, array(
	'plugin_last_version'     => '2.0.6',
	'plugin_already_activate' => defined( 'WINP_PLUGIN_ACTIVE' ),
	'required_php_version'    => '5.2',
	'required_wp_version'     => '4.2.0'
) ) );

/**
 * If the plugin is compatible, it will continue its work, otherwise it will be stopped and the user will receive a warning.
 */
if ( $wbcr_inp_plugin_requirements->check() ) {
	global $wbcr_inp_safe_mode;
	
	$wbcr_inp_safe_mode = false;
	
	// Set the constant that the plugin is activated
	define( 'WINP_PLUGIN_ACTIVE', true );
	
	define( 'WINP_PLUGIN_VERSION', $wbcr_inp_plugin_requirements->getPluginVersion() );
	
	// Root directory of the plugin
	define( 'WINP_PLUGIN_DIR', dirname( __FILE__ ) );
	
	// Absolute url of the root directory of the plugin
	define( 'WINP_PLUGIN_URL', plugins_url( null, __FILE__ ) );
	
	// Relative url of the plugin
	define( 'WINP_PLUGIN_BASE', plugin_basename( __FILE__ ) );
	
	// The type of posts used for snippets types
	define( 'WINP_SNIPPETS_POST_TYPE', 'wbcr-snippets' );
	
	// The taxonomy used for snippets types
	define( 'WINP_SNIPPETS_TAXONOMY', 'wbcr-snippet-tags' );
	
	// The snippets types
	define( 'WINP_SNIPPET_TYPE_PHP', 'php' );
	define( 'WINP_SNIPPET_TYPE_TEXT', 'text' );
	define( 'WINP_SNIPPET_TYPE_UNIVERSAL', 'universal' );
	
	// The snippet automatic insertion locations
	define( 'WINP_SNIPPET_AUTO_HEADER', 'header' );
	define( 'WINP_SNIPPET_AUTO_FOOTER', 'footer' );
	define( 'WINP_SNIPPET_AUTO_BEFORE_POST', 'before_post' );
	define( 'WINP_SNIPPET_AUTO_BEFORE_CONTENT', 'before_content' );
	define( 'WINP_SNIPPET_AUTO_BEFORE_PARAGRAPH', 'before_paragraph' );
	define( 'WINP_SNIPPET_AUTO_AFTER_PARAGRAPH', 'after_paragraph' );
	define( 'WINP_SNIPPET_AUTO_AFTER_CONTENT', 'after_content' );
	define( 'WINP_SNIPPET_AUTO_AFTER_POST', 'after_post' );
	define( 'WINP_SNIPPET_AUTO_BEFORE_EXCERPT', 'before_excerpt' );
	define( 'WINP_SNIPPET_AUTO_AFTER_EXCERPT', 'after_excerpt' );
	define( 'WINP_SNIPPET_AUTO_BETWEEN_POSTS', 'between_posts' );
	define( 'WINP_SNIPPET_AUTO_BEFORE_POSTS', 'before_posts' );
	define( 'WINP_SNIPPET_AUTO_AFTER_POSTS', 'after_posts' );
	
	require_once( WINP_PLUGIN_DIR . '/libs/factory/core/boot.php' );
	require_once( WINP_PLUGIN_DIR . '/includes/class.helpers.php' );
	require_once( WINP_PLUGIN_DIR . '/includes/class.plugin.php' );
	
	try {
		new WINP_Plugin( __FILE__, array_merge( $wbcr_inp_plugin_info, array(
			'plugin_version' => WINP_PLUGIN_VERSION
		) ) );
	} catch( Exception $exception ) {
		throw new Exception( $exception->getMessage() );
	}
}

/*
Note: This plugin requires WordPress version 3.3.1 or higher.

Information about the Insert PHP plugin can be found here:
http://www.willmaster.com/software/WPplugins/go/iphphome_iphplugin

Instructions and examples can be found here:
http://www.willmaster.com/software/WPplugins/go/iphpinstructions_iphplugin
*/

// todo: This is the code of the old version of the plugin, left unchanged for compatibility. Delete in the new major version of the plugin
if ( ! function_exists( 'will_bontrager_insert_php' ) ) {
	
	function will_bontrager_insert_php( $content ) {
		
		if ( WINP_Helper::is_safe_mode() ) {
			return $content;
		}
		
		$will_bontrager_content = $content;
		preg_match_all( '!\[insert_php[^\]]*\](.*?)\[/insert_php[^\]]*\]!is', $will_bontrager_content, $will_bontrager_matches );
		$will_bontrager_nummatches = count( $will_bontrager_matches[0] );
		for ( $will_bontrager_i = 0; $will_bontrager_i < $will_bontrager_nummatches; $will_bontrager_i ++ ) {
			ob_start();
			eval( $will_bontrager_matches[1][ $will_bontrager_i ] );
			$will_bontrager_replacement = ob_get_contents();
			ob_clean();
			ob_end_flush();
			$will_bontrager_content = preg_replace( '/' . preg_quote( $will_bontrager_matches[0][ $will_bontrager_i ], '/' ) . '/', $will_bontrager_replacement, $will_bontrager_content, 1 );
		}
		
		return $will_bontrager_content;
	} # function will_bontrager_insert_php()
	
	add_filter( 'the_content', 'will_bontrager_insert_php', 9 );
} # if( ! function_exists('will_bontrager_insert_php') )

