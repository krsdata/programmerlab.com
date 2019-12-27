jQuery(document).ready(function($) {	

    $('.radio-image-buttenset').each(function(){
        /** Radio Image **/
        id = $(this).attr('id');
        $( '[id='+id+']' ).buttonset();
    });

});

/* Customizer JS Upsale*/
( function( api ) {

	api.sectionConstructor['upsell'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );