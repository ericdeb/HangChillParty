
var EmailSettings = (function() {


	var instance = false;


	function constructor(emailData) {
		

		var DOMID = "emailSettings";
		var emailSettingsTitleDOMID = "emailSettingsTitle";
		var emailSettingsCheckboxesDOMID = "emailSettingsCheckboxes";
		var emailSettingsTitle = "Email me when...";
		var emailFriendJoinsLabel = "A friend joins my update";
		var emailSignalsGreenLabel = "A friend signals me green in an update";
		var emailSignalsYellowLabel = "A friend signals me yellow in an update";
		var emailFriendAcceptsRequestLabel = "Someone accepts my friend request";
		var emailNewFriendRequestLabel = "Someone requests me as a friend";
		var emailNewFeatureLabel = "Hangchillparty adds or changes a feature";
		var emailFriendJoinsCheckbox = new Checkbox("emailWhenJoinCheckBox", emailData.ej);
		var emailSignalsGreenCheckbox = new Checkbox("emailSignalsGreenCheckBox", emailData.eg);
		var emailSignalsYellowCheckbox = new Checkbox("emailSignalsYellowCheckBox", emailData.ey);
		var emailFriendAcceptsRequestCheckbox = new Checkbox("emailFriendAcceptsRequestCheckbox", emailData.efar);
		var emailNewFriendRequestCheckbox = new Checkbox("emailNewFriendRequestCheckbox", emailData.efnr);
		var emailNewFeatureCheckbox = new Checkbox("emailNewFeatureCheckbox", emailData.ewu);
		var emailSettingsResults = new SettingsResults("emailSettingsResults", updateEmailSettings);
		
		function updateEmailSettings(passwordEntered) {
			var e = ExceptionsManager.getInstance(), v = VerificationManager.getInstance(); 
			e.clearExceptions();			
			 var obj = {
				email_friend_joins: emailFriendJoinsCheckbox.getValue(),
				email_green: emailSignalsGreenCheckbox.getValue(),
				email_yellow: emailSignalsYellowCheckbox.getValue(),
				email_fri_accept_request: emailFriendAcceptsRequestCheckbox.getValue(),
				email_new_fri_request: emailNewFriendRequestCheckbox.getValue(),
				email_hangchillparty_updates: emailNewFeatureCheckbox.getValue()
			}
			for (var key in obj)
				v.verifyReturnBoolean(obj[key]);
			obj.currentPassword = passwordEntered;
			v.verifyPassword(passwordEntered);
			if (e.areThereExceptions() == false)
				Settings.getInstance().updateSettings(emailSettingsResults, "setEmailSettings", obj);
			else
				emailSettingsResults.displayError(e.printExceptions()).generateSaveButton().bind();
		}
		
	
        return {

            generate: function() {
				var retStr = '<div id="' + DOMID + '"><div class="settingsTitle"><span>' + emailSettingsTitle + '</span>';
				retStr += '</div><div id="' + emailSettingsCheckboxesDOMID + '">';
				retStr += emailFriendJoinsCheckbox.generate() + '<span>' + emailFriendJoinsLabel + '</span>';
				retStr += emailSignalsGreenCheckbox.generate() + '<span>' + emailSignalsGreenLabel + '</span>';
				retStr += emailSignalsYellowCheckbox.generate() + '<span>' + emailSignalsYellowLabel + '</span><br /><br />';
				retStr += emailFriendAcceptsRequestCheckbox.generate() + '<span>' + emailFriendAcceptsRequestLabel + '</span>';
				retStr += emailNewFriendRequestCheckbox.generate() + '<span>' + emailNewFriendRequestLabel + '</span>';
				retStr += emailNewFeatureCheckbox.generate() + '<span>' + emailNewFeatureLabel + '</span><br /><br />';
				retStr += '</div>' + emailSettingsResults.generate() + '</div>';
				return retStr;
			},
			
			
			bind: function() {
				emailFriendJoinsCheckbox.bind(); emailSignalsGreenCheckbox.bind(); emailSignalsYellowCheckbox.bind(); emailFriendAcceptsRequestCheckbox.bind(); emailNewFriendRequestCheckbox.bind(); emailNewFeatureCheckbox.bind(); emailSettingsResults.bind();
			},
						
			
			getDOMID: function() {
				return DOMID;	
			}
			
		}
	
	}
	
	
	return {
	
		getInstance: function() {
			if(instance)
				return instance;		
		},
		
		constructor: function(emailData) {
			
			if (!instance) 
				return instance = constructor(emailData);
			
		}
		
	}		
	
})();