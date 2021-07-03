
var SocialNetworkSettings = (function() {


	var instance = false;


	function constructor(socialNetworksData) {
		

		var DOMID = "socialNetworksSettings";
		var socialNetworksSettingsLabelDOMID = "socialNetworksSettingsLabel";
		var socialNetworksSettingsLabel = "Signal your friends on social networks when you want to chill.";
		var socialNetworkSettingsResults = new SettingsResults("socialNetworkSettingsResults", updateSocialNetworksSettings);
		
		var socialNetworksSettingsFacebookLabelDOMID = "socialNetworksSettingsFacebookLabel";
		var socialNetworksSettingsFacebookCheckboxLabelDOMID = "socialNetworksSettingsFacebookCheckboxLabel";
		var publishToMyFacebookSettingsCheckbox = new Checkbox("publishToMyFacebookSettingsCheckbox", socialNetworksData.fbp);
		var publishToMyFacebookLabel = 'Have the <strong>"publish to my facebook"</strong> checkbox start as checked (you can uncheck it anytime)';
		var facebookCheckbox = new FacebookCheckbox("socialNetworkSettingsFacebookCheckboxDiv", publishToMyFacebookLabel, publishToMyFacebookSettingsCheckbox);
		var facebookSettingsButton = new FacebookSettingsButton();
		
		var socialNetworksSettingsTwitterLabelDOMID = "socialNetworksSettingsTwitterLabel";
		var socialNetworksSettingsTwitterCheckboxLabelDOMID = "socialNetworksSettingsTwitterCheckboxLabel";
		var publishToMyTwitterSettingsCheckbox = new Checkbox("publishToMyTwitterSettingsCheckbox", socialNetworksData.twp);
		var publishToMyTwitterLabel = 'Have the <strong>"publish to my twitter"</strong> checkbox start as checked (you can uncheck it anytime)';
		var twitterCheckbox = new TwitterCheckbox("socialNetworkSettingsTwitterCheckboxDiv", publishToMyTwitterLabel, publishToMyTwitterSettingsCheckbox);
		var twitterSettingsButton = new TwitterSettingsButton();
		

		
		function updateSocialNetworksSettings(passwordEntered) {
			 var e = ExceptionsManager.getInstance(), v = VerificationManager.getInstance(); 
			 e.clearExceptions();
			 var obj = {
				 currentPassword: passwordEntered,
				 facebookPublish: publishToMyFacebookSettingsCheckbox.getValue(),
				 twitterPublish: publishToMyTwitterSettingsCheckbox.getValue()
			}
			v.verifyReturnBoolean(obj.facebookPublish); v.verifyReturnBoolean(obj.twitterPublish); v.verifyPassword(passwordEntered);
			if (e.areThereExceptions() == false)
				Settings.getInstance().updateSettings(socialNetworkSettingsResults, "setSocialNetworkSettings", obj)
			else
				socialNetworkSettingsResults.displayError(e.printExceptions()).generateSaveButton().bind();
		}
		
	
        return {

            generate: function() {
				var retStr = '<div id="' + DOMID + '"><span id="' + socialNetworksSettingsLabelDOMID + '">' + socialNetworksSettingsLabel + '</span><br />';
				retStr += '<span id="' + socialNetworksSettingsFacebookLabelDOMID + '">Facebook:</span>' + facebookSettingsButton.generate();
				retStr += facebookCheckbox.generate() + '<span id="' + socialNetworksSettingsTwitterLabelDOMID + '">Twitter:</span>';
				retStr += twitterSettingsButton.generate() + twitterCheckbox.generate() + socialNetworkSettingsResults.generate() + '</div>';
				return retStr;
			},
			
			
			bind: function() {
				facebookCheckbox.bind(); facebookSettingsButton.bind(); socialNetworkSettingsResults.bind(); twitterCheckbox.bind(); twitterSettingsButton.bind();
			},
						
			
			getDOMID: function() {
				return DOMID;	
			},
			
			
			getFacebookSettingsButton: function() {
				return facebookSettingsButton;
			},
			
			
			getFacebookCheckbox: function() {
				return facebookCheckbox;	
			},
			
			getTwitterCheckbox: function() {
				return twitterCheckbox;	
			}			
			
		}
	
	}
	
	
	return {
	
		getInstance: function() {
			if(instance)
				return instance;		
		},
		
		constructor: function(socialNetworksData) {
			
			if (!instance) 
				return instance = constructor(socialNetworksData);
			
		}
		
	}		
	
})();