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
	
});