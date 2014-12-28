/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new FrontPageJs(), {
	_submitForm: function(jQueryForm) {
		var tmp = {};
		tmp.me = this;
		tmp.data = {};
		jQuery.each(jQueryForm.find('[new-message-form]'), function(index, item) {
			tmp.data[jQuery(item).attr('new-message-form')] = jQuery(item).val();
		});
		console.debug(tmp.data);return;
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

	,initSelect2(jQuerySelector) {
		var tmp = {};
		tmp.me = this;
		tmp.newEmail = null;
		jQuery(jQuerySelector).select2({
			placeholder: "Recipients",
			minimumInputLength: 1,
			multiple: true,
			ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
				url: "/backend/ajax/searchPerson",
				dataType: 'json',
				quietMillis: 250,
				data: function (term, page) {
					if(/^.+@.+$/.match(term) === true)
						tmp.newEmail = term;
					return {
						searchText: term, // search term
						pageNo: page
					};
				},
				results: function (data, page) { // parse the results into the format expected by Select2.
					// since we are using custom formatting functions we do not need to alter the remote JSON data
					tmp.results = [];
					if(tmp.newEmail !== null) {
						tmp.results.push({'text' : tmp.newEmail, 'id': tmp.newEmail});
					}
					data.resultData.items.each(function(item){
						tmp.results.push({'text': item.fullName + '<' + item.email + '>', 'id': item.id});
					})
					return { results: tmp.results };
				},
				cache: true
			},
		});
		return tmp.me;
	}
	
	,init: function(jQueryFormSelector) {
		var tmp = {};
		tmp.me = this;
		tmp.me.jQueryFormSelector = jQueryFormSelector;
		jQuery(tmp.me.jQueryFormSelector).bootstrapValidator({
	        message: 'This value is not valid',
	        feedbackIcons: {
	            valid: 'glyphicon glyphicon-ok',
	            invalid: 'glyphicon glyphicon-remove',
	            validating: 'glyphicon glyphicon-refresh'
	        },
	        fields: {
	        	'to': {
	                validators: {
	                    notEmpty: {
	                        message: 'Please tell us whom you want to sent to.'
	                    }
	                }
	        	}
	        	,'subject': {
	        		validators: {
	        			notEmpty: {
	        				message: 'A summary of your message'
	        			}
	        		}
	        	}
	        	,'comments': {
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
});