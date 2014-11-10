/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new BackEndPageJs(), {
	_item: {} //the item entity that we are dealing with

	,_getCreatingPanel: function() {
		var tmp = {};
		tmp.me = this;
		tmp.newDiv = new Element('div')
			.insert({'bottom': new Element('div', {'class': 'page-header'})
				.insert({'bottom': new Element('div', {'class': 'row'})
					.insert({'bottom': new Element('div', {'class': 'col-sm-8'})
						.insert({'bottom': new Element('h3').update('Creating Property:') })
					})
				})
			})
			.insert({'bottom': new Element('div', {'class': ''})
				.insert({'bottom': new Element('div', {'class': 'input-group col-sm-6', 'style': 'margin: 50px auto;'})
					.insert({'bottom': new Element('input', {'class': 'form-control', 'placeholder': 'Type in an address'})
						.observe('keydown', function() {
							console.debug($F(this));
						})
					})
					.insert({'bottom': new Element('span', {'class': 'btn btn-default input-group-addon'})
						.insert({'bottom': new Element('span', {'class': 'glyphicon glyphicon-search'}) })
					})
				})
			})
		return tmp.newDiv;
	}
	
	,_getDetailsPanel: function() {
		var tmp = {};
		tmp.me = this;
		tmp.newDiv = new Element('div');
		return tmp.newDiv;
	}
	/**
	 * Showing the item
	 */
	,load: function(item) {
		var tmp = {};
		tmp.me = this;
		tmp.me._item = item;
		$(tmp.me._htmlIDs.itemDivId).update(tmp.me._item.id ? tmp.me._getDetailsPanel() : tmp.me._getCreatingPanel());
		return tmp.me;
	}
});