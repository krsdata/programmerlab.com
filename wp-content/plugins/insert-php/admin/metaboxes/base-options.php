<?php

class WINP_BaseOptionsMetaBox extends Wbcr_FactoryMetaboxes404_FormMetabox {
	
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
		
		$this->title = __( 'Base options', 'insert-php' );
		
		add_action( 'admin_head', array( $this, 'removeMediaButton' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'deregisterDefaultEditorResourses' ) );
		
		$snippet_type = WINP_Helper::get_snippet_type();
		
		if ( $snippet_type !== WINP_SNIPPET_TYPE_TEXT ) {
			add_action( 'admin_footer-post.php', array( $this, 'printCodeEditorScripts' ), 99 );
			add_action( 'admin_footer-post-new.php', array( $this, 'printCodeEditorScripts' ), 99 );
			add_action( 'edit_form_after_editor', array( $this, 'phpEditorMarkup' ), 10, 1 );
		}
		
		add_action( 'admin_body_class', array( $this, 'admin_body_class' ) );
		add_action( 'edit_form_top', array( $this, 'editFormTop' ) );
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
		//method must be overriden in the derived classed.
		$styles->add( WINP_PLUGIN_URL . '/admin/assets/css/general.css' );
		
		$code_editor_theme = $this->plugin->getPopulateOption( 'code_editor_theme' );
		
		if ( ! empty( $code_editor_theme ) && $code_editor_theme != 'default' ) {
			$this->styles->add( WINP_PLUGIN_URL . '/admin/assets/css/cmthemes/' . $code_editor_theme . '.css' );
		}
		
		$this->styles->add( WINP_PLUGIN_URL . '/admin/assets/css/code-editor.min.css' );
		$this->scripts->addToHeader( WINP_PLUGIN_URL . '/admin/assets/js/code-editor.min.js' );
	}
	
	
	/**
	 * Remove media button
	 */
	public function removeMediaButton() {
		global $post;
		
		if ( empty( $post ) || $post->post_type !== WINP_SNIPPETS_POST_TYPE ) {
			return;
		}
		remove_action( 'media_buttons', 'media_buttons' );
	}
	
	/**
	 * Deregister other CodeMirror styles
	 */
	public function deregisterDefaultEditorResourses() {
		global $post;
		
		if ( empty( $post ) || $post->post_type !== WINP_SNIPPETS_POST_TYPE ) {
			return;
		}
		
		/* Remove other CodeMirror styles */
		wp_deregister_style( 'codemirror' );
	}
	
	public function printCodeEditorScripts() {
		global $post;
		
		if ( empty( $post ) || $post->post_type !== WINP_SNIPPETS_POST_TYPE ) {
			return;
		}
		
		$snippet_type      = WINP_Helper::get_snippet_type();
		$code_editor_mode  = $snippet_type == WINP_SNIPPET_TYPE_PHP ? 'text/x-php' : 'application/x-httpd-php';
		$code_editor_theme = $this->plugin->getPopulateOption( 'code_editor_theme' );
		
		?>
        <script>
			/* Loads CodeMirror on the snippet editor */
			(function() {

				var atts = [];

				atts['mode'] = '<?= $code_editor_mode ?>';

				atts['matchBrackets'] = true;
				atts['styleActiveLine'] = true;
				atts['continueComments'] = true;
				atts['autoCloseTags'] = true;
				atts['viewportMargin'] = Infinity;

				atts['inputStyle'] = 'contenteditable';
				atts['direction'] = 'ltr';
				atts['lint'] = true;
				atts['gutters'] = ["CodeMirror-lint-markers"];

				atts['matchTags'] = {
					'bothTags': true
				};

				atts['extraKeys'] = {
					'Ctrl-Enter': function(cm) {
						document.getElementById('<?= $this->plugin->getPrefix() ?>snippet_code').submit();
					},
					'Ctrl-Space': 'autocomplete',
					'Ctrl-/': 'toggleComment',
					'Cmd-/': 'toggleComment',
					'Alt-F': 'findPersistent',
					'Ctrl-F': 'findPersistent',
					'Cmd-F': 'findPersistent'
				};

				atts['indentWithTabs'] = <?php $this->printBool( $this->plugin->getPopulateOption( 'code_editor_indent_with_tabs', true ) ) ?>;
				atts['tabSize'] = <?= (int) $this->plugin->getPopulateOption( 'code_editor_tab_size', 4 ) ?>;
				atts['indentUnit'] = <?= (int) $this->plugin->getPopulateOption( 'code_editor_indent_unit', 4 ) ?>;
				atts['lineNumbers'] = <?php $this->printBool( $this->plugin->getPopulateOption( 'code_editor_line_numbers', true ) ) ?>;
				atts['lineWrapping'] = <?php $this->printBool( $this->plugin->getPopulateOption( 'code_editor_wrap_lines', true ) ) ?>;
				atts['autoCloseBrackets'] = <?php $this->printBool( $this->plugin->getPopulateOption( 'code_editor_auto_close_brackets', true ) ) ?>;
				<?php if ($this->plugin->getPopulateOption( 'code_editor_highlight_selection_matches', true )) { ?>
				atts['highlightSelectionMatches'] = {
					showToken: true,
					style: 'winp-matchhighlight'
				};
				<?php } else { ?>
				atts['highlightSelectionMatches'] = false;
				<?php } ?>
				
				<?php if(! empty( $code_editor_theme ) && $code_editor_theme != 'default'): ?>
				atts['theme'] = '<?= esc_attr( $code_editor_theme ) ?>';
				<?php endif; ?>

				Woody_CodeMirror.fromTextArea(document.getElementById('<?= $this->plugin->getPrefix() ?>snippet_code'), atts);
			})();

			jQuery(document).ready(function($) {
				$('.wp-editor-tabs').remove();
			});
        </script>
		<?php
	}
	
	/**
	 * Markup PHP snippet editor.
	 *
	 * @param object $post Post Object.
	 */
	function phpEditorMarkup( $post ) {
		// Get all posts.
		$post_type = get_post_type();
		
		if ( WINP_SNIPPETS_POST_TYPE == $post_type ) {
			wp_nonce_field( basename( __FILE__ ), WINP_SNIPPETS_POST_TYPE );
			$content = WINP_Helper::getMetaOption( $post->ID, 'snippet_code' );
			?>
            <div class="wp-editor-container winp-editor-container">
                <textarea id="<?= $this->plugin->getPrefix() ?>snippet_code" name="<?= $this->plugin->getPrefix() ?>snippet_code" class="wp-editor-area winp-php-content"><?php echo esc_html( $content ); ?></textarea>
            </div>
			<?php
		}
	}
	
	/**
	 * Adds one or more classes to the body tag in the dashboard.
	 *
	 * @param  string $classes Current body classes.
	 *
	 * @return string Altered body classes.
	 */
	public function admin_body_class( $classes ) {
		
		global $post;
		
		if ( ! empty( $post ) && $post->post_type == WINP_SNIPPETS_POST_TYPE ) {
			$snippet_type = WINP_Helper::get_snippet_type();
			
			$new_classes = "wbcr-inp-snippet-type-" . $snippet_type;
			
			if ( $snippet_type !== WINP_SNIPPET_TYPE_TEXT ) {
				$new_classes .= " winp-snippet-enabled";
			}
			
			return $classes . $new_classes;
		}
		
		return $classes;
	}
	
	/**
	 * Add hidden tag to edit post form
	 *
	 * @param $post
	 */
	public function editFormTop( $post ) {
		if ( empty( $post ) || $post->post_type !== WINP_SNIPPETS_POST_TYPE ) {
			return;
		}
		
		$snippet_type = isset( $_GET['winp_item'] ) ? sanitize_text_field( $_GET['winp_item'] ) : WINP_SNIPPET_TYPE_PHP;
		$snippet_type = WINP_Helper::getMetaOption( $post->ID, 'snippet_type', $snippet_type );
		echo '<input type="hidden" id="wbcr_inp_snippet_type" name="wbcr_inp_snippet_type" value="' . $snippet_type . '">';
	}
	
	/**
	 * @param bool $bool_val
	 */
	protected function printBool( $bool_val ) {
		echo $bool_val ? 'true' : 'false';
	}
	
	/**
	 * Configures a form that will be inside the metabox.
	 *
	 * @see Wbcr_FactoryMetaboxes404_FormMetabox
	 * @since 1.0.0
	 *
	 * @param Wbcr_FactoryForms411_Form $form A form object to configure.
	 *
	 * @return void
	 */
	public function form( $form ) {
		$snippet_type = WINP_Helper::get_snippet_type();
		$events       = array();
		
		if ( $snippet_type === WINP_SNIPPET_TYPE_PHP ) {
			$option_name = 'Run everywhere';
			$data        = array(
				array( 'evrywhere', __( $option_name, 'insert-php' ) ),
				array( 'shortcode', __( 'Where there is a shortcode', 'insert-php' ) )
			);
		} else {
			if ( $snippet_type === WINP_SNIPPET_TYPE_TEXT ) {
				$hint = __( 'If you want to place some content into your snippet from the shortcode just wrap it inside [wbcr_text_snippet id="xxx"]content[/wbcr_text_snippet]. To use this content inside the snippet use {{SNIPPET_CONTENT}} variable.', 'insert-php' );
			} else if ( $snippet_type === WINP_SNIPPET_TYPE_PHP ) {
				$hint = __( 'If you want to place some content into your snippet from the shortcode just wrap it inside [wbcr_php_snippet id="xxx"]content[/wbcr_php_snippet]. To use this content inside the snippet use $content variable.', 'insert-php' );
			} else if ( $snippet_type === WINP_SNIPPET_TYPE_UNIVERSAL ) {
				$hint = __( 'If you want to place some content into your snippet from the shortcode just wrap it inside [wbcr_snippet id="xxx"]content[/wbcr_snippet]. To use this content inside the snippet use $content variable.', 'insert-php' );
			}
			
			$option_name = 'Automatic insertion';
			$data        = array(
				array( 'auto', __( $option_name, 'insert-php' ) ),
				array( 'shortcode', __( 'Where there is a shortcode', 'insert-php' ), $hint )
			);
			$events      = array(
				'auto'      => array(
					'show' => '.factory-control-snippet_location'
				),
				'shortcode' => array(
					'hide' => '.factory-control-snippet_location,.factory-control-snippet_p_number'
				)
			);
		}
		
		$items[] = array(
			'type'    => 'dropdown',
			'way'     => 'buttons',
			'name'    => 'snippet_scope',
			'data'    => $data,
			'title'   => __( 'Where to execute the code?', 'insert-php' ),
			'hint'    => __( 'If you select the "' . $option_name . '" option, after activating the widget, the php code will be launched on all pages of your site. Another option works only where you have set a shortcode snippet (widgets, post).', 'insert-php' ),
			'default' => 'shortcode',
			'events'  => $events
		);
		
		if ( $snippet_type !== WINP_SNIPPET_TYPE_PHP ) {
			$data = array(
				array(
					'title' => __( 'Everywhere', 'insert-php' ),
					'type'  => 'group',
					'items' => array(
						array(
							WINP_SNIPPET_AUTO_HEADER,
							__( 'Head', 'insert-php' ),
							__( 'Snippet will be placed in the source code before </head>.', 'insert-php' )
						),
						array(
							WINP_SNIPPET_AUTO_FOOTER,
							__( 'Footer', 'insert-php' ),
							__( 'Snippet will be placed in the source code before </body>.', 'insert-php' )
						)
					)
				),
				array(
					'title' => __( 'Posts, Pages, Custom post types', 'insert-php' ),
					'type'  => 'group',
					'items' => array(
						array(
							WINP_SNIPPET_AUTO_BEFORE_POST,
							__( 'Insert Before Post', 'insert-php' ),
							__( 'Snippet will be placed before the title of the post/page.', 'insert-php' )
						),
						array(
							WINP_SNIPPET_AUTO_BEFORE_CONTENT,
							__( 'Insert Before Content', 'insert-php' ),
							__( 'Snippet will be placed before the content of the post/page.', 'insert-php' )
						),
						array(
							WINP_SNIPPET_AUTO_BEFORE_PARAGRAPH,
							__( 'Insert Before Paragraph', 'insert-php' ),
							__( 'Snippet will be placed before the paragraph, which number you can specify in the Location number field.', 'insert-php' )
						),
						array(
							WINP_SNIPPET_AUTO_AFTER_PARAGRAPH,
							__( 'Insert After Paragraph', 'insert-php' ),
							__( 'Snippet will be placed after the paragraph, which number you can specify in the Location number field.', 'insert-php' )
						),
						array(
							WINP_SNIPPET_AUTO_AFTER_CONTENT,
							__( 'Insert After Content', 'insert-php' ),
							__( 'Snippet will be placed after the content of the post/page.', 'insert-php' )
						),
						array(
							WINP_SNIPPET_AUTO_AFTER_POST,
							__( 'Insert After Post', 'insert-php' ),
							__( 'Snippet will be placed in the very end of the post/page.', 'insert-php' )
						)
					)
				),
				array(
					'title' => __( 'Categories, Archives, Tags, Taxonomies', 'insert-php' ),
					'type'  => 'group',
					'items' => array(
						array(
							WINP_SNIPPET_AUTO_BEFORE_EXCERPT,
							__( 'Insert Before Excerpt', 'insert-php' ),
							__( 'Snippet will be placed before the excerpt of the post/page.', 'insert-php' )
						),
						array(
							WINP_SNIPPET_AUTO_AFTER_EXCERPT,
							__( 'Insert After Excerpt', 'insert-php' ),
							__( 'Snippet will be placed after the excerpt of the post/page.', 'insert-php' )
						),
						array(
							WINP_SNIPPET_AUTO_BETWEEN_POSTS,
							__( 'Between Posts', 'insert-php' ),
							__( 'Snippet will be placed between each post.', 'insert-php' )
						),
						array(
							WINP_SNIPPET_AUTO_BEFORE_POSTS,
							__( 'Before post', 'insert-php' ),
							__( 'Snippet will be placed before the post, which number you can specify in the Location number field.', 'insert-php' )
						),
						array(
							WINP_SNIPPET_AUTO_AFTER_POSTS,
							__( 'After post', 'insert-php' ),
							__( 'Snippet will be placed after the post, which number you can specify in the Location number field.', 'insert-php' )
						)
					)
				)
			);
			
			if ( $snippet_type === WINP_SNIPPET_TYPE_TEXT ) {
				unset( $data[0] );
				$data = array_values( $data );
			}
			
			$items[] = array(
				'type'    => 'dropdown',
				'name'    => 'snippet_location',
				'data'    => $data,
				'title'   => __( 'Insertion location', 'insert-php' ),
				'hint'    => __( 'Select the location for you snippet.', 'insert-php' ),
				'default' => WINP_SNIPPET_AUTO_HEADER,
				'events'  => array(
					WINP_SNIPPET_AUTO_HEADER           => array(
						'hide' => '.factory-control-snippet_p_number'
					),
					WINP_SNIPPET_AUTO_FOOTER           => array(
						'hide' => '.factory-control-snippet_p_number'
					),
					WINP_SNIPPET_AUTO_BEFORE_POST      => array(
						'hide' => '.factory-control-snippet_p_number'
					),
					WINP_SNIPPET_AUTO_BEFORE_CONTENT   => array(
						'hide' => '.factory-control-snippet_p_number'
					),
					WINP_SNIPPET_AUTO_AFTER_CONTENT    => array(
						'hide' => '.factory-control-snippet_p_number'
					),
					WINP_SNIPPET_AUTO_AFTER_POST       => array(
						'hide' => '.factory-control-snippet_p_number'
					),
					WINP_SNIPPET_AUTO_BEFORE_EXCERPT   => array(
						'hide' => '.factory-control-snippet_p_number'
					),
					WINP_SNIPPET_AUTO_AFTER_EXCERPT    => array(
						'hide' => '.factory-control-snippet_p_number'
					),
					WINP_SNIPPET_AUTO_BETWEEN_POSTS    => array(
						'hide' => '.factory-control-snippet_p_number'
					),
					WINP_SNIPPET_AUTO_BEFORE_PARAGRAPH => array(
						'show' => '.factory-control-snippet_p_number'
					),
					WINP_SNIPPET_AUTO_AFTER_PARAGRAPH  => array(
						'show' => '.factory-control-snippet_p_number'
					),
					WINP_SNIPPET_AUTO_BEFORE_POSTS     => array(
						'show' => '.factory-control-snippet_p_number'
					),
					WINP_SNIPPET_AUTO_AFTER_POSTS      => array(
						'show' => '.factory-control-snippet_p_number'
					)
				)
			);
			
			$items[] = array(
				'type'    => 'textbox',
				'name'    => 'snippet_p_number',
				'title'   => __( 'Location number', 'insert-php' ),
				'hint'    => __( 'Paragraph / Post number', 'insert-php' ),
				'default' => 0
			);
		}
		
		$items[] = array(
			'type'    => 'textarea',
			'name'    => 'snippet_description',
			'title'   => __( 'Description', 'insert-php' ),
			'hint'    => __( 'You can write a short note so that you can always remember why this code or your colleague was able to apply this code in his works.', 'insert-php' ),
			'tinymce' => array(
				'height'  => 150,
				'plugins' => ''
			),
			'default' => ''
		);
		
		if ( $snippet_type !== WINP_SNIPPET_TYPE_TEXT ) {
			$shorcode_name = 'wbcr_php_snippet';
			if ( $snippet_type === WINP_SNIPPET_TYPE_UNIVERSAL ) {
				$shorcode_name = 'wbcr_snippet';
			}
			$items[] = array(
				'type'        => 'textbox',
				'name'        => 'snippet_tags',
				'title'       => __( 'Available attributes', 'insert-php' ),
				'hint'        => __( "Available attributes for shortcode via comma. Only numbers, letters and underscore characters are allowed. Attribute id is always available. With this option you can set additional attributes for the shortcode. Example: start_date attribute to [$shorcode_name id='xxx' start_date='2018/01/15'] shortcode. Now we can get attribute value in the snippet with th \$start_date variable. It's convenient if you want to print out different results depending on this attributes.", "insert-php" ),
				'placeholder' => 'title, pass_attr1, pass_attr2'
				//'default'     => ''
			);
		}
		
		$form->add( $items );
	}
	
	/**
	 * Validate the snippet code before saving to database
	 *
	 * @param $snippet_code
	 * @param $snippet_type
	 *
	 * @return bool true if code produces errors
	 */
	private function validateCode( $snippet_code, $snippet_type ) {
		global $post;
		
		$snippet_code = stripslashes( $snippet_code );
		
		if ( empty( $snippet_code ) ) {
			return true;
		}
		
		ob_start( array( $this, 'codeErrorCallback' ) );
		
		$result = $snippet_type == WINP_SNIPPET_TYPE_UNIVERSAL ? eval( "?> " . $snippet_code . " <?php " ) : eval( $snippet_code );
		
		// elimination of errors 500 in eval() functions, with the directive display_errors = off;
		header( 'HTTP/1.0 200 OK' );
		
		ob_end_clean();
		
		do_action( 'wbcr_inp_after_execute_snippet', $post->ID, $snippet_code, $result );
		
		return false !== $result;
	}
	
	/**
	 * This friendly notice will be shown to the user in case of php errors.
	 *
	 * @param $out
	 *
	 * @return string
	 */
	private function codeErrorCallback( $out ) {
		$error = error_get_last();
		
		if ( is_null( $error ) ) {
			return $out;
		}
		
		$m = '<h3>' . __( "Don't Panic", 'code-snippets' ) . '</h3>';
		$m .= '<p>' . sprintf( __( 'The code snippet you are trying to save produced a fatal error on line %d:', 'code_snippets' ), $error['line'] ) . '</p>';
		$m .= '<strong>' . $error['message'] . '</strong>';
		$m .= '<p>' . __( 'The previous version of the snippet is unchanged, and the rest of this site should be functioning normally as before.', 'code-snippets' ) . '</p>';
		$m .= '<p>' . __( 'Please use the back button in your browser to return to the previous page and try to fix the code error.', 'code-snippets' );
		$m .= ' ' . __( 'If you prefer, you can close this page and discard the changes you just made. No changes will be made to this site.', 'code-snippets' ) . '</p>';
		
		return $m;
	}
	
	/**
	 * Filter the code by removing close php tag from beginning and adding open php tag to beginning (if not)
	 *
	 * @param $code
	 * @param $snippet_type
	 *
	 * @return mixed|string
	 */
	private function filterCode( $code, $snippet_type ) {
		if ( $snippet_type != WINP_SNIPPET_TYPE_PHP ) {
			/* Remove ?> from beginning of snippet */
			$code = preg_replace( '|^[\s]*\?>|', '', $code );
			
			/* Если количество закрывающих тегов не равно количеству открывающих, то добавим лишний */
			$start_count = substr_count( $code, '<?' );
			$end_count   = substr_count( $code, '?>' );
			
			if ( $start_count !== $end_count ) {
				if ( $start_count > $end_count ) {
					$code = $code . '?>';
				} else {
					$code = '<?php ' . $code;
				}
			}
		}
		
		return $code;
	}
	
	/**
	 * On saving form
	 *
	 * @param $postId
	 */
	public function onSavingForm( $postId ) {
		global $post;
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		$snippet_location = isset( $_POST[ WINP_Plugin::app()->getPrefix() . 'snippet_location' ] ) ? sanitize_text_field( $_POST[ WINP_Plugin::app()->getPrefix() . 'snippet_location' ] ) : WINP_SNIPPET_AUTO_HEADER;
		WINP_Helper::updateMetaOption( $post->ID, 'snippet_location', $snippet_location );
		
		$snippet_type = isset( $_POST[ WINP_Plugin::app()->getPrefix() . 'snippet_type' ] ) ? sanitize_text_field( $_POST[ WINP_Plugin::app()->getPrefix() . 'snippet_type' ] ) : WINP_SNIPPET_TYPE_PHP;
		WINP_Helper::updateMetaOption( $post->ID, 'snippet_type', $snippet_type );
		
		$snippet_code = isset( $_POST[ WINP_Plugin::app()->getPrefix() . 'snippet_code' ] ) ? $this->filterCode( $_POST[ WINP_Plugin::app()->getPrefix() . 'snippet_code' ], $snippet_type ) : '';
		WINP_Helper::updateMetaOption( $post->ID, 'snippet_code', $snippet_code );
		
		// Save Conditional execution logic for the snippet
		$snippet_filters = isset( $_POST[ WINP_Plugin::app()->getPrefix() . 'snippet_filters' ] ) ? json_decode( stripslashes( $_POST[ WINP_Plugin::app()->getPrefix() . 'snippet_filters' ] ) ) : '';
		WINP_Helper::updateMetaOption( $post->ID, 'snippet_filters', $snippet_filters );
		
		$changed_filters = isset( $_POST[ WINP_Plugin::app()->getPrefix() . 'changed_filters' ] ) ? intval( $_POST[ WINP_Plugin::app()->getPrefix() . 'changed_filters' ] ) : 0;
		WINP_Helper::updateMetaOption( $post->ID, 'changed_filters', $changed_filters );
	}
	
	/**
	 * After saving form
	 *
	 * @param $postId
	 */
	public function afterSavingForm( $postId ) {
		global $post;
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		
		$is_default_activate = WINP_Plugin::app()->getPopulateOption( 'activate_by_default', true );
		
		$snippet_type = WINP_Helper::get_snippet_type( $post->ID );
		if ( $snippet_type != WINP_SNIPPET_TYPE_TEXT ) {
			$snippet_content = isset( $_POST[ WINP_Plugin::app()->getPrefix() . 'snippet_code' ] ) ? WINP_Plugin::app()->getExecuteObject()->prepareCode( $_POST[ WINP_Plugin::app()->getPrefix() . 'snippet_code' ], $post->ID ) : '';
		} else {
			$snippet_content = $post->post_content;
		}
		
		$snippet_scope = isset( $_POST[ WINP_Plugin::app()->getPrefix() . 'snippet_scope' ] ) ? sanitize_text_field( $_POST[ WINP_Plugin::app()->getPrefix() . 'snippet_scope' ] ) : null;
		
		WINP_Helper::updateMetaOption( $post->ID, 'snippet_activate', false );
		
		$validate = true;
		
		if ( $snippet_scope == 'evrywhere' || $snippet_scope == 'auto' ) {
			if ( $snippet_type != WINP_SNIPPET_TYPE_TEXT ) {
				$validate = $this->validateCode( $snippet_content, $snippet_type );
			} else {
				$validate = ! empty( $snippet_content );
			}
		}
		
		if ( $validate && $is_default_activate && WINP_Plugin::app()->currentUserCan() ) {
			WINP_Helper::updateMetaOption( $post->ID, 'snippet_activate', true );
		} else {
			/* Display message if a parse error occurred */
			wp_redirect( add_query_arg( array(
				'action'                       => 'edit',
				'post'                         => $post->ID,
				'wbcr_inp_save_snippet_result' => 'code-error'
			), admin_url( 'post.php' ) ) );
			
			exit;
		}
	}
	
	/**
	 * Codemirror is used in Wordpress 4.9.0, if the Wordpress version is smaller,
	 * Wordpress does not have codemirror support.
	 *
	 * @return bool
	 */
	private function isCodemirrorSupport() {
		return version_compare( get_bloginfo( 'version' ), '4.9.0', '<' );
	}
	
}
