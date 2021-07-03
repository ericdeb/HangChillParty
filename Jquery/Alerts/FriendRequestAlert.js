var FriendRequestAlert = function(DOMID, nameLink, userImage) {

	this.DOMID = DOMID;
	this.innerDOMID = DOMID + "Inner";
	this.nameLink = nameLink;
	this.userImage = userImage;
	
}


FriendRequestAlert.prototype = {
	
	friendRequestClass: "friendRequestAlert",
	innerClass: "friendRequestInner",
	acceptLinkClass: "acceptRequestLink", 
	denyLinkClass: "denyRequestLink", 
	responseClass: "alertResponseMessage",
	deniedResponseMessage: "Friend request rejected.",
	acceptResponseMessage: "Friend request accepted!",
	errorResponseMessage: "An error occurred please try again.",
	errorClass: "friendRequestAlertError",
	successClass: "friendRequestSuccess",

	generate: function() {
		var retStr = '<div id="' + this.DOMID + '" class="' + this.friendRequestClass + '">' + this.userImage.generate();
		retStr += '<div id="' + this.innerDOMID + '" class="' + this.innerClass + '">' + this.nameLink.generate() + '<span> wants to be your friend on Hangchillparty</span>';
		retStr += '<a href="#" class="' + this.acceptLinkClass + '">accept</a>';
		retStr += '<a href="#" class="' + this.denyLinkClass + '">deny</a>';
		retStr += '</div></div>';
		return retStr;
	},


	generateDenySuccess: function() {
		return '<span class="' + this.responseClass + '">' + this.deniedResponseMessage + '</span>';
	},
	
	
	generateAcceptSuccess: function() {
		return '<span class="' + this.responseClass + '">' + this.acceptResponseMessage + '</span>';
	},
	
	
	generateErrorMessage: function() {
		return '<span class="' + this.responseClass + '">' + this.errorResponseMessage + '</span>';
	},


	bind: function() {
		var that = this; this.userImage.bind(); this.nameLink.bind();
		$("#" + this.innerDOMID + ' .' + this.acceptLinkClass).click(function() {
			that.sendResponseToServer(true);
			return false;
		});
		$("#" + this.innerDOMID + ' .' + this.denyLinkClass).click(function() {
			that.sendResponseToServer(false);
			return false;
		});
	},
	
	
	sendResponseToServer: function(acceptedBool) {
		var that = this, searchObj = {requesterID: this.nameLink.getValue(), status: acceptedBool == true ? 1 : 2};
		var errorCallback = function() {
			$("#" + that.innerDOMID).addClass(that.errorClass).html(that.generateErrorMessage());
			$("#" + that.innerDOMID + " ." + that.responseClass).fadeOut(2000, function() {
				$("#" + that.innerDOMID).removeClass(that.errorClass).html(that.generateCore());	
				that.bind();
			});
		}
		var loadingImage = new LoadingImage("respondToFriendLoad", 25, 25);
		$("#" + this.innerDOMID).html(loadingImage.generate());
		var callback = function(data) {
			that.fadeOutMessage(acceptedBool);
			if (acceptedBool == true)
				MainMenuBar.getInstance().getHangchillpartyLink().setPageRefresh();
		}
		var responseRequest = new Request("respondToFriendRequest", {}, searchObj, false, callback, errorCallback);
		responseRequest.getResponse();
	},
	
	
	fadeOutMessage: function(acceptedBool) {
		var that = this, insMsg = acceptedBool == true ? this.generateAcceptSuccess() : this.generateDenySuccess();
		$("#" + this.innerDOMID).html(insMsg);
		var callback = function() {
			$("#" + that.DOMID).remove();
			if (that.removeCallback != null)
				that.removeCallback(that.DOMID);
			Alerts.getInstance().subtractTotalAlertsCount();
		}
		if (acceptedBool == true)
			$("#" + this.innerDOMID + " ." + that.responseClass).addClass(this.successClass);
		$("#" + this.innerDOMID + " ." + that.responseClass).fadeOut(2000, callback);
	},
	
	getDOMID: function() {
		return this.DOMID;	
	},
	
	
	setRemoveCallback: function(removeCallback, index) {
		this.removeCallback = removeCallback;
		this.index = index;
	},
	
	
	isNewRequest: function() {
		return true;	
	}
	
};