
var SettingsSideBar = (function() {


	var instance = false;


	function constructor() {
		
		var DOMID = "settingsSideBar";
		var settingsSideBarClass = "tabsSideBar";
		var textSettingsLinkDOMID = "textSettingsLink";
		var textSettingsLabel = "Text Updates";
		var emailSettingsLinkDOMID = "emailSettingsLink";
		var emailSettingsLabel = "Email Updates";
		var contactSettingsLinkDOMID = "contactSettingsLink";
		var contactSettingsLabel = "Email and Cell";
		var socialNetworkSettingsLinkDOMID = "socialSettingsLink";
		var socialNetworkSettingsLabel = "Social Networks";
		var profileSettingsLinkDOMID = "profileSettingsLink";
		var profileSettingsLabel = "Profile";
		var pictureSettingsLinkDOMID = "pictureSettingsLink";
		var pictureSettingsLabel = "Picture";
		var passwordSettingsLinkDOMID = "passwordLink";
		var passwordSettingsLabel = "Password";
		
		var intObj = {
			textSettingsLink:  new SettingsSideLink(textSettingsLinkDOMID, textSettingsLabel, textSettingsLabel, 0, true),
			emailSettingsLink:  new SettingsSideLink(emailSettingsLinkDOMID, emailSettingsLabel, emailSettingsLabel, 1, false),
			contactSettingsLink:  new SettingsSideLink(contactSettingsLinkDOMID, contactSettingsLabel, contactSettingsLabel, 2, false),
			socialNetworkSettingsLink:  new SettingsSideLink(socialNetworkSettingsLinkDOMID, socialNetworkSettingsLabel, socialNetworkSettingsLabel, 3, false),
			profileSettingsLink:  new SettingsSideLink(profileSettingsLinkDOMID, profileSettingsLabel, profileSettingsLabel, 4, false),
			pictureSettingsLink:  new SettingsSideLink(pictureSettingsLinkDOMID, pictureSettingsLabel, pictureSettingsLabel, 5, false),
			passwordSettingsLink:  new SettingsSideLink(passwordSettingsLinkDOMID, passwordSettingsLabel, passwordSettingsLabel, 6, false)
		}
		
	
        return {

            generate: function() {
				var retStr = '<div id="' + DOMID + '" class="' + settingsSideBarClass + '">';
				for (var key in intObj)
					retStr += intObj[key].generate();
				retStr += '</div>';
				return retStr;
			},
			
			
			bind: function() {
				for (var key in intObj)
					intObj[key].bind();
			},
			
			
			getDOMID: function() {
				return DOMID;	
			},
			
			
			getContactSettingsLink: function() {
				return intObj.contactSettingsLink;	
			},
			
			
			getSocialNetworkSettingsLink: function() {
				return intObj.socialNetworkSettingsLink;	
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