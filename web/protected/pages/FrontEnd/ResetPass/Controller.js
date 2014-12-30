/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new FrontPageJs(), {
	_ressultPanelId: ''
	,_getLoadingPanel: function() {
		var tmp = {};
		tmp.me = this;
		return new Element('div', {'class': 'row'}).update(tmp.me._getLoadingDiv());
	}
	,_submitResetPass: function() {
		var tmp = {};
		tmp.me = this;
		tmp.data = {'skey': tmp.me._skey};
		$(tmp.me._ressultPanelId).getElementsBySelector('[reset-panel]').each(function(element){
			tmp.data[element.readAttribute('reset-panel')] = $F(element).strip();
		});
		$(tmp.me._ressultPanelId).down('.msg-div').update('');
		tmp.loadingDiv = tmp.me._getLoadingPanel();
		tmp.me.postAjax(tmp.me.getCallbackId('reset-pass'), tmp.data, {
			'onLoading': function() {
				$(tmp.me._ressultPanelId).insert({'after': tmp.loadingDiv}).hide();
			}
			,'onSuccess': function (sender, param) {
				try {
					tmp.result = tmp.me.getResp(param, false, true);
					if(!tmp.result || !tmp.result.url)
						return;
					jQuery(tmp.me.jQueryFormSelector).bootstrapValidator('resetForm', true);
					$(tmp.me._ressultPanelId).update(new Element('div', {'class': 'well'})
						.insert({'bottom': new Element('h4').update('Password saved') })
						.insert({'bottom': new Element('strong')
							.insert({'bottom': new Element('a', {'href': tmp.result.url})
								.update('You can click here to login, if you browser did not automactially refersh.')
							})
						})
					);
				} catch (e) {
					$(tmp.me._ressultPanelId).down('.msg-div').update(tmp.me.getAlertBox('Error:', e).addClassName('alert-danger'));
				}
			}
			,'onComplete': function() {
				tmp.loadingDiv.remove();
				$(tmp.me._ressultPanelId).show();
			}
		});
		return tmp.me;
	}
	,_loadValidator: function() {
		var tmp = {};
		tmp.me = this;
		jQuery(tmp.me.jQueryFormSelector).bootstrapValidator({
	        feedbackIcons: {
	            valid: 'glyphicon glyphicon-ok',
	            invalid: 'glyphicon glyphicon-remove',
	            validating: 'glyphicon glyphicon-refresh'
	        },
	        fields: {
	        	'new_pass': {
	                validators: {
	                    notEmpty: {
	                        message: 'Your email is needed here'
	                    }
				        ,stringLength: {
			                min: 6,
			                max: 30,
			                message: 'The password must be more than 6 and less than 30 characters long'
			            }
	                }
	        	}
	        	,'confirm_pass': {
	        		enabled: false,
	        		validators: {
	        			notEmpty: {
	        				message: 'You password please.'
	        			},
	        			identical: {
                            field: 'new_pass',
                            message: 'The password and its confirm must be the same'
                        }
	        		}
	        	}
	        }
		})
		.on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();
            tmp.me._submitResetPass();
        })
         .on('error.field.bv', function(e, data) {
        	data.bv.disableSubmitButtons(false);
        })
        .on('success.field.bv', function(e, data) {
        	data.bv.disableSubmitButtons(false);
        })
        // Enable the password/confirm password validators if the password is not empty
        .on('keyup', '[name="new_pass"]', function() {
            tmp.thisVal = jQuery(this).val();
            tmp.isEmpty = (tmp.thisVal == '');
            jQuery(tmp.me.jQueryFormSelector)
                    .bootstrapValidator('enableFieldValidators', 'confirm_pass', !tmp.isEmpty);

            // Revalidate the field when user start typing in the password field
            if (tmp.thisVal.length > 1) {
            	jQuery(tmp.me.jQueryFormSelector)
                    .bootstrapValidator('validateField', 'confirm_pass');
            }
        });
		return tmp.me;
	}
	,_getFormGroup: function(label, control) {
		return new Element('div', {'class': 'form-group'})
			.insert({'bottom': new Element('label', {'class': 'col-sm-4 control-label'}).update(label) })
			.insert({'bottom': new Element('div', {'class': 'col-sm-8'}).update(control) })
	}
	,_showForm: function() {
		var tmp = {};
		tmp.me = this;
		tmp.newDiv = new Element('div', {'class': 'row pass-reset-panel'})
			.insert({'bottom': new Element('div', {'class': 'col-sm-6 col-sm-push-3'})
				.insert({'bottom': new Element('div', {'class': 'form-horizontal'})
					.insert({'bottom': new Element('div', {'class': 'form-group'})
						.insert({'bottom': new Element('h3').update('Please provide your new password:') })
					})
					.insert({'bottom': tmp.me._getFormGroup('Password:', 
							new Element('input', {'class': 'form-control pass-field', 'name': 'new_pass', 'reset-panel': 'new_pass', 'placeholder': 'Your new password', 'type': 'password'})
					) })
					.insert({'bottom': tmp.me._getFormGroup('Confirm password:', 
							new Element('input', {'class': 'form-control pass-field', 'name': 'confirm_pass', 'reset-panel': 'confirm_pass', 'placeholder': 'Confirm your new password', 'type': 'password'})
					) })
					.insert({'bottom': new Element('div', {'class': 'form-group'})
						.insert({'bottom': new Element('div', {'class': 'col-sm-offset-4 col-sm-8'})
							.insert({'bottom': new Element('div', {'class': 'checkbox'})
								.insert({'bottom': new Element('label')
									.insert({'bottom': new Element('input', {'type': 'checkbox'})
										.observe('click', function() {
											tmp.checked = $(this).checked;
											$(this).up('.pass-reset-panel').getElementsBySelector('input.pass-field').each(function(item){
												item.writeAttribute('type', (tmp.checked === true ? 'text' : 'password'));
											});
										})
									})
									.insert({'bottom': new Element('span').update(' Show Password') })
								})
							})
						})
					})
					.insert({'bottom': tmp.me._getFormGroup('', 
							new Element('div')
							.insert({'bottom': new Element('div', {'class': 'msg-div'}).update('') })
							.insert({'bottom': new Element('button', {'type': 'submit', 'class': 'btn btn-primary btn-lg'}).update('Confirm') })
					) })
				})
			});
		$(tmp.me._ressultPanelId).update(tmp.newDiv);
		return tmp.me;
	}
	/**
	 * initialising
	 */
	,init: function(ressultPanelId, jQueryFormSelector, skey, username) {
		var tmp = {};
		tmp.me = this;
		tmp.me._ressultPanelId = ressultPanelId;
		tmp.me._skey = skey;
		tmp.me._username = username;
		tmp.me.jQueryFormSelector = jQueryFormSelector;
		tmp.me._showForm();
		tmp.me._loadValidator();
		return tmp.me;
	}
	
});