var RequestAcceptedAlert = function(DOMID, nameLink, userImage) {

	this.DOMID = DOMID;
	this.nameLink = nameLink;
	this.userImage = userImage;
	
}


RequestAcceptedAlert.prototype = {
	
	requestAcceptedAlertClass: "friendRequestAccepted",
	
	generate: function() {
		return '<div id="' + this.DOMID + '" class="' + this.requestAcceptedAlertClass + '">' + this.userImage.generate() + '<span>' + this.nameLink.generate() + ' accepted your friend request.</span></div>';
	},
	
	bind: function() {
		this.userImage.bind(); this.nameLink.bind();
	},
	
	getDOMID: function() {
		return this.DOMID;	
	},
	
	
	isNewRequest: function() {
		return false;	
	}
	
};