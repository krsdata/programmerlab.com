<?php
/**
 * Import snippet
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 16.11.2018, Webcraftic
 * @version 1.0
 */
class WINP_Import_Snippet {

	/**
	 * WINP_Export_Snippet constructor.
	 */
	public function __construct() {
		$this->registerHooks();
	}

	/**
	 * Register hooks
	 */
	public function registerHooks()
	{
		add_action( 'admin_init', array( $this, 'adminInit' ) );
	}

	/**
	 * Update post meta
	 *
	 * @param $post_id
	 * @param $meta_name
	 * @param $meta_value
	 */
	private function updateMeta( $post_id, $meta_name, $meta_value )
	{
		update_post_meta( $post_id, WINP_Plugin::app()->getPrefix() . $meta_name, $meta_value );
	}

	/**
	 * adminInit
	 */
	public function adminInit()
	{
		$this->processImportFiles();
	}

	/**
	 * Save snippet
	 *
	 * @param $snippet
	 *
	 * @return int
	 */
	private function saveSnippet( $snippet )
	{
		$data = array(
			'post_title'   => $snippet['title'],
			'post_content' => $snippet['content'],
			'post_status'  => 'publish',
			'post_type'    => WINP_SNIPPETS_POST_TYPE
		);

		if ( isset( $snippet['id'] ) && 0 != $snippet['id'] ) {
			$data['ID'] = $snippet['id'];
		}

		$snippet['id'] = wp_insert_post( $data );

		$this->updateMeta( $snippet['id'], 'snippet_location', $snippet['location'] );
		$this->updateMeta( $snippet['id'], 'snippet_type', $snippet['type'] );
		$this->updateMeta( $snippet['id'], 'snippet_code', $snippet['code'] );
		$this->updateMeta( $snippet['id'], 'snippet_filters', $snippet['filters'] );
		$this->updateMeta( $snippet['id'], 'changed_filters', $snippet['changed_filters'] );
		$this->updateMeta( $snippet['id'], 'snippet_scope', $snippet['scope'] );
		$this->updateMeta( $snippet['id'], 'snippet_description', $snippet['description'] );
		$this->updateMeta( $snippet['id'], 'snippet_tags', $snippet['tags'] );
		$this->updateMeta( $snippet['id'], 'snippet_activate', 0 );

		return $snippet['id'];
	}

	/**
	 * Save imported snippets
	 *
	 * @param $snippets
	 * @param $dup_action
	 *
	 * @return array
	 */
	private function saveImportedSnippets( $snippets, $dup_action )
	{
		$existing_snippets = array();
		if ( 'replace' === $dup_action || 'skip' === $dup_action ) {
			$all_snippets = get_posts( array( 'post_type' => WINP_SNIPPETS_POST_TYPE ) );
			foreach ( $all_snippets as $snippet ) {
				$existing_snippets[ $snippet->post_name ] = $snippet->ID;
			}
		}

		$imported = array();

		foreach ( $snippets as $snippet ) {
			if ( 'ignore' !== $dup_action && isset( $existing_snippets[ $snippet['name'] ] ) ) {
				if ( 'replace' === $dup_action ) {
					$snippet['id'] = $existing_snippets[ $snippet['name'] ];
				} elseif ( 'skip' === $dup_action ) {
					continue;
				}
			}

			if ( $snippet_id = $this->saveSnippet( $snippet ) ) {
				$imported[] = $snippet_id;
			}
		}

		return $imported;
	}

	/**
	 * Import snippets
	 *
	 * @param $file
	 * @param $dup_action
	 *
	 * @return int|bool|array
	 */
	private function importSnippet( $file, $dup_action )
	{
		if ( ! file_exists( $file ) || ! is_file( $file ) ) {
			return false;
		}

		$raw_data = file_get_contents( $file );
		$data = json_decode( $raw_data, true );
		$snippets = isset( $data['snippets'] ) ? $data['snippets'] : array();

		$imported = $this->saveImportedSnippets( $snippets, $dup_action );

		return $imported;
	}

	/**
	 * Process the uploaded import files
	 *
	 * @uses import_snippets() to process the import file
	 * @uses wp_redirect() to pass the import results to the page
	 * @uses add_query_arg() to append the results to the current URI
	 */
	private function processImportFiles()
	{
		if (
			! isset( $_FILES['wbcr_inp_import_files'] )
			|| ! count( $_FILES['wbcr_inp_import_files'] )
			|| ! isset( $_FILES['wbcr_inp_import_files']['tmp_name'][0] )
			|| empty( $_FILES['wbcr_inp_import_files']['tmp_name'][0] )
		) {
			return;
		}

		$count = 0;
		$uploads = $_FILES['wbcr_inp_import_files'];
		$dup_action = isset( $_POST['duplicate_action'] ) ? $_POST['duplicate_action'] : 'ignore';
		$error = false;

		foreach ( $uploads['tmp_name'] as $i => $import_file ) {
			$ext = pathinfo( $uploads['name'][ $i ] );
			$ext = $ext['extension'];
			$mime_type = $uploads['type'][ $i ];

			if ( 'json' === $ext || 'application/json' === $mime_type ) {
				$result = $this->importSnippet( $import_file, $dup_action );
			} else {
				$result = false;
			}

			if ( false === $result || -1 === $result ) {
				$error = true;
			} else {
				$count += count( $result );
			}
		}

		$url = remove_query_arg(
			array( 'wbcr_inp_error', 'wbcr_inp_imported' )
		);
		$url = add_query_arg( $error ? array( 'wbcr_inp_error' => true ) : array( 'wbcr_inp_imported' => $count ), $url );
		wp_redirect( esc_url_raw( $url ) );
		exit;
	}

}
