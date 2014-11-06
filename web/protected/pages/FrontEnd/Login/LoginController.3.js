/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new FrontPageJs(), {
	
	login: function (btn) {
		var tmp = {};
		tmp.me = this;
		tmp.panel = $(btn).up('.login-form');
		tmp.data = tmp.me._preSubmit(tmp.panel);
		if(tmp.data === false) {
			return;
		}
		tmp.me._signRandID(btn);
		tmp.loadingMsg = new Element('div', {'class': 'loadingMsg'}).update('log into system ...');
		tmp.me.postAjax(tmp.me.getCallbackId('login'), tmp.data, {
			'onLoading': function () {
				jQuery('#' + btn.id).button('loading');
				tmp.panel.down('.msg-div').update('');
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
	
});