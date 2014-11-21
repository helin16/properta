/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new BackEndPageJs(), {
	_item: {} //the item entity that we are dealing with
	/**
	 * getting an address object from place(google map object)
	 * 
	 * @param place Google map object
	 * 
	 * @return object
	 */
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
	,getPropertyEditPanel: function(property, title) {
		var tmp = {};
		tmp.me = this;
		tmp.noOfRooms = tmp.noOfBaths = tmp.noOfCars = '';
		if(property) {
			tmp.noOfRooms = property.noOfRooms;
		}
		tmp.addrString = tmp.me._item.newAddr.street + ', ' + tmp.me._item.newAddr.city + ', ' + tmp.me._item.newAddr.region + ' ' + tmp.me._item.newAddr.country + ' ' + tmp.me._item.newAddr.postCode;
		tmp.newDiv = new Element('div')
			.insert({'bottom': new Element('h3').update(title ? title : 'Adding a property:') })
			.insert({'bottom': new Element('div', {'class': 'row'})
				.insert({'bottom': new Element('div', {'class': 'form-group col-sm-8'})
					.insert({'bottom': new Element('div', {'class': 'prop-edit-panel form-inline'})
						.insert({'bottom': new Element('div', {'class': 'form-group col-sm-4'})
							.insert({'bottom': new Element('div', {'class': 'input-group'})
								.insert({'bottom': new Element('div', {'class': 'input-group-addon'})
									.insert({'bottom': new Element('span', {'class': 'label-text'}).update('Bedrooms:') })
								})
								.insert({'bottom': new Element('input', {'type': 'number', 'class': 'form-control', 'addr-edit': 'noOfRooms', 'placeholder': 'Number of Rooms', 'value': tmp.noOfRooms}) })
							})
						})
						.insert({'bottom': new Element('div', {'class': 'form-group col-sm-4'})
							.insert({'bottom': new Element('div', {'class': 'input-group'})
								.insert({'bottom': new Element('div', {'class': 'input-group-addon'})
									.insert({'bottom': new Element('span', {'class': 'label-text'}).update('Bathrooms:') })
								})
								.insert({'bottom': new Element('input', {'type': 'number', 'class': 'form-control', 'addr-edit': 'noOfBaths', 'placeholder': 'Number of Bathrooms', 'value': tmp.noOfBaths}) })
							})
						})
						.insert({'bottom': new Element('div', {'class': 'form-group col-sm-4'})
							.insert({'bottom': new Element('div', {'class': 'input-group'})
								.insert({'bottom': new Element('div', {'class': 'input-group-addon'})
									.insert({'bottom': new Element('span', {'class': 'label-text'}).update('CarSpaces:') })
								})
								.insert({'bottom': new Element('input', {'type': 'number', 'class': 'form-control', 'addr-edit': 'noOfCars', 'placeholder': 'Number of car spaces','value': tmp.noOfCars}) })
							})
						})
					})
				})
				.insert({'bottom': new Element('div', {'class': 'form-group col-sm-4'})
					.insert({'bottom': new Element('img', {'src': 'https://maps.googleapis.com/maps/api/staticmap?center=' + tmp.addrString + '&zoom=15&size=400x400&markers=color:red|label:P|' + tmp.addrString + ''}) })
				})
			})
			.insert({'bottom': new Element('h3').update('I am the ...') })
			.insert({'bottom': new Element('div', {'class': 'row'})
				.insert({'bottom': new Element('a', {'href': 'javascript: void(0);', 'class': 'form-group col-sm-4 text-center rel-type-selector blue'})
					.insert({'bottom': new Element('div', {'class': 'milstone-counter'})
						.insert({'bottom': new Element('span', {'class': 'fa fa-calendar fa-5x icon-header'}) })
						.insert({'bottom': new Element('span', {'class': 'stat-count highlight'}).update('Agent') })
						.insert({'bottom': new Element('span', {'class': 'milestone-details'}).update('Who manages this property') })
					})
				})
				.insert({'bottom': new Element('a', {'href': 'javascript: void(0);', 'class': 'form-group col-sm-4 text-center rel-type-selector green'})
					.insert({'bottom': new Element('div', {'class': 'milstone-counter'})
						.insert({'bottom': new Element('span', {'class': 'fa fa-map-marker fa-5x icon-header'}) })
						.insert({'bottom': new Element('span', {'class': 'stat-count highlight'}).update('Owner') })
						.insert({'bottom': new Element('span', {'class': 'milestone-details'}).update('Who owns this property') })
					})
				})
				.insert({'bottom': new Element('a', {'href': 'javascript: void(0);', 'class': 'form-group col-sm-4 text-center rel-type-selector orange'})
					.insert({'bottom': new Element('div', {'class': 'milstone-counter'})
						.insert({'bottom': new Element('span', {'class': 'fa fa-key fa-5x icon-header'}) })
						.insert({'bottom': new Element('span', {'class': 'stat-count highlight'}).update('Tanent') })
						.insert({'bottom': new Element('span', {'class': 'milestone-details'}).update('Who rents this property') })
					})
				})
			});
		return tmp.newDiv;
	}
	/**
	 * checking whether the backend has such an address or not
	 */
	,confirmAddr: function() {
		var tmp = {};
		tmp.me = this;
		tmp.hasErrorInAddr = false;
		$H(tmp.me._item.newAddr).each(function(item){
			if(item.value.blank()) {
				tmp.hasErrorInAddr = true;
			}
		});
		if(tmp.hasErrorInAddr === true) {
			tmp.me.showAddrEditPanel('<span class="text-warning">Missing some information in selected address, please manually correct them and submit:</span>');
			return tmp.me;
		}
		
		$(tmp.me._htmlIDs.mapViewer).hide();
		tmp.editView = $(tmp.me._htmlIDs.editViewer);
		tmp.editView.update('')
			.insert({'bottom': new Element('div', {'class': 'text-center', 'style': 'padding: 100px 0;'})
				.insert({'bottom': new Element('span', {'class': 'fa fa-refresh fa-5x fa-spin'}) })
			})
			.show();
		tmp.me.postAjax(tmp.me.getCallbackId('checkAddr'), {'checkAddr': tmp.me._item.newAddr}, {
			'onLoading': function() {}
			,'onSuccess': function(sender, param) {
				try {
					tmp.result = tmp.me.getResp(param, false, true);
					if(!tmp.result)
						return;
					if(tmp.result.address && tmp.result.address.street) {
						tmp.me._item.newAddr = tmp.result.address;
					}
					$(tmp.me._htmlIDs.addrSearchTxtBox).value = tmp.me._item.newAddr.street + ', ' + tmp.me._item.newAddr.city + ', ' + tmp.me._item.newAddr.region + ' ' + tmp.me._item.newAddr.country + ' ' + tmp.me._item.newAddr.postCode;
					if(tmp.result.properties && tmp.result.properties.size() >0) {
						tmp.me.showAllProperties(tmp.result.properties);
					} else {
						tmp.editView.update(tmp.me.getPropertyEditPanel(null, 'Lucky you! you are the first person to add this property.'));
					}
				} catch (e) {
					tmp.editView.update(tmp.me.getAlertBox('ERROR', e).addClassName('alert-danger'));
				}
			}
		})
		return tmp.me;
	}
	/**
	 * showing the address manual input panel
	 */
	,showAddrEditPanel: function(title) {
		var tmp = {};
		tmp.me = this;
		$(tmp.me._htmlIDs.mapViewer).hide();
		tmp.editView = $(tmp.me._htmlIDs.editViewer)
			.show()
			.update('')
			.insert({'bottom': new Element('div', {'class': 'form-horizontal addr-edit-panel'})
				.insert({'bottom': new Element('h4').update(title ? title : 'Please manually type in the address:') })
				.insert({'bottom': new Element('div', {'class': 'form-group'})
					.insert({'bottom': new Element('label', {'class': 'control-label col-sm-2'}).update('Street:') })
					.insert({'bottom': new Element('div', {'class': 'col-sm-10'})
						.insert({'bottom': new Element('input', {'class': 'form-control', 'addr-viewer': 'street', 'value': tmp.me._item.newAddr.street})})
					})
				})
				.insert({'bottom': new Element('div', {'class': 'form-group'})
					.insert({'bottom': new Element('label', {'class': 'control-label col-sm-2'}).update('Suburb:') })
					.insert({'bottom': new Element('div', {'class': 'col-sm-10'})
						.insert({'bottom': new Element('input', {'class': 'form-control', 'addr-viewer': 'city', 'value': tmp.me._item.newAddr.city}) })
					})
				})
				.insert({'bottom': new Element('div', {'class': 'form-group'})
					.insert({'bottom': new Element('label', {'class': 'control-label col-sm-2'}).update('State:') })
					.insert({'bottom': new Element('div', {'class': 'col-sm-10'})
						.insert({'bottom': new Element('input', {'class': 'form-control', 'addr-viewer': 'region', 'value': tmp.me._item.newAddr.region}) })
					})
				})
				.insert({'bottom': new Element('div', {'class': 'form-group'})
					.insert({'bottom': new Element('label', {'class': 'control-label col-sm-2'}).update('Country:') })
					.insert({'bottom': new Element('div', {'class': 'col-sm-10'})
						.insert({'bottom': new Element('input', {'class': 'form-control', 'addr-viewer': 'country', 'value': tmp.me._item.newAddr.country}) })
					})
				})
				.insert({'bottom': new Element('div', {'class': 'form-group'})
					.insert({'bottom': new Element('label', {'class': 'control-label col-sm-2'}).update('PostCode:') })
					.insert({'bottom': new Element('div', {'class': 'col-sm-10'})
						.insert({'bottom': new Element('input', {'class': 'form-control', 'addr-viewer': 'postCode', 'value': tmp.me._item.newAddr.postCode}) })
					})
				})
				.insert({'bottom': new Element('div', {'class': 'form-group'})
					.insert({'bottom': new Element('div', {'class': 'col-sm-offset-2 col-sm-10'})
						.insert({'bottom': new Element('span', {'class': 'btn btn-success'}).update('Confirm this address')
							.observe('click', function() {
								tmp.hasError = false;
								$(this).up('.addr-edit-panel').getElementsBySelector('[addr-viewer]').each(function(el) {
									if($F(el).blank()) {
										tmp.me._markFormGroupError(el, 'This field is required.');
										tmp.hasError = true;
									}
									tmp.me._item.newAddr[el.readAttribute('addr-viewer')] = $F(el).strip();
								});
								if(tmp.hasError === false)
									tmp.me.confirmAddr();
							})
						})
					})
				})
				
			});
		return tmp.me;
	}
	/**
	 * bind auto complete address box
	 */
	,_bindAutoComplete: function (txtBox, editPanel) {
		var tmp = {};
		tmp.me = this;
		tmp.map = new google.maps.Map(editPanel.down('#' + tmp.me._htmlIDs.mapViewer), {center: new google.maps.LatLng(-33.8688, 151.2195), zoom: 13});
		$(txtBox).store('auto-complete', tmp.autocomplete = new google.maps.places.Autocomplete(txtBox));
		tmp.infowindow = new google.maps.InfoWindow();
		tmp.marker = new google.maps.Marker({
			map : tmp.map,
			anchorPoint : new google.maps.Point(0, -29)
		});
		google.maps.event.addListener(tmp.autocomplete, 'place_changed', function() {
			$(txtBox).writeAttribute('disabled', true)
				.insert({'after': new Element('span', {'class': 'input-group-addon btn btn-danger', 'title': 'reset'}).update( new Element('span', {'class': 'glyphicon glyphicon-remove'}) )
					.observe('click', function() {
						$(txtBox).writeAttribute('disabled', false).value = '';
						$(txtBox).focus();
						$(tmp.me._htmlIDs.mapViewer).show();
						$(tmp.me._htmlIDs.editViewer).hide();
						$(this).remove();
					})
				})
			$(tmp.me._htmlIDs.mapViewer).show();
			$(tmp.me._htmlIDs.editViewer).hide();
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
		    tmp.markerMinWidth = (jQuery( document ).width() / 5);
		    tmp.infowindow.setContent('<div class="my-marker-div" style="min-width: ' + (tmp.markerMinWidth > 200 ? tmp.markerMinWidth : 200) + 'px;">'
		    		+ '<div><strong>' + tmp.place.name + '</strong></div>'
		    		+ '<div><small>' + tmp.address + '</small></div>'
		    		+ '<div><small>Is this the right address?</small></div>'
		    		+ '<div>'
		    			+ '<span class="btn btn-default btn-xs" onclick="pageJs.showAddrEditPanel();" title="No, it is NOT the address I meant">NO, manual enter</span> '
		    			+ '<span class="btn btn-success btn-xs pull-right" onclick="pageJs.confirmAddr();" title="Yes, it is">YES</span>'
		    		+ '</div>');
		    tmp.infowindow.open(tmp.map, tmp.marker);
		});
	}
	,_getEditPanel: function() {
		var tmp = {};
		tmp.me = this;
		tmp.newDiv = new Element('section')
			.insert({'bottom': new Element('div', {'class': 'row'})
				.insert({'bottom': new Element('div', {'class': 'col-sm-12', 'id': tmp.me._htmlIDs.mapViewer, 'style': 'min-height: 400px;'}) })
				.insert({'bottom': new Element('div', {'class': 'col-sm-12', 'id': tmp.me._htmlIDs.editViewer, 'style': 'min-height: 400px; display:none;'}) })
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
					.insert({'bottom': new Element('h4', {'class': 'col-sm-3'}).update('Adding Property @: ')
					})
					.insert({'bottom': new Element('div', {'class': 'input-group col-sm-9'})
						.insert({'bottom': tmp.searchBox = new Element('input', {'id': tmp.me._htmlIDs.addrSearchTxtBox, 'class': 'form-control', 'placeholder': 'Type in an address'}) })
					})
				})
			})
			.insert({'bottom': tmp.editPanel = tmp.me._getEditPanel() });
		$(tmp.me._htmlIDs.itemDivId).update(tmp.newDiv);
		tmp.me._bindAutoComplete(tmp.searchBox, tmp.editPanel);
		return tmp.me;
	}
	/**
	 * Showing the item
	 */
	,load: function(item) {
		var tmp = {};
		tmp.me = this;
		tmp.me._item = item;
		tmp.me._htmlIDs.mapViewer = 'map-viewer';
		tmp.me._htmlIDs.editViewer = 'property-edit-viewer';
		tmp.me._htmlIDs.addrSearchTxtBox = 'addr-search-box';
		tmp.me._showCreatingPanel();
		return tmp.me;
	}
});