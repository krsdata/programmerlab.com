<?php
/**
 * PHP snippets plugin base
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 19.02.2018, Webcraftic
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WINP_Plugin' ) ) {
	
	class WINP_Plugin extends Wbcr_Factory410_Plugin {
		
		/**
		 * @var Wbcr_Factory410_Plugin
		 */
		private static $app;
		
		/**
		 * @param string $plugin_path
		 * @param array $data
		 *
		 * @throws Exception
		 */
		public function __construct( $plugin_path, $data ) {
			parent::__construct( $plugin_path, $data );
			
			self::$app = $this;
			
			self::app()->setTextDomain( 'insert-php', WINP_PLUGIN_DIR );
			$this->setModules();
			
			$this->globalScripts();
			
			if ( is_admin() ) {
				$this->initActivation();
				$this->adminScripts();
				
				if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
					require( WINP_PLUGIN_DIR . '/admin/ajax/ajax.php' );
				}
			}
		}
		
		/**
		 * @return WINP_Plugin
		 */
		public static function app() {
			return self::$app;
		}
		
		/**
		 * @return bool
		 */
		public function currentUserCan() {
			return current_user_can( 'manage_options' );
		}
		
		
		/**
		 * Get Execute_Snippet object
		 *
		 * @return WINP_Execute_Snippet
		 */
		public function getExecuteObject() {
			require_once( WINP_PLUGIN_DIR . '/includes/class.execute.snippet.php' );
			
			return new WINP_Execute_Snippet();
		}
		
		protected function setModules() {
			$this->load( array(
				array( 'libs/factory/bootstrap', 'factory_bootstrap_410', 'admin' ),
				array( 'libs/factory/forms', 'factory_forms_411', 'admin' ),
				array( 'libs/factory/pages', 'factory_pages_411', 'admin' ),
				array( 'libs/factory/types', 'factory_types_405' ),
				array( 'libs/factory/taxonomies', 'factory_taxonomies_325' ),
				array( 'libs/factory/metaboxes', 'factory_metaboxes_404', 'admin' ),
				array( 'libs/factory/viewtables', 'factory_viewtables_405', 'admin' ),
				array( 'libs/factory/shortcodes', 'factory_shortcodes_325', 'all' ),
				array( 'libs/factory/notices', 'factory_notices_408', 'admin' )
			) );
		}
		
		protected function initActivation() {
			include_once( WINP_PLUGIN_DIR . '/admin/activation.php' );
			$this->registerActivation( 'WINP_Activation' );
		}
		
		private function registerPages() {
			$this->registerPage( 'WINP_NewItemPage', WINP_PLUGIN_DIR . '/admin/pages/new-item.php' );
			$this->registerPage( 'WINP_ImportPage', WINP_PLUGIN_DIR . '/admin/pages/import.php' );
			$this->registerPage( 'WINP_SettingsPage', WINP_PLUGIN_DIR . '/admin/pages/settings.php' );
			$this->registerPage( 'WINP_AboutPage', WINP_PLUGIN_DIR . '/admin/pages/about.php' );
		}
		
		private function registerTypes() {
			$this->registerType( 'WSC_TasksItemType', WINP_PLUGIN_DIR . '/admin/types/snippets-post-types.php' );
			
			require_once( WINP_PLUGIN_DIR . '/admin/types/snippets-taxonomy.php' );
			Wbcr_FactoryTaxonomies325::register( 'WINP_SnippetsTaxonomy', $this );
		}
		
		private function register_shortcodes() {
			$is_cron = WINP_Helper::doing_cron();
			$is_rest = WINP_Helper::doing_rest_api();
			
			if ( ! ( isset( $_GET['action'] ) && $_GET['action'] == 'edit' && is_admin() ) && ! $is_cron && ! $is_rest ) {
				require_once( WINP_PLUGIN_DIR . '/includes/shortcodes/shortcodes.php' );
				require_once( WINP_PLUGIN_DIR . '/includes/shortcodes/shortcode-php.php' );
				require_once( WINP_PLUGIN_DIR . '/includes/shortcodes/shortcode-text.php' );
				require_once( WINP_PLUGIN_DIR . '/includes/shortcodes/shortcode-universal.php' );
				
				Wbcr_FactoryShortcodes325::register( 'WINP_SnippetShortcodePhp', $this );
				Wbcr_FactoryShortcodes325::register( 'WINP_SnippetShortcodeText', $this );
				Wbcr_FactoryShortcodes325::register( 'WINP_SnippetShortcodeUniversal', $this );
			}
		}
		
		
		private function globalScripts() {
			$this->registerGutenberg();
			$this->getExecuteObject()->registerHooks();
			$this->register_shortcodes();
			
			require_once( WINP_PLUGIN_DIR . '/admin/boot.php' );
		}
		
		private function adminScripts() {
			require_once( WINP_PLUGIN_DIR . '/admin/includes/class.snippets.viewtable.php' );
			require_once( WINP_PLUGIN_DIR . '/admin/includes/class.filter.snippet.php' );
			require_once( WINP_PLUGIN_DIR . '/admin/includes/class.export.snippet.php' );
			require_once( WINP_PLUGIN_DIR . '/admin/includes/class.import.snippet.php' );
			require_once( WINP_PLUGIN_DIR . '/admin/includes/class.notices.php' );
			
			$this->registerTypes();
			$this->registerPages();
			
			new WINP_Filter_List();
			new WINP_Export_Snippet();
			new WINP_Import_Snippet();
			new WINP_WarningNotices();
		}
		
		/**
		 * Register Gutenberg related scripts.
		 */
		private function registerGutenberg() {
			require_once( WINP_PLUGIN_DIR . '/admin/includes/class.gutenberg.snippet.php' );
			
			new WINP_Gutenberg_Snippet();
		}
	}
}