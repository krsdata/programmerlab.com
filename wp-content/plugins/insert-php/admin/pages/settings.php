<?php
/**
 * The file contains a short help info.
 *
 * @author Alex Kovalev <alex.kovalevv@gmail.com>
 * @copyright (c) 2018, OnePress Ltd
 *s
 * @package core
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Common Settings
 */
class WINP_SettingsPage extends Wbcr_FactoryPages411_AdminPage {
	
	/**
	 * @param Wbcr_Factory410_Plugin $plugin
	 */
	public function __construct( Wbcr_Factory410_Plugin $plugin ) {
		$this->menu_post_type = WINP_SNIPPETS_POST_TYPE;
		
		/*if( !current_user_can('administrator') ) {
			$this->capabilitiy = "read_wbcr-scrapes";
		}*/
		
		$this->id         = "settings";
		$this->menu_title = __( 'Settings', 'insert-php' );
		
		parent::__construct( $plugin );
		
		$this->plugin = $plugin;
	}
	
	public function assets( $scripts, $styles ) {
		$this->scripts->request( 'jquery' );
		
		$this->scripts->request( array(
			'control.checkbox',
			'control.dropdown'
		), 'bootstrap' );
		
		$this->styles->request( array(
			'bootstrap.core',
			'bootstrap.form-group',
			'bootstrap.separator',
			'control.dropdown',
			'control.checkbox',
		), 'bootstrap' );
	}
	
