<?php

/**
 * Text Shortcode
 */
class WINP_SnippetShortcodeText extends WINP_SnippetShortcode {

	public $shortcode_name = 'wbcr_text_snippet';

	/**
	 * Content render
	 *
	 * @param array $attr
	 * @param string $content
	 */
	public function html($attr, $content)
	{
		$id = $this->getSnippetId( $attr, WINP_SNIPPET_TYPE_TEXT );

		if( !$id ) {
			echo '<span style="color:red">' . __('[wbcr_text_snippet]: PHP snippets error (not passed the snippet ID)', 'insert-php') . '</span>';

			return;
		}

		$snippet_meta = get_post_meta($id, '');
		if( empty($snippet_meta) ) {
			return;
		}

		$is_activate = $this->getSnippetActivate( $snippet_meta );
		$snippet_content = get_post($id)->post_content;
		$snippet_scope = $this->getSnippetScope( $snippet_meta );
		$is_condition = WINP_Plugin::app()->getExecuteObject()->checkCondition($id);

		if( !$is_activate || empty($snippet_content) || $snippet_scope != 'shortcode' || !$is_condition ) {
			return;
		}

		$code = do_shortcode($snippet_content);
		$code = str_replace( '{{SNIPPET_CONTENT}}', $content, $code );
		echo( $code );
	}

}