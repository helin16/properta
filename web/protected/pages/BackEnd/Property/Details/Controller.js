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
			
			tmp.infowindow = new google.maps.InfoWindow();
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
		    tmp.infowindow.setContent('<div class="my-marker-div" style="min-width: ' + (tmp.markerMinWidth > 200 ? tmp.markerMinWidth : 200) + 'px;">'
		    		+ '<div>' + tmp.me._item.address.full + '</div>'
		    		+ '</div>');
		    tmp.infowindow.open(tmp.map, tmp.marker);
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
						.insert({'bottom': new Element('div', {'class': 'col-xs-4'})
							.insert({'bottom': new Element('div', {'class': 'input-group input-group-sm', 'title': 'No. Of Bedrooms'})
								.insert({'bottom': new Element('span', {'class': 'input-group-addon'}).update(new Element('span', {'class': 'fa fa-users'})) })
								.insert({'bottom': new Element('span', {'class': 'form-control'}).update(' ' + tmp.me._item.noOfRooms) })
							})
						})
						.insert({'bottom': new Element('div', {'class': 'col-xs-4'})
							.insert({'bottom': new Element('div', {'class': 'input-group input-group-sm', 'title': 'No. Of Bathrooms'})
							.insert({'bottom': new Element('span', {'class': 'input-group-addon'}).update(new Element('span', {'class': 'fa fa-cogs'})) })
								.insert({'bottom': new Element('span', {'class': 'form-control'}).update(' ' + tmp.me._item.noOfBaths) })
							})
						})
						.insert({'bottom': new Element('div', {'class': 'col-xs-4'})
							.insert({'bottom': new Element('div', {'class': 'input-group input-group-sm', 'title': 'No. Of Car Spaces'})
								.insert({'bottom': new Element('span', {'class': 'input-group-addon'}).update(new Element('span', {'class': 'fa fa-car'})) })
								.insert({'bottom': new Element('span', {'class': 'form-control'}).update(' ' + tmp.me._item.noOfCars) })
							})
						})
					})
				})
			})
			.insert({'bottom': new Element('div', {'class': 'row'})
				.insert({'bottom': new Element('div', {'class': 'col-sm-4 col-sm-push-8'})
					.insert({'bottom': new Element('div', {'class': 'panel panel-default'})
						.insert({'bottom': new Element('div', {'class': 'panel-body'})
							.insert({'bottom': new Element('div', {'class': 'col-sm-12'}).update(tmp.me._item.description) })
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
				.insert({'bottom': new Element('div', {'class': 'col-sm-8 col-sm-pull-4', 'id': tmp.me._htmlIDs.mapViewer, 'style': 'height: 400px;'}) })
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