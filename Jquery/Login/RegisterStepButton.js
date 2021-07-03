var RegisterStepButton = function(DOMID, state, callback) {

	this.DOMID = DOMID;
	this.state = state;
	this.callback = callback;
	
}


RegisterStepButton.prototype = {
	
	registerStepButtonClass: "registerStepButton",
	enterButtonImageSource: "Images/enterButton.gif",
	saveAndFinishImageSource: "Images/saveAndFinishButton.gif",
	
	generate: function() {
		if (this.state == 'skipPage') 
			var ins = '<span>Skip this page >></span>';
		else
			var ins = this.state == 'enter' ? '<img src="' + this.enterButtonImageSource + '" />' : '<img src="' + this.saveAndFinishImageSource + '" />';
		return '<div id="' + this.DOMID + '">' + ins + '</div>';
	},
	
	
	bind: function() {
		var that = this;
		$("#" + this.DOMID).click(function() {
			$(this).unbind();
			that.callback();
		})
	},
	
	
	unbind: function() {
		$("#" + this.DOMID).unbind();
	},
	
	
	getDOMID: function() {
		return this.DOMID;
	}
	
};
