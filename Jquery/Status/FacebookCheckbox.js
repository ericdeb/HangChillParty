var FacebookCheckbox = function(DOMID, message, checkbox) {

	this.DOMID = DOMID;
	this.checkbox = checkbox;
	this.message = message;
	
	this.generate = function() {
		return '<div id="' + this.DOMID + '">' + this.checkbox.generate() + '<span>' + this.message + '</span></div>';	
	};
	
	this.bind = function() {
		this.checkbox.bind();
		var that = this;
		$("#" + this.DOMID).click(function() {
			if (that.checkbox.getValue() == 1) {
				var fb = FacebookManager.getInstance();	
				var permissionCallback = function(permissionToPublish) {
					if (permissionToPublish == false)
						$("#" + that.checkbox.getDOMID()).click();
				}
				if (fb.havePublishPermission() == false)
					fb.getPublishPermission(permissionCallback);
			}
		});
	};
	
	
	this.getValue = function() {
		return this.checkbox.getValue();
	};
	
	
	this.setUnchecked = function() {
		if (this.checkbox.getValue() == 1)
			$("#" + this.checkbox.getDOMID()).click();
	}
	
};