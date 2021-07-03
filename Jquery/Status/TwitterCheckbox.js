var TwitterCheckbox = function(DOMID, message, checkbox) {

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
				if (TwitterManager.getInstance().isSynced() == false)  {
					var failedCallback = function() {
						$("#" + that.checkbox.getDOMID()).click();
					}
					TwitterManager.getInstance().openTwitterWindow(null, null, failedCallback);
				}
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