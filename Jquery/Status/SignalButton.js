var SignalButton = function(errorMsgDOMID) {

	this.DOMID = "signalButton";
	this.imageSource = 	"Images/signalButton.gif";
	this.errorMsgDOMID = errorMsgDOMID;
	this.errorClass = "signalButtonError";
	this.successClass = "signalButtonSuccess";
	this.successMessage = "You have signaled your friends.";
	
	var that = this;	
	var updateCallback = function(facebookObj) {
		if (facebookObj != null) 
			FacebookManager.getInstance().publishToFacebook(facebookObj.activity, facebookObj.place, facebookObj.light, facebookObj.friendsAR, null);
		var u = Updates.getInstance(), currUpdate = u.getMyCurrentUpdate();
		var removeSuspendedCallback = function() {
			if (currUpdate != null) {
				u.ajaxRemoveSuspendedUpdate(currUpdate.getUpdateID());
				u.ajaxClearAllSuspendedUpdates();
			}
		}
		$("#" + that.errorMsgDOMID).stopTime().oneTime(1000, removeSuspendedCallback);	
		UpdatesManager.getInstance().tryToGetNewUpdates();
		u.setMyUpdateFirst(true);	
		MoreFeaturesBox.getInstance().clear();
		that.ajaxUnsuspend();
	};	
	
	
	this.generate = function() {
		return '<div id="' + this.DOMID + '">' + this.generateImage() + '</div>';
	};
	
	this.generateImage = function() {
		return '<img src="' + this.imageSource + '" />';
	}
	
	
	this.bind = function() {
		var that = this;
		var errorCallback = function(errors) {
			var ins = '<span>'+ ExceptionsManager.getInstance().printExceptions() + '</span>';
			$("#" + that.errorMsgDOMID).removeClass(that.successClass).addClass(that.errorClass).html(ins);
			$("#" + that.DOMID).oneTime(3000, function() {
				$("#" + that.errorMsgDOMID).html('');
			});
			that.ajaxUnsuspend();
			var u = Updates.getInstance();
			if (u.getMyCurrentUpdate() != null)
				u.ajaxUnsuspendUpdate(u.getMyCurrentUpdate().getUpdateID());
		};		
		$("#" + this.DOMID).click(function() {
			that.ajaxSuspend();
			if (MoreFeaturesBox.getInstance().isHidden() == false)
				Status.getInstance().getMoreFeaturesButton().toggleOrientation();
			$("#" + that.errorMsgDOMID).stopTime().html('');
			var u = Updates.getInstance(), currUpdate = u.getMyCurrentUpdate(), e = ExceptionsManager.getInstance();
			if (currUpdate != null)
				u.ajaxSuspendUpdate(currUpdate.getUpdateID());
			e.clearExceptions();
			var insObj = Status.getInstance().getValues();
			var facebookObj = Status.getInstance().getSocialNetworkValues();
			if (!e.areThereExceptions()) {
				var facebookCallback = function() {
					e.clearExceptions();
					callback = function() {
						if (u.isOpened == true)
							$.scrollTo(250, 1000);
						else {
							$("#status").oneTime(750, function() {
								$.scrollTo(250, 1000);							   
							});							
						}
						$("#" + that.errorMsgDOMID).removeClass(that.errorClass).addClass(that.successClass).html('<span>' + that.successMessage + '</span>');
						$("#" + that.DOMID).oneTime(3000, function() {
							$("#" + that.errorMsgDOMID).html('');
						});
						updateCallback(facebookObj);
					}
					var statusRequest = new Request("createStatus", {}, insObj, true, callback, errorCallback);
					statusRequest.getResponse();
				}
				if (FacebookManager.getInstance().isLoggedIn() == false && insObj.facebookPublish == 1) 
					FacebookManager.getInstance().tryLogin(null, facebookCallback)
				else
					facebookCallback();			
			}
			else
				errorCallback();
		});
		
	}
	
	
	this.ajaxSuspend = function() {
		$("#" + this.DOMID).unbind();
		var loadingImage = new LoadingImage("signalButtonLoad", 50, 50);
		$("#" + this.DOMID).html(loadingImage.generate());
	}
	
	
	this.ajaxUnsuspend = function() {
		$("#" + this.DOMID).html(this.generateImage());
		this.bind();
	}
	
};