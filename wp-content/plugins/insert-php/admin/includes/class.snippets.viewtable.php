<?php

class WINP_SnippetsViewTable extends Wbcr_FactoryViewtables405_Viewtable {
	
	public function configure() {
		/**
		 * Columns
		 */
		$this->columns->clear();
		//$this->columns->add('status', __('Status', 'insert-php'));
		$this->columns->add( 'title', __( 'Snippet title', 'insert-php' ) );
		$this->columns->add( 'description', __( 'Description', 'insert-php' ) );
		$this->columns->add( 'actions', __( 'Status', 'insert-php' ) );
		$this->columns->add( 'where_use', __( 'Where use?', 'insert-php' ) );
		$this->columns->add( 'taxonomy-' . WINP_SNIPPETS_TAXONOMY, __( 'Tags', 'insert-php' ) );
		$this->columns->add( 'snippet_type', '' );
		
		/**
		 * Scripts & styles
		 */
		$this->styles->add( WINP_PLUGIN_URL . '/admin/assets/css/list-table.css' );
		$this->runActions();
	}
	
	/**
	 * Column 'Title'
	 *
	 * @param $post
	 */
	public function columnTitle( $post ) {
		echo $post->post_title;
	}
	
	/**
	 * Column 'Type'
	 *
	 * @param $post
	 */
	public function columnSnippet_type( $post ) {
		$type  = WINP_Helper::getMetaOption( $post->ID, 'snippet_type', WINP_SNIPPET_TYPE_PHP );
		$class = 'wbcr-inp-type-' . esc_attr( $type );
		$type  = $type == 'universal' ? 'uni' : $type;
		
		echo '<div class="wbcr-inp-snippet-type-label ' . $class . '">' . esc_attr( $type ) . '</div>';
	}
	
	public function columnDescription( $post ) {
		echo WINP_Helper::getMetaOption( $post->ID, 'snippet_description' );
	}
	
	/**
	 * Column 'Where_use'
	 *
	 * @param $post
	 */
	public function columnWhere_use( $post ) {
		$snippet_scope = WINP_Helper::getMetaOption( $post->ID, 'snippet_scope' );
		
		if ( $snippet_scope == 'evrywhere' ) {
			echo __( 'Run everywhere', 'insert-php' );
		} elseif ( $snippet_scope == 'auto' ) {
			$items            = array(
				WINP_SNIPPET_AUTO_HEADER           => __( 'Header', 'insert-php' ),
				WINP_SNIPPET_AUTO_FOOTER           => __( 'Footer', 'insert-php' ),
				WINP_SNIPPET_AUTO_BEFORE_POST      => __( 'Insert Before Post', 'insert-php' ),
				WINP_SNIPPET_AUTO_BEFORE_CONTENT   => __( 'Insert Before Content', 'insert-php' ),
				WINP_SNIPPET_AUTO_BEFORE_PARAGRAPH => __( 'Insert Before Paragraph', 'insert-php' ),
				WINP_SNIPPET_AUTO_AFTER_PARAGRAPH  => __( 'Insert After Paragraph', 'insert-php' ),
				WINP_SNIPPET_AUTO_AFTER_CONTENT    => __( 'Insert After Content', 'insert-php' ),
				WINP_SNIPPET_AUTO_AFTER_POST       => __( 'Insert After Post', 'insert-php' ),
				WINP_SNIPPET_AUTO_BEFORE_EXCERPT   => __( 'Insert Before Excerpt', 'insert-php' ),
				WINP_SNIPPET_AUTO_AFTER_EXCERPT    => __( 'Insert After Excerpt', 'insert-php' ),
				WINP_SNIPPET_AUTO_BETWEEN_POSTS    => __( 'Between Posts', 'insert-php' ),
				WINP_SNIPPET_AUTO_BEFORE_POSTS     => __( 'Before post', 'insert-php' ),
				WINP_SNIPPET_AUTO_AFTER_POSTS      => __( 'After post', 'insert-php' ),
			);
			$snippet_location = WINP_Helper::getMetaOption( $post->ID, 'snippet_location', '' );
			switch ( $snippet_location ) {
				case WINP_SNIPPET_AUTO_HEADER:
				case WINP_SNIPPET_AUTO_FOOTER:
					$text = __( 'Everywhere', 'insert-php' ) . '[' . $items[ $snippet_location ] . ']';
					break;
				case WINP_SNIPPET_AUTO_BEFORE_POST:
				case WINP_SNIPPET_AUTO_BEFORE_CONTENT:
				case WINP_SNIPPET_AUTO_BEFORE_PARAGRAPH:
				case WINP_SNIPPET_AUTO_AFTER_PARAGRAPH:
				case WINP_SNIPPET_AUTO_AFTER_CONTENT:
				case WINP_SNIPPET_AUTO_AFTER_POST:
					$text = __( 'Posts, Pages, Custom post types', 'insert-php' ) . '[' . $items[ $snippet_location ] . ']';
					break;
				case WINP_SNIPPET_AUTO_BEFORE_EXCERPT:
				case WINP_SNIPPET_AUTO_AFTER_EXCERPT:
				case WINP_SNIPPET_AUTO_BETWEEN_POSTS:
				case WINP_SNIPPET_AUTO_BEFORE_POSTS:
				case WINP_SNIPPET_AUTO_AFTER_POSTS:
					$text = __( 'Categories, Archives, Tags, Taxonomies', 'insert-php' ) . '[' . $items[ $snippet_location ] . ']';
					break;
				default:
					$text = __( 'Everywhere', 'insert-php' );
			}
			echo __( 'Automatic insertion', 'insert-php' ) . ': ' . $text;
		} else {
			$snippet_type = WINP_Helper::getMetaOption( $post->ID, 'snippet_type', WINP_SNIPPET_TYPE_PHP );
			$snippet_type = ( $snippet_type == WINP_SNIPPET_TYPE_UNIVERSAL ? '' : $snippet_type . '_' );
			echo '[wbcr_' . $snippet_type . 'snippet id="' . $post->ID . '"]';
		}
	}
	
	/**
	 * Column 'Status'
	 *
	 * @param $post
	 */
	/*public function columnStatus($post)
	{
	
	}*/
	
	/**
	 * Column 'Actions'
	 *
	 * @param $post
	 */
	public function columnActions( $post ) {
		$is_activate = (int) WINP_Helper::getMetaOption( $post->ID, 'snippet_activate', 0 );
		
		//$button_text  = __( 'Activate', 'insert-php' );
		//$status_class = "wbcr-inp-status-grey";
		$icon = 'dashicons-controls-play';
		
		if ( $is_activate ) {
			//$button_text  = __( 'Deactivate', 'insert-php' );
			//$status_class = "wbcr-inp-status-green";
			$icon = 'dashicons-controls-pause';
		}
		
		echo '<a class="wbcr-inp-enable-snippet-button button" href="' . wp_nonce_url( admin_url( 'edit.php?post_type=' . WINP_SNIPPETS_POST_TYPE . '&amp;post=' . $post->ID . '&amp;action=wbcr_inp_activate_snippet' ), 'wbcr_inp_snippert_' . $post->ID . '_action_nonce' ) . '"><span class="dashicons ' . esc_attr( $icon ) . '"></span></a>';
	}
	
	/*
	 * Activate/Deactivate snippet
	 */
	protected function runActions() {
		if ( isset( $_GET['post_type'] ) && $_GET['post_type'] == WINP_SNIPPETS_POST_TYPE ) {
			
			if ( isset( $_GET['action'] ) && isset( $_GET['post'] ) && $_GET['action'] == 'wbcr_inp_activate_snippet' ) {
				$post_id = (int) $_GET['post'];
				
				if ( ( isset( $_GET['_wpnonce'] ) && ! wp_verify_nonce( $_GET['_wpnonce'], 'wbcr_inp_snippert_' . $post_id . '_action_nonce' ) ) || ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Permission error. You can not edit this page.' );
				}
				
				$is_activate   = (int) WINP_Helper::getMetaOption( $post_id, 'snippet_activate', 0 );
				$snippet_scope = WINP_Helper::getMetaOption( $post_id, 'snippet_scope' );
				$snippet_type  = WINP_Helper::get_snippet_type( $post_id );
				
				/**
				 * Prevent activation of the snippet if it contains an error. This will not allow the user to break his site.
				 * @since 2.0.5
				 */
				if ( ( $snippet_scope == 'evrywhere' || $snippet_scope == 'auto' ) && $snippet_type != WINP_SNIPPET_TYPE_TEXT && ! $is_activate ) {
					if ( WINP_Plugin::app()->getExecuteObject()->getSnippetError( $post_id ) ) {
						wp_safe_redirect( add_query_arg( array(
							'action'                       => 'edit',
							'post'                         => $post_id,
							'wbcr_inp_save_snippet_result' => 'code-error'
						), admin_url( 'post.php' ) ) );
						exit;
					}
				}
				
				$status = ! $is_activate;
				
				update_post_meta( $post_id, $this->plugin->getPrefix() . 'snippet_activate', $status );
				
				$redirect_url = add_query_arg( array(
					'post_type'                => WINP_SNIPPETS_POST_TYPE,
					'wbcr_inp_snippet_updated' => 1
				), admin_url( 'edit.php' ) );
				
				wp_safe_redirect( $redirect_url );
				exit;
			}
		}
	}
}
