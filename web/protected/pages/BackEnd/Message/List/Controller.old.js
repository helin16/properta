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
						.insert({'bottom': tmp.leftPanel = new Element('div', {'class': 'col-md-4 left-panel-container'})
						})
						.insert({'bottom': tmp.rightPanel = new Element('div', {'class': 'col-md-7 right-panel-container pull-right'})
						})
					});
					
					tmp.result.items.each(function(item) {
						tmp.leftPanel.insert({'bottom': tmp.me._getLeftPanelRow(item).addClassName('item_row').writeAttribute('item_id', item.id) });
					});
					
					//show all items
//					tmp.result.items.each(function(item) {
//						$(tmp.resultDiv).insert({'bottom': tmp.me._getResultRow(item).addClassName('item_row').writeAttribute('item_id', item.id) });
//					});
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
	,_getLeftPanelRow: function(item) {
		var tmp = {};
		tmp.me = this;
		return new Element('div', {'class': (!item.isRead ? 'unread row' : 'row'), 'style': (!item.isRead ? 'color: red' : '')}).store('data',item)
			.insert({'bottom': new Element('span').update(item.from ? item.from : 'sender name or email ...') })
			.insert({'bottom': new Element('div', {'style': 'overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'}).update(item.subject) })
			.observe('click', function(){
				if($(this).retrieve('data').isRead === false) {
					tmp.me._updateMessage(this, item, 'MARKREAD');
				}
				$$('.right-panel-container').first().update(tmp.me._getMessageDetailDiv(item)).addClassName('message-detail-container').writeAttribute('item_id', item.id);
			})
	}
	
	,_updateMessage: function(btn, item, action) {
		var tmp = {};
		tmp.me = this;
		tmp.btn = btn;
		console.debug(btn);
		tmp.me.postAjax(tmp.me.getCallbackId('updateMessage'), {'message': item, 'action': action}, {
			'onLoading': function () {
			}
			,'onSuccess': function(sender, param) {
				try{
					tmp.result = tmp.me.getResp(param, false, true);
					if(!tmp.result)
						return;
					tmp.btn.removeClassName('unread').writeAttribute('style','color: ""');
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
	
	,_getMessageDetailDiv: function(item) {
		var tmp = {};
		tmp.me = this;
		return new Element('div')
			.insert({'bottom': new Element('div', {'class': 'row message-summery-container'}) 
				.insert({'bottom': new Element('div', {'class': 'row'})
					.insert({'bottom': new Element('b').update('From: ') })
					.insert({'bottom': new Element('span').update(item.from ? item.form : 'sender name or email ...') })
				})
				.insert({'bottom': new Element('div', {'class': 'row', 'style': 'overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'})
					.insert({'bottom': new Element('b').update('Subject: ') })
					.insert({'bottom': new Element('span').update(item.subject) })
				})
				.insert({'bottom': new Element('div', {'class': 'row', 'style': 'height: 3px; background-color: brown;'}) })
				.insert({'bottom': new Element('div', {'class': 'row'})
					.insert({'bottom': new Element('span').update(item.body) })
				})
			})
			;
	}
	,_getNextPageBtn: function() {
		var tmp = {}
		tmp.me = this;
		return new Element('div')
			.insert({'bottom': new Element('span', {'class': 'btn btn-primary btn-lg col-xs-12', 'data-loading-text':"Fetching more results ..."}).update('Show More')
				.observe('click', function() {
					tmp.btn = $(this);
					tmp.me._signRandID(tmp.btn);
					jQuery('#' + tmp.btn.id).button('loading');
					tmp.me._pagination.pageNo = tmp.me._pagination.pageNo*1 + 1;
					tmp.me.getResults(false, tmp.me._pagination.pageSize, function() {
						jQuery('#' + tmp.btn.id).button('reset');
					});
				})
			});
	}
	
	,_getTitleRowData: function() {
		return {};
	}
	
	,_getResultRow: function(message) {
		var tmp = {};
		tmp.me = this;
		return new Element('div', {'class': 'row'}).store('data',message)
			.insert({'bottom': new Element('div', {'class': 'row'})
				.insert({'bottom': new Element('div').update(message.subject) })
			})
			.insert({'bottom': new Element('div', {'class': 'row'})
				.insert({'bottom': new Element('div').update(message.body) })
			})
			.insert({'bottom': new Element('div', {'class': 'row'})
				.insert({'bottom': new Element('div').update(message.created) })
			})
			.insert({'bottom': new Element('div', {'class': 'row'})
				.insert({'bottom': new Element('div').update(message.updated) })
			})
			;
	}
	
	,_getNoResultDiv: function() {
		return new Element('div', {'class': 'no-result-div'})
			.insert({'bottom': new Element('h4', {'class': ''})})
			.insert({'bottom': new Element('p', {'class': 'lead'}).update('There isn\'t any property for you yet, please ')
				.insert({'bottom': new Element('a', {'href': $('new-property-btn').readAttribute('href'), 'class': 'btn btn-success btn-xs'}).update(new Element('span', {'class': 'glyphicon glyphicon-plus'}))
					.insert({'bottom': ' ADD'})
				})
				.insert({'bottom': ' one now.'})
			})
			.insert({'bottom': new Element('hr', {'style': 'width: 100px;'}) })
			.insert({'bottom': new Element('p').update('Only one minute to add a property ')
				.insert({'bottom': new Element('span', {'class': 'fa fa-cog fa-spin'}) })
			})
	}
});