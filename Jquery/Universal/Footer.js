var Footer = function(DOMID, loginPageBool) {

	this.DOMID = DOMID;
	this.helpLinkDOMID = DOMID + "Help";
	this.loginPageBool = loginPageBool;
	
};


Footer.prototype = {
	
	footerClass:  "footer",
	horizontalLineClass: "footerHorizontalLine",
	footerLinksClass: "footerLinks",
	bottomMessageClass: "footerBottomMessage",
	bottomMessage: "Works best in Mozilla, Chrome, and Safari. &copy; 2010 Hangchillparty",
	loginHelpTab: 4, 
	indexHelpTab: 6,
	aboutUsLink: "http://blog.hangchillparty.com/?page_id=122",
	facebookLink: "http://www.facebook.com/pages/Hangchillpartycom/129473100421698?v=info&ref=ts",
	twitterLink: "http://twitter.com/Hangchillparty",
	blogLink: "http://blog.hangchillparty.com",
	contactLink: "http://blog.hangchillparty.com/?page_id=9",
	pressLink: "http://blog.hangchillparty.com/?page_id=94",
	jobsLink: "http://blog.hangchillparty.com/?page_id=14",
	termsLink: "http://blog.hangchillparty.com/?page_id=162",
	
	generate: function () {
		var retStr = '<div id="' + this.DOMID + '" class="' + this.footerClass + '">';
		retStr += '<div class="' + this.footerLinksClass + '"><a href="' + this.aboutUsLink + '" target="_blank">About us</a>';
		retStr += '<a href="' + this.facebookLink + '" target="_blank">Facebook</a>';
		retStr += '<a href="' + this.twitterLink + '" target="_blank">Twitter</a></div>';
		retStr += '<div class="' + this.footerLinksClass + '"><a href="' + this.blogLink + '" target="_blank">Blog</a>';
		retStr += '<a href="' + this.contactLink + '" target="_blank">Contact</a>';
		retStr += '<a id="' + this.helpLinkDOMID + '" href="#">Help</a></div>';
		retStr += '<div class="' + this.footerLinksClass + '"><a href="' + this.pressLink + '" target="_blank">Press</a>';
		retStr += '<a href="' + this.termsLink + '" target="_blank">Terms Of Service</a>';
		retStr += '<a href="' + this.jobsLink + '" target="_blank">Jobs</a></div>';
		retStr += '<div class="' + this.horizontalLineClass + '" target="_blank"></div>';
		retStr += '<div class="' + this.bottomMessageClass + '" target="_blank"><span>' + this.bottomMessage + '</span></div></div>';
		return retStr;
	},
	
	bind: function() {
		var that = this;
		$("#" + this.helpLinkDOMID).click(function() {								   
			if (that.loginPageBool == true)
				InitializeLoginManager.getInstance().getMainTabs().setCurrentTab(that.loginHelpTab);
			else {
				InitializeManager.getInstance().getMainTabs().setCurrentTab(that.indexHelpTab);
				MainMenuBar.getInstance().setAllWhite();				
			}
			return false;
		});
	},
	
	getDOMID: function() {
		return this.DOMID;	
	},
	
	selectHelpLink: function() {
		$("#" + this.helpLinkDOMID).click();
	}
	
};
