var LoginForgotPass = function(DOMID, forgotCallback, clickCallback, successCallback, errorCallback) {

	this.DOMID = DOMID;
	this.linkDOMID = DOMID + "Link";
	this.submitButtonDOMID = DOMID + "SubmitButton";
	this.textInputDOMID = DOMID + "TextInput";
	this.forgotInput = new TextInput(this.textInputDOMID, "", false);
	this.forgotCallback = forgotCallback;
	this.successCallback = successCallback;
	this.clickCallback = clickCallback;
	this.errorCallback = errorCallback;
	
}


LoginForgotPass.prototype = {
	
	loginForgotPassClass: "loginForgotPassLink",
	divClass: "loginForgotPass",
	errorClass: "loginForgotPassError",
	submitButtonImage: "Images/settingsSubmitButton.png",
	
	generate: function() {
		return '<a href="#" id="' + this.linkDOMID + '" class="' + this.loginForgotPassClass + '">forgot?</a>';
	},

	generateInput: function() {
		return '<div id="' + this.DOMID + '" class="' + this.divClass + '"><span>Email</span>' + this.forgotInput.generate() + '<img id="' + this.submitButtonDOMID + '" src="' + this.submitButtonImage + '" /></div>';
	},
	
	bind: function() {
		var that = this;
		$("#" + this.linkDOMID).click(function() {
			that.forgotCallback();
		})
	},
	
	bindInput: function() {
		var that = this, focusedOn = false;
		$("#" + this.submitButtonDOMID).click(function() {
			var e = ExceptionsManager.getInstance(); e.clearExceptions();
			$(this).oneTime(20, function() {
				focusedOn = true;		
			});
			var tempErrorCallback = function () {
				that.errorCallback(e.printExceptions());				
			}
			var tempSuccessCallback = function () {
				that.successCallback();			
				$("#" + that.DOMID).remove();
				that.forgotInput.clear();
			}
			that.forgotInput.saveCurrentValue();
			VerificationManager.getInstance().verifyEmail(that.forgotInput.getValue());
			if (e.areThereExceptions() == false) {
				that.clickCallback();
				var insObj = {email: that.forgotInput.getValue()};
				var loginForgotPass = new Request("sendForgottenPassword", insObj, {}, false, tempSuccessCallback, tempErrorCallback);
				loginForgotPass.getResponse();	
			}
			else
				tempErrorCallback();
			return false;										   
		});
		$("#" + this.textInputDOMID).blur(function() {
			focusedOn = false
			$(this).oneTime(150, function() {
				if (focusedOn == false)
					$("#" + that.DOMID).remove();		
			});
		}).focus();
	}

	
};
