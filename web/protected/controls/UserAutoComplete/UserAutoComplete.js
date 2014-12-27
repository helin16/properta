/***
 * The UserAutoComplete javascript class
 */
var UserAutoCompleteJs = new Class.create();
UserAutoCompleteJs.prototype = {
	pageJs: null //the pageJs objet for ajaxing
	,input: null // the html element when the popup inital
	
	//constructor
	,initialize: function (pageJs, exsitingPersonIds) {
		this.pageJs = pageJs;
		this.exsitingPersonIds = exsitingPersonIds;
		return this;
	}
	,_showPopOver: function(onSelectFunc, addNewFunc) {
		var tmp = {};
		tmp.me = this;
		tmp.me.pageJs._signRandID(tmp.me.input);
		tmp.popover = jQuery('#' + tmp.me.input.id).popover({
			'title'    : function() {
				return new Element('div', {'class': 'row'})
					.insert({'bottom': new Element('div', {'class': 'col-xs-10'})
						.insert({'bottom': new Element('input', {'class': 'form-control input-sm searchtext', 'placeholder': 'Name or Email'}) })
					})
					.insert({'bottom': new Element('div', {'class': 'col-xs-2'})
						.insert({'bottom': new Element('a', {'class': 'btn btn-danger btn-xs'}).update(new Element('i', {'class': 'fa fa-times fa-2x'})) 
							.observe('click', function() {
								tmp.popover.popover('hide');
							})
						})
					});
			},
			'html'     : true, 
			'placement': 'bottom',
			'container': 'body', 
			'content'  : '',
			'template' : '<div class="popover" role="tooltip" style="max-width: none; z-index: 0; min-width: 300px;"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>'
		})
		.on('show.bs.popover', function(event){
			tmp.popoverContent = jQuery('.popover-content', tmp.popover.data('bs.popover').$tip);
			tmp.popoverContent.html('');
		})
		.on('shown.bs.popover', function(event){
			tmp.popoverDiv = tmp.popover.data('bs.popover').$tip;
			tmp.popoverContent = jQuery('.popover-content', tmp.popoverDiv);
			jQuery('.searchtext', tmp.popoverDiv).autocomplete({
				minChars: 3,
				type: 'POST',	
				appendTo: jQuery('.popover-content', tmp.popoverDiv),
				deferRequestBy : 300,
				beforeRender: function(container){
					container.siblings('.new-user-row').remove();
					jQuery('.searchtext', tmp.popoverDiv).val('');
					container.css('position', '').css('min-width', '400px');
				},
				paramName: 'PRADO_CALLBACK_PARAMETER',
				params: {
					'PRADO_CALLBACK_TARGET': tmp.me.pageJs.getCallbackId('searchPerson'),
					'PRADO_PAGESTATE': jQuery('#PRADO_PAGESTATE').val()
				},
				onSelect: function (suggestion) {
					tmp.popover.popover('hide');
			        if(typeof onSelectFunc === 'function')
			        	onSelectFunc(suggestion.data);
			    },
				onSearchStart: function(query) {
					query.PRADO_CALLBACK_PARAMETER = JSON.stringify({'searchText': jQuery(this).val()});
					return query;
				},
				transformResult: function(response, originalQuery) {
					try {
						tmp.result = tmp.me.pageJs.getResp(response, false, true);
						//filter out the existing.
						tmp.newItems = [];
						tmp.result.items.each(function(item){
							if(!(tmp.me.exsitingPersonIds.indexOf(item.id) > -1)) {
								tmp.newItems.push(item);
							}
						});
						tmp.result.items = tmp.newItems;
						console.debug(tmp.result.items);
						
						
						if(!tmp.result || !tmp.result.items || tmp.result.items.size() === 0) {
							jQuery('.popover-content', tmp.popoverDiv)
								.append(jQuery('<div class="row new-user-row"/>')
									.append('<div class="col-sm-4"><input class="form-control" user-auto-new="email" placeholder="Email" required=true /></div>')
									.append('<div class="col-sm-3"><input class="form-control" user-auto-new="firstName" placeholder="Firstname"/></div>')
									.append('<div class="col-sm-3"><input class="form-control" user-auto-new="lastName" placeholder="Lastname"/></div>')
									.append(jQuery('<div class="col-sm-2" />')
										.append(jQuery('<span class="btn btn-success btn-sm" />')
												.append('<span class="glyphicon glyphicon-plus"></span>')
												.click(function(event) {
													if(typeof addNewFunc === 'function') {
														addNewFunc(event);
													}
													tmp.popover.popover('hide');
												})
										)
									)
								);
						}
						tmp.suggestions = [];
						tmp.result.items.each(function(item){
							tmp.suggestions.push({'value': item.email, 'data': item});
						});
						return {'suggestions': tmp.suggestions};
					} catch (e) {
						jQuery('.popover-content', tmp.popoverDiv).html(tmp.me.pageJs.getAlertBox('ERROR:', e).addClassName('alert-danger'));
					}
				},
				serviceUrl: window.location,
				formatResult: function (suggestion, currentValue) {
					return new Element('div', {'class': 'row'})
						.insert({'bottom': new Element('div', {'class': 'col-sm-4'}).update(suggestion.data.email) })
						.insert({'bottom': new Element('div', {'class': suggestion.data.btns ? 'col-sm-3': 'col-sm-4'}).update(suggestion.data.firstName) })
						.insert({'bottom': new Element('div', {'class': suggestion.data.btns ? 'col-sm-3': 'col-sm-4'}).update(suggestion.data.lastName) })
						.insert({'bottom': !suggestion.data.btns ? '': new Element('div', {'class': 'col-sm-2'})
							.insert({'bottom': suggestion.data.btns})
						})
						.outerHTML;
				}
			})
		});
		tmp.me.input.observe('click', function(){
			jQuery('.popover-auto-complete').not(jQuery('#' + tmp.me.input.id)).popover('hide');
		});
		return tmp.me;
	}
	,loadPopOver: function(input, onSelectFunc, addNewFunc) {
		var tmp = {};
		tmp.me = this;
		tmp.me.input = input.addClassName('popover-auto-complete');
//			.writeAttribute('data-toggle', "popover")
//			.writeAttribute('data-trigger',"focus");
		tmp.me._showPopOver(onSelectFunc, addNewFunc);
		return tmp.me;
	}
}
	