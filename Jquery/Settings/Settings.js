
var Settings = (function() {


	var instance = false;


	function constructor(alertSettings, userSettings, socialNetworkSettings) {

		var DOMID = "settings";
		var DOMIDinner = "settingsInner";
		var settingsHeadingLabelDOMID = "settingsHeading";
		var settingsTabsDOMID = "settingsTabs";
		var settingsHeadingLabel = new HeadingLabel(settingsHeadingLabelDOMID, "Text Updates");
		var settingsTabs = new Tabs(settingsTabsDOMID, settingsTabsDOMID + "Heading", 7)
		var settingsSideBar = SettingsSideBar.getInstance();
		
		for (var key in alertSettings)
			alertSettings[key] = alertSettings[key] == 0 ? false : true;			
			
		for (var key in socialNetworkSettings)
			socialNetworkSettings[key] = socialNetworkSettings[key] == 0 ? false : true;
			
		
		var intObj = {
			textSettings: TextSettings.constructor(alertSettings),
			emailSettings: EmailSettings.constructor(alertSettings),
			contactSettings: ContactSettings.constructor(userSettings),
			socialNetworkSettings: SocialNetworkSettings.constructor(socialNetworkSettings),
			profileSettings: ProfileSettings.constructor(userSettings),
			imageSettings: ImageSettings.getInstance(),
			passwordSettings: PasswordSettings.getInstance()
		}
		
	
        return {

            generate: function() {
				var retStr = '<div id="' + DOMID + '" class="' + DOMID + '"><div id="' + DOMIDinner + '">' + settingsHeadingLabel.generate();
				retStr += settingsSideBar.generate() + settingsTabs.generate() + '<div class="floatFake"></div></div></div>';
				$("#" + InitializeManager.getInstance().getMainTabs().getDOMID() + "-6").html(retStr);
				$("#" + settingsTabs.getDOMID() + '-1').html(intObj.textSettings.generate());
				$("#" + settingsTabs.getDOMID() + '-2').html(intObj.emailSettings.generate());
				$("#" + settingsTabs.getDOMID() + '-3').html(intObj.contactSettings.generate());
				$("#" + settingsTabs.getDOMID() + '-4').html(intObj.socialNetworkSettings.generate());
				$("#" + settingsTabs.getDOMID() + '-5').html(intObj.profileSettings.generate());
				$("#" + settingsTabs.getDOMID() + '-6').html(intObj.imageSettings.generate());
				$("#" + settingsTabs.getDOMID() + '-7').html(intObj.passwordSettings.generate());
			},
			
			
			bind: function() {
				settingsTabs.bind();
				settingsSideBar.bind();
				for (var key in intObj)
					intObj[key].bind();				
			},

			
			updateSettings: function(resultsDiv, updateType, updateObject, callback) {
				var e = ExceptionsManager.getInstance();
				var errorCallback = function() {
					resultsDiv.displayError(e.printExceptions()).generateSaveButton().bind();
					if (callback != null)
						callback();
				}
				var updateCallback = function() {
					var messageCallback = function() {
						resultsDiv.generateSaveButton().bind();
					}
					resultsDiv.fadeOutSuccessMessage('Successful', messageCallback);
					if (callback != null)
						callback();
				}
				resultsDiv.displayLoadingImage();
				var settingsRequest = new Request(updateType, {}, updateObject, false, updateCallback, errorCallback);
				settingsRequest.getResponse();
			},
			
			
			getDOMID: function() {
				return DOMID;	
			},
			
			
			getSettingsTabs: function() {
				return settingsTabs;
			},
			
			
			getHeadingLabel: function() {
				return settingsHeadingLabel;
			}
			
		}
	
	}
	
	
	return {
	
		getInstance: function() {
			if(instance)
				return instance;		
		},
		
		constructor: function(alertSettings, userSettings, socialNetworkSettings) {
			
			if (!instance) 
				return instance = constructor(alertSettings, userSettings, socialNetworkSettings);
			
		}
		
	}		
	
})();