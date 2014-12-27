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
	
	,init: function(jQueryFormSelector) {
		var tmp = {};
		tmp.me = this;
		jQuery(jQueryFormSelector).bootstrapValidator({
	        message: 'This value is not valid',
	        feedbackIcons: {
	            valid: 'glyphicon glyphicon-ok',
	            invalid: 'glyphicon glyphicon-remove',
	            validating: 'glyphicon glyphicon-refresh'
	        },
	        fields: {
	        	'name': {
	        		message: 'The name is invalid',
	                validators: {
	                    notEmpty: {
	                        message: 'Please tell us who you are.'
	                    },
	                }
	        	}
	        	,'email': {
	        		message: 'The email is invalid',
	                validators: {
	                    notEmpty: {
	                        message: 'Please tell us how we can contact you.'
	                    },
	                }
	        	}
	        	,'subject': {
	        		message: 'Something about your question',
	        		validators: {
	        			notEmpty: {
	        				message: 'A summary of your question'
	        			},
	        		}
	        	}
	        	,'comments': {
	        		message: 'what do you want to ask us?',
	        		validators: {
	        			notEmpty: {
	        				message: 'what do you want to ask us?'
	        			},
	        		}
	        	}
	        }
		})
		.on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();
            tmp.me.submitForm(btn)
        });
		return tmp.me;
	}
	
	
	
});