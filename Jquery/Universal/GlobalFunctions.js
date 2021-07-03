$(document).ready(function(){
		if ($.browser.mozilla || $.browser.opera)
			$("link[media='screen']").attr("href", "Styles/firefox.css");
		else if ($.browser.webkit)
			$("link[media='screen']").attr("href", "Styles/webkit.css");
		else if ($.browser.msie || $.browser.opera)
			$("link[media='screen']").attr("href", "Styles/internetExplorer.css");
		if (test == true)
			LoadManager.getInstance().loadAll(loadingCallback);	
		else
			loadingCallback();
});





function loadingCallback() {
	var initialRequest = new Request("getInitialData", {}, {}, false, initialCallback, null);
	initialRequest.getResponse();	
};



function initialCallback(data) {
	initializeManager = InitializeManager.constructor(data);
	initializeManager.generate();
	initializeManager.bind();
	initializeManager.initialize();
	if (initializeManager.getInviteFacebookFriends() == true) {
		initializeManager.getMainTabs().setCurrentTab(1);
		MainMenuBar.getInstance().getFindFriendsLink().selectLink();
		FindFriends.getInstance().getFriendsSearchTabs().setCurrentTab(2);
		var linkVal = FriendsSearchSideBar.getInstance().getFacebookYourFriendsLink();
		linkVal.selectLink();
		FindFriends.getInstance().getHeadingLabel().setLabel(linkVal.getHeadingLabel);
	}
	initializeManager.removeLoadingCover();
};