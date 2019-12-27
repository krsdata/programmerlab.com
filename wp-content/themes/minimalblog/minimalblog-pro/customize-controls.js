(function (api) {

	// Extends our custom "minimalblog" section.
	api.sectionConstructor['minimalblog'] = api.Section.extend({

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	});
	jQuery("#accordion-panel-minimalblog-theme-options").addClass("custom-class");

})(wp.customize);