var SettingsResults = function(DOMID, searchCallback) {
	
	var that = this;
	
	var saveButtonCallback = function() {
		that.generatePasswordInput().bindPasswordInput();
	}
	
	this.resultsSearchCallback = function() {
		$("#" + that.DOMID).oneTime(20, function() {
			that.focused = true;				 
		});
		$("." + that.passwordInputClass).remove();
		searchCallback(that.passwordInput.getValue());
	}
	
	this.DOMID = DOMID;
	this.passwordInputDOMID = this.DOMID + "passwordRequest";
	this.settingsSaveButton = new SettingsSaveButton(this.DOMID + "SaveButton", saveButtonCallback);
	this.settingsSubmitButton = new SettingsSubmitButton(this.DOMID + "SubmitButton", this.resultsSearchCallback);
	this.passwordInput = new TextInput(this.passwordInputDOMID, null, true);
	this.focused = false;
	
}


SettingsResults.prototype = {
	
	settingsResultsClass: "settingsResults",
	responseMessageClass: "settingsResultsResponse",
	passwordInputClass: "settingsResultsPassword",
	passwordInputMessage: 'Enter your current password to save',
	errorClass: "settingsResultsError",
	successClass: "settingsSuccess",
	settingsLoadClass: "settingsLoad",
	

	generate: function() {
		var retStr = '<div id="' + this.DOMID + '" class="' + this.settingsResultsClass + '">' + this.settingsSaveButton.generate() + '</div>';
		return retStr;
	},
	
	
	generateSaveButton: function() {
		$("#" + this.settingsLoadClass + ", ." + this.passwordInputClass).remove();
		this.passwordInput.clear();
		$("#" + this.DOMID).prepend(this.settingsSaveButton.generate());
		return this;
	},
	
	
	bind: function() {
		 this.settingsSaveButton.bind();
	},	
	
	
	getSaveButton: function() {
		return this.settingsSaveButton;
	},
	
	
	generatePasswordInput: function() {
		var str = '<div class="' + this.passwordInputClass + '"><span>' + this.passwordInputMessage + '</span>';
		str +=  this.passwordInput.generate() + this.settingsSubmitButton.generate() + '</div>';
		$("#" + this.DOMID).html(str);
		$("#" + this.passwordInputDOMID).focus();
		return this;
	},
	
	
	bindPasswordInput: function() {
		var that = this;
		this.passwordInput.bind(); this.settingsSubmitButton.bind();
		$("#" + this.passwordInputDOMID).blur(function() {
			that.focused = false;
			$("#" + that.DOMID).oneTime(150, function() {
				if (that.focused == false)
					that.generateSaveButton().bind();
			});
		})
		.keydown(function(e) {
			if (e.which == 13) {
				that.passwordInput.saveCurrentValue();
				that.resultsSearchCallback();
			}
		});	
		return this;
	},
	
	
	displayLoadingImage: function() {
		$("." + this.responseMessageClass).remove();
		var loadingImage = new LoadingImage(this.settingsLoadClass, 50, 50);
		$("#" + this.DOMID).html(loadingImage.generate());
		return this;
	},
	
	
	displayMessage: function(message) {
		$("." + this.responseMessageClass + ", #" + this.settingsLoadClass).remove();
		var ins = '<div class="' + this.responseMessageClass + '"><span>' + message + '</span></div>';
		$("#" + this.DOMID).append(ins);
		$("." + this.responseMessageClass + " span").removeClass(this.errorClass).removeClass(this.successClass);
	},
	
	
	fadeOutMessage: function(message, callback) {
		this.displayMessage(message);
		$("." + this.responseMessageClass).fadeOut(2000, callback);
	},
	
	
	displayError: function(error) {
		$("." + this.responseMessageClass + ", #" + this.settingsLoadClass).remove();
		var ins = '<div class="' + this.responseMessageClass + '"><span>' + error + '</span></div>';
		$("#" + this.DOMID).append(ins);
		$("." + this.responseMessageClass + " span").removeClass(this.successClass).addClass(this.errorClass);
		return this;
	},
	
	
	fadeOutSuccessMessage: function(message, callback) {
		this.displayMessage(message);
		$("." + this.responseMessageClass + " span").addClass(this.successClass);
		$("." + this.responseMessageClass).fadeOut(1500, callback);
	}
	
};

		