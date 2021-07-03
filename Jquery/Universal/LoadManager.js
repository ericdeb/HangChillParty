var LoadManager = (function() {

	var instance = false;
	var classPath = 'Jquery/', pluginsPath = 'IncludesJS/', cssPath = 'Styles/';
	var alertsPath = 'Alerts/', friendsSearchPath = 'FriendsSearch/', menuBarPath = 'MenuBar/', statusPath = 'Status/', universalPath = 'Universal/', updatesPath = 'Updates/', profilesPath = 'Profiles/', settingsPath = 'Settings/', helpPath = 'Help/', awardsPath = 'Awards/';
	
	
	var alertsAR = [
	'AlertDay',
	'Alerts',
	'FriendRequestAlert',
	'FriendshipAlert',
	'NewsItemAlert',
	'RequestAcceptedAlert'		  
	];
	
	var friendsSearchAR = [
	'EmailFriendsLink',
	'FacebookYourFriendsLink',
	'FindFriends',
	'FriendsSearchSideBar',
	'InviteEmailFriends',
	'InviteEmailFriendsButton'
	];
	
	var menuBarAR = [
	'AlertsLink',
	'FindFriendsLink',
	'LogoutLink',
	'MainMenuBar',
	'SettingsLink',
	'HangchillpartyLink',
	'HangchillpartyLogo'
	];
	
	
	var profilesAR = [
	'FacebookLink',
	'FriendsOfLink',
	'Profiles',
	'ProfileUpdate',
	'UserProfile',
	'SocialMeter',
	'TwitterLink'
	];
	
	
	var settingsAR = [
	'ContactSettings',
	'EmailSettings',
	'FacebookSettingsButton',
	'ImageSettings',
	'PasswordSettings',
	'ProfileSettings',
	'Settings',
	'SettingsResults',
	'SettingsSaveButton',
	'SettingsSideBar',
	'SettingsSideLink',
	'SettingsSubmitButton',
	'SocialNetworkSettings',
	'TextSettings',
	'TwitterSettingsButton'
	];
	
	
	var statusAR = [
	'CancelStatusButton',
	'ClearMoreFeaturesBoxLink',
	'FacebookCheckbox',
	'FriendsList',
	'ListRow',
	'MoreFeaturesBox',
	'MoreFeaturesButton',
	'Status',
	'StatusLight',
	'TwitterCheckbox',
	'SignalButton'
	];
	
	
	var universalAR = [
	'TopLink',
	'BasicUser',
	'BirthdayInput',
	'AutoCompleteInput',
	'Checkbox',
	'DropDownBox',
	'ExceptionsManager',
	'FacebookManager',
	'Footer',
	'FriendRequestLink',
	'Global',
	'HeadingLabel',
	'InitializeManager',
	'LoadingImage',
	'NameLink',
	'PasswordInput',
	'RadioButton',
	'Request',
	'TwitterManager',
	'Tabs',
	'TermsLink',
	'TextArea',
	'TextInput',
	'TimeManager',
	'TimeZoneInput',
	'UserImage',
	'VerificationManager'
	];
	
	
	var updatesAR = [
	'JoinLight',
	'Update',
	'UpdateFriendLink',
	'Updates',
	'UpdatesManager'
	];

	var pluginsAR = [
	'ajaxUpload',
	'autocomplete',
	'timers',
	'ui.core',
	'ui.tabs',
	'effects.core',
	'effects.slide',
	'lightbox',
	'scrollTo'
	];
	
	var helpAR = [
	'Help',
	'FAQs',
	'SocialMeterHelp',
	'FacebookAndTwitter',
	'HelpSideBar',
	'HelpSideLink',
	'StepsToSuccess',
	'StepsToSuccessTab'
	];
	
	var awardsAR = [
	'AwardsLightBox',
	'AwardsManager'
	];

	var cssAR = [
	'main',
	'findFriends',
	'ui.core',
	'ui.tabs',
	'mainMenuBar',
	'status',
	'updates',
	'autocomplete',
	'alerts',
	'profiles',
	'settings',
	'help',
	'awards'
	];
	
	
	for (var i = 0; i < alertsAR.length; i++) 
		alertsAR[i] = classPath + alertsPath + alertsAR[i] + ".js";
	
	for (var i = 0; i < friendsSearchAR.length; i++) 
		friendsSearchAR[i] = classPath + friendsSearchPath + friendsSearchAR[i] + ".js";
	
	for (var i = 0; i < menuBarAR.length; i++) 
		menuBarAR[i] = classPath + menuBarPath + menuBarAR[i] + ".js";
		
	for (var i = 0; i < profilesAR.length; i++) 
		profilesAR[i] = classPath + profilesPath + profilesAR[i] + ".js";
		
	for (var i = 0; i < settingsAR.length; i++) 
		settingsAR[i] = classPath + settingsPath + settingsAR[i] + ".js";
		
	for (var i = 0; i < helpAR.length; i++) 
		helpAR[i] = classPath + helpPath + helpAR[i] + ".js";
		
	for (var i = 0; i < awardsAR.length; i++) 
		awardsAR[i] = classPath + awardsPath + awardsAR[i] + ".js";
		
	for (var i = 0; i < statusAR.length; i++) 
		statusAR[i] = classPath + statusPath + statusAR[i] + ".js";
		
	for (var i = 0; i < universalAR.length; i++)
		universalAR[i] = classPath + universalPath + universalAR[i] + ".js";
		
	for (var i = 0; i < updatesAR.length; i++)
		updatesAR[i] = classPath + updatesPath + updatesAR[i] + ".js";

	for (i = 0; i < pluginsAR.length; i++) 
		pluginsAR[i] = pluginsPath + pluginsAR[i] + ".js";
		
	for (i = 0; i < cssAR.length; i++) 
		cssAR[i] = cssPath + cssAR[i] + ".css";
		
	
	function constructor() {
	
        return {
		
            loadClasses: function(callback) {
				$.include(classesAR, callback);			
			}, 
			
			loadPlugins: function(callback) {
				$.include(pluginsAR, callback);			
			},
		
			loadStyles: function(callback) {
				$.include(cssAR, callback);			
			},

            loadAll: function(callback) {
				
				finalAR = [];
				finalAR = finalAR.concat(universalAR, alertsAR, awardsAR, friendsSearchAR, menuBarAR, helpAR, profilesAR, settingsAR, statusAR, updatesAR, pluginsAR, cssAR);
				
				$.include(finalAR, callback);

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