var LoginHeader = function(DOMID, loginPageBool) {

	this.DOMID = DOMID;
	this.loginPageBool = loginPageBool;
	this.signInDOMID = DOMID + "signInLink";
	this.loginLightBox = new LoginLightBox(this.DOMID + "LightBox");
	
}


LoginHeader.prototype = {
	
	imageClass: "topBarImage",
	loginClass: "loginPageHeader",
	registerClass: "registerPageHeader",
	haveAnAccountClass: "haveAnAccount",
	haveAnAccountLabel: "Have an account?",
	signInLinkClass: "signInLink",
	
	
	generate: function() {
		var insClass = this.loginPageBool == true ? this.loginClass : this.registerClass; 
		var retStr = '<div id="' + this.DOMID + '" class="' + insClass + '"><a id="' + this.signInDOMID + '" href="#" class="' + this.signInLinkClass + '">Sign in</a>';
		retStr += '<span class="' + this.haveAnAccountClass + '">' + this.haveAnAccountLabel + '</span>' + this.loginLightBox.generate() + '</div>';	
		return retStr;
	},
	
	
	bind: function() {
		var that = this;
		this.loginLightBox.bind();
		$("#" + this.DOMID).click(function() {
			that.loginLightBox.displayLightBox();
		});
	}	
	
};
