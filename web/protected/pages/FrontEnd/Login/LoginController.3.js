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
		if($F(tmp.usernamebox).blank()) {
			tmp.me._markFormGroupError($(tmp.usernamebox), tmp.me._getErrMsg('Please provide an email!'));
			tmp.hasError = true;
		}
		if(!tmp.me.validateEmail($F(tmp.usernamebox).strip())) {
			tmp.me._markFormGroupError($(tmp.usernamebox), tmp.me._getErrMsg('Please provide an valid email!'));
			tmp.hasError = true;
		}
		if($F(tmp.passwordbox).blank()) {
			tmp.me._markFormGroupError($(tmp.passwordbox), tmp.me._getErrMsg('Please provide an password!'));
			tmp.hasError = true;
		}
		return tmp.hasError === true ? false : {'email': $F(tmp.usernamebox).strip(), 'password': $F(tmp.passwordbox).strip()};
	}

	,_getErrMsg: function (msg) {
		return new Element('span', {'class': 'errmsg smalltxt'}).update(msg);
	}
	
	,signUp: function (btn) {
		var tmp = {};
		tmp.me = this;
		tmp.panel = $(btn).up('.signup-form');
		tmp.panel.down('.msg-div').update('');
		tmp.hasErr = false;
		tmp.email = (tmp.panel.down('input.email') ? $F(tmp.panel.down('input.email')).strip() : '');
		if (tmp.email.match(/^.+@[0-9a-zA-Z_-]+(\.[0-9a-zA-Z_-]+)+$/) === null) {
			tmp.me._markFormGroupError(tmp.panel.down('input.email'), 'Please provide an valid email address.');
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
					tmp.panel.down('input.email').clear();
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
		tmp.emailBox = tmp.panel.down('input.email');
		tmp.hasErr = false;
		tmp.email = (tmp.emailBox ? $F(tmp.emailBox).strip() : '');
		if (tmp.email.match(/^.+@[0-9a-zA-Z_-]+(\.[0-9a-zA-Z_-]+)+$/) === null) {
			tmp.me._markFormGroupError(tmp.emailBox, 'Please provide an valid email address.');
			tmp.hasErr = true;
		}
		if(tmp.hasErr === true)
			return tmp.me;
		
		
		tmp.me._signRandID(btn);
		tmp.me.postAjax(tmp.me.getCallbackId('retrieve-pass'), {'email': tmp.email}, {
			'OnLoading': function () {
				tmp.emailBox.disabled = true;
				jQuery('#' + btn.id).button('loading');
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
				tmp.emailBox.disabled = false;
			}
		}, 60000)
		return tmp.me;
	}
	/**
	 * Showing the retrieve password panel
	 */
	,showRetrievePassPanel: function(btn) {
		var tmp = {};
		tmp.me = this;
		tmp.newPanel = new Element('div', {'class': 'col-sm-6 col-sm-push-3 pass-retrieve-panel'})
			.insert({'bottom': new Element('div', {'class': 'panel panel-default'})
				.insert({'bottom': new Element('div', {'class': 'panel-body'})
					.insert({'bottom': new Element('h4').update('Please provide your email you signed up with:') })
					.insert({'bottom': new Element('div', {'class': 'msg-div'}) })
					.insert({'bottom': new Element('div', {'class': 'form-group'}) 
						.insert({'bottom': new Element('label').update('Your email:') }) 
						.insert({'bottom': new Element('div', {'class': 'input-group'})
							.insert({'bottom': new Element('div', {'class': 'input-group-addon'}).update(new Element('div', {'class': 'glyphicon glyphicon-envelope'})) })
							.insert({'bottom': tmp.emailTxtBox = new Element('input', {'class': 'form-control email', 'placeholder': "Your email that you signed up with."})
								.observe('keydown', function(event){
									tmp.submitBtn = $(this).up('.pass-retrieve-panel').down('.submit-btn');
									tmp.me.keydown(event, function(){ 
										if(tmp.submitBtn) {
											tmp.submitBtn.click();
										} 
									});
								})
							})
						}) 
					})
					.insert({'bottom': new Element('div', {'class': 'form-group'})
						.insert({'bottom': new Element('a', {'href': 'javascript: void(0);'}).update('Cancel')
							.observe('click', function() {
								$(this).up('.pass-retrieve-panel').remove();
								$(tmp.me._ressultPanelId).show();
							})
						})
						.insert({'bottom': new Element('span', {'class': 'btn btn-primary pull-right submit-btn', 'data-loading-text': "<i class='fa fa-refresh fa-spin'></i>"}).update('Retrieve My Password')
							.observe('click', function() {
								tmp.me._submtRetrievePass(this);
							})
						})
					})
				})
			})
		$(tmp.me._ressultPanelId).insert({'after': tmp.newPanel}).hide();
		tmp.emailTxtBox.focus();
	}
	
});