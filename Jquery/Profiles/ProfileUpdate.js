var ProfileUpdate = function(DOMID, friendsBool, basicUser, leaderNameLink, leaderUserImage, update, userImagesAR, nameLinkAR) {

	this.update = update;
	this.DOMID = DOMID;
	this.leaderNameLink = leaderNameLink;
	this.leaderUserImage = leaderUserImage;
	this.userImagesAR = userImagesAR;
	this.nameLinkAR = nameLinkAR;
	this.notFriendsResponse = "You and " + basicUser.getFirstName() + " " + basicUser.getLastName() + " are not friends yet.";
	this.friendsBool = friendsBool;

};	

	
ProfileUpdate.prototype = {

	profileUpateClass: "profileUpdate",
	titleImageSource: "Images/currentSignalLabel.png",
	titleImageClass: "profileImageTitle",
	friendsListClass: "profileFriendsList",
	responseMessageClass: "responseMessage",
	noUpdatesResponse: "No recent signals",
	joinedWithClass: "profileJoinedWith",
	
	generate: function() {
		var retStr = '<div id="' + this.DOMID + '" class="' + this.profileUpateClass + '">';
		retStr += '<img class="' + this.titleImageClass + '" src="' + this.titleImageSource + '" />';
		if (this.update != null) {
			retStr += this.update.generateFull();
			retStr += '<div class="' + this.joinedWithClass + '">';
			if (this.leaderNameLink != null)
				retStr += this.leaderUserImage.generate() + this.leaderNameLink.generate();
			for (var i = 0; i < this.userImagesAR.length; i++)
				retStr += this.userImagesAR[i].generate() + this.nameLinkAR[i].generate();
			retStr += '</div>';
		}
		else if (this.friendsBool == true) 
			retStr += '</div><div class="' + this.responseMessageClass + '"><span>' + this.noUpdatesResponse + '</span></div>';
		else
			retStr += '</div><div class="' + this.responseMessageClass + '"><span>' + this.notFriendsResponse + '</span></div>';
		retStr += '</div>';
		return retStr;
	},
	
	bind: function() {
		if (this.update != null) {
			this.update.bind();
			for (var i = 0; i < this.userImagesAR.length; i++) {
				this.userImagesAR[i].bind();
				this.nameLinkAR[i].bind();
			}
			if (this.leaderNameLink != null) {
				this.leaderNameLink.bind();
				this.leaderUserImage.bind();				
			}
		}
	}
	
};
		

