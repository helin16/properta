/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new BackEndPageJs(), {
	_item: {} //the item entity that we are dealing with
	,_showMap: function() {
		var tmp = {};
		tmp.me = this;
		$(tmp.me._htmlIDs.mapViewer).update(tmp.me._getLoadingDiv());
		jQuery.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + tmp.me._item.address.full, {
			format : "json"
		}).success(function(data) {
			if(!data.results || data.results.length === 0 || !data.results[0].geometry || !data.results[0].geometry.location)
				return;
			tmp.geoLocation = data.results[0].geometry.location;
			tmp.map = new google.maps.Map($(tmp.me._htmlIDs.mapViewer), {center: data.results[0].geometry.location, zoom: 13});
			
			tmp.marker = new google.maps.Marker({
				map : tmp.map,
				anchorPoint : new google.maps.Point(0, -29)
			});
			// If the place has a geometry, then present it on a map.
	    	tmp.map.setCenter(data.results[0].geometry.location);
	    	tmp.map.setZoom(17);  // Why 17? Because it looks good.
	    	
		    tmp.marker.setPosition(data.results[0].geometry.location);
		    tmp.marker.setVisible(true);
		    tmp.markerMinWidth = (jQuery( document ).width() / 5);
		});
		return tmp.me;
	}
	,_getTimeLineUL: function() {
		var tmp = {};
		tmp.me = this;
		tmp.newDiv = new Element('div', {'class': 'period-tl-div'})
			.insert({'bottom': new Element('ul', {'class': 'period-tl'})
				.insert({'bottom': new Element('li')
					.insert({'bottom': new Element('div', {'class': 'direction-r'})
						.insert({'bottom': new Element('div', {'class': 'flag-wrapper'})
							.insert({'bottom': new Element('span', {'class': 'flag'}).update('') })
							.insert({'bottom': new Element('div', {'class': 'time-wrapper'})
								.insert({'bottom': new Element('span', {'class': 'time'}).update('May 2011 - Present') })
							})
						})
						.insert({'bottom': new Element('div', {'class': 'desc'}).update('Joined themeforest, the best place to sell your work arround the world') })
					})
				})
				.insert({'bottom': new Element('li')
					.insert({'bottom': new Element('div', {'class': 'direction-r'})
						.insert({'bottom': new Element('div', {'class': 'flag-wrapper'})
							.insert({'bottom': new Element('span', {'class': 'flag'}).update('') })
							.insert({'bottom': new Element('div', {'class': 'time-wrapper'})
								.insert({'bottom': new Element('span', {'class': 'time'}).update('May 2011 - Present') })
							})
						})
						.insert({'bottom': new Element('div', {'class': 'desc'}).update('Joined themeforest, the best place to sell your work arround the world') })
					})
				})
			});
		return tmp.newDiv;
	}
	,_getMainPanel: function(property) {
		var tmp = {};
		tmp.me = this;
		tmp.newDiv = new Element('div')
			.insert({'bottom': new Element('ul', {'class': 'nav nav-tabs', 'role': 'tablist'})
				.insert({'bottom': new Element('li', {'role': 'presentation', 'class': 'active'})
					.insert({'bottom': new Element('a', {}).update('Description') })
				})
				.insert({'bottom': new Element('li', {'role': 'presentation'})
					.insert({'bottom': new Element('a', {}).update('History') })
				})
			})
			.insert({'bottom': new Element('div', {'class': 'tab-content'})
				.insert({'bottom': new Element('div', {'class': 'tab-pane active'})
					.insert({'bottom': new Element('div', {'class': 'panel-body'})
						.insert({'bottom': new Element('div', {'class': 'row'})
							.insert({'bottom': new Element('div', {'class': 'col-sm-4'})
								.insert({'bottom': new Element('div', {'class': 'input-group input-group-sm', 'title': 'No. Of Bedrooms'})
									.insert({'bottom': new Element('span', {'class': 'input-group-addon'}).update('No. Of Bedrooms:') })
									.insert({'bottom': new Element('span', {'class': 'form-control', 'type': 'number'}).update(' ' + tmp.me._item.noOfRooms) })
								})
							})
							.insert({'bottom': new Element('div', {'class': 'col-sm-4'})
								.insert({'bottom': new Element('div', {'class': 'input-group input-group-sm', 'title': 'No. Of Bathrooms:'})
								.insert({'bottom': new Element('span', {'class': 'input-group-addon'}).update('No. Of Bedrooms:') })
									.insert({'bottom': new Element('span', {'class': 'form-control', 'type': 'number'}).update(' ' + tmp.me._item.noOfBaths) })
								})
							})
							.insert({'bottom': new Element('div', {'class': 'col-sm-4'})
								.insert({'bottom': new Element('div', {'class': 'input-group input-group-sm', 'title': 'No. Of Car Spaces'})
									.insert({'bottom': new Element('span', {'class': 'input-group-addon'}).update('No. Of Carspaces:') })
									.insert({'bottom': new Element('span', {'class': 'form-control', 'type': 'number'}).update(' ' + tmp.me._item.noOfCars) })
								})
							})
						})
						.insert({'bottom': new Element('div', {'class': 'form-group'})
							.insert({'bottom': new Element('label').update('Description:') })
							.insert({'bottom': new Element('textarea', {'class': 'form-control', 'rows': 5}).update(property.description) })
						})
					})
				})
			})
		return tmp.newDiv;
	}
	/**
	 * Showing the editing panel
	 */
	,_showEditPanel: function() {
		var tmp = {};
		tmp.me = this;
		tmp.newDiv = new Element('div')
			.insert({'bottom': new Element('div', {'class': 'page-header'})
				.insert({'bottom': new Element('div', {'class': 'row'})
					.insert({'bottom': new Element('h4', {'class': 'col-sm-8'}).update(tmp.me._item.address.full) })
					.insert({'bottom': new Element('div', {'class': 'col-sm-4'})
					})
				})
			})
			.insert({'bottom': new Element('div', {'class': 'row'})
				.insert({'bottom': new Element('div', {'class': 'col-sm-4 col-sm-push-8'})
					.insert({'bottom': new Element('div', {'class': 'panel panel-default'})
						.insert({'bottom': new Element('div', {'class': 'panel-body'})
							.insert({'bottom': new Element('div', {'class': 'col-sm-12', 'id': tmp.me._htmlIDs.mapViewer, 'style': 'height: 200px;'}) })
						})
					})
					.insert({'bottom': new Element('div', {'class': 'row'})
						.insert({'bottom': new Element('div', {'class': 'col-sm-12'})
							.insert({'bottom': new Element('div', {'class': 'panel-group', 'id': 'accordion'})
								.insert({'bottom': new Element('div', {'class': 'panel panel-default'})
									.insert({'bottom': new Element('div', {'class': 'panel-heading'})
										.insert({'bottom': new Element('h4', {'class': 'panel-title'})
											.insert({'bottom': new Element('a', {'data-toggle':"collapse", 'data-parent': "#accordion", 'href':"#timeline-div", 'aria-expanded':"true"}).update('Time Line:') })
										})
									})
									.insert({'bottom': new Element('div', {'id': "timeline-div", 'class': "panel-collapse collapse", 'role': "tabpanel", 'aria-labelledby': "headingOne"})
										.insert({'bottom': new Element('div', {'class': 'panel-body'}).update(tmp.me._getTimeLineUL()) })
									})
								})
								.insert({'bottom': new Element('div', {'class': 'panel panel-default'})
									.insert({'bottom': new Element('div', {'class': 'panel-heading'})
										.insert({'bottom': new Element('h4', {'class': 'panel-title'})
											.insert({'bottom': new Element('a', {'data-toggle':"collapse", 'data-parent': "#accordion", 'href':"#timeline-div1", 'aria-expanded':"true"}).update('Time Line:') })
										})
									})
									.insert({'bottom': new Element('div', {'id': "timeline-div1", 'class': "panel-collapse collapse", 'role': "tabpanel", 'aria-labelledby': "headingOne"})
										.insert({'bottom': new Element('div', {'class': 'panel-body'}).update(tmp.me._getTimeLineUL()) })
									})
								})
							})
						})
					})
				})
				.insert({'bottom': new Element('div', {'class': 'col-sm-8 col-sm-pull-4'}).update(tmp.me._getMainPanel(tmp.me._item)) })
			})
		$(tmp.me._htmlIDs.itemDivId).update(tmp.newDiv);
		tmp.me._showMap();
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
		tmp.me._showEditPanel();
		return tmp.me;
	}
});