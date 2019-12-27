( function( api ) {

	// Extends our custom "vw-consulting" section.
	api.sectionConstructor['vw-consulting'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );