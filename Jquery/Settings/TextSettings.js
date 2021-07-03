
var TextSettings = (function() {


	var instance = false;


	function constructor(textData) {
		
		var DOMID = "textSettings";
		var textSettingsTitleDOMID = "textSettingsTitle";
		var textSettingsTinyMessageDOMID = "textSettingsTinyMessage";
		var textSettingsCheckboxesDOMID = "textSettingsCheckboxes";
		var textSettingsTitle = "Text me when...";
		var textSettingsTinyMessage = "Make sure to enter your cell in the email and cell page.";
		var textfriendJoinsLabel = "A friend joins my update";
		var textSignalsGreenLabel = "A friend signals me green in an update";
		var textSignalsYellowLabel = "A friend signals me yellow in an update";
		var textFriendJoinsCheckbox = new Checkbox("textWhenJoinCheckBox", textData.tj);
		var textSignalsGreenCheckbox = new Checkbox("textSignalsGreenCheckBox", textData.tg);
		var textSignalsYellowCheckbox = new Checkbox("textSignalsYellowCheckBox", textData.ty);
		var textSettingsResults = new SettingsResults("textSettingsResults", updateTextSettings);
		
		function updateTextSettings(passwordEntered) {
			var e = ExceptionsManager.getInstance(), v = VerificationManager.getInstance(); 
			e.clearExceptions();	
			 var obj = {
				currentPassword: passwordEntered,
				text_friend_joins: textFriendJoinsCheckbox.getValue(),
				text_green: textSignalsGreenCheckbox.getValue(),
				text_yellow: textSignalsYellowCheckbox.getValue()
			}
			v.verifyReturnBoolean(obj.text_friend_joins);  v.verifyReturnBoolean(obj.text_green); 
			v.verifyPassword(passwordEntered); v.verifyReturnBoolean(obj.text_yellow);
			if (e.areThereExceptions() == false)
				Settings.getInstance().updateSettings(textSettingsResults, "setTextSettings", obj);
			else
				textSettingsResults.displayError(e.printExceptions()).generateSaveButton().bind();
		}
		
	
        return {

            generate: function() {
				var retStr = '<div id="' + DOMID + '"><div class="settingsTitle"><span>' + textSettingsTitle + '</span><br />';
				retStr += '<span id="' + textSettingsTinyMessageDOMID + '" class="tinyMessage">' + textSettingsTinyMessage + '</span></div><div id="' + textSettingsCheckboxesDOMID + '">';
				retStr += textFriendJoinsCheckbox.generate() + '<span>' + textfriendJoinsLabel + '</span>';
				retStr += textSignalsGreenCheckbox.generate() + '<span>' + textSignalsGreenLabel + '</span>';
				retStr += textSignalsYellowCheckbox.generate() + '<span>' + textSignalsYellowLabel + '</span>';
				retStr += '</div>' + textSettingsResults.generate() + '</div>';
				return retStr;
			},
			
			
			bind: function() {
				textFriendJoinsCheckbox.bind(); textSignalsGreenCheckbox.bind(); textSignalsYellowCheckbox.bind(); textSettingsResults.bind();
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
		
		constructor: function(textData) {
			
			if (!instance) 
				return instance = constructor(textData);
			
		}
		
	}		
	
})();