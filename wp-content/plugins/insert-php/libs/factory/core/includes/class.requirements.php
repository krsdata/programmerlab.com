<?php

/**
 * Class to check if the current WordPress and PHP versions meet our requirements
 *
 * @see Docs https://webcraftic.atlassian.net/wiki/spaces/FFD/pages/21692485/WFF+Requirements
 *
 * @author Webcraftic <wordpress.webraftic@gmail.com>, Alea Kovalev <alex.kovalevv@gmail.com>
 * @copyright (c) 26.09.2018, Webcraftic
 * @version 2.0.0
 * @since 4.0.9
 */

if ( ! class_exists( 'Wbcr_Factory410_Requirements' ) ) {
	class Wbcr_Factory410_Requirements {
		
		/**
		 * Factory framework version
		 *
		 * @var string
		 */
		protected $factory_version;
		
		/**
		 * @var string
		 */
		protected $plugin_version;
		
		/**
		 * Plugin file path
		 *
		 * @var string
		 */
		protected $plugin_file_path;
		
		/**
		 * Plugin dir
		 *
		 * @var string
		 */
		protected $plugin_dir;
		
		/**
		 * Plugin base dir
		 *
		 * @var string
		 */
		protected $plugin_base;
		
		/**
		 * Plugin url
		 *
		 * @var string
		 */
		protected $plugin_url;
		
		/**
		 * Plugin prefix
		 *
		 * @var string
		 */
		protected $plugin_prefix;
		
		/**
		 * Plugin name
		 *
		 * @var string
		 */
		protected $plugin_name;
		
		/**
		 * Plugin title
		 *
		 * @var string
		 */
		protected $plugin_title = "(no title)";
		
		/**
		 * Required PHP version
		 *
		 * @var string
		 */
		protected $required_php_version = '5.3';
		
		/**
		 * Required WordPress version
		 *
		 * @var string
		 */
		protected $required_wp_version = '4.2.0';
		
		/**
		 * Is this plugin already activated?
		 *
		 * @var bool
		 */
		protected $plugin_already_activate = false;
		
		/**
		 * WFF_Requirements constructor.
		 *
		 * @param string $plugin_file
		 * @param array $plugin_info
		 */
		function __construct( $plugin_file, array $plugin_info ) {
			
			foreach ( (array) $plugin_info as $property => $value ) {
				if ( isset( $this->$property ) ) {
					$this->$property = $value;
				}
			}
			
			$this->plugin_file_path = $plugin_file;
			$this->plugin_dir       = dirname( $plugin_file );
			$this->plugin_base      = plugin_basename( $plugin_file );
			$this->plugin_url       = plugins_url( null, $plugin_file );
			
			$plugin_info = get_file_data( $this->plugin_file_path, array(
				'Version'          => 'Version',
				'FrameworkVersion' => 'Framework Version',
			), 'plugin' );
			
			if ( isset( $plugin_info['FrameworkVersion'] ) ) {
				$this->factory_version = $plugin_info['FrameworkVersion'];
			}
			
			if ( isset( $plugin_info['Version'] ) ) {
				$this->plugin_version = $plugin_info['Version'];
			}
			
			add_action( 'admin_init', array( $this, 'registerNotices' ) );
		}
		
		/**
		 * Get plugin version
		 *
		 * @return |null
		 */
		public function getPluginVersion() {
			return $this->plugin_version;
		}
		
		public function registerNotices() {
			if ( current_user_can( 'activate_plugins' ) && current_user_can( 'edit_plugins' ) && current_user_can( 'install_plugins' ) ) {
				
				if ( is_multisite() ) {
					add_action( 'network_admin_notices', array( $this, 'showNotice' ) );
					
					if ( ! empty( $this->plugin_base ) && in_array( $this->plugin_base, (array) get_option( 'active_plugins', array() ) ) ) {
						add_action( 'admin_notices', array( $this, 'showNotice' ) );
					}
				} else {
					add_action( 'admin_notices', array( $this, 'showNotice' ) );
				}
			}
		}
		
		/**
		 * Shows the incompatibility notification.
		 */
		public function showNotice() {
			$notice_text = $this->getNoticeText();
			
			if ( empty( $notice_text ) ) {
				return;
			}
			
			$notice_text = '<p>' . $this->getNoticeText() . '</p>';
			
			echo '<div class="notice notice-error">' . apply_filters( 'wbcr/factory/check_compatibility/notice_text', $notice_text, $this->plugin_name ) . '</div>';
		}
		
		
		/**
		 * The method checks the compatibility of the plugin with php and wordpress version.
		 *
		 * @return bool
		 */
		public function check() {
			
			// Fix for ithemes sync. When the ithemes sync plugin accepts the request, set the WP_ADMIN constant,
			// after which the plugin Clearfy begins to create errors, and how the logic of its work is broken.
			// Solution to simply terminate the plugin if there is a request from ithemes sync
			// --------------------------------------
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'ithemes_sync_request' ) {
				return false;
			}
			
			if ( isset( $_GET['ithemes-sync-request'] ) && ! empty( $_GET['ithemes-sync-request'] ) ) {
				return false;
			}
			// ----------------------------------------
			
			if ( ! $this->isPhpCompatibility() || ! $this->isWpCompatibility() || $this->plugin_already_activate ) {
				return false;
			}
			
			return true;
		}
		
		/**
		 * The method checks the compatibility of the plugin with the php version of the server.
		 *
		 * @return mixed
		 */
		public function isPhpCompatibility() {
			return version_compare( PHP_VERSION, $this->required_php_version, '>=' );
		}
		
		/**
		 * The method checks the compatibility of the plugin with the Wordpress version of the site.
		 *
		 * @return mixed
		 */
		public function isWpCompatibility() {
			// Get the WP Version global.
			global $wp_version;
			
			return version_compare( $wp_version, $this->required_wp_version, '>=' );
		}
		
		/**
		 * Method returns notification text
		 *
		 * @return string
		 */
		protected function getNoticeText() {
			$notice_text         = $notice_default_text = '';
			$notice_default_text .= '<b>' . $this->plugin_title . ' ' . __( 'warning', '' ) . ':</b>' . '<br>';
			
			$notice_default_text .= sprintf( __( 'The %s plugin has stopped.', 'wbcr_factory_clearfy_000' ), $this->plugin_title ) . ' ';
			$notice_default_text .= __( 'Possible reasons:', '' ) . ' <br>';
			
			$has_one = false;
			
			if ( ! $this->isPhpCompatibility() ) {
				$has_one     = true;
				$notice_text .= '- ' . $this->getPhpInCompatibilityMessage() . '<br>';
			}
			
			if ( ! $this->isWpCompatibility() ) {
				$has_one     = true;
				$notice_text .= '- ' . $this->getWordpressInCompatibilityMessage() . '<br>';
			}
			
			if ( $this->plugin_already_activate ) {
				$has_one     = true;
				$notice_text = '- ' . $this->getPluginActivateErrorMessage() . '<br>';
			}
			
			if ( $has_one ) {
				$notice_text = $notice_default_text . $notice_text;
			}
			
			return $notice_text;
		}
		
		/**
		 * @return string
		 */
		protected function getPhpInCompatibilityMessage() {
			return sprintf( __( 'You need to update the PHP version to %s or higher!', 'wbcr_factory_410' ), $this->required_php_version );
		}
		
		/**
		 * @return string
		 */
		protected function getWordpressInCompatibilityMessage() {
			return sprintf( __( 'You need to update WordPress to %s or higher!', 'wbcr_factory_410' ), $this->required_wp_version );
		}
		
		/**
		 * @return string
		 */
		protected function getPluginActivateErrorMessage() {
			return sprintf( __( 'Plugin %s is already activated, you are trying to activate it again.', 'wbcr_factory_410' ), $this->plugin_title );
		}
	}
}