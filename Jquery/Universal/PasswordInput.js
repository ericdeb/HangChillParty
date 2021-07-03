var PasswordInput = function(DOMID, newPassBool) {
	
	this.newPasswordLabel = newPassBool == true ? "New Password" : "Password";
	this.newPasswordAgainLabel = "Again";
	this.newPasswordDivDOMID = DOMID + "NewPassword";
	this.newPasswordAgainDivDOMID = DOMID + "NewPasswordAgain";
	this.newPasswordTinyMessageDOMID = DOMID + "TinyMessage";
	this.newPasswordTinyMessage = "5 character min";
	this.newPasswordInput = new TextInput(DOMID + "NewPasswordInput", null, true);
	this.newPasswordAgainInput = new TextInput(DOMID + "NewPasswordAgainInput", null, true);
	
};


PasswordInput.prototype = {
	
	generate: function() {
		var retStr = '<div id="' + this.newPasswordDivDOMID + '"><span>' + this.newPasswordLabel + '</span>';
		retStr += this.newPasswordInput.generate() + '<br /><span id="' + this.newPasswordTinyMessageDOMID + '">' + this.newPasswordTinyMessage + '</span></div>';
		retStr += '<div id="' + this.newPasswordAgainDivDOMID + '"><span>' + this.newPasswordAgainLabel + '</span>';
		retStr += this.newPasswordAgainInput.generate() + '</div>';
		return retStr;
	},
			
			
	bind: function() {
		this.newPasswordInput.bind(); this.newPasswordAgainInput.bind();
	},
	
	
	getNewPassword: function() {
		return this.newPasswordInput.getValue();
	},
	
	
	getNewPasswordAgain: function() {
		return this.newPasswordAgainInput.getValue();
	},
	
	
	getNewPasswordAgainInput: function() {
		return this.newPasswordAgainInput;
	}
	
	
};
