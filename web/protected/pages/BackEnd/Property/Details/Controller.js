/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new BackEndPageJs(), {
	_item: {} //the item entity that we are dealing with

	,_getAddressObj: function(place) {
		var tmp = {};
		tmp.me = this;
		tmp.components = place.address_components;
		tmp.address = {
			'street': (tmp.components[0] && tmp.components[0].short_name || '') + ' ' + (tmp.components[1] && tmp.components[1].long_name || '')
			,'city': (tmp.components[2] && tmp.components[2].long_name || '')
			,'region': (tmp.components[3] && tmp.components[3].short_name || '')
			,'country': (tmp.components[4] && tmp.components[4].long_name || '')
			,'postCode': (tmp.components[5] && tmp.components[5].short_name || '')
		}
		return tmp.address;
	}
	,_showMap: function(mapViewer) {
		var tmp = {};
		tmp.me = this;
		tmp.map = new google.maps.Map(mapViewer, {center: new google.maps.LatLng(-33.8688, 151.2195), zoom: 13 });
		tmp.infowindow = new google.maps.InfoWindow();
		tmp.autocomplete.bindTo('bounds', tmp.map);
		
		return tmp.me;
	}
	/**
	 * bind auto complete address box
	 */
	,_bindAutoComplete: function (txtBox, editPanel) {
		var tmp = {};
		tmp.me = this;
		tmp.map = new google.maps.Map(editPanel.down('#map-viewer'), {center: new google.maps.LatLng(-33.8688, 151.2195), zoom: 13});
		$(txtBox).store('auto-complete', tmp.autocomplete = new google.maps.places.Autocomplete(txtBox));
		tmp.infowindow = new google.maps.InfoWindow();
		tmp.marker = new google.maps.Marker({
			map : tmp.map,
			anchorPoint : new google.maps.Point(0, -29)
		});
		google.maps.event.addListener(tmp.autocomplete, 'place_changed', function() {
			tmp.infowindow.close();
			tmp.marker.setVisible(false);
			tmp.place = tmp.autocomplete.getPlace();
			if (!tmp.place.geometry) {
				return;
			}
		    // If the place has a geometry, then present it on a map.
		    if (tmp.place.geometry.viewport) {
		    	tmp.map.fitBounds(tmp.place.geometry.viewport);
		    } else {
		    	tmp.map.setCenter(tmp.place.geometry.location);
		    	tmp.map.setZoom(17);  // Why 17? Because it looks good.
		    }
		    tmp.marker.setIcon(/** @type {google.maps.Icon} */{
		    	url: tmp.place.icon,
		    	size: new google.maps.Size(71, 71),
		    	origin: new google.maps.Point(0, 0),
		    	anchor: new google.maps.Point(17, 34),
		    	scaledSize: new google.maps.Size(35, 35)
		    });
		    tmp.marker.setPosition(tmp.place.geometry.location);
		    tmp.marker.setVisible(true);
		    tmp.address = '';
		    if (tmp.place.address_components) {
		    	tmp.address = [
			        (tmp.place.address_components[0] && tmp.place.address_components[0].short_name || ''),
			        (tmp.place.address_components[1] && tmp.place.address_components[1].short_name || ''),
			        (tmp.place.address_components[2] && tmp.place.address_components[2].short_name || '')
		        ].join(' ');
		    }
		    tmp.me._item.newAddr = tmp.me._getAddressObj(tmp.place);
		    tmp.infowindow.setContent('<div><strong>' + tmp.place.name + '</strong><br>' + tmp.address);
		    tmp.infowindow.open(tmp.map, tmp.marker);
		    
		    editPanel.down('#addr-viewer').getElementsBySelector('[addr-viewer]').each(function(el){
		    	tmp.type = el.readAttribute('addr-viewer');
		    	if(tmp.me._item.newAddr[tmp.type])
		    		el.update(tmp.me._item.newAddr[tmp.type]);
		    });
		});
	}
	,_getEditPanel: function() {
		var tmp = {};
		tmp.me = this;
		tmp.newDiv = new Element('section')
			.insert({'bottom': new Element('div', {'class': 'row'})
				.insert({'bottom': new Element('div', {'class': 'col-sm-5','id': 'addr-viewer'})
					.insert({'bottom': new Element('div', {'class': 'input-group'})
						.insert({'bottom': new Element('span', {'class': 'input-group-addon'}).update('Street') })
						.insert({'bottom': new Element('span', {'class': 'form-control', 'addr-viewer': 'street'}) })
					})
					.insert({'bottom': new Element('div', {'class': 'input-group'})
						.insert({'bottom': new Element('span', {'class': 'input-group-addon'}).update('Suburb') })
						.insert({'bottom': new Element('span', {'class': 'form-control', 'addr-viewer': 'city'}) })
					})
					.insert({'bottom': new Element('div', {'class': 'input-group'})
						.insert({'bottom': new Element('span', {'class': 'input-group-addon'}).update('Street') })
						.insert({'bottom': new Element('span', {'class': 'form-control', 'addr-viewer': 'street'}) })
					})
					.insert({'bottom': new Element('div', {'class': 'input-group'})
						.insert({'bottom': new Element('span', {'class': 'input-group-addon'}).update('State') })
						.insert({'bottom': new Element('span', {'class': 'form-control', 'addr-viewer': 'region'}) })
					})
					.insert({'bottom': new Element('div', {'class': 'input-group'})
						.insert({'bottom': new Element('span', {'class': 'input-group-addon'}).update('PostCode') })
						.insert({'bottom': new Element('span', {'class': 'form-control', 'addr-viewer': 'postCode'}) })
					})
				})
				.insert({'bottom': new Element('div', {'class': 'col-sm-7', 'id': 'map-viewer', 'style': 'height: 400px;'})
				})
			});
		return tmp.newDiv;
	}
	/**
	 * Showing the creating panel
	 */
	,_showCreatingPanel: function() {
		var tmp = {};
		tmp.me = this;
		tmp.newDiv = new Element('div')
			.insert({'bottom': new Element('div', {'class': 'page-header'})
				.insert({'bottom': new Element('div', {'class': 'row'})
					.insert({'bottom': new Element('div', {'class': 'col-sm-9'})
						.insert({'bottom': new Element('h3').update('Creating Property @: ')
							.insert({'bottom': new Element('div', {'class': 'btn-group text-reset-wrapper', 'style': 'width: 60%'})
								.insert({'bottom': tmp.searchBox = new Element('input', {'id': 'addr-search-box', 'class': 'text-reset-box form-control', 'placeholder': 'Type in an address'}) })
								.insert({'bottom': new Element('a', {'href': 'javascript: void(0)', 'class': 'text-reset-btn', 'style': 'position: absolute; font-size: 12px; right: 10px; top: 0; bottom: 0; height: 14px; margin: auto;color: #ccc'}).update( new Element('span', {'class': 'glyphicon glyphicon-remove'}) )
									.observe('click', function() {
										$('addr-search-box').value = '';
									})
								})
							})
						})
					})
				})
			})
			.insert({'bottom': tmp.editPanel = tmp.me._getEditPanel() });
		$(tmp.me._htmlIDs.itemDivId).update(tmp.newDiv);
		tmp.me._bindAutoComplete(tmp.searchBox, tmp.editPanel);
		return tmp.me;
	}
	/**
	 * 
	 */
	,_showDetailsPanel: function() {
		var tmp = {};
		tmp.me = this;
		tmp.newDiv = new Element('div');
		return tmp.me;
	}
	/**
	 * Showing the item
	 */
	,load: function(item) {
		var tmp = {};
		tmp.me = this;
		tmp.me._item = item;
		if(tmp.me._item.id)
			tmp.me._showDetailsPanel();
		else
			tmp.me._showCreatingPanel();
		return tmp.me;
	}
});