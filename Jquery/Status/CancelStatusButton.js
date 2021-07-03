var CancelStatusButton = function() {

	this.DOMID = "cancelStatusButton";
	
	this.generate = function() {
		return '<a id="' + this.DOMID + '" href="#">cancel</a>';
	}
	
	this.bind = function() {
		$("#" + this.DOMID).click(function() {
			var u = Updates.getInstance(), update = u.getMyCurrentUpdate();
			if (update != null) {
				u.ajaxSuspendUpdate(update.getUpdateID());
				var cancelStatusCallback = function() {
					u.closeUpdates();
				}
				var cancelStatusErrorCallback = function(errors) {
					u.ajaxUnsuspendUpdate(update.getUpdateID(), "An unknown error occured.  Try again");
				}
				var cancelRequest = new Request("cancelStatus", {}, {}, false, cancelStatusCallback, cancelStatusErrorCallback);
				cancelRequest.getResponse();
			}
			return false;
		});
	}
	
	this.unbind = function() {
		$("#" + this.DOMID).unbind();
	};
	
	this.getDOMID = function() {
		return this.DOMID;	
	}
	
};
