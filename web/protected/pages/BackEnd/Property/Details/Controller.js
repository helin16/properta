/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new BackEndPageJs(), {
	_item: {} //the item entity that we are dealing with
	,_counts: {} //the counts of the attributes
	,_roles: [] //the roles
	,_can: {} //whether this user can do something
	,_fileReader: null // file uploader
	,_acceptableTypes: ['csv', 'jpg', 'jpeg', 'png']
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
		tmp.me.postAjax(tmp.me.getCallbackId('getHistory'), {'propertyId': tmp.me._item.sKey, 'pageNo': pageNo, 'pageSize': pageSize}, {
			'onLoading': function() {}
			,'onSuccess': function(sender, param) {
				try{
					tmp.result = tmp.me.getResp(param, false, true);
					if(!tmp.result || !tmp.result.items)
						return;
					
					if(pageNo <= 1) {
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
		});
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
							.insert({'bottom': new Element('span', {'class': 'form-control save-field', 'type': 'number', 'data-save-field': 'noOfRooms', 'data-type': 'input'}).update(tmp.me._item.noOfRooms) 	})
						})
					})
					.insert({'bottom': new Element('div', {'class': 'col-sm-4'})
						.insert({'bottom': new Element('div', {'class': 'input-group input-group-sm', 'title': 'No. Of Bathrooms:'})
							.insert({'bottom': new Element('span', {'class': 'input-group-addon'}).update('No. Of Bedrooms:') })
							.insert({'bottom': new Element('span', {'class': 'form-control save-field', 'type': 'number', 'data-save-field': 'noOfBaths', 'data-type': 'input'}).update(tmp.me._item.noOfBaths) })
						})
					})
					.insert({'bottom': new Element('div', {'class': 'col-sm-4'})
						.insert({'bottom': new Element('div', {'class': 'input-group input-group-sm', 'title': 'No. Of Car Spaces'})
							.insert({'bottom': new Element('span', {'class': 'input-group-addon'}).update('No. Of Carspaces:') })
							.insert({'bottom': new Element((tmp.me._can.changeDetails === true ? 'input' : 'span'), {'class': 'form-control save-field', 'type': 'number', 'data-save-field': 'noOfCars', 'data-type': 'input'}).update(tmp.me._item.noOfCars) })
						})
					})
				})
				.insert({'bottom': new Element('div', {'class': 'row'})
					.insert({'bottom': new Element('label', {'class': 'col-sm-12'}).update('Description:') 
						.insert({'bottom': tmp.me._can.changeDetails !== true ? '' : new Element('small').update( new Element('em', {'class': 'text-danger pull-right'}).update('Description will be viewed by other users') ) }) 
					})
					.insert({'bottom': new Element('label', {'class': 'col-sm-12'})
						.insert({'bottom': new Element('div', {'class': 'save-field', 'rows': '5', 'data-save-field': 'description', 'data-type': 'textarea'})
							.update( new Element('div', {'style': 'min-height: 100px;border: 1px #ccc solid; padding: 8px; border-radius: 4px;'}).update(tmp.me._item.description) )  
						})
					})
				})
			});
		return tmp.newDiv;
	}
	,_getUserRow: function(item) {
		var tmp = {};
		tmp.me = this;
		tmp.tr = new Element('tr', {'class': 'prop-rel-row', 'user-id': item.id}).store('data', item)
			.insert({'bottom': new Element('td').update(item.name) });
		tmp.me._roles.each(function(role){
			tmp.hasRole = (item.roleIds.indexOf(role.id) > -1);
			tmp.tr.insert({'bottom': new Element('td', {'role-id': role.id})
				.insert({'bottom': tmp.me._can.changeDetails !== true ? 
					new Element('span', {'class': (tmp.hasRole === true ? 'text-success': '')}).update(new Element('span', {'class': (tmp.hasRole === true ? 'glyphicon glyphicon-ok-sign' : '') }))
					:
					new Element('input', {'type': 'checkbox', 'checked': tmp.hasRole, 'role-id': role.id})
						.observe('click', function() {
							if(!item.newUser)
								tmp.me._confirmRel(item, [role], $(this), $(this).checked ? 'create' : 'delete');
						})
				})
			});
		});
		if(item.newUser){
			tmp.tr.getElementsBySelector('td').pop()
			.insert({'bottom': new Element('div', {'class': 'new-user-btn-group pull-right'})
				.insert({'bottom': new Element('a', {'class': 'user-save-btn', 'href': 'javascript: void(0)'})
					.insert({'bottom': new Element('i', {'class': 'fa fa-floppy-o', 'style': 'padding: 0 2px'}) 
						.observe('click', function(){
							tmp.newUserRoles = [];
							$(this).up('.prop-rel-row').getElementsBySelector('[role-id]').each(function(item){
								if(item.checked)
									tmp.newUserRoles.push( {'id': item.readAttribute('role-id')} );
							});
							tmp.me._confirmRel($(this).up('.prop-rel-row').retrieve('data'), tmp.newUserRoles, this, 'addUser');
						})
					})
				})
				.insert({'bottom': new Element('a', {'class': 'user-save-btn', 'href': 'javascript: void(0)'})
					.insert({'bottom': new Element('i', {'class': 'fa fa-times', 'style': 'padding: 0 2px'}) 
						.observe('click', function(){
							tmp.me._confirmDelUserRel(this,this.up('.prop-rel-row').retrieve('data'));
						})
					})
				})
			});
		}
		return tmp.tr;
	}
	/**
	 * show the panel of displaying the confirmation box for adding a propertyrel
	 */
	,_confirmDelUserRel: function (btn, user) {
		var tmp = {};
		tmp.me = this;
		tmp.newDiv = new Element('div', {'class': 'update-rel-panel'})
			.insert({'bottom': new Element('div').update('You are about to remove' + ' user(' + user.name + ') for this property.')})
			.insert({'bottom': new Element('div').update('Countinue?')})
			.insert({'bottom': new Element('div', {'class': 'msg-panel'}) })
			.insert({'bottom': new Element('div', {'class': 'row'})
				.insert({'bottom': new Element('span', {'class': 'col-sm-4 btn btn-danger', 'data-loading-text': "Saving ..."})
					.update('YES')
					.observe('click', function(){
						btn.up('.prop-rel-row').remove();
						tmp.me.hideModalBox();
					})
				})
				.insert({'bottom': new Element('span', {'class': 'col-sm-4 col-sm-offset-4 btn btn-default'})
					.update('NO')
					.observe('click', function(){
						tmp.me.hideModalBox();
					})
				})
			});
		tmp.me.showModalBox('Confirm', tmp.newDiv, false);
		return tmp.me;
	}
	/**
	 * Ajax: creating PropertyRef
	 */
	,_submitRel: function (btn, user, roles, action) {
		var tmp = {};
		tmp.me = this;
		tmp.btn = btn;
		tmp.me._signRandID(tmp.btn);
		tmp.me.postAjax(tmp.me.getCallbackId('saveRel'), {'firstName': user.firstName ? user.firstName : '', 'lastName': user.lastName ? user.lastName : '', 'email': user.email ? user.email : '', 'propertyId': tmp.me._item.sKey, 'userId': user.id, 'roleId': roles, 'action': action}, {
			'onLoading': function() {
				tmp.btn.up('.update-rel-panel').down('.msg-panel').update('');
				jQuery('#' + tmp.btn.id).button('loading');
			}
			,'onSuccess': function (sender, param) {
				try {
					tmp.result = tmp.me.getResp(param, false, true);
					if(!tmp.result || !tmp.result.item)
						return;
					tmp.row = $$('.prop-rel-row[user-id=' + tmp.result.item.id + ']');
					if(tmp.row.size() > 0)
						tmp.row.first().replace(tmp.me._getUserRow(tmp.result.item));
					tmp.btn.up('.update-rel-panel').down('.msg-panel').update(tmp.me.getAlertBox('Success: ', 'Saved successfully.').addClassName('alert-success'));
					tmp.me.hideModalBox();
				} catch(e) {
					tmp.btn.up('.update-rel-panel').down('.msg-panel').update(tmp.me.getAlertBox('Error: ', e).addClassName('alert-danger'));
				}
			}
			,'onComplete': function() {
				jQuery('#' + tmp.btn.id).button('reset');
			}
		});
		return tmp.me;
	}
	/**
	 * show the panel of displaying the confirmation box for adding a propertyrel
	 */
	,_confirmRel: function (user, roles, btn, action) {
		var tmp = {};
		tmp.me = this;
		tmp.newDiv = new Element('div', {'class': 'update-rel-panel'})
			.insert({'bottom': new Element('div').update('You are about to ' + (((action.strip() === 'create') || (action.strip() === 'addUser') ) ? 'add' : 'remove') + ' user (' + user.name + ')' + ((action.strip() === 'addUser') ? ' to ' : (' to the ' + roles.name + ' of ')) + 'this property.')})
			.insert({'bottom': new Element('div').update('Countinue?')})
			.insert({'bottom': new Element('div', {'class': 'msg-panel'}) })
			.insert({'bottom': new Element('div', {'class': 'row'})
				.insert({'bottom': new Element('span', {'class': 'col-sm-4 btn btn-' + (action.strip()  === 'create' ? 'primary' : 'danger'), 'data-loading-text': "Saving ..."})
					.update('YES')
					.observe('click', function(){
						tmp.me._submitRel(this, user, roles, action);
					})
				})
				.insert({'bottom': new Element('span', {'class': 'col-sm-4 col-sm-offset-4 btn btn-default'})
					.update('NO')
					.observe('click', function(){
						if($(btn) && $(btn).readAttribute('type') === 'checkbox')
							$(btn).checked = false;
						tmp.me.hideModalBox();
					})
				})
			});
		tmp.me.showModalBox('Confirm', tmp.newDiv, false);
		return tmp.me;
	}
	/**
	 * getting file manager
	 */
	,_showFileManager: function(panel) {
		var tmp = {};
		tmp.me = this;
		if(panel.hasClassName('loaded'))
			return tmp.me;
		tmp.me._fileReader = new FileReader();
		
		tmp.FileUploadDiv = new Element('div',  {'class': 'panel panel-default drop_file_div', 'title': 'You can drag multiple files here!'})
		.insert({'bottom': new Element('div', {'class': 'panel-body'})
			.insert({'bottom': new Element('div', {'class': 'form-group center-block text-left', 'style': 'width: 50%'})
				.insert({'bottom': new Element('label').update('Drop you files here or select your file below:') })
				.insert({'bottom': tmp.inputFile = new Element('input', {'type': 'file', 'style': 'display: none;', 'multiple': true}) 
					.observe('change', function(event) {
						tmp.me._readFiles(event.target.files, panel);
					})
				})
				.insert({'bottom': new Element('div', {'class': 'clearfix'}) })
				.insert({'bottom': new Element('span', {'class': 'btn btn-success clearfix'})
					.update('Click to select your file')
					.observe('click', function(event) {
						tmp.inputFile.click();
					})
				})
				.insert({'bottom': new Element('div', {'class': 'clearfix'}) })
				.insert({'bottom': new Element('small').update('ONLY ACCEPT file formats: ' + tmp.me._acceptableTypes.join(', ')) })
			})
		})
		.observe('dragover', function(evt) {
			evt.stopPropagation();
			evt.preventDefault();
			evt.dataTransfer.dropEffect = 'copy';
		})
		.observe('drop', function(evt) {
			evt.stopPropagation();
			evt.preventDefault();
			tmp.me._readFiles(evt.dataTransfer.files);
		})
	;
		
		panel.addClassName('loaded').update(new Element('div', {'class': 'file-upload-div'})
			.insert({'bottom': tmp.FileUploadDiv})
		);
		return tmp.me;
	}
	
	,_readFiles: function(files, panel) {
		var tmp = {};
		tmp.me = this;
		tmp.panel = panel;
		tmp.me._uploadedData = {};
		tmp.fileLists = new Element('div', {'class': 'list-group'});
		tmp.allFilesSupported = true;
		for(tmp.i = 0, tmp.file; tmp.file = files[tmp.i]; tmp.i++) {
			tmp.fileRow = new Element('div', {'class': 'row'}).update( new Element('div', {'class': 'col-lg-6 col-md-6'}).update(tmp.file.name) );
			if((tmp.extension = tmp.file.name.split('.').pop()) !== '' && tmp.me._acceptableTypes.indexOf(tmp.extension.toLowerCase()) > -1) {
				tmp.me._fileReader = new FileReader();
				tmp.me._fileReader.onload = function(event) {
					event.target.result.split(/\r\n|\n|\r/).each(function(line) {
						if(line !== null && !line.blank()) {
							tmp.cols = [];
							line.split(',').each(function(col) {
								if(col !== null && !col.blank()) {
									tmp.cols.push(col.strip());
								}
							})
							tmp.key = tmp.cols.join(',');
						}
					})
				}
				tmp.me._fileReader.readAsText(tmp.file);
				tmp.supported = true;
			} else {
				tmp.fileRow.insert({'bottom': new Element('div', {'class': 'col-lg-6 col-md-6'}).update(new Element('small').update('Not supported file extension: ' + tmp.extension) )})
				tmp.supported = false;
				tmp.allFilesSupported = false;
			}
			tmp.fileLists.insert({'bottom': new Element('div', {'class': 'list-group-item ' + (tmp.supported === true ? 'list-group-item-success' : 'list-group-item-danger')})
				.insert({'bottom': tmp.fileRow })
			});
		}
		$(tmp.panel).update(
			new Element('div', {'class': 'panel panel-default'})
			.insert({'bottom': new Element('div', {'class': 'panel-heading'})
				.update('Files Selected:')
				.insert({'bottom': new Element('small', {'class': 'pull-right'}).update('ONLY ACCEPT file formats: ' + tmp.me._acceptableTypes.join(', ')) })
			})
			.insert({'bottom': tmp.fileLists })
			.insert({'bottom': new Element('div', {'class': 'panel-footer'})
				.insert({'bottom': new Element('span', {'class': 'btn btn-success start-upload-btn', 'disabled': !tmp.allFilesSupported})
					.update(tmp.allFilesSupported ? 'Start' : 'Not supported file extension!')
					.observe('click', function() {
						console.debug('you clicked the upload file btn');
						// whatever after upload
					})
				})
				.insert({'bottom': new Element('span', {'class': 'btn btn-warning pull-right'})
					.update('Cancel')
					.observe('click', function(){
						tmp.me._showFileManager($(tmp.panel).removeClassName('loaded') );
					})
				})
			})
		);
		return tmp.me;
	}
	
	/**
	 * getting the list of people for this property
	 */
	,_showPeople: function(panel) {
		var tmp = {};
		tmp.me = this;
		if(panel.hasClassName('loaded'))
			return tmp.me;
		
		tmp.me.postAjax(tmp.me.getCallbackId('getPeople'), {'propertyId': tmp.me._item.sKey}, {
			'onLoading': function() {}
			,'onSuccess': function(sender, param) {
				try{
					tmp.result = tmp.me.getResp(param, false, true);
					if(!tmp.result || !tmp.result.items)
						return;
					tmp.table = new Element('table', {'class': 'table'})
						.insert({'bottom': tmp.thead = new Element('thead')
							.insert({'bottom': tmp.theadTR = new Element('tr')
								.insert({'bottom': new Element('th')
									.insert({'bottom': new Element('span', {'class': 'pull-left'}).update('User') })
									.insert({'bottom': tmp.me._can.changeDetails!== true ? '' : new Element('a', {'href': 'javascript: void(0);', 'class': 'new-user-btn visible-xs visible-sm visible-lg visible-md pull-left', 'style': 'padding: 0 3px'})
										.insert({'bottom': new Element('i', {'class': 'glyphicon glyphicon-plus-sign'}) })
									})
								})
							})
						})
						.insert({'bottom': tmp.tbody = new Element('tbody') });
					tmp.me._roles.each(function(role){
						tmp.theadTR.insert({'bottom': new Element('th').update(role.name) });
					});
					$H(tmp.result.items).each(function(item){
						tmp.tbody.insert({'bottom': tmp.me._getUserRow(item.value) });
					});
					
					
					
					panel.update(tmp.table).addClassName('loaded');
					panel.getElementsBySelector('.new-user-btn').each(function(item){
						tmp.exsitingPersonIds = [];
						$$('.prop-rel-row').each(function(item){
							tmp.exsitingPersonIds.push(item.readAttribute('user-id'));
						});
						tmp.userAutoCompleteJs = new UserAutoCompleteJs(tmp.me, tmp.exsitingPersonIds);
						tmp.userAutoCompleteJs.loadPopOver(item, function(selectedData) {
							selectedData.name = (selectedData.firstName || selectedData.lastName) ? (selectedData.firstName + ' ' + selectedData.lastName) : selectedData.email;
							selectedData.roleIds = [];
							selectedData.newUser = true;
							$$('.prop-rel-row[user-id]').first()
								.insert({'before': tmp.me._getUserRow(selectedData).addClassName('success') });
//								
						}
						,function(event){
							tmp.newUserData = {};
							$(event.target).up('.new-user-row').getElementsBySelector('[user-auto-new]').each(function(item){
								tmp.newUserData[item.readAttribute('user-auto-new')]= $F(item);
							});
							tmp.newUserData.id = '';
							tmp.newUserData.roleIds = [];
							tmp.newUserData.newUser = true;
							tmp.newUserData.name = (tmp.newUserData.firstName || tmp.newUserData.lastName) ? (tmp.newUserData.firstName + ' ' + tmp.newUserData.lastName) : tmp.newUserData.email;
							$$('.prop-rel-row[user-id]').first()
								.insert({'before': tmp.me._getUserRow(tmp.newUserData).addClassName('success') });
						});
						item.store('userAutoCompleteJs', tmp.userAutoCompleteJs);
					});
				} catch (e) {
					tmp.me.showModalBox('<h4 class="text-danger">Error</h4>', e, true);
				}
			}
			,'onComplete': function() {}
		});
		return tmp.me;
	}
	,_getNewUserRow: function() {
		var tmp = {};
		tmp.me = this;
		tmp.tr = new Element('tr', {'class': 'prop-rel-row', 'user-id': 'new-user'})
			.insert({'bottom': new Element('td')
				.insert({'bottom': new Element('a', {'href': 'javascript: void(0);', 'class': 'new-user-btn visible-xs visible-sm visible-lg visible-md', 'style': 'display: "inline-block !important"'})
					.insert({'bottom': new Element('i', {'class': 'glyphicon glyphicon-plus-sign'}) })
				})
			});
		tmp.me._roles.each(function(role){
			tmp.hasRole = false;
			tmp.tr.insert({'bottom': new Element('td', {'class': 'new-user-role', 'role': role.id})
			});
		});
		return tmp.tr;
	}
	,_getNewUserPanel: function(btn) {
		var tmp = {};
		tmp.me = this;
		tmp.me._signRandID(btn);
		if(!jQuery('#' + btn.id).hasClass('popover-loaded') ) {
			jQuery('#' + btn.id).popover({
				'title'    : function(){
					return new Element('div', {'class': 'new-user-search-box-container', 'role': btn.up('td').readAttribute('role')})
					.insert({'bottom': new Element('input', {'class': 'new-user-search-box'}) 
						.observe('keyup', function(event){
							Event.stop(event);
							tmp.me.postAjax(tmp.me.getCallbackId('getNewPeople'), {'searchText': $F(this)}, {
								'onLoading': function() {
								}
								,'onSuccess': function(sender, param) {
									try{
										tmp.result = tmp.me.getResp(param, false, true);
										tmp.serchTxt = $F($$('.new-user-search-box').first());
										if(tmp.serchTxt.length === 0)
											$$('.new-user-search-result-container tbody').first().innerHTML = '';
										tmp.result.items.each(function(user){
											tmp.me.rowMatched = false;
											$$('.new-user-search-result-container .new-user-result-row').each(function(item){
												if(tmp.serchTxt.length && item.retrieve('data').id && item.retrieve('data').id != user.id) {
													item.remove();
												}
												if(tmp.serchTxt.length && item.retrieve('data').id && item.retrieve('data').id == user.id) {
													tmp.me.rowMatched = true;
												}
											});
											if(tmp.me.rowMatched === false)
												$$('.new-user-search-result-container tbody').first().insert({'bottom': tmp.me._getUserResultRow(user) });
										});
									} catch (e) {
										tmp.me.showModalBox('<h4 class="text-danger">Error</h4>', e, true);
									}
								}
								,'onComplete': function() {
								}
							});
						})
					})
					.insert({'bottom': new Element('a', {'href': 'javascript: void(0);'})
						.insert({'bottom': new Element('i', {'class': 'pull-right glyphicon glyphicon-remove'}) })
						.observe('click', function(event){
							Event.stop(event);
							jQuery('#' + btn.id).popover('hide');
						})
					})
					;
				},
				'html'     : true, 
				'placement': 'bottom',
				'container': 'body', 
				'trigger'  : 'manual', 
				'viewport' : {},
				'content'  : function(){
					return new Element('table', {'class': 'table table-striped table-hover new-user-search-result-container'})
						.insert({'bottom': new Element('tbody') });
				},
				'template' : '<div class="popover" role="tooltip" style="max-width: none; z-index: 0;"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
			})
			.addClass('popover-loaded');
		}
		jQuery('#' + btn.id).popover('toggle');
		return tmp.me;
	}
	,_getUserResultRow: function(row) {
		var tmp = {};
		tmp.me = this;
		return new Element('tr', {'class': 'row container-fluid new-user-result-row'})
			.store('data',row)
			.insert({'bottom': new Element('td', {'class': ''}).update(row.firstName) })
			.insert({'bottom': new Element('td', {'class': ''}).update(row.lastName) })
			.insert({'bottom': new Element('td', {'class': ''}).update(row.email) })
			.observe('click', function(event){
				Event.stop(event);
				tmp.me.postAjax(tmp.me.getCallbackId('saveRel'), {'userId': this.retrieve('data').id, 'propertyId': tmp.me._item.sKey, 'roleId': this.up('.popover').down('.new-user-search-box-container').readAttribute('role'), 'action': 'create'}, {
					'onLoading': function() {
						$$('.new-user-search-box').first().button('loading');
					}
					,'onSuccess': function(sender, param) {
						try{
							tmp.result = tmp.me.getResp(param, false, true);
						} catch (e) {
							tmp.me.showModalBox('<h4 class="text-danger">Error</h4>', e, true);
						}
					}
					,'onComplete': function() {
						$$('.new-user-search-box').first().button('reset');
					}
				});
			})
			;
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
					.insert({'bottom': new Element('a', {'href': '#tab-description', 'data-toggle': "tab", 'aria-controls': "tab-description", 'role': "tab"}).update('Overview') })
				})
				.insert({'bottom': new Element('li', {'role': 'presentation'})
					.insert({'bottom': new Element('a', {'href': '#tab-people', 'data-toggle': "tab", 'aria-controls': "tab-people", 'role': "tab"})
						.update('People ') 
						.insert({'bottom': (tmp.me._counts.people ? new Element('span', {'class': 'badge'}).update(tmp.me._counts.people) : null) })
						.observe('click', function() {
							tmp.me._showPeople($($(this).readAttribute('aria-controls')).down('.panel-body'));
						})
					})
				})
				.insert({'bottom': tmp.me._can.changeDetails !== true ? '' :  new Element('li', {'role': 'presentation'})
					.insert({'bottom': new Element('a', {'href': '#tab-files', 'data-toggle': "tab", 'aria-controls': "tab-files", 'role': "tab"})
						.update('Files ') 
						.insert({'bottom': (tmp.me._counts.files ? new Element('span', {'class': 'badge'}).update(tmp.me._counts.files) : null) 
						})
						.observe('click', function() {
							tmp.me._showFileManager($($(this).readAttribute('aria-controls')).down('.panel-body'));
						})
					})
				})
				.insert({'bottom': new Element('li', {'role': 'presentation'})
					.insert({'bottom': new Element('a', {'href': '#tab-leases', 'data-toggle': "tab", 'aria-controls': "tab-leases", 'role': "tab"})
						.update('Leases ')
						.insert({'bottom': (tmp.me._counts.leases ? new Element('span', {'class': 'badge'}).update(tmp.me._counts.leases) : null) })
					})
				})
				.insert({'bottom': tmp.me._can.changeDetails !== true ? '' : new Element('li', {'role': 'presentation'})
					.insert({'bottom': new Element('a', {'href': '#tab-leger', 'data-toggle': "tab", 'aria-controls': "tab-leger", 'role': "tab"}).update('Inspections') })
				})
				.insert({'bottom': tmp.me._can.changeDetails !== true ? '' : new Element('li', {'role': 'presentation'})
					.insert({'bottom': new Element('a', {'href': '#tab-history', 'data-toggle': "tab", 'aria-controls': "tab-history", 'role': "tab"}).update('History')
						.observe('click', function() {
							tmp.me._showHistory($($(this).readAttribute('aria-controls')).down('.panel-body'), 1, 10);
						})
					})
				})
				.insert({'bottom': new Element('li', {'role': 'presentation'})
					.insert({'bottom': new Element('a', {'href': '#tab-leger', 'data-toggle': "tab", 'aria-controls': "tab-leger", 'role': "tab"}).update('Leger') })
				})
			})
			.insert({'bottom': new Element('div', {'class': 'tab-content'})
				.insert({'bottom': tmp.me._getDescriptionTabPanel(property).addClassName('active').writeAttribute('id', 'tab-description') })
				.insert({'bottom': new Element('div', {'class': 'tab-pane', 'id': 'tab-people'}).update ( new Element('div', {'class': 'panel-body'}).update(tmp.me._getLoadingDiv()) ) })
				.insert({'bottom': new Element('div', {'class': 'tab-pane', 'id': 'tab-files'}).update ( new Element('div', {'class': 'panel-body'}).update(tmp.me._getLoadingDiv()) ) })
				.insert({'bottom': new Element('div', {'class': 'tab-pane', 'id': 'tab-leases'}).update ( new Element('div', {'class': 'panel-body'}).update(tmp.me._getLoadingDiv()) ) })
				.insert({'bottom': new Element('div', {'class': 'tab-pane', 'id': 'tab-history'}).update ( new Element('div', {'class': 'panel-body'}).update(tmp.me._getLoadingDiv()) ) })
				.insert({'bottom': new Element('div', {'class': 'tab-pane', 'id': 'tab-leger'}).update ( new Element('div', {'class': 'panel-body'}).update(tmp.me._getLoadingDiv()) ) })
			});
		return tmp.newDiv;
	}
	/**
	 * Getting the rental coverage bar
	 */
	,_rentalCoverageBar: function(property) {
		var tmp = {};
		tmp.me = this;
		tmp.newDiv = new Element('div')
			.insert({"bottom": new Element('div').update('<strong>Rental Coverage:</strong>') })
			.insert({"bottom": new Element('div', {'class': 'progress rental-cover-bar'})
				.insert({'bottom': new Element('div', {'class': 'progress-bar progress-bar-success', 'role': 'progress-bar', 'aria-valuenow': '40', 'aria-valuemin': '0', 'aria-valuemax': '100', 'style': 'width: 40%'})
					.insert({'bottom': new Element('div', {'class': 'sr-only1'}).update('40%') })
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
					.insert({'bottom': new Element('div', {'class': 'col-sm-4'}) })
				})
			})
			.insert({'bottom': new Element('div', {'class': 'row'}).update( new Element('div', {'class': 'col-sm-12','id': tmp.me._htmlIDs.msgDiv}) ) })
			.insert({'bottom': new Element('div', {'class': 'row'})
				.insert({'bottom': new Element('div', {'class': 'col-sm-8'}).update(tmp.me._getTabPanels(tmp.me._item)) })
				.insert({'bottom': new Element('div', {'class': 'col-sm-4'})
					.insert({'bottom': new Element('div', {'class': 'panel panel-default'})
						.insert({'bottom': new Element('div', {'class': 'panel-body'}).update(tmp.me._rentalCoverageBar(tmp.me._item))	})
					})
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
			});
		$(tmp.me._htmlIDs.itemDivId).update(tmp.newDiv);
		tmp.me._showMap();
		return tmp.me;
	}
	,_updateDetails: function(field, data) {
		var tmp = {};
		tmp.me = this;
		tmp.me.postAjax(tmp.me.getCallbackId('updateDetails'), {'propertyId': tmp.me._item.sKey, 'field': field, 'data': data}, {
			'onSuccess': function(sender, param) {
				try {
					tmp.result = tmp.me.getResp(param, false, true);
					if(!tmp.result || !tmp.result.item)
						return;
					tmp.me._item = tmp.result.item;
					$(tmp.me._htmlIDs.msgDiv).update(tmp.me.getAlertBox('Success: ', field + ' is now: ' + data).addClassName('alert-success'));
				} catch (e) {
					$(tmp.me._htmlIDs.msgDiv).update(tmp.me.getAlertBox('ERROR: ', e).addClassName('alert-danger'));
				}
			}
		})
		return tmp.me;
	}
	,_loadFormForDetails: function() {
		var tmp = {};
		tmp.me = this;
		jQuery.each(jQuery('.save-field[data-save-field]'), function(index, element){
			tmp.newElement = jQuery('<' + (jQuery(element).attr('data-type') ? jQuery(element).attr('data-type') : 'input') + '/>');
			jQuery.each(jQuery(element)[0].attributes, function(i, attrib){
				tmp.newElement.attr(attrib.name, attrib.value);
			});
			tmp.newElement.addClass('form-control').val(jQuery(element).text());
			jQuery(element).replaceWith(tmp.newElement);
			tmp.newElement.change(function() {
				tmp.me._updateDetails(jQuery(element).attr('data-save-field'), jQuery(this).val());
			});
		});
		return tmp.me;
	}
	/**
	 * Showing the item
	 */
	,load: function(item) {
		var tmp = {};
		tmp.me = this;
		tmp.me._htmlIDs.mapViewer = 'map-viewer';
		tmp.me._htmlIDs.msgDiv = 'msg-div';
		
		tmp.me._item = item.item;
		tmp.me._counts = item.counts;
		tmp.me._roles = item.roles;
		tmp.me._can.changeDetails = false;
		for(tmp.i = 0; tmp.i < tmp.me._roles.size(); tmp.i++) {
			if(item.curRoleIds.indexOf(tmp.me._roles[tmp.i].id) > -1 && tmp.me._roles[tmp.i].changeDetails === true) {
				tmp.me._can.changeDetails = true;
				break;
			}
		}
		
		tmp.me._showEditPanel();
		if(tmp.me._can.changeDetails === true) {
			tmp.me._loadFormForDetails()
		}
		return tmp.me;
	}
});