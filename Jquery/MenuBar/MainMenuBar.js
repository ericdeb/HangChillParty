var MainMenuBar = (function() {


	var instance = false;	


	function constructor(basicUser) {

		var DOMID = "mainMenuBar";
		
		var intObj = {
			
			hangchillpartyLogo: new HangchillpartyLogo("mainMenuHangchillpartyLogo"),
			hangchillpartyLink: new HangchillpartyLink(),
			findFriendsLink: new FindFriendsLink(),
			alertsLink: new AlertsLink(),
			settingsLink: new SettingsLink(),
			logoutLink: new LogoutLink("mainMenuLogoutLink"),
			nameLink: new NameLink("mainMenuProfileLink", basicUser)
			
		}
	
        return {
		
            generate: function() {
				var retStr = '<div id="' + DOMID + '">', io = intObj;
				retStr += '<div id="upperLeftTopLinks">' + io.nameLink.generate() + io.settingsLink.generate() + io.logoutLink.generate() + '</div>';
				retStr += io.hangchillpartyLogo.generate();
				retStr += '<div id="mainTopLinks">' + io.hangchillpartyLink.generate() + io.findFriendsLink.generate() + io.alertsLink.generate() + '</div>';
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
			
			getFindFriendsLink: function() {
				return intObj.findFriendsLink;
			},
			
			
			getAlertsLink: function() {
				return intObj.alertsLink;
			},
			
			
			getHangchillpartyLink: function() {
				return intObj.hangchillpartyLink;	
			},
			
			getSettingsLink: function() {
				return intObj.settingsLink;	
			},
			
			setAllWhite: function() {
				$("#" + DOMID + " a").css('color', "#FFF");
				intObj.hangchillpartyLink.setWhite();
				intObj.findFriendsLink.setWhite();
				intObj.alertsLink.setWhite();
			}
			
		}
	
	}
	
	
	return {
	
		getInstance: function() {
			if(instance)
				return instance;		
		},
		
		
		constructor: function(basicUser) {
			
			if (!instance) 
				return instance = constructor(basicUser);
			
		}
		
	}
	
})();