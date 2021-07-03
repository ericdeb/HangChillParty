var FriendRequestLink = function(DOMID, userID, buttonBool) {

	this.DOMID = DOMID;
	this.linkDOMID = DOMID + "Link";
	this.userID = userID;
	this.buttonBool = buttonBool;
	
};



FriendRequestLink.prototype = {
	
	friendRequestClass: "friendRequestLink",
	buttonClass: "friendRequestButton",
	buttonImageSource: "Images/friendRequestButton.png",
	buttonLoad: "friendRequestButtonLoad",
	regularLoad: "friendRequestLoad",
	displayText: "request",
	errorClass: "friendRequestError",
	successClass: "friendRequestSuccess",
	errorMessage: "Error, try again.",
	
	
	generate: function() {
		if (this.buttonBool == false)
			return '<div id="' + this.DOMID + '" class="' + this.friendRequestClass + '"><a id="' + this.linkDOMID + '" href="#">' + this.displayText + '</a></div>';
		return '<div id="' + this.DOMID + '" class="' + this.buttonClass + '"><img src="' + this.buttonImageSource + '" /></div>';
	},
	
	
	bind: function() {
		var that = this, insDOMID = this.buttonBool == true ? this.DOMID : this.linkDOMID;
		var insButtonLoad = this.buttonBool == true ? this.buttonLoad : this.regularLoad;
		$("#" + insDOMID).click(function() {
				$(this).unbind();
				var requestCallback = function() {
					$("#" + that.DOMID).addClass(that.successClass).html('<span>Successful</span>').fadeOut(2000, function() {
						$(this).remove();															  
					});
				};
				var errorCallback = function() {
					$("#" + that.DOMID).addClass(that.errorClass).html('<span>' + that.errorMessage + '</span>').fadeOut(2000, function() {																							
						$(this).removeClass(that.errorClass).replaceWith(that.generate());
						that.bind();
					});
				};
				var loadingImage = new LoadingImage(insButtonLoad, 20, 20);
				$("#" + that.DOMID).html(loadingImage.generate());
				var friendRequestRequest = new Request("requestFriend", {receiverID: that.userID}, {}, true, requestCallback, errorCallback);
				friendRequestRequest.getResponse();
				return false;
		});
	},
	
	
	getValue: function() {
		return this.userID();
	}
	
	
};