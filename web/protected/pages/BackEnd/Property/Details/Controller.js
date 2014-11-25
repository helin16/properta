/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new BackEndPageJs(), {
	_item: {} //the item entity that we are dealing with
	/**
	 * Showing the google map
	 */
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
	/**
	 * Showing the history of the property
	 */
	,_showHistory: function(panel, pageNo, pageSize, succFunc, completeFunc) {
		var tmp = {};
		tmp.me = this;
		tmp.historyListDiv = panel.down('.period-tl');
		if(pageNo <= 1 && tmp.historyListDiv)
			return tmp.me;
		tmp.me.postAjax(tmp.me.getCallbackId('getHistory'), {'propertyId': tmp.me._item.sKey, 'pageNo': pageNo, 'pageSize': pageSize}, {
			'onLoading': function() {}
			,'onSuccess': function(sender, param) {
				try{
					tmp.result = tmp.me.getResp(param, false, true);
					if(!tmp.result || !tmp.result.items)
						return;
					
					if(!tmp.historyListDiv) {
						panel.update('').insert({'bottom': new Element('div', {'class': 'period-tl-div'})
							.insert({'bottom': tmp.historyListDiv = new Element('ul', {'class': 'period-tl'}) })
						});
					}
					tmp.result.items.each(function(item){
						tmp.historyListDiv.insert({'bottom': new Element('li') 
							.insert({'bottom': new Element('div', {'class': 'direction-r'}) 
								.insert({'bottom': new Element('div', {'class': 'flag-wrapper'}) 
									.insert({'bottom': new Element('div', {'class': 'flag'}).update(item.by) })
									.insert({'bottom': new Element('div', {'class': 'time-wrapper'}).update(tmp.me.loadUTCTime(item.whenUTC).toLocaleString()) })
								})
								.insert({'bottom': new Element('div', {'class': 'desc'}).update(item.comments) })
							})
						});
					});
					if(pageNo * 1 < tmp.result.pagination.totalPages) {
						tmp.historyListDiv.insert({'after': new Element('span', {'class': 'btn btn-success btn-sm', 'data-loading-text':"Getting More ..."})
							.update('Get More')
							.observe('click', function() {
								tmp.btn = $(this);
								tmp.me._signRandID(tmp.btn);
								jQuery('#' + tmp.btn.id).button('loading');
								tmp.me._showHistory(panel, (pageNo * 1 + 1), pageSize, function() {
									$(tmp.btn).remove();
								}, function () {
									jQuery('#' + tmp.btn.id).button('reset');
								});
							})
						});
					}
					if(typeof(succFunc) === 'function')
						succFunc();
				} catch (e) {
					tmp.me.showModalBox('<h4 class="text-danger">Error</h4>', e, true);
				}
			}
			,'onComplete': function() {
				if(typeof(completeFunc) === 'function')
					completeFunc();
			}
		})
		return tmp.me;
	}
	/***
	 * Getting the description tab panel
	 */
	,_getDescriptionTabPanel: function(property) {
		var tmp = {};
		tmp.me = this;
		tmp.newDiv = new Element('div', {'class': 'tab-pane'})
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
				.insert({'bottom': new Element('div', {'class': 'row'})
					.insert({'bottom': new Element('label', {'class': 'col-sm-12'}).update('Description:') 
						.insert({'bottom': new Element('small').update( new Element('em', {'class': 'text-danger pull-right'}).update('Description will be viewed by other users') ) }) 
					})
					.insert({'bottom': new Element('textarea', {'class': 'form-control', 'rows': 5}).update(property.description) })
				})
			});
		return tmp.newDiv;
	}
	/**
	 * Getting the group of tab panels
	 */
	,_getTabPanels: function(property) {
		var tmp = {};
		tmp.me = this;
		tmp.newDiv = new Element('div', {'class': 'tab-panels'})
			.insert({'bottom': new Element('ul', {'class': 'nav nav-tabs', 'role': 'tablist'})
				.insert({'bottom': new Element('li', {'role': 'presentation', 'class': 'active'})
					.insert({'bottom': new Element('a', {'href': '#tab-description', 'data-toggle': "tab", 'aria-controls': "tab-description", 'role': "tab"}).update('Description') })
				})
				.insert({'bottom': new Element('li', {'role': 'presentation'})
					.insert({'bottom': new Element('a', {'href': '#tab-people', 'data-toggle': "tab", 'aria-controls': "tab-people", 'role': "tab"}).update('People') })
				})
				.insert({'bottom': new Element('li', {'role': 'presentation'})
					.insert({'bottom': new Element('a', {'href': '#tab-files', 'data-toggle': "tab", 'aria-controls': "tab-files", 'role': "tab"}).update('Files') })
				})
				.insert({'bottom': new Element('li', {'role': 'presentation'})
					.insert({'bottom': new Element('a', {'href': '#tab-history', 'data-toggle': "tab", 'aria-controls': "tab-history", 'role': "tab"}).update('History')
						.observe('click', function() {
							tmp.me._showHistory($($(this).readAttribute('aria-controls')).down('.panel-body'), 1, 10);
						})
					})
				})
			})
			.insert({'bottom': new Element('div', {'class': 'tab-content'})
				.insert({'bottom': tmp.me._getDescriptionTabPanel(property).addClassName('active').writeAttribute('id', 'tab-description') })
				.insert({'bottom': new Element('div', {'class': 'tab-pane', 'id': 'tab-people'}).update ( new Element('div', {'class': 'panel-body'}).update(tmp.me._getLoadingDiv()) ) })
				.insert({'bottom': new Element('div', {'class': 'tab-pane', 'id': 'tab-files'}).update ( new Element('div', {'class': 'panel-body'}).update(tmp.me._getLoadingDiv()) ) })
				.insert({'bottom': new Element('div', {'class': 'tab-pane', 'id': 'tab-history'}).update ( new Element('div', {'class': 'panel-body'}).update(tmp.me._getLoadingDiv()) ) })
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
							.insert({'bottom': new Element('div', {'class': 'panel-group', 'id': 'left-pane-group'})
								.insert({'bottom': new Element('div', {'class': 'panel panel-default'})
									.insert({'bottom': new Element('div', {'class': 'panel-heading'})
										.insert({'bottom': new Element('h4', {'class': 'panel-title'})
											.insert({'bottom': new Element('a', {'data-toggle':"collapse", 'data-parent': "#left-pane-group", 'href':"#timeline-div", 'aria-expanded':"true"}).update('Messages:') })
										})
									})
									.insert({'bottom': new Element('div', {'id': "timeline-div", 'class': "panel-collapse collapse in", 'role': "tabpanel", 'aria-labelledby': "headingOne"})
										.insert({'bottom': new Element('div', {'class': 'panel-body'}).update('') })
									})
								})
							})
						})
					})
				})
				.insert({'bottom': new Element('div', {'class': 'col-sm-8 col-sm-pull-4'}).update(tmp.me._getTabPanels(tmp.me._item)) })
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