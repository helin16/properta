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
	,login: function (btn) {
		var tmp = {};
		tmp.me = this;
		tmp.panel = $(btn).up('.login-form');
		tmp.panel.down('.msg-div').update('');
		tmp.data = tmp.me._preSubmit(tmp.panel);
		if(tmp.data === false) {
			return;
		}
		
		tmp.me._signRandID(btn);
		tmp.loadingDiv = tmp.me._getLoadingPanel();
		tmp.me.postAjax(tmp.me.getCallbackId('login'), tmp.data, {
			'onLoading': function () {
				jQuery('#' + btn.id).button('loading');
				$(tmp.me._ressultPanelId).insert({'after': tmp.loadingDiv}).hide();
			}
			,'onSuccess': function(sender, param) {
				try {
					tmp.result = tmp.me.getResp(param, false, true);
					if(tmp.result.url)
						window.location = tmp.result.url;
				} catch(e) {
					tmp.panel.down('.msg-div').update(tmp.me.getAlertBox(e).addClassName('alert-danger'));
				}
			}
			,'onComplete': function(sender, param) {
				jQuery('#' + btn.id).button('reset');
				tmp.loadingDiv.remove();
				$(tmp.me._ressultPanelId).show();
			}
		}, 60000);
	}

	,_preSubmit: function (loginPanel) {
		var tmp = {};
		tmp.me = this;
		tmp.hasError = false;
		
		tmp.usernamebox = loginPanel.down('[login-panel="email"]');
		tmp.passwordbox = loginPanel.down('[login-panel="password"]');
		tmp.errMsgDiv = new Element('div');
		if($F(tmp.usernamebox).blank()) {
			tmp.errMsgDiv.insert({'bottom': tmp.me._getErrMsg('Please provide an email!') });
			tmp.hasError = true;
		}
		else if($F(tmp.usernamebox).strip().match(/^.+@.+$/) === null) {
			tmp.errMsgDiv.insert({'bottom': tmp.me._getErrMsg('Please provide an valid email!') });
			tmp.hasError = true;
		}
		if($F(tmp.passwordbox).blank()) {
			tmp.errMsgDiv.insert({'bottom': tmp.me._getErrMsg('Please provide an password!') });
			tmp.hasError = true;
		}
		if(tmp.hasError === true) {
			loginPanel.down('.msg-div').update(tmp.errMsgDiv);
			return false;
		}
		return {'email': $F(tmp.usernamebox).strip(), 'password': $F(tmp.passwordbox).strip()};
	}

	,_getErrMsg: function (msg) {
		return new Element('div', {'class': 'errmsg smalltxt text-danger'}).update(msg);
	}
	
	,_signUp: function (btn) {
		var tmp = {};
		tmp.me = this;
		tmp.panel = $(btn).up('.signup-form');
		tmp.panel.down('.msg-div').update('');
		tmp.emailBox = tmp.panel.down('[sigup-panel="email"]');
		tmp.hasErr = false;
		tmp.email = (tmp.emailBox ? $F(tmp.emailBox).strip() : '');
		if (tmp.email.match(/^.+@.+$/) === null) {
			tmp.panel.down('.msg-div').update(tmp.me._getErrMsg('Please provide an valid email!'));
			tmp.hasErr = true;
		}
		if(tmp.hasErr === true)
			return tmp.me;
		
		tmp.me._signRandID(btn);
		tmp.loadingDiv = tmp.me._getLoadingPanel();
		tmp.me.postAjax(tmp.me.getCallbackId('signUp'), {'email': tmp.email}, {
			'onLoading': function () {
				jQuery('#' + btn.id).button('loading');
				$(tmp.me._ressultPanelId).insert({'after': tmp.loadingDiv}).hide();
			}
			,'onSuccess': function(sender, param) {
				try {
					tmp.result = tmp.me.getResp(param, false, true);
					if(!tmp.result || !tmp.result.confirmEmail)
						return;
					tmp.msg = '<p>An email will be sent to <em><u>' + tmp.result.confirmEmail + '</u></em> with the initial password soon. Please use that to login and change the initial password after you logged in.</p>';
					tmp.panel.down('.msg-div').update(tmp.me.getAlertBox(tmp.msg).addClassName('alert-success'));
					tmp.emailBox.clear();
				} catch(e) {
					tmp.panel.down('.msg-div').update(tmp.me.getAlertBox(e).addClassName('alert-danger'));
				}
			}
			,'onComplete': function(sender, param) {
				jQuery('#' + btn.id).button('reset');
				tmp.loadingDiv.remove();
				$(tmp.me._ressultPanelId).show();
			}
		}, 60000);
		return tmp.me;
	}
	/**
	 * submitting the password retrieve request to the server
	 */
	,_submtRetrievePass: function(btn) {
		var tmp = {};
		tmp.me = this;
		tmp.panel = $(btn).up('.pass-retrieve-panel');
		tmp.panel.down('.msg-div').update('');
		tmp.emailBox = tmp.panel.down('[pass-retrieve-panel="email"]');
		tmp.hasErr = false;
		tmp.email = (tmp.emailBox ? $F(tmp.emailBox).strip() : '');
		if (tmp.email.match(/^.+@.+$/) === null) {
			tmp.panel.down('.msg-div').update(tmp.me._getErrMsg('Please provide an valid email!'));
			tmp.hasErr = true;
		}
		if(tmp.hasErr === true)
			return tmp.me;
		
		tmp.me._signRandID(btn);
		tmp.loadingDiv = tmp.me._getLoadingPanel();
		tmp.me.postAjax(tmp.me.getCallbackId('retrieve-pass'), {'email': tmp.email}, {
			'onLoading': function () {
				jQuery('#' + btn.id).button('loading');
				$(tmp.me._ressultPanelId).insert({'after': tmp.loadingDiv}).hide();
			}
			,'onSuccess': function(sender, param) {
				try {
					tmp.result = tmp.me.getResp(param, false, true);
					if(!tmp.result || !tmp.result)
						return;
					tmp.msg = '<p>An email will be sent to <em><u>' + tmp.result.confirmEmail + '</u></em> with the initial password soon. Please use that to login and change the initial password after you logged in.</p>';
					tmp.panel.down('.msg-div').update(tmp.me.getAlertBox(tmp.msg).addClassName('alert-success'));
					tmp.emailBox.clear();
				} catch(e) {
					tmp.panel.down('.msg-div').update(tmp.me.getAlertBox(e).addClassName('alert-danger'));
				}
			}
			,'onComplete': function(sender, param) {
				jQuery('#' + btn.id).button('reset');
				tmp.loadingDiv.remove();
				$(tmp.me._ressultPanelId).show();
			}
		}, 60000)
		return tmp.me;
	}
	/**
	 * Showing the retrieve password panel
	 */
	,showRetrievePassPanel: function(show) {
		if(show === true) { //the retrieve-panel
			jQuery('.pass-retrieve-panel').show();
			jQuery('.login-panel').hide();
		} else {
			jQuery('.login-panel').show();
			jQuery('.pass-retrieve-panel').hide();
		}
	}
	/**
	 * initialising
	 */
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
	        	'login_email': {
	                validators: {
	                    notEmpty: {
	                        message: 'Your email is needed here'
	                    },
	                    emailAddress: {
	                        message: 'The input is not a valid email address'
	                    }
	                }
	        	}
	        	,'login_pass': {
	        		validators: {
	        			notEmpty: {
	        				message: 'You password please.'
	        			}
	        		}
	        	}
	        	,'signup_email': {
	        		validators: {
	                    notEmpty: {
	                        message: 'We need to know your email address to sign you up.'
	                    },
	                    emailAddress: {
	                        message: 'The input is not a valid email address'
	                    }
	                }
	        	}
	        	,'retrieve_pass_email': {
	        		validators: {
	        			notEmpty: {
	        				message: 'Your email is needed here'
	        			},
	        			emailAddress: {
	        				message: 'The input is not a valid email address'
	        			}
	        		}
	        	}
	        }
		})
		.on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();
        })
        .on('error.field.bv', function(e, data) {
        	data.bv.disableSubmitButtons(false);
        })
        .on('success.field.bv', function(e, data) {
        	data.bv.disableSubmitButtons(false);
        })
        .on('keydown', '.login-page-form[submit-btn]', function(e){
        	tmp.element = jQuery(e.target);
        	tmp.me.keydown(e, function(){
        		jQuery(tmp.element.attr('submit-btn')).click();
        	});
        })
        .on('click', '#loginbtn', function(e){
        	jQuery('.panel .msg-div').html('');
            jQuery.each(jQuery('.form-control'), function(index, element){
            	jQuery(tmp.me.jQueryFormSelector).bootstrapValidator('enableFieldValidators', jQuery(element).attr('name'), jQuery(element).hasClass('login-form'));
            });
            if(jQuery(tmp.me.jQueryFormSelector).bootstrapValidator('validate').data('bootstrapValidator').isValid())
            	tmp.me.login($('loginbtn'));
        })
        .on('click', '#signupbtn', function(e){
        	jQuery('.panel .msg-div').html('');
        	jQuery.each(jQuery('.form-control'), function(index, element){
        		jQuery(tmp.me.jQueryFormSelector).bootstrapValidator('enableFieldValidators', jQuery(element).attr('name'), jQuery(element).hasClass('signup-form'));
        	});
        	if(jQuery(tmp.me.jQueryFormSelector).bootstrapValidator('validate').data('bootstrapValidator').isValid())
        		tmp.me._signUp($('signupbtn'));
        })
        .on('click', '#retrievebtn', function(e){
        	jQuery('.panel .msg-div').html('');
        	jQuery.each(jQuery('.form-control'), function(index, element){
        		jQuery(tmp.me.jQueryFormSelector).bootstrapValidator('enableFieldValidators', jQuery(element).attr('name'), jQuery(element).hasClass('retrieve-pass-form'));
        	});
        	if(jQuery(tmp.me.jQueryFormSelector).bootstrapValidator('validate').data('bootstrapValidator').isValid())
        		tmp.me._submtRetrievePass($('retrievebtn'));
        })
        ;
		return tmp.me;
	}
	
});