var FriendshipAlert = function(DOMID, nameLinkOne, nameLinkTwo, userImageOne, userImageTwo) {

	this.DOMID = DOMID;
	this.nameLinkOne = nameLinkOne;
	this.nameLinkTwo = nameLinkTwo;
	this.userImageOne = userImageOne;
	this.userImageTwo = userImageTwo;
	
}


FriendshipAlert.prototype = {
	
	friendshipAlertClass: "friendshipAlert",
	
	generate: function() {
		return '<div id="' + this.DOMID + '" class="' + this.friendshipAlertClass + '">' + this.userImageOne.generate() + this.userImageTwo.generate() + '<span>' + this.nameLinkOne.generate() + ' and ' + this.nameLinkTwo.generate() + ' are now friends on Hangchillparty</span></div>';
	},
	
	bind: function() {
		this.userImageOne.bind(); this.userImageTwo.bind(); this.nameLinkOne.bind(); this.nameLinkTwo.bind();
	},
	
	getDOMID: function() {
		return this.DOMID;	
	},
	
	
	isNewRequest: function() {
		return false;	
	}
	
};