<?php

class WINP_InfoMetaBox extends Wbcr_FactoryMetaboxes404_Metabox {
	
	/**
	 * A visible title of the metabox.
	 *
	 * Inherited from the class FactoryMetabox.
	 * @link http://codex.wordpress.org/Function_Reference/add_meta_box
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $title;
	
	/**
	 * The part of the page where the edit screen
	 * section should be shown ('normal', 'advanced', or 'side').
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $context = 'side';
	
	
	/**
	 * The priority within the context where the boxes should show ('high', 'core', 'default' or 'low').
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_meta_box
	 * Inherited from the class FactoryMetabox.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $priority = 'core';
	
	public $css_class = 'factory-bootstrap-410 factory-fontawesome-000';
	
	protected $errors = array();
	protected $source_channel;
	protected $facebook_group_id;
	protected $paginate_url;
	
	public function __construct( $plugin ) {
		parent::__construct( $plugin );
		
		$this->title = __( 'Robin image optimizer: notice', 'insert-php' );
	}
	
	
	/**
	 * Configures a metabox.
	 *
	 * @since 1.0.0
	 *
	 * @param Wbcr_Factory410_ScriptList $scripts A set of scripts to include.
	 * @param Wbcr_Factory410_StyleList $styles A set of style to include.
	 *
	 * @return void
	 */
	public function configure( $scripts, $styles ) {
	}
	
	public function html() {
		$install_plugin_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=robin-image-optimizer' ), 'install-plugin_robin-image-optimizer' );
		?>
        <div class="wbcr-inp-metabox-banner">
            <h3 class="wbcr-inp-title">YOU HAVE 83% UNOPTIMIZED<br><span>&lt;IMAGES&gt;</span></h3>
            <div class="wbcr-inp-image">
                <img src="<?= WINP_PLUGIN_URL ?>/admin/assets/img/rio-banner.png" alt="">
            </div>
            <strong class="wbcr-inp-big-text"><?php _e( 'Install plugin Robin Image Optimizer to speed up your site!', 'insert-php' ); ?></strong>
            <a href="<?= $install_plugin_url ?>" class="wbcr-inp-button" target="_blank">
                <span class="dashicons dashicons-dashboard"></span> <?php _e( 'Optimize now for free', 'insert-php' ); ?>
            </a>
        </div>
		<?php
	}
}