
var ProfileSettings = (function() {


	var instance = false;


	function constructor(profileData) {
		

		var DOMID = "profileSettings";
		var topDOMID = "profileSettingsTop";
		var middleDOMID = "profileSettingsMiddle";
		var bottomDOMID = "profileSettingsBottom";
		var firstNameDivDOMID = "profileSettingsFirstName";
		var lastNameDivDOMID = "profileSettingsLastName";
		var genderDivDOMID = "profileSettingsGender";
		var birthdayDivDOMID = "profileSettingsBirthday";
		var blurbDivDOMID = "profileSettingsBlurb";
		var worldRegionDOMID = "profileSettingsWorldRegion";
		var firstNameInput = new TextInput("firstNameInput", profileData.fn);
		var lastNameInput = new TextInput("lastNameInput", profileData.ln);
		var genderRadio = new RadioButton("genderRadio", "male", "female", 0, 1, profileData.gn);
		var birthdayInput = new BirthdayInput("settingsBirthdayInput", profileData.bi);
		var blurbTextArea = new TextArea("blurbTextArea", profileData.bl);				
		var timeZoneInput = new TimeZoneInput("settingsTimeZoneInput", profileData.tzr, profileData.tzz);
		var profileSettingsResults = new SettingsResults("profileSettingsResults", updateProfileSettings);
											  
		function updateProfileSettings(passwordEntered) {
			var e = ExceptionsManager.getInstance(), v = VerificationManager.getInstance(); 
			e.clearExceptions();

			var obj = {
				currentPassword: passwordEntered,
				firstName: firstNameInput.getValue(),
				lastName: lastNameInput.getValue(),
				gender: genderRadio.getValue(),
				birthday: birthdayInput.getValue(),
				blurb: blurbTextArea.getValue(),
				timeZoneID: timeZoneInput.getValue()
			}
			v.verifyFirstName(firstNameInput.getValue()); v.verifyLastName(lastNameInput.getValue()); 
			v.verifyReturnBoolean(genderRadio.getValue()); 
			if (birthdayInput.getValue() != null)
				v.verifyBirthday(birthdayInput.getValue());
			if (blurbTextArea.getValue() != null)
				v.verifyBlurb(blurbTextArea.getValue()); 
			v.verifyPassword(passwordEntered);
			if (e.areThereExceptions() == false)
				Settings.getInstance().updateSettings(profileSettingsResults, "setProfileSettings", obj)
			else
				profileSettingsResults.displayError(e.printExceptions()).generateSaveButton().bind();
		}
		
	
        return {

            generate: function() {
				var retStr = '<div id="' + DOMID + '"><div id="' + topDOMID + '">';
				retStr += '<div id="' + firstNameDivDOMID + '"><span>First Name</span>' + firstNameInput.generate() + '</div>';
				retStr += '<div id="' + lastNameDivDOMID + '"><span>Last Name</span>' + lastNameInput.generate() + '</div>';
				retStr += '<div class="' + genderDivDOMID + '"><span>Sex</span>' + genderRadio.generate() + '</div>';
				retStr += '<div id="' + birthdayDivDOMID + '"><span>Birthday</span>' + birthdayInput.generate() + '</div>';
				retStr += '<div id="' + blurbDivDOMID + '"><span>Quickie</span>' + blurbTextArea.generate() + '</div></div>';
				retStr += '<div id="' + middleDOMID + '">';
				retStr += '</div><div id="' + bottomDOMID + '">';
				retStr += timeZoneInput.generate();
				retStr += profileSettingsResults.generate() + '</div></div>';
				return retStr;
			},
			
			
			bind: function() {
				firstNameInput.bind(); lastNameInput.bind(); genderRadio.bind(); birthdayInput.bind(); 
				blurbTextArea.bind(); timeZoneInput.bind(); profileSettingsResults.bind(); 
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
		
		constructor: function(profileData) {
			
			if (!instance) 
				return instance = constructor(profileData);
			
		}
		
	}		
	
})();