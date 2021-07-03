var FacebookYourFriendsLink = function() {

	var DOMID = "facebookYourFriendsLink";
	var tabNumber = 2;
	var label = "Facebook Your Friends";
	var findFriendsClass = "findFriendsInviteFacebook";
	var headingLabel = "Let Friends know through Facebook";
	var refreshPage = false;
	
	function selectTab() {
		var ff = FindFriends.getInstance();
		ff.getFriendsSearchTabs().setCurrentTab(tabNumber);
		$("#" + ff.getDOMID()).removeClass().addClass(findFriendsClass);
		$("#" + FriendsSearchSideBar.getInstance().getDOMID() + " div").removeClass('friendsSearchTabHighlight');
		$("#" + DOMID).addClass('friendsSearchTabHighlight');
	}
	
	function refreshTest() {
		
		
	}

	this.generate = function () {
		return '<div id="' + DOMID + '" class="friendsSearchTabs"><span>' + label + '</span></div>';
	};	
	
	
	this.bind = function () {		
		$("#" + this.getDOMID()).click(function() {
			var loggedInCallback = function() {
				if (refreshPage == true) {
					var callback = function() {
						window.location.reload();	
					}
					var facebookYourFriends = new Request("inviteFacebookFriends", {}, {}, false, callback, null);
					facebookYourFriends.getResponse();
				}
				else 
					selectTab();
			}
			FacebookManager.getInstance().tryLogin(loggedInCallback);
			FindFriends.getInstance().getHeadingLabel().setLabel(headingLabel);
		});
	};
	
	this.getTabNumber = function() {
		return tabNumber;
	};
	
	this.getDOMID = function() {
		return DOMID;
	};
	
	this.setPageRefreshTrue = function() {
		refreshPage = true;
	};
	
	this.selectLink = function() {
		$("#" + this.getDOMID()).click();	
	};
	
	this.getHeadingLabel = function() {
		return headingLabel;
	};
	
	this.getRefreshPage = function() {
		return refreshPage;	
	}
};
