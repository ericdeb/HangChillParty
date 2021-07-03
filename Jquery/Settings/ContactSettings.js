
var ContactSettings = (function() {


	var instance = false;


	function constructor(contactData) {
		

		var DOMID = "contactSettings";
		var currentEmailLabel = "Current Email";
		var currentPhoneLabel = "Current Cell";
		var currentEmailDivDOMID = "currentEmail";
		var currentPhoneDivDOMID = "currentPhone";
		var currentEmailTinyMessage = "This is your login email";
		var currentPhoneTinyMessage = "Text Updates will be sent here";
		var currentEmailTinyMessageDOMID = "currentEmailMessage";
		var currentPhoneTinyMessageDOMID = "currentPhoneMessage";
		var currentEmailInput = new TextInput("currentEmailInput", contactData.em);
		if (contactData.ph != null) 
			var phoneInsOne = contactData.ph.substr(0,3), phoneInsTwo = contactData.ph.substr(3,3), phoneInsThree = contactData.ph.substr(6,4);
		else
			var phoneInsOne = null, phoneInsTwo = null, phoneInsThree = null; 
		var currentPhoneInputOne = new TextInput("currentPhoneInputOne", phoneInsOne);
		var currentPhoneInputTwo = new TextInput("currentPhoneInputTwo", phoneInsTwo);
		var currentPhoneInputThree = new TextInput("currentPhoneInputThree", phoneInsThree);
		var contactSettingsResults = new SettingsResults("contactSettingsResults", updatecontactSettings);

		function updatecontactSettings(passwordEntered) {
			var e = ExceptionsManager.getInstance(), v = VerificationManager.getInstance(), phoneIns = null;
			e.clearExceptions();
			if (currentPhoneInputOne.getValue() != null || currentPhoneInputTwo.getValue() != null || currentPhoneInputThree.getValue() != null)
				phoneIns = v.removeSpaces(currentPhoneInputOne.getValue() + currentPhoneInputTwo.getValue() + currentPhoneInputThree.getValue());
			var obj = {
				currentPassword: passwordEntered,
				phone: phoneIns,
				email: currentEmailInput.getValue()
			}
			if (obj.phone != null)
				v.verifyPhone(obj.phone); 
			if (obj.email != null)
				v.verifyEmail(obj.email);
			v.verifyPassword(passwordEntered); 
			if (e.areThereExceptions() == false)
				Settings.getInstance().updateSettings(contactSettingsResults, "setContactSettings", obj)
			else
				contactSettingsResults.displayError(e.printExceptions()).generateSaveButton().bind();
		}
		
	
        return {

            generate: function() {
				var retStr = '<div id="' + DOMID + '"><div class="' + currentEmailDivDOMID + '"><span>' + currentEmailLabel + '</span>';
				retStr += currentEmailInput.generate() + '<br /><span id="' + currentEmailTinyMessageDOMID + '" class="tinyMessage">';
				retStr += currentEmailTinyMessage + '</span></div><div class="' + currentPhoneDivDOMID + '"><span>' + currentPhoneLabel + '</span>';
				retStr += currentPhoneInputOne.generate() + currentPhoneInputTwo.generate() + currentPhoneInputThree.generate();
				retStr += '<br /><span id="' + currentPhoneTinyMessageDOMID + '" class="tinyMessage">' + currentPhoneTinyMessage + '</span></div>';
				retStr += contactSettingsResults.generate() + '</div>';
				return retStr;
			},
			
			
			bind: function() {
				currentEmailInput.bind(); currentPhoneInputOne.bind(); currentPhoneInputTwo.bind(); currentPhoneInputThree.bind(); contactSettingsResults.bind();
			},
			
			
			getPhoneValue: function() {
				return currentPhoneInputOne.getValue() + currentPhoneInputTwo.getValue() + currentPhoneInputThree.getValue();
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
		
		constructor: function(contactData) {
			
			if (!instance) 
				return instance = constructor(contactData);
			
		}
		
	}		
	
})();