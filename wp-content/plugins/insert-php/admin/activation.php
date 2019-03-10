<?php
/**
 * Class of activation/deactivation of the plugin. Must be registered in file includes/class.plugin.php
 *
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 02.12.2018, Webcraftic
 * @see Wbcr_Factory410_Activator
 *
 * @version 1.0.1
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WINP_Activation extends Wbcr_Factory410_Activator {
	
	/**
	 * Method is executed during the activation of the plugin.
	 *
	 * @since 1.0.0
	 */
	public function activate() {
		
		// Write information about the first activation of plugin
		if ( ! get_option( $this->plugin->getOptionName( 'first_activation' ) ) ) {
			update_option( $this->plugin->getOptionName( 'first_activation' ), array(
				'version'   => $this->plugin->getPluginVersion(),
				'timestamp' => time()
			) );
		}
		
		// Create a demo snippets with examples of use
		if ( ! get_option( $this->plugin->getOptionName( 'demo_snippets_created' ) ) ) {
			WINP_Helper::create_demo_snippets();
		}
		
		update_option( $this->plugin->getOptionName( 'what_new_210' ), 1 );
	}
	
	/**
	 * The method is executed during the deactivation of the plugin.
	 *
	 * @since 1.0.0
	 */
	public function deactivate() {
		// Code to be executed during plugin deactivation
	}
}


