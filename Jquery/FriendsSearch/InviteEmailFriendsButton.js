var InviteEmailFriendsButton = function() {

	this.DOMID = "inviteEmailFriendsButton";
	this.imageSource = "Images/inviteEmailFriendsButton.png";

	this.generate = function() {
		return '<div id="' + this.DOMID + '"><img src="' + this.imageSource + '" /></div>';
	}	
	
	this.bind = function() {
		var that = this;
		$("#" + this.DOMID).click(function() {
			$(this).unbind();
			InviteEmailFriends.getInstance().performSearch(true);
		});

	}
	
};
