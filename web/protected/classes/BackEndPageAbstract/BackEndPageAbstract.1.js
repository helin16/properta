/**
 * The FrontEndPageAbstract Js file
 */
var BackEndPageJs = new Class.create();
BackEndPageJs.prototype = Object.extend(new FrontPageJs(), {
	_htmlIDs: {}

	,setHTMLIDs: function(htmlIds) {
		this._htmlIDs = htmlIds;
		return this;
	}
});