	/**
	 * Returns options for the Basic Settings screen.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function getOptions() {
		
		$options = array();
		
		$options[] = array(
			'type' => 'separator'
		);
		
		$options[] = array(
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'activate_by_default',
			'title'   => __( 'Activate by Default', 'insert-php' ),
			'default' => true,
			'hint'    => __( 'When creating a new snippet or updating an old one, make the code snippets active by default.', 'insert-php' )
		);
		
		$options[] = array(
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'complete_uninstall',
			'title'   => __( 'Complete Uninstall', 'insert-php' ),
			'default' => false,
			'hint'    => __( 'When the plugin is deleted from the Plugins menu, also delete all snippets and plugin settings.', 'insert-php' )
		);
		
		$options[] = array(
			'type' => 'html',
			'html' => '<h3 style="margin-left:0">Code Editor</h3>'
		);
		
		$options[] = array(
			'type' => 'separator'
		);
		
		$options[] = array(
			'type'    => 'dropdown',
			'name'    => 'code_editor_theme',
			'title'   => __( 'Code style', 'insert-php' ),
			'data'    => $this->getAvailableThemes(),
			'default' => 'default',
			'hint'    => __( 'The optional feature. You can customize the code style in the snippet editor. The "Default" style is applied by default.', 'insert-php' )
		);
		
		$options[] = array(
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'code_editor_indent_with_tabs',
			'title'   => __( 'Indent With Tabs', 'insert-php' ),
			'default' => false,
			'hint'    => __( 'The optional feature. Whether, when indenting, the first N*tabSize spaces should be replaced by N tabs. The default is false.', 'insert-php' )
		);
		
		$options[] = array(
			'type'    => 'integer',
			'way'     => 'buttons',
			'name'    => 'code_editor_tab_size',
			'title'   => __( 'Tab Size', 'insert-php' ),
			'default' => 4,
			'hint'    => __( 'The optional feature. Pressing Tab in the code editor increases left indent to N spaces. N is a number pre-defined by you.', 'insert-php' )
		);
		
		$options[] = array(
			'type'    => 'integer',
			'way'     => 'buttons',
			'name'    => 'code_editor_indent_unit',
			'title'   => __( 'Indent Unit', 'insert-php' ),
			'default' => 4,
			'hint'    => __( 'The optional feature. The indent for code lines (units). Example: select a snippet, press Tab. The left indent in the selected code increases to N spaces. N is a number pre-defined by you.', 'insert-php' )
		);
		
		$options[] = array(
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'code_editor_wrap_lines',
			'title'   => __( 'Wrap Lines', 'insert-php' ),
			'default' => true,
			'hint'    => __( 'The optional feature. If ON, the editor will wrap long lines. Otherwise, it will create a horizontal scroll.', 'insert-php' )
		);
		
		$options[] = array(
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'code_editor_line_numbers',
			'title'   => __( 'Line Numbers', 'insert-php' ),
			'default' => true,
			'hint'    => __( 'The optional feature. If ON, all lines in the editor will be numbered.', 'insert-php' )
		);
		
		$options[] = array(
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'code_editor_auto_close_brackets',
			'title'   => __( 'Auto Close Brackets', 'insert-php' ),
			'default' => true,
			'hint'    => __( 'The optional feature. If ON, the editor will automatically close opened quotes or brackets. Sometimes, it speeds up coding.', 'insert-php' )
		);
		
		$options[] = array(
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'code_editor_highlight_selection_matches',
			'title'   => __( 'Highlight Selection Matches', 'insert-php' ),
			'default' => false,
			'hint'    => __( 'The optional feature. If ON, it searches for matches for the selected variable/function name. Highlight matches with green. Improves readability.', 'insert-php' )
		);
		
		$options[] = array(
			'type' => 'separator'
		);
		
		return $options;
	}
	
	
	public function indexAction() {
		
		// creating a form
		$form = new Wbcr_FactoryForms411_Form( array(
			'scope' => substr( $this->plugin->getPrefix(), 0, - 1 ),
			'name'  => 'setting'
		), $this->plugin );
		
		$form->setProvider( new Wbcr_FactoryForms411_OptionsValueProvider( $this->plugin ) );
		
		$form->add( $this->getOptions() );
		
		if ( isset( $_POST[ $this->plugin->getPrefix() . 'saved' ] ) ) {
			if ( ! wp_verify_nonce( $_POST[ $this->plugin->getPrefix() . 'nonce' ], $this->plugin->getPrefix() . 'settings_form' ) ) {
				wp_die( 'Permission error. You can not edit this page.' );
			}
			$form->save();
		}
		
		?>
        <div class="wrap ">
            <div class="factory-bootstrap-410 factory-fontawesome-000">
                <h3><?php _e( 'Settings', 'insert-php' ) ?></h3>
                <form method="post" class="form-horizontal">
					<?php if ( isset( $_POST[ $this->plugin->getPrefix() . 'saved' ] ) ) { ?>
                        <div id="message" class="alert alert-success">
                            <p><?php _e( 'The settings have been updated successfully!', 'insert-php' ) ?></p>
                        </div>
					<?php } ?>
                    <div style="padding-top: 10px;">
						<?php $form->html(); ?>
                    </div>
                    <div class="form-group form-horizontal">
                        <label class="col-sm-2 control-label"> </label>
                        <div class="control-group controls col-sm-10">
							<?php wp_nonce_field( $this->plugin->getPrefix() . 'settings_form', $this->plugin->getPrefix() . 'nonce' ); ?>
                            <input name="<?= $this->plugin->getPrefix() . 'saved' ?>" class="btn btn-primary" type="submit" value="<?php _e( 'Save settings', 'insert-php' ) ?>"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
		<?php
	}
	
	/**
	 * Retrieve a list of the available CodeMirror themes
	 * @return array the available themes
	 */
	public function getAvailableThemes() {
		static $themes = null;
		
		if ( ! is_null( $themes ) ) {
			return $themes;
		}
		
		$themes      = array();
		$themes_dir  = WINP_PLUGIN_DIR . '/admin/assets/css/cmthemes/';
		$theme_files = glob( $themes_dir . '*.css' );
		
		foreach ( $theme_files as $i => $theme ) {
			$theme    = str_replace( $themes_dir, '', $theme );
			$theme    = str_replace( '.css', '', $theme );
			$themes[] = array( $theme, $theme );
		}
		
		array_unshift( $themes, array( 'default', 'default' ) );
		
		return $themes;
	}
}
