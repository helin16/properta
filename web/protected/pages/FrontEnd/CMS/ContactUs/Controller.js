/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new FrontPageJs(), {
	
	_submitForm: function(data) {
		
	}
	
	,preSubmitForm: function(btn) {
		var tmp = {}
		tmp.me = this;
		return tmp.me;
	}
	
});