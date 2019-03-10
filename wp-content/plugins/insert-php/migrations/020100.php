<?php #comp-page builds: premium

/**
 * Updates for altering the table used to store statistics data.
 * Adds new columns and renames existing ones in order to add support for the new social buttons.
 */
class WINPUpdate020100 extends Wbcr_Factory410_Update {
	
	public function install() {
		update_option( $this->plugin->getOptionName( 'complete_uninstall' ), 0 );
		update_option( $this->plugin->getOptionName( 'what_new_210' ), 1 );
		
		$snippets = get_posts( array(
			'post_type'   => WINP_SNIPPETS_POST_TYPE,
			'post_status' => array(
				'publish',
				'pending',
				'draft',
				'auto-draft',
				'future',
				'private',
				'inherit',
				'trash'
			),
			'numberposts' => - 1
		) );
		
		if ( ! empty( $snippets ) ) {
			foreach ( (array) $snippets as $snippet ) {
				$snippet_type = WINP_Helper::getMetaOption( $snippet->ID, 'snippet_type' );
				
				if ( empty( $snippet_type ) ) {
					WINP_Helper::updateMetaOption( $snippet->ID, 'snippet_type', WINP_SNIPPET_TYPE_PHP );
				}
			}
		}
	}
}