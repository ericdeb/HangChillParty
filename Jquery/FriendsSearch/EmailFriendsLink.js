var EmailFriendsLink = function() {

	var DOMID = "emailYourFriendsLink";
	var tabNumber = 3;
	var label = "Email Your Friends";
	var headingLabel = "Email Your Friends Hangchillparty";
	var findFriendsClass = "findFriendsInviteEmail";


	this.generate = function () {
		return '<div id="' + DOMID + '" class="friendsSearchTabs"><span>' + label + '</span></div>';
	};	
	
	
	this.bind = function () {
		$("#" + this.getDOMID()).click(function() {
			var ff = FindFriends.getInstance();
			ff.getFriendsSearchTabs().setCurrentTab(tabNumber);
			$("#" + ff.getDOMID()).removeClass().addClass(findFriendsClass);
			$("#" + FriendsSearchSideBar.getInstance().getDOMID() + " div").removeClass('friendsSearchTabHighlight');
			$("#" + DOMID).addClass('friendsSearchTabHighlight');
			ff.getHeadingLabel().setLabel(headingLabel);
		});
	};
	
	this.getTabNumber = function() {
		return tabNumber;
	};
	
	this.getDOMID = function() {
		return DOMID;
	}
		
};
