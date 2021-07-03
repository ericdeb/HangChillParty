var RegisterButton = function(DOMID, state) {

	this.DOMID = DOMID;
	this.itemDOMID = DOMID + state;
	this.state = state;
	
}


RegisterButton.prototype = {
	
	registerButtonClass: "registerButton",
	signalImageSource: "Images/signalButton.gif",
	signalImageHoverSource: "Images/signalButtonHover.gif",
	signUpImageSource: "Images/signUpButton.png",
	signUpImageHoverSource: "Images/signUpButtonHover.gif",
	lightBoxText: "Click here to sign up",
	lightBoxLinkClass: "lightBoxSignUpLink", 
	
	generate: function() {
		if (this.state != "lightBox") {
			if (this.state == "signUp")
				var ins = '<div id="' + this.itemDOMID + '"></div><img src="' + this.signUpImageSource + '" />';
			else
				var ins = '<img id="' + this.itemDOMID + '" src="' + this.signalImageSource + '" />';
			return '<div id="' + this.DOMID + '">' + ins + '</div>';	
		}
		else
			return '<a id="' + this.itemDOMID + '" class="' + this.lightBoxLinkClass + '" href="#">' + this.lightBoxText + '</a>';
	},
	
	
	bind: function() {
		var that = this;
		$("#" + this.itemDOMID).click(function() {
			var im = InitializeLoginManager.getInstance();
			im.getMainTabs().setCurrentTab(1);
			$("#" + im.getFooter().getDOMID()).css('margin-top', '50px');
			var registerRequest = new Request("incrementRegisterStatistic", {}, {}, false, null, null);
			registerRequest.getResponse();	
			return false;
		})/*
		.mouseenter(function() {
			if (that.state != "lightBox") {
				var insSrc = that.state == 'signal' ? that.signalImageHoverSource : that.signUpImageHoverSource;
				$(this).attr('src', insSrc).css({bottom: '1px', right: '1px'});
			}
		})
		.mouseleave(function() {
			if (that.state != "lightBox") {
				var insSrc = that.state == 'signal' ? that.signalImageSource : that.signUpImageSource;
				$(this).attr('src', insSrc).css({bottom: '0px', right: '0px'});
			}			 
		});*/
	}	
	
};
