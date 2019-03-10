<?php
/**
 * This class is implemented page: import, export in the admin panel.
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
class WINP_NewItemPage extends Wbcr_FactoryPages411_AdminPage {
 
	/**
	 * @param Wbcr_Factory410_Plugin $plugin
	 */
	public function __construct( Wbcr_Factory410_Plugin $plugin ) {
		$this->menu_post_type = WINP_SNIPPETS_POST_TYPE;
		
		$this->menu_position = 1;
		$this->id            = "new-item";
		$this->menu_title    = __( '+ Add snippet', 'insert-php' );
		
		parent::__construct( $plugin );
		
		$this->plugin = $plugin;
	}
	
	public function assets( $scripts, $styles ) {
		$this->scripts->request( 'jquery' );
		
		$this->styles->request( array(
			'bootstrap.core'
		), 'bootstrap' );
		
		//$this->scripts->add( WINP_PLUGIN_URL . '/admin/assets/js/new-item.js' );
		$this->styles->add( WINP_PLUGIN_URL . '/admin/assets/css/new-item.css' );
	}
	
	/**
	 * Prints the contents of the page.
	 */
	public function indexAction() {
		$types = array(
			WINP_SNIPPET_TYPE_PHP       => array(
				'title'       => __( 'PHP snippet', 'insert-php' ),
				'help'        => 'http://woody-ad-snippets.webcraftic.com/getting-started-with-woody-ad-snippets/#Creating_a_PHP_snippet',
				'description' => '<p>' . __( 'Used for inserting php code. Can be used for registering functions, hooks, global variables, printing text. Virtual functions.php', 'insert-php' ) . '</p>'
			),
			WINP_SNIPPET_TYPE_TEXT      => array(
				'title'       => __( 'Text snippet', 'insert-php' ),
				'help'        => 'http://woody-ad-snippets.webcraftic.com/getting-started-with-woody-ad-snippets/#Creating_a_Text_Snippet',
				'description' => '<p>' . __( 'Used for inserting formatted text. Can be used for inserting quotes, paragraphs, shortcodes from other plugins, tables, media files.', 'insert-php' ) . '</p>'
			),
			WINP_SNIPPET_TYPE_UNIVERSAL => array(
				'title'       => __( 'Universal snippet', 'insert-php' ),
				'help'        => 'http://woody-ad-snippets.webcraftic.com/getting-started-with-woody-ad-snippets/#Creating_a_Universal_Snippet',
				'description' => '<p>' . __( 'Used for inserting php, html, js & css code. Can be used for inserting ads, analytics, embeds & other complex scenarios.', 'insert-php' ) . '</p>'
			),
		); ?>
        <div class="wrap factory-fontawesome-000">
            <div class="wbcr-inp-items">
                <h2><?php _e( 'Creating New Snippet', 'insert-php' ) ?></h2>
                <p style="margin-top: 0;"><?php _e( 'Choose which snippet you would like to create.', 'insert-php' ) ?></p>
				<?php foreach ( $types as $name => $type ) { ?>
                    <div class="postbox wbcr-inp-item">
                        <h4 class="wbcr-inp-title">
							<?php echo $type['title'] ?>
                        </h4>
                        <div class="wbcr-inp-description">
							<?php echo $type['description'] ?>
                        </div>
                        <div class="wbcr-inp-buttons">
                            <a href="<?php echo admin_url( 'post-new.php?post_type=' . WINP_SNIPPETS_POST_TYPE . '&winp_item=' . $name ); ?>"
                               class="button button-large wbcr-inp-create">
                                <span class="dashicons dashicons-plus"></span><span><?php _e( 'Create Item', 'insert-php' ) ?></span>
                            </a>
							<?php if ( isset( $type['help'] ) ) { ?>
                                <a href="<?php echo $type['help'] ?>" class="button button-large wbcr-inp-hint-button" target="_blank" rel="noopener" title="<?php _e( 'Click here to learn more', 'insert-php' ) ?>">
                                    <span class="dashicons dashicons-editor-help"></span>
                                </a>
							<?php } ?>
                        </div>
                    </div>
				<?php } ?>
            </div>
        </div>
		<?php
	}
}
