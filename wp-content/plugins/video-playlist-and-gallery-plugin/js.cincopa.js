var cincopaGallery = {
	loged: false,
	list_filled: false,
	gallery_block: false,

	init: function () {
		cincopaGallery.gallery_block = jQuery('.cincopa-gallery-block');
	},
	format: function(value, tokens) {
		  var formatted = value;
		  
		  for (var token in tokens)
		    if (tokens.hasOwnProperty(token))
		      formatted = formatted.replace(RegExp("{" + token + "}", "g"), tokens[token]);
		  return formatted;
	},
	is_visible: function () {
		return cincopaGallery.gallery_block.hasClass('cincopa-gallery-block-visible');
	},
	_show: function () {
		cincopaGallery.gallery_block.addClass('cincopa-gallery-block-visible');
		
		//jQuery(event.target).parent().addClass('pressed'); //original code
		
		//var position = jQuery(event.target).offset(); //original code
		
		//console.log(event.target)
		jQuery('#cincopa_show_button').parent().addClass('pressed');

		var position = jQuery('#cincopa_show_button').offset();

		cincopaGallery.gallery_block.offset( {left: position.left - 25, top: position.top + 23} );
	},
	toggle: function () {
		if ( cincopaGallery.is_visible() )
			cincopaGallery.hide();
		else
			cincopaGallery.show();
	},
	show: function () {
		
		if ( ! cincopaGallery.list_filled ) 
			cincopaGallery.fill();
		else
			cincopaGallery._show();
	},
	hide: function () {
		cincopaGallery.gallery_block.removeClass('cincopa-gallery-block-visible');
		cincopaGallery.gallery_block.removeAttr('style');
		
		jQuery('#cincopa_button').removeClass('pressed');
	},
	select: function (item) {
		cincopaGallery.hide();
		top.send_to_editor( "[cincopa " + jQuery(item).attr('did') + "]" );
	},
	_show_contents: function (data) {
		
		/* 
		//-----------------Original Code---------------------
		var is_list = (data != "no session");
		
		var login = '<div class="cincopa-login"><a href="//www.cincopa.com/login.aspx" target="_blank">Please login first</a></div>';
		
		var container = '<ul class="cincopa-gallery-list">{items}</ul>';
		var item_container = '<li class="cincopa-gallery-item" did="{id}">{item}</li>';
		var item = '<div class="cincopa-gallery-item-data"><strong>{name}</strong> (id: {id})<br/>Modified: {modified}</div>';
		var contents = '';
		
		if ( is_list && data.response.folders.length != 0 ) {
			cincopaGallery.list_filled = true;
			for (var index in data.response.folders) {
				var gdata = data.response.folders[index].sysdata;
				contents +=
					cincopaGallery.format(item_container, 
						{
							id: gdata.did,
							item: cincopaGallery.format( item, 
									{
										name: gdata.name, 
										id: gdata.did, 
										modified: gdata.modified
									} 
							)
						}
					);
			}
			contents = cincopaGallery.format( container, {items: contents} );
					
			contents += "<div>found " + data.response.folders.length+ " galleries</div>";
			
			cincopaGallery.gallery_block.html(contents );
			return;	
		}*/

		// if not logged
		//cincopaGallery.hide();
		
		// call iframe window
		//jQuery('#cincopa_button a').click();
		//---------------End Original Code---------------

		//-------------New Code--------------------
		var is_list = (data != "no session");

		var login = '<div class="cincopa-login"><a href="https://www.cincopa.com/login.aspx" target="_blank">Login</a> or <a href="https://www.cincopa.com/register.aspx" target="_blank">Register</a> to Cincopa to see this list</div>';
		//var login = '<div class="cincopa-login"><a href="//www.cincopa.com/login.aspx" target="_blank">Please login first</a></div>';

		var container = '<ul class="cincopa-gallery-list">{items}</ul>';
		var item_container = '<li class="cincopa-gallery-item" did="{id}">{item}</li>';
		var item = '<div class="cincopa-gallery-item-data"><strong>{name}</strong> (id: {id})<br/>Modified: {modified}</div>';
		var contents = '';

		if( jQuery('.cincopa-gallery-block img').length > 0 ){
			jQuery('.cincopa-gallery-block').attr('loading_gif_src', jQuery('.cincopa-gallery-block img').attr('src') );
		}

		var loading_gif = '';
		if( jQuery('.cincopa-gallery-block').attr('loading_gif_src') != '' || jQuery('.cincopa-gallery-block').attr('loading_gif_src') != 'undefined' ){
			loading_gif = '<img src="'+ jQuery('.cincopa-gallery-block').attr('loading_gif_src') +'">';
		}

		//console.log(data);
		if( data.response.error ){

			cincopaGallery.gallery_block.html(login);

			// if not logged
			//cincopaGallery.hide();
		}else{
			cincopaGallery.gallery_block.html(loading_gif);

			if ( is_list && data.response.folders.length != 0 ) {
				cincopaGallery.list_filled = true;
				for (var index in data.response.folders) {
					var gdata = data.response.folders[index].sysdata;
					contents +=
						cincopaGallery.format(item_container, 
							{
								id: gdata.did,
								item: cincopaGallery.format( item, 
										{
											name: gdata.name, 
											id: gdata.did, 
											modified: gdata.modified
										} 
								)
							}
						);
				}
				contents = cincopaGallery.format( container, {items: contents} );
						
				contents += "<div>found " + data.response.folders.length+ " galleries</div>";
				
				cincopaGallery.gallery_block.html(contents );
				return;	
			}

			// call iframe window
			jQuery('#cincopa_button a').click();
		}
		//---------------End New Code----------------
		
	},
	_client_fill: function (data) {
		if (data) {
			cincopaGallery._show_contents(data);
			return;
		}
		
		jQuery.getScript(
			"//www.cincopa.com/media-platform/my-galleries-getlist?disable_editor=true&callback=cincopaGallery._client_fill"
		);
	},
	fill: function () {
		cincopaGallery._show();
		cincopaGallery._client_fill();
	}
};

jQuery('.cincopa-show-gallery').live('click', function () { cincopaGallery.toggle(); } );
jQuery('.cincopa-gallery-item').live('click', function () { cincopaGallery.select(this); });
jQuery('body').live('click', doGalleryClick);
	
function doGalleryClick(event) {
	if ( jQuery(event.target).attr('id') != 'cincopa_show_button' && 
			jQuery('.cincopa-show-gallery').find(event.target).length == 0 && 
			jQuery('.cincopa-gallery-list').find(event.target).length == 0 ) {
		cincopaGallery.hide();
		return;
	}
}
jQuery(function () {
	cincopaGallery.init();
});
