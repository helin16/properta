/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new BackEndPageJs(), {
	_pagination: {'pageNo': 1, 'pageSize': 30} //the pagination details
	,_searchCriteria: {} //the searching criteria
	,_propRelTypeIds: {}
	/**
	 * Setting the property user relationship
	 */
	,setPropRelTypes: function (tenantId, agentId, ownerId) {
		this._propRelTypeIds = {'tenant': tenantId, 'agent': agentId, 'owner': ownerId};
		return this;
	}
	,getResults: function(reset, pageSize, completeFunc) {
		var tmp = {};
		tmp.me = this;
		tmp.reset = (reset === true ? true : false);
		tmp.resultDiv = $(tmp.me._htmlIDs.resultDivId);
		
		if(tmp.reset === true)
			tmp.me._pagination.pageNo = 1;
		tmp.me._pagination.pageSize = (pageSize || tmp.me._pagination.pageSize);
		tmp.me.postAjax(tmp.me.getCallbackId('getItems'), {'pagination': tmp.me._pagination, 'searchCriteria': tmp.me._searchCriteria}, {
			'onLoading': function () {
				//reset div
				if(tmp.reset === true) {
					tmp.resultDiv.update( tmp.me._getLoadingDiv() );
				}
			}
			,'onSuccess': function(sender, param) {
				try{
					tmp.result = tmp.me.getResp(param, false, true);
					if(!tmp.result)
						return;
					
					//reset div
					if(tmp.reset === true) {
						if(tmp.result.pageStats.totalRows === 0) {
							tmp.resultDiv.update(tmp.me._getNoResultDiv());
							return;
						}
						$(tmp.me._htmlIDs.totalNoOfItemsId).update(tmp.result.pageStats.totalRows);
						tmp.resultDiv.update('');
					}
					//remove next page button
					tmp.resultDiv.getElementsBySelector('.paginWrapper').each(function(item){
						item.remove();
					});
					//main body structure
					$(tmp.resultDiv).insert({'bottom': new Element('div', {'class': 'row'}) 
						.insert({'bottom': tmp.leftPanel = tmp.me._getLeftPanel().addClassName('col-md-2')
						})
						.insert({'bottom': tmp.rightPanel = tmp.me._getRightPanel().addClassName('col-md-10')
						})
					});
					//fill in messages
					tmp.result.items.each(function(item){
						tmp.me._fillMessageRow(item);
					});
					jQuery('[data-toggle="collapse"]').collapse('hide');
				} catch (e) {
					tmp.resultDiv.insert({'bottom': tmp.me.getAlertBox('Error', e).addClassName('alert-danger') });
				}
			}
			,'onComplete': function() {
				if(typeof(completeFunc) === 'function')
					completeFunc();
			}
		});
	}
	,_fillMessageRow: function(message) {
		var tmp = {};
		tmp.me = this;
		tmp.message = message;
		console.debug(message);
		
		// ids
		tmp.containerId = tmp.message.isRead ? tmp.me._htmlIDs.messageContentBody : tmp.me._htmlIDs.unreadMessageContentBodyId;
		tmp.headingId = tmp.containerId + 'Heading' + message.id;
		tmp.accordionId = tmp.containerId;
		tmp.collapseId = tmp.containerId + 'Collapse' + message.id;
		
		//remove empty message
		if($(tmp.containerId).down('.empty-message-row'))
			$(tmp.containerId).down('.empty-message-row').remove();
		//fill in message
		$(tmp.containerId).insert({'bottom': new Element('div', {'class': 'panel panel-default message-panel', 'style': 'cursor: pointer;', 'item-id': message.id }).store('data', tmp.message)
			.insert({'bottom': new Element('div', {'class': 'panel-heading', 'role': 'tab', 'id': tmp.headingId })
				.insert({'bottom': new Element('h4', {'class': 'panel-title'})
					.insert({'bottom': new Element('a', {'data-toggle': 'collapse', 'data-parent': ('#' + tmp.accordionId), 'href': ('#' + tmp.collapseId), 'aria-expanded': 'false', 'aria-controls': tmp.collapseId })
						.insert({'bottom': new Element('div', {'class': 'row'})
							.insert({'bottom': new Element('span', {'class': 'col-md-3', 'style': 'white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'}).update(message.from.fullName) })
							.insert({'bottom': new Element('span', {'class': 'col-md-9', 'style': 'white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'}).update(message.subject) })
						})
					})
					.observe('click', function(){
						tmp.message = $(this).up('.message-panel').retrieve('data');
						tmp.me._markMessageToRead(tmp.message);
					})
				})
			})
			.insert({'bottom': new Element('div', {'class': 'panel-collapse collapse in', 'id': tmp.collapseId, 'role': 'tabpanel', 'aria-labelledby': tmp.headingId }) 
				.insert({'bottom': new Element('div', {'class': 'panel-body'})
					.update(message.body)
				})
			})
		})
	}
	,_markMessageToRead: function(message) {
		var tmp = {};
		tmp.me = this;
		tmp.message = message;
		tmp.me.postAjax(tmp.me.getCallbackId('updateMessage'), {'message': tmp.message, 'action': 'MARKREAD'}, {
			'onLoading': function () {
			}
			,'onSuccess': function(sender, param) {
				try{
					tmp.result = tmp.me.getResp(param, false, true);
					if(!tmp.result)
						return;
					return tmp.result.items;
				} catch (e) {
					tmp.resultDiv.insert({'bottom': tmp.me.getAlertBox('Error', e).addClassName('alert-danger') });
				}
			}
			,'onComplete': function() {
				if(typeof(completeFunc) === 'function')
					completeFunc();
			}
		});
	}
	,_getRightPanel: function() {
		var tmp = {};
		tmp.me = this;
		return new Element('div', {'id': 'content'})
			.insert({'bottom': new Element('h2').update('Unread') })
			.insert({'bottom': new Element('div', {'class': 'panel-group', 'id': tmp.me._htmlIDs.unreadMessageContentBodyId, 'role': 'tablist', 'aria-multiselectable': 'true' })
				.insert({'bottom': new Element('div', {'class': 'row empty-message-row' })
					.insert({'bottom': new Element('div', {'class': 'col-md-12'}).update('Woohoo! You' + "'" + 've read all the messages in your inbox.') })
				})
			})
			.insert({'bottom': new Element('h2').update('Everything Else') }) 
			.insert({'bottom': new Element('div', {'class': 'panel-group', 'id': tmp.me._htmlIDs.messageContentBody, 'role': 'tablist', 'aria-multiselectable': 'true' })
				.insert({'bottom': new Element('div', {'class': 'row empty-message-row'})
					.insert({'bottom': new Element('div', {'class': 'col-md-12'})
						.insert({'bottom': new Element('span').update('Psst! It seems like you haven' + "'" + 't read any message yet. ') })
						.insert({'bottom': new Element('span').update('Click') })
						.insert({'bottom': new Element('a', {'href': '/backend/message/new.html'}).update(' HERE ') })
						.insert({'bottom': new Element('span').update('to create one.') })
					})
				})
			})
	}
	,_getLeftPanel: function() {
		var tmp = {};
		tmp.me = this;
		return new Element('div', {'id': 'side'})
			.insert({'bottom': new Element('button', {'id': 'compose-button', 'class': 'btn btn-success'}).update('Compose') })
			.insert({'bottom': new Element('ul', {'class': 'nav nav-list'}) 
				.insert({'bottom': tmp.me._getLeftPanelRow('Inbox') })
				.insert({'bottom': tmp.me._getLeftPanelRow('Starred') })
				.insert({'bottom': tmp.me._getLeftPanelRow('Important') })
				.insert({'bottom': tmp.me._getLeftPanelRow('Sent Msg') })
				.insert({'bottom': tmp.me._getLeftPanelRow('Drafts') })
				.insert({'bottom': tmp.me._getLeftPanelRow('Follow Up') })
			})
			.insert({'bottom': new Element('p').update('Any text here Any text here Any text here Any text here ') })
	}
	,_getLeftPanelRow: function(name, link = 'javascript:void(0)') {
		var tmp = {};
		tmp.me = this;
		return new Element('li').insert({'bottom': new Element('a', {'href': link}).update(name) });
	}
});