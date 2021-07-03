var MainMenuBar = (function() {

	var instance = false;
	var weuttLogo = new WeuttLogo(106, 40, "MainMenuWeuttLogo");
	var weuttLink = new WeuttLink();
	var findFriendsLink = new FindFriendsLink();
	var alertsLink = new AlertsLink();
	var settingsLink = new SettingsLink();
	var logoutLink = new LogoutLink("MainMenuLogoutLink");
	var nameLink = new NameLink();
	

	function constructor() {
	
        return {
		
            generate: function() {
                				
			},
			
			bind: function() {
			
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