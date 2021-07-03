var LoginLightBox = function(DOMID) {

	this.DOMID = DOMID;
	this.registerLink = new RegisterButton(DOMID + "RegisterLink", "lightBox");
	var that = this;
	var facebookSyncNeeded = false;
	
	/******** Login Callback *****/
	this.loginCallback = function() {
		var e = ExceptionsManager.getInstance(), v = VerificationManager.getInstance(); 
		e.clearExceptions();
		v.verifyEmail(that.emailInput.getValue()); v.verifyPassword(that.passwordInput.getValue()); v.verifyReturnBoolean(that.checkbox.getValue());
		
		if (e.areThereExceptions() == false) {
			var obj = {
				email: that.emailInput.getValue(),
				password: that.passwordInput.getValue(),
				rememberMe: that.checkbox.getValue()
			}
			var loggedInCallback = function() {
				if (facebookSyncNeeded == true) {
					var facebookSyncRequest = new Request("synchronizeWithFacebook", {}, {}, false, null, null);
					facebookSyncRequest.getResponse();	
				}
				$("#hiddenEmail").val(obj.email);
				$("#hiddenPass").val(obj.password);
				$("#hiddenSubmit").click();
			}
			var errorCallback = function() {
				that.loginButton.displayError(e.printExceptions());
				that.bindPasswordInputKeydown();
			}
			that.loginButton.ajaxSuspend();
			var loginRequest = new Request("loginUser", {}, obj, false, loggedInCallback, errorCallback);
			loginRequest.getResponse();	
		}
		else {
			that.loginButton.displayError(e.printExceptions());
			that.bindPasswordInputKeydown();
		}			
	}
	
	/******** Forgot Password Callback *****/
	var forgotCallback = function() {
		$("#" + that.DOMID).append(that.loginForgotPass.generateInput());
		that.loginForgotPass.bindInput();
	};
	
	/******** Forgot Password Success Callback *****/
	var successCallback = function() {
		that.loginButton.displaySuccessMessage('Password reset.  Check your email.');
	};
	
	/******** Error Callback *****/	
	var errorCallback = function(error) {
		that.loginButton.displayError(ExceptionsManager.getInstance().printExceptions());
	};
	
	/******** Login Click Callback *****/	
	var clickCallback = function() {
		that.loginButton.ajaxSuspend();
	}	
	
	this.loginForgotPass = new LoginForgotPass(DOMID + "loginForgotPass", forgotCallback, clickCallback, successCallback, errorCallback);
	this.loginButton = new LoginButton(DOMID + "LoginButton", this.loginCallback);
	this.emailInput = new TextInput(DOMID + "EmailInput", null, false);
	this.passwordInput = new TextInput(DOMID + "PasswordInput", null, true);
	this.checkbox = new Checkbox(DOMID + "RememberCheckbox", false);
	
	/******** Facebook Sync Callback *****/	
	var facebookSyncCallback = function() {
		$("#" + that.DOMID).oneTime(700, function() {
			that.loginButton.displayError("Your facebook account must be synced.  Please login reguarly this one time.");
			facebookSyncNeeded = true;								  
		});
	}
	
	/******** Twitter Sync Callback *****/	
	var twitterSyncCallback = function() {
		$("#" + that.DOMID).oneTime(700, function() {
			that.loginButton.displayError("Your twitter account must be synced.  Please login reguarly this one time.");						  
		});
	}
	
	this.twitterLoginButton = new TwitterLoginButton(DOMID + "TwitterLogin", twitterSyncCallback);
	this.facebookLoginButton = new FacebookLoginButton(DOMID + "FacebookLogin", facebookSyncCallback);
	this.firstOpen = true;
	
}

/******** Lightbox Prototype Callback *****/	
LoginLightBox.prototype = {
	
	titleImageSource: "Images/lightBoxTitle.png",
	titleImageClass: "loginLightBoxImage",
	titleLabelClass: "loginLightBoxTitleLabel",
	titleLabel: "Not on Hangchillparty yet?",
	loginLightBoxClass: "loginLightBox",
	emailClass: "loginLightBoxEmail",
	passwordClass: "loginLightBoxPass",
	rememberMeClass: "loginLightBoxRememberMe",
	orClass: "loginLightOr",
	
	/******** Generates HTML *****/
	generate: function() {
		var retStr = '<div id="' + this.DOMID + '" class="' + this.loginLightBoxClass + '">';
		retStr += '<img src="' + this.titleImageSource + '" class="' + this.titleImageClass + '" /><br />';
		retStr += '<span class="' + this.titleLabelClass + '">' + this.titleLabel + '</span>' + this.registerLink.generate();
		retStr += this.facebookLoginButton.generate() + this.twitterLoginButton.generate() + '<br /><div class="' + this.orClass + '"><span>or</span></div>';
		retStr += '<div class="' + this.emailClass + '"><span>Email</span>' + this.emailInput.generate() + '</div>';
		retStr += '<div class="' + this.passwordClass + '"><span>Password</span>' + this.passwordInput.generate() + '</div>';
		retStr += this.checkbox.generate() + '<span class="' + this.rememberMeClass + '">Remember me</span>';
		retStr += this.loginForgotPass.generate() + this.loginButton.generate() + '</div>';
		return retStr;
	},
	
	/******** Binds Links/Inputs *****/
	bind: function() {
		this.registerLink.bind(); this.facebookLoginButton.bind(); this.emailInput.bind(); this.checkbox.bind(); this.loginButton.bind(); this.passwordInput.bind(); this.twitterLoginButton.bind(); this.loginForgotPass.bind();
		this.bindPasswordInputKeydown();
	},
	
	/******** Binds Password Input *****/	
	bindPasswordInputKeydown: function() {
		var that = this;
		$("#" + this.passwordInput.getDOMID() + ", #" + this.emailInput.getDOMID()).keydown(function(e) {
			if (e.which == 13) {
				that.passwordInput.saveCurrentValue();
				$(this).unbind("keydown");
				that.loginCallback();			
			}
		});		
	},
	
	/******** Displays Lightbox *****/
	displayLightBox: function() {
		var that = this;
		var onloadFunction =  function() { 
            that.emailInput.focusOn();
			if (that.firstOpen == true) {
				that.firstOpen = false;
				var loginEm = $("#hiddenEmail").val() == "" ? null : $("#hiddenEmail").val();
				var loginPass = $("#hiddenPass").val() == "" ? null : $("#hiddenPass").val();
				that.emailInput.setValue(loginEm);
				that.passwordInput.setValue(loginPass);
			}
        }
		var insObj = {
        	onLoad: onloadFunction,
			closeSelector: ".lightBoxSignUpLink",
			modalCSS: {top: '136px'}
        }
		$('#' + this.DOMID).lightbox_me(insObj);
	}
	
};
