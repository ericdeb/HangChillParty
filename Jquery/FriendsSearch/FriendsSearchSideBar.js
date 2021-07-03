
var FriendsSearchSideBar = (function() {


	var instance = false;


	function constructor() {
		
		var DOMID = "friendsSearchSideBar";
		var friendsSearchSideBarClass = "tabsSideBar";
		var searchLink = new SearchLink();
		var withFacebookLink = new WithFacebookLink();
		var facebookYourFriendsLink = new FacebookYourFriendsLink();
		var emailFriendsLink = new EmailFriendsLink();
	
        return {

            generate: function() {
				var retStr = '<div id="' + DOMID + '" class="' + friendsSearchSideBarClass + '">';
				retStr += facebookYourFriendsLink.generate() + searchLink.generate() + withFacebookLink.generate() + emailFriendsLink.generate(); 
				retStr += '</div>';
				return retStr;
			},
			
			
			bind: function() {
				searchLink.bind(); withFacebookLink.bind(); facebookYourFriendsLink.bind(); emailFriendsLink.bind();				
			},
			
			
			getDOMID: function() {
				return DOMID;	
			},
			
			
			getSearchLink: function() {
				return searchLink;	
			},
			
			
			getFacebookYourFriendsLink: function() {
				return facebookYourFriendsLink;
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