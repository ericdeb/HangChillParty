var UserProfile = function(DOMID, userImage, nameLink, friendRequestLink, phoneNumber, facebookLink, twitterLink, friendsOfLink, socialMeter, socialRating, numberOfUpdates, profileUpdate, quickie, friendsBool) {

	this.DOMID = DOMID;
	this.userImage = userImage;
	this.nameLink = nameLink;
	this.friendsOfLink = friendsOfLink;
	this.phoneNumber = phoneNumber;
	this.facebookLink = facebookLink;
	this.friendRequestLink = friendRequestLink;
	this.profileUpdate = profileUpdate;
	this.quickie = quickie;
	this.socialMeter = socialMeter;
	this.socialRating = socialRating;
	this.twitterLink = twitterLink;
	this.numberOfUpdates = numberOfUpdates == "" ? 0 : numberOfUpdates;
	this.friendsBool = friendsBool;
	
};	

	
UserProfile.prototype = {

	profileTopClass: "userProfileTop",
	profileNameClass: "userProfileName",
	profileSocialNetworkClass: "userProfileSocialNetworks",
	profileNumberClass: "userProfileNumber",
	profileStatisticsClass: "userProfileStatistics",
	profileSocialRatingClass: "userProfileSocialRating",
	profileSocialRatingLabelClass: "userProfileSocialRatingLabel",
	profileQuickieClass: "userProfileQuickie",
	profileSignalsCountClass: "userProfileSignalsCount",

	generate: function() {
		if (this.friendRequestLink == null && this.friendsBool == true) {
			var insOne = '<span class="' + this.profileSocialRatingLabelClass + '">Social</span>';
			insOne += '<span class="' + this.profileSocialRatingClass + '">' + this.socialRating + '</span>';
		}
		else if (this.friendRequestLink != null)
			var insOne = this.friendRequestLink.generate();
		else
			var insOne = "";
		var insTwo = this.twitterLink != null ? this.twitterLink.generate() : "";
		var insThree = this.facebookLink != null ? this.facebookLink.generate() : "";
		var retStr = '<div id="' + this.DOMID + '" class="' + this.profileTopClass + '">';
		retStr += '<div class="' + this.profileNameClass + '">' + this.nameLink.generate() + '</div>';  
		retStr += '<div class="' + this.profileSocialNetworkClass + '">' + insThree + insTwo + '</div>';
		retStr += '<div class="' + this.profileNumberClass + '"><br />';
		retStr += '<span>' + this.phoneNumber + '</span></div>'; 
		retStr += '<div class="' + this.profileStatisticsClass + '">' + this.friendsOfLink.generate();
		retStr += '<span class="' + this.profileSignalsCountClass + '">' + this.numberOfUpdates + ' signals</span></div>';
		retStr += this.userImage.generate() + this.socialMeter.generate() + insOne;
		retStr += '<div class="' + this.profileQuickieClass + '"><span>' + this.quickie + '</span>';
		retStr += '</div></div>' + this.profileUpdate.generate() + '<div class="floatFake"></div>';
		return retStr;
	},


	bind: function() {
		this.userImage.bind(); this.nameLink.bind(); this.friendsOfLink.bind(); this.profileUpdate.bind(); this.socialMeter.bind();
		if (this.friendRequestLink != null)
			this.friendRequestLink.bind(); 
	}

};
		

