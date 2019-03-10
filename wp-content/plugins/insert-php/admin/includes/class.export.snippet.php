<?php

/**
 * Export snippet
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 16.11.2018, Webcraftic
 * @version 1.0
 */
class WINP_Export_Snippet {
	
	/**
	 * WINP_Export_Snippet constructor.
	 */
	public function __construct() {
		$this->registerHooks();
	}
	
	/**
	 * Register hooks
	 */
	public function registerHooks() {
		add_filter( 'post_row_actions', array( $this, 'postRowActions' ), 10, 2 );
		add_filter( 'bulk_actions-edit-' . WINP_SNIPPETS_POST_TYPE, array( $this, 'actionBulkEditPost' ) );
		add_filter( 'handle_bulk_actions-edit-' . WINP_SNIPPETS_POST_TYPE, array(
			$this,
			'handleActionBulkEditPost',
		), 10, 3 );
		
		add_action( 'post_submitbox_start', array( $this, 'postSubmitboxStart' ) );
		add_action( 'admin_init', array( $this, 'adminInit' ) );
	}
	
	/**
	 * Get export url
	 *
	 * @param $post_id
	 *
	 * @return string
	 */
	private function getExportUrl( $post_id ) {
		$url = admin_url( 'post.php?post=' . $post_id );
		
		return add_query_arg( array( 'action' => 'export' ), $url );
	}
	
	/**
	 * postRowActions
	 *
	 * @param $actions
	 * @param $post
	 *
	 * @return mixed
	 */
	public function postRowActions( $actions, $post ) {
		if ( $post->post_type == WINP_SNIPPETS_POST_TYPE ) {
			$export_link = $this->getExportUrl( $post->ID );
			
			if ( isset( $actions['trash'] ) ) {
				$trash = $actions['trash'];
				unset( $actions['trash'] );
			}
			
			$actions['export'] = sprintf( '<a href="%1$s">%2$s</a>', esc_url( $export_link ), esc_html( __( 'Export', 'insert-php' ) ) );
			
			if ( isset( $trash ) ) {
				$actions['trash'] = $trash;
			}
		}
		
		return $actions;
	}
	
	/**
	 * actionBulkEditPost
	 *
	 * @param $bulk_actions
	 *
	 * @return mixed
	 */
	public function actionBulkEditPost( $bulk_actions ) {
		$bulk_actions['export']     = __( 'Export', 'insert-php' );
		$bulk_actions['deletesnp']  = __( 'Delete', 'insert-php' );
		$bulk_actions['deactivate'] = __( 'Deactivate', 'insert-php' );
		$bulk_actions['activate']   = __( 'Activate', 'insert-php' );
		
		return $bulk_actions;
	}
	
	/**
	 * handleActionBulkEditPost
	 *
	 * @param $redirect_to
	 * @param $doaction
	 * @param $post_ids
	 *
	 * @return mixed
	 */
	public function handleActionBulkEditPost( $redirect_to, $doaction, $post_ids ) {
		$actions = array(
			'export'     => 1,
			'deletesnp'  => 1,
			'deactivate' => 1,
			'activate'   => 1
		);
		
		if ( ! isset( $actions[ $doaction ] ) ) {
			return $redirect_to;
		}
		
		if ( count( $post_ids ) ) {
			switch ( $doaction ) {
				case 'export':
					$this->exportSnippets( $post_ids );
					break;
				case 'deletesnp':
					$this->deleteSnippets( $post_ids );
					break;
				case 'deactivate':
					$this->deactivateSnippets( $post_ids );
					break;
				case 'activate':
					$this->activateSnippets( $post_ids );
					break;
			}
		}
		
		return $redirect_to;
	}
	
	/**
	 * postSubmitboxStart
	 */
	public function postSubmitboxStart() {
		global $post;
		
		if ( $post && $post->post_type == WINP_SNIPPETS_POST_TYPE ) {
			$export_link = $this->getExportUrl( $post->ID );
			echo "<div id='winp-export-action'>" . sprintf( '<a href="%1$s">%2$s</a>', esc_url( $export_link ), esc_html( __( 'Export', 'insert-php' ) ) ) . "</div>";
		}
	}
	
	/**
	 * Get post meta
	 *
	 * @param $post_id
	 * @param $meta_name
	 *
	 * @return mixed
	 */
	private function getMeta( $post_id, $meta_name ) {
		return get_post_meta( $post_id, WINP_Plugin::app()->getPrefix() . $meta_name, true );
	}
	
