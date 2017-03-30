(function ( $ ) {
	$( document ).ready( function() {
		$( '.PSR_stars label' ).on( 'mouseenter', function() {
			var $parent = $( this ).parent( '.PSR_stars' ),
				psr_id = $( this ).attr( 'for' ),
				psr_points = $parent.find( '#' + psr_id ).val();
			$parent.find( 'label' ).each(function( i ) {
				$( this ).data( 'class', $( this ).attr( 'class' ) );
				$( this ).attr( 'class', 'PSR_full_star' );
				if ( i + 1 == psr_points ) {
					return false;
				}
			});
		}).on( 'mouseleave', function() {
			var $parent = $( this ).parent( '.PSR_stars' );
			$parent.find( 'label' ).each(function() {
				$( this ).attr( 'class', $( this ).data( 'class' ) );
			});
		}).on( 'click', function() {
			var $parent = $( this ).parent( '.PSR_stars' ),
				psr_id = $( this ).attr( 'for' ),
				psr_post_id = $parent.find( 'input[name="p"]' ).val(),
				psr_points = $parent.find( '#' + psr_id ).val(),
				psr_data = {
					'action'         : 'psr_save_vote',
					'psr_ajax_nonce' : psr_ajax['nonce'],
					'psr_post_id'    : psr_post_id,
					'psr_points'     : psr_points
				};
			$.post( psr_ajax['url'], psr_data, function( response ) {
				$parent.parent( '.PSR_container' ).replaceWith( response );
			});
		});
	});
})(jQuery)