var InitializeManager = (function() {

	var instance = false;


	function constructor(initialData) {
		
		var userSettings = initialData.userSettings[0], socialNetworkSettings = initialData.socialNetworkSettings[0];
		var basicUser = new BasicUser(userSettings.fn, userSettings.ln, userSettings.id); 

		Global.setUserID(userSettings.id);
		Global.setFirstName(userSettings.fn);
		Global.setLastName(userSettings.ln);
		Global.setGender(userSettings.gn);
		TimeManager.constructor(initialData.currentTime[0].of);
		var DOMID = "main";
		var mainTabsDOMID = "mainTabs";
		var loadingCoverDOMID = "loadingCover";
		var fakeActivityDOMID = "fakeActivity";
		var fakeActivityCoverDOMID = "fakeActivityCover";
		var mainMenuBar = MainMenuBar.constructor(basicUser);
		var mainTabs = new Tabs(mainTabsDOMID, mainTabsDOMID + "Heading", 8);
		var updates = Updates.getInstance();
		var alerts = Alerts.getInstance();
		var findFriends = FindFriends.getInstance();
		var profiles = Profiles.getInstance();
		var friendsOfSearch = FriendsOfSearch.getInstance();
		var footer = new Footer("mainFooter", false);
		var help = Help.constructor(false);
		var stepsToSuccessTab = StepsToSuccessTab.getInstance();
		var awardsManager = AwardsManager.getInstance();

		FacebookManager.constructor(initialData.FacebookID[0].id);

		TwitterManager.constructor(initialData.twitterSynced[0].set);
	
		var status = Status.constructor(initialData.Friends, socialNetworkSettings.fbp, socialNetworkSettings.twp);
		
		var settings = Settings.constructor(initialData.alertSettings[0], userSettings, initialData.socialNetworkSettings[0]);
	
		var inviteFacebookFriends = initialData.inviteFacebook[0].set == 1 ? true : false;
		
		if (initialData.inviteFacebook[0].done == 1)
			findFriends.setFacebookFriendsSuccess();

        return {

            generate: function() {
				$("#" + DOMID).prepend(mainMenuBar.generate()).append('<div id="' + fakeActivityCoverDOMID + '"></div><div id="' + fakeActivityDOMID + '"></div>');
				$("#" + mainTabsDOMID + "-1").append(status.generate() + updates.generate());
				findFriends.generate();
				$("#" + mainTabsDOMID + "-3").append(alerts.generate());
				$("#" + mainTabsDOMID + "-4").append(profiles.generate());
				$("#" + mainTabsDOMID + "-5").append(friendsOfSearch.generate());
				$("#" + mainTabsDOMID + "-6").append(settings.generate());
				$("#" + mainTabsDOMID + "-8").append(stepsToSuccessTab.generate());
				help.generate();
				$("#" + DOMID).after(footer.generate() + awardsManager.generate());
			},
			
			
			bind: function() {
				mainTabs.bind();
				mainMenuBar.bind();
				status.bind();
				findFriends.bind();
				friendsOfSearch.bind();
				settings.bind();
				footer.bind();
				help.bind();
				stepsToSuccessTab.bind();
			},
			
			
			initialize: function() {
				if (userSettings.nl == 1)
					mainTabs.setCurrentTab(7);
				else
					awardsManager.initialize();
				findFriends.fadeOutFacebookSuccess();
				alerts.initialize();
				UpdatesManager.getInstance().tryToGetNewUpdates();
			},
			
			
			getMainTabs: function() {
				return mainTabs;
			},
			
			
			getFakeActivityDOMID: function() {
				return fakeActivityDOMID;
			},
			
			
			getInviteFacebookFriends: function() {
				return inviteFacebookFriends;	
			},
			
			
			getFacebookInvitesDone: function() {
				return facebookInvitesDone;	
			},
			
			
			removeLoadingCover: function() {
				$("#" + loadingCoverDOMID).remove();	
			},
			
			getFooter: function() {
				return footer;
			}
			
		}
	
	}
	
	
	return {
	
		getInstance: function() {
			if(instance)
				return instance;		
		},
		
		
		constructor: function(initialData) {
						
			if (!instance) 
				return instance = constructor(initialData);
			
		}
		
	}		
	
})();