	/**
	 * Set up the current page to act like a downloadable file instead of being shown in the browser
	 *
	 * @param string $format
	 * @param array $ids
	 * @param string $mime_type
	 *
	 * @return array
	 */
	public function prepareExport( $format, $ids, $mime_type = '' ) {
		$snippets = array();
		
		if ( count( $ids ) ) {
			foreach ( $ids as $id ) {
				$post       = get_post( $id );
				$snippets[] = array(
					'name'            => $post->post_name,
					'title'           => $post->post_title,
					'content'         => $post->post_content,
					'location'        => $this->getMeta( $id, 'snippet_location' ),
					'type'            => $this->getMeta( $id, 'snippet_type' ),
					'code'            => $this->getMeta( $id, 'snippet_code' ),
					'filters'         => $this->getMeta( $id, 'snippet_filters' ),
					'changed_filters' => $this->getMeta( $id, 'changed_filters' ),
					'scope'           => $this->getMeta( $id, 'snippet_scope' ),
					'description'     => $this->getMeta( $id, 'snippet_description' ),
					'tags'            => $this->getMeta( $id, 'snippet_tags' )
				);
			}
		}
		
		/* Build the export filename */
		if ( 1 == count( $ids ) ) {
			$name  = $snippets[0]['title'];
			$title = strtolower( $name );
		} else {
			/* Otherwise, use the site name as set in Settings > General */
			$title = strtolower( get_bloginfo( 'name' ) );
		}
		
		$filename = "{$title}.php-code-snippets.{$format}";
		
		/* Set HTTP headers */
		header( 'Content-Disposition: attachment; filename=' . sanitize_file_name( $filename ) );
		
		if ( '' !== $mime_type ) {
			header( "Content-Type: $mime_type; charset=" . get_bloginfo( 'charset' ) );
		}
		
		return $snippets;
	}
	
	/**
	 * Export snippets in JSON format
	 *
	 * @param array $ids
	 */
	public function exportSnippets( $ids ) {
		$snippets = $this->prepareExport( 'json', $ids, 'application/json' );
		
		$data = array(
			'generator'    => 'PHP Code Snippets v' . WINP_PLUGIN_VERSION,
			'date_created' => date( 'Y-m-d H:i' ),
			'snippets'     => $snippets,
		);
		
		echo wp_json_encode( $data, 0 );
		exit;
	}
	
	/**
	 * Delete snippets
	 *
	 * @param $ids
	 */
	private function deleteSnippets( $ids ) {
		if ( count( $ids ) ) {
			foreach ( $ids as $id ) {
				wp_trash_post( $id );
			}
		}
	}
	
	/**
	 * Deactivate snippets
	 *
	 * @param $ids
	 */
	private function deactivateSnippets( $ids ) {
		if ( count( $ids ) ) {
			foreach ( $ids as $id ) {
				update_post_meta( $id, WINP_Plugin::app()->getPrefix() . 'snippet_activate', 0 );
			}
		}
	}
	
	/**
	 * Activate snippets
	 *
	 * @param $ids
	 */
	private function activateSnippets( $ids ) {
		if ( count( $ids ) ) {
			foreach ( $ids as $id ) {
				$is_activate   = (int) WINP_Helper::getMetaOption( $id, 'snippet_activate', 0 );
				$snippet_scope = WINP_Helper::getMetaOption( $id, 'snippet_scope' );
				$snippet_type  = WINP_Helper::get_snippet_type( $id );
				
				if ( ( $snippet_scope == 'evrywhere' || $snippet_scope == 'auto' ) && ! $is_activate && $snippet_type != WINP_SNIPPET_TYPE_TEXT && WINP_Plugin::app()->getExecuteObject()->getSnippetError( $id ) ) {
					continue;
				}
				
				update_post_meta( $id, WINP_Plugin::app()->getPrefix() . 'snippet_activate', 1 );
			}
		}
	}
	
	/**
	 * adminInit
	 */
	public function adminInit() {
		if ( isset( $_GET['action'], $_GET['post'] ) ) {
			$ids = is_array( $_GET['post'] ) ? $_GET['post'] : array( absint( $_GET['post'] ) );
			
			switch ( sanitize_key( $_GET['action'] ) ) {
				case 'export':
					$this->exportSnippets( $ids );
					break;
				default:
					return;
			}
		}
	}
	
}