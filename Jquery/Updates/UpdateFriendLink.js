var UpdateFriendLink = function(DOMID, basicUserUserNameLink, basicUserLeaderNameLink, friendCount) {

	this.DOMID = DOMID;
	this.basicUserUserNameLink = basicUserUserNameLink;
	this.basicUserLeaderNameLink = basicUserLeaderNameLink;
	this.friendCount = friendCount;
	this.tabNumber = 3;
	
};


Global.extend(UpdateFriendLink, TopLink);


UpdateFriendLink.prototype = {
	
	generate: function() {
		var retStr = '<span id="' + this.DOMID + '">' + this.basicUserUserNameLink.generate();
		if (this.basicUserLeaderNameLink != null)
			retStr += "'s with " + this.basicUserLeaderNameLink.generate();
		if (this.friendCount != 0) {
			var ins = this.friendCount == 1 ? 'friend' : 'friends';
			retStr += " and " + this.friendCount + " " + ins;
		}
		retStr += "</span>";
		return retStr;	
	},
	
	
	bind: function() {
		 this.basicUserUserNameLink.bind();
		 if (this.basicUserLeaderNameLink != null)
			 this.basicUserLeaderNameLink.bind();
	},
	
	
	getValue: function() {
		return this.basicUserUserNameLink.getBasicUser().getUserID();
	}
	
	
};
