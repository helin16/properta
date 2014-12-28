/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new FrontPageJs(), {
	valCap: function(data, input) {
		var tmp = {};
		tmp.me = this;
		$(input).value = data;
		tmp.me._signRandID(input);
		jQuery(tmp.me.jQueryFormSelector).bootstrapValidator('revalidateField', input.id);
		return tmp.me;
	}
	
	,_submitForm: function(jQueryForm) {
		var tmp = {};
		tmp.me = this;
		tmp.data = {};
		jQuery.each(jQueryForm.find('[contact-form]'), function(index, item) {
			tmp.data[jQuery(item).attr('contact-form')] = jQuery(item).val();
		});
		
		tmp.submitBtn = jQuery(tmp.me.jQueryFormSelector).data('bootstrapValidator').$submitButton;
		jQuery(tmp.me.jQueryFormSelector).find('.contact-form-msg').remove();
		tmp.msg = jQuery('<div class="alert contact-form-msg" style="display: inline-block;"/>');
		tmp.me.postAjax(tmp.me.getCallbackId('contactus'), tmp.data, {
			'onLoading': function() {
				jQuery(tmp.submitBtn).button('loading');
			}
			,'onSuccess': function(sender, param) {
				try{
					tmp.result = tmp.me.getResp(param, false, true);
					tmp.msg.addClass('alert-success').html("We've got your message, will contact you later. Thanks!").insertBefore(jQuery(tmp.submitBtn));
					jQuery(tmp.me.jQueryFormSelector).data('bootstrapValidator').resetForm(true);
				} catch(e) {
					tmp.msg.addClass('alert-danger').html('<strong>ERROR:</strong> ' + e).insertBefore(jQuery(tmp.submitBtn));
				}
			}
			,'onComplete': function() {
				jQuery(tmp.submitBtn).button('reset');
			}
		})
		return tmp.me;
	}
	
	,init: function(jQueryFormSelector) {
		var tmp = {};
		tmp.me = this;
		tmp.me.jQueryFormSelector = jQueryFormSelector;
		jQuery(tmp.me.jQueryFormSelector).bootstrapValidator({
			excluded: [':disabled'],
	        message: 'This value is not valid',
	        feedbackIcons: {
	            valid: 'glyphicon glyphicon-ok',
	            invalid: 'glyphicon glyphicon-remove',
	            validating: 'glyphicon glyphicon-refresh'
	        },
	        fields: {
	        	'to': {
	        		message: 'The name is invalid',
	                validators: {
	                    notEmpty: {
	                        message: 'Please tell us whom you want to sent to.'
	                    }
	                }
	        	}
	        	,'subject': {
	        		message: 'Something about your message',
	        		validators: {
	        			notEmpty: {
	        				message: 'A summary of your message'
	        			}
	        		}
	        	}
	        	,'comments': {
	        		message: 'what do you want to say?',
	        		validators: {
	        			notEmpty: {
	        				message: 'what do you want to say?'
	        			}
	        		}
	        	}
	        }
		})
		.on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();
            tmp.me._submitForm(jQuery(tmp.me.jQueryFormSelector));
        });
		return tmp.me;
	}
	
	,load: function () {
		jQuery('.user-flipper').textrotator({
	        speed: 3000
		})
	}
	
});