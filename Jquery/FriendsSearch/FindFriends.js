
var FindFriends = (function() {


	var instance = false;


	function constructor() {
		
		var DOMID = "findFriends";
		var headingDOMID = "findFriendsHeading";
		var friendsSearchTabsDOMID = "friendsSearchTabs";
		var facebookFriendsSuccessDOMID = "facebookFriendsSuccess";
		var facebookFriendsSuccessMessage = "Thanks for spreadin the word about Hangchillparty";
		var headingLabel = new HeadingLabel(headingDOMID, "Search");
		var friendsSearchTabs = new Tabs(friendsSearchTabsDOMID, friendsSearchTabsDOMID + "Heading", 4);
		var friendsSearchSideBar = FriendsSearchSideBar.getInstance();
		var friendsSearch = FriendsSearch.getInstance();
		var friendsFromFacebook = FriendsFromFacebook.getInstance();
		var inviteEmailFriends = InviteEmailFriends.getInstance();
		var noResultsSearchMessage = "There were no results for that search.  Sorry.";
		var searchLinkClass = friendsSearchSideBar.getSearchLink().getSearchLinkClass();
		
		
        return {

            generate: function() {
				$("#" + DOMID).addClass(searchLinkClass).prepend(headingLabel.generate() + friendsSearchSideBar.generate());
				$("#" + friendsSearchTabsDOMID + "-1").append(friendsSearch.generate());
				$("#" + friendsSearchTabsDOMID + "-2").append(friendsFromFacebook.generate());
				$("#" + friendsSearchTabsDOMID + "-4").append(inviteEmailFriends.generate());
			},
			
			
			bind: function() {
				friendsSearchTabs.bind(); friendsSearchSideBar.bind(); friendsSearch.bind(); inviteEmailFriends.bind();
			},
			
			
			getFriendsSearchTabs: function() {
				return friendsSearchTabs;
			},
			
			
			performFriendsSearch: function(newSearchBool, resultsDiv, searchType, searchObject, callback) {
				var e = ExceptionsManager.getInstance();
				var errorCallback = function() {
					resultsDiv.displayError(e.printExceptions());
					if (callback != null)
						callback();
				}
				var searchCallback = function(data) {
					if (newSearchBool == true && data.searchCount[0].co != 0)
						resultsDiv.getSearchPageBox().bind().setNumberOfResults(data.searchCount[0].co).generatePageNumbers().bindPageNumbers().displayBox();
					if (data.searchResults != null)
						resultsDiv.setResults(data.searchResults).generateResults().bindResults();
					else
						resultsDiv.displayMessage(noResultsSearchMessage);
					if (callback != null)
						callback();
				}
				if (newSearchBool == true)
					resultsDiv.displayLoadingImage().getSearchPageBox().hideBox();
				else
					resultsDiv.displayLoadingImage();
				var friendsSearchRequest = new Request(searchType, {}, searchObject, true, searchCallback, errorCallback);
				friendsSearchRequest.getResponse();
			},
			
			getDOMID: function() {
				return DOMID;
			},
			
			getHeadingLabel: function() {
				return headingLabel;
			},
			
			setFacebookFriendsSuccess: function() {
				$("#" + facebookFriendsSuccessDOMID).html('<span>' + facebookFriendsSuccessMessage + '</span>');
			},
			
			fadeOutFacebookSuccess: function() {
				var fadeOutCallback = function() {
					$(this).html('');	
				}
				var timerCallback = function() {
					$(this).fadeOut(200, fadeOutCallback);
				}
				$("#" + facebookFriendsSuccessDOMID).oneTime(10000, timerCallback);				
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