<?php
/**
 * This class is implemented page: import in the admin panel.
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
class WINP_ImportPage extends Wbcr_FactoryPages411_AdminPage {
	
	/**
	 * @param Wbcr_Factory410_Plugin $plugin
	 */
	public function __construct( Wbcr_Factory410_Plugin $plugin ) {
		$this->menu_post_type = WINP_SNIPPETS_POST_TYPE;
		
		$this->id         = "import";
		$this->menu_title = __( 'Import', 'insert-php' );
		
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
	
	private function getMessage() {
		if ( isset( $_REQUEST['wbcr_inp_error'] ) && $_REQUEST['wbcr_inp_error'] ) { ?>
            <div id="message" class="alert alert-danger">
                <p><?php _e( 'An error occurred when processing the import files.', 'insert-php' ) ?></p>
            </div>
		<?php } else if ( isset( $_REQUEST['wbcr_inp_imported'] ) && intval( $_REQUEST['wbcr_inp_imported'] ) >= 0 ) {
			$imported = intval( $_REQUEST['wbcr_inp_imported'] );
			if ( 0 === $imported ) {
				$message = __( 'No snippets were imported.', 'insert-php' );
			} else {
				$message = sprintf( _n( 'Successfully imported <strong>%1$d</strong> snippet.', 'Successfully imported <strong>%1$d</strong> snippets.', $imported, 'insert-php' ), $imported );
			} ?>
            <div id="message" class="alert alert-success">
                <p><?php echo $message ?></p>
            </div>
			<?php
		} else if ( isset( $_POST[ $this->plugin->getPrefix() . 'saved' ] ) ) { ?>
            <div id="message" class="alert alert-warning">
                <p><?php _e( 'No files selected!', 'insert-php' ) ?></p>
            </div>
		<?php }
	}
	
	public function indexAction() {
		if ( isset( $_POST[ $this->plugin->getPrefix() . 'saved' ] ) ) {
			if ( ! wp_verify_nonce( $_POST[ $this->plugin->getPrefix() . 'nonce' ], $this->plugin->getPrefix() . 'import_form' ) ) {
				wp_die( 'Permission error. You can not edit this page.' );
			}
		}
		
		$max_size_bytes = apply_filters( 'import_upload_size_limit', wp_max_upload_size() );
		
		?>
        <div class="wrap ">
            <div class="factory-bootstrap-410 factory-fontawesome-000">
                <form method="post" class="form-horizontal" enctype="multipart/form-data">
					<?php $this->getMessage() ?>
                    <h3><?php _e( 'Import Snippets', 'insert-php' ) ?></h3>
                    <p style="padding-bottom: 15px"><?php _e( 'Upload one or more Php Snippets export files and the snippets will be imported.', 'insert-php' ); ?></p>
                    <h4><?php _e( 'Duplicate Snippets', 'insert-php' ); ?></h4>
                    <p class="description">
						<?php esc_html_e( 'What should happen if an existing snippet is found with an identical name to an imported snippet?', 'insert-php' ); ?>
                    </p>
                    <div style="padding-top: 10px;" class="winp-import-radio-container">
                        <fieldset>
                            <p>
                                <label style="font-weight: normal;">
                                    <input type="radio" name="duplicate_action" value="ignore" checked="checked">
									<?php _e( 'Ignore any duplicate snippets: import all snippets from the file regardless and leave all existing snippets unchanged.', 'insert-php' ); ?>
                                </label>
                            </p>
                            <p>
                                <label style="font-weight: normal;">
                                    <input type="radio" name="duplicate_action" value="replace">
									<?php _e( 'Replace any existing snippets with a newly imported snippet of the same name.', 'insert-php' ); ?>
                                </label>
                            </p>
                            <p>
                                <label style="font-weight: normal;">
                                    <input type="radio" name="duplicate_action" value="skip">
									<?php _e( 'Do not import any duplicate snippets; leave all existing snippets unchanged.', 'insert-php' ); ?>
                                </label>
                            </p>
                        </fieldset>
                    </div>
                    <h3><?php _e( 'Upload Files', 'insert-php' ); ?></h3>
                    <p class="description">
						<?php _e( 'Choose one or more Php Snippets (.json) files to upload, then click "Upload files and import".', 'insert-php' ); ?>
                    </p>
                    <fieldset>
                        <p>
                            <label for="upload" style="font-weight: normal;">
								<?php _e( 'Choose files from your computer:', 'insert-php' ); ?>
                            </label>
							<?php printf( /* translators: %s: size in bytes */
								esc_html__( '(Maximum size: %s)', 'insert-php' ), size_format( $max_size_bytes ) ); ?>
                            <input type="file" id="upload" name="wbcr_inp_import_files[]" size="25" accept="application/json,.json,text/xml" multiple="multiple">
                            <input type="hidden" name="action" value="save">
                            <input type="hidden" name="max_file_size" value="<?php echo esc_attr( $max_size_bytes ); ?>">
                        </p>
                    </fieldset>
                    <div class="form-group form-horizontal">
                        <div class="control-group controls col-sm-12">
							<?php wp_nonce_field( $this->plugin->getPrefix() . 'import_form', $this->plugin->getPrefix() . 'nonce' ); ?>
                            <input name="<?= $this->plugin->getPrefix() . 'saved' ?>" class="btn btn-primary" type="submit" value="<?php _e( 'Upload files and import', 'insert-php' ) ?>"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
		<?php
	}
}
