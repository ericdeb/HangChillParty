var FriendsOfLink = function(DOMID, numberFriends, mutualFriends, userID) {

	this.DOMID = DOMID;
	this.generalFriendsDOMID = DOMID + "GeneralFriends";
	this.mutualFriendsDOMID = DOMID + "MutualFriends";
	this.numberFriends = numberFriends;
	this.mutualFriends = mutualFriends;
	this.userID = userID;
	
};

Global.extend(FriendsOfLink, TopLink);


FriendsOfLink.prototype = {
	
	friendsOfLinkClass:  "friendsOfLink",
	generalFriendsLinkClass: "generalFriendsLink",
	mutualFriendsLinkClass: "mutualFriendsLink",
	tabNumber: 4,
	
	
	generate: function() {
		var retStr = '<div id="' + this.DOMID + '" class="' + this.friendsOfLinkClass + '">';
		retStr += '<a href="#" class="' + this.generalFriendsLinkClass + '">' + this.numberFriends + '</a>';
		retStr += '<span>friends,</span>';
		retStr += '<a href="#" class="' + this.mutualFriendsLinkClass + '">' + this.mutualFriends + '</a>';
		retStr += '<span>in common</span></div>';
		return retStr;		
	},
	
	
	bind: function() {
		var that = this;
		$("#" + this.DOMID + ' .' +  this.generalFriendsLinkClass).click(function() {
			FriendsOfLink.superClass.selectTab(null, that.tabNumber, false);
			FriendsOfSearch.getInstance().setCurrentUser(that.userID).setSearchType("generalFriends").performSearch(true);
		});
		$("#" + this.DOMID + ' .' +  this.mutualFriendsLinkClass).click(function() {
			FriendsOfLink.superClass.selectTab(null, that.tabNumber, false);
			FriendsOfSearch.getInstance().setCurrentUser(that.userID).setSearchType("mutualFriends").performSearch(true);
		});
	}	
	
};
