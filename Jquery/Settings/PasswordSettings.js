
var PasswordSettings = (function() {


	var instance = false;


	function constructor() {
		

		var DOMID = "PasswordSettings";
		var newPasswordInput = new PasswordInput("settings", true);
		var passwordSettingsResults = new SettingsResults("PasswordSettingsResults", updatePasswordSettings);
		
		function updatePasswordSettings(passwordEntered) {
			var e = ExceptionsManager.getInstance(), v = VerificationManager.getInstance(); 
			e.clearExceptions();
			 var obj = {
				currentPassword: passwordEntered,
				password: newPasswordInput.getNewPassword(),
				passwordVerified: newPasswordInput.getNewPasswordAgain()
			}
			v.verifyPassword(passwordEntered); v.verifyPassword(obj.password); 
			v.verifyPassword(obj.passwordVerified); v.verifyPasswordsEqual(obj.password, obj.passwordVerified);
			if (e.areThereExceptions() == false)
				Settings.getInstance().updateSettings(passwordSettingsResults, "setPasswordSettings", obj)
			else
				passwordSettingsResults.displayError(e.printExceptions()).generateSaveButton().bind();
		}
		
	
        return {

            generate: function() {
				var retStr = '<div id="' + DOMID + '">' + newPasswordInput.generate() + passwordSettingsResults.generate() + '</div>';
				return retStr;
			},
			
			
			bind: function() {
				newPasswordInput.bind(); passwordSettingsResults.bind();
			}
			
		}
	
	}
	
	
	return {
	
		getInstance: function() {
			if(!instance) {
				instance = constructor();
			}
			return instance;
		}
		
	}		
	
})();