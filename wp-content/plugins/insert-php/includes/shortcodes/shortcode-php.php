<?php

/**
 * Php Shortcode
 */
class WINP_SnippetShortcodePhp extends WINP_SnippetShortcode {
	
	public $shortcode_name = 'wbcr_php_snippet';
	
	/**
	 * Content render
	 *
	 * @param array $attr
	 * @param string $content
	 */
	public function html( $attr, $content ) {
		$id = $this->getSnippetId( $attr, WINP_SNIPPET_TYPE_PHP );
		
		if ( ! $id ) {
			echo '<span style="color:red">' . __( '[wbcr_php_snippet]: PHP snippets error (not passed the snippet ID)', 'insert-php' ) . '</span>';
			
			return;
		}
		
		$snippet_meta = get_post_meta( $id, '' );
		
		if ( empty( $snippet_meta ) ) {
			return;
		}
		
		$attr = $this->filterAttributes( $attr, $id );
		
		// Let users pass arbitrary variables, through shortcode attributes.
		// @since 2.0.5
		extract( $attr, EXTR_SKIP );
		
		$is_activate     = $this->getSnippetActivate( $snippet_meta );
		$snippet_scope   = $this->getSnippetScope( $snippet_meta );
		$snippet_content = $this->getSnippetContent( $snippet_meta, $id );
		
		if ( ! $is_activate || empty( $snippet_content ) || $snippet_scope != 'shortcode' || WINP_Helper::is_safe_mode() ) {
			return;
		}
		
		eval( $snippet_content );
	}
	
}