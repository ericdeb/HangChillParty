var FacebookLink = function(DOMID, facebookLink) {

	this.DOMID = DOMID;
	this.facebookLink = facebookLink;
	
};



FacebookLink.prototype = {
	
	facebookLinkClass: "facebookLink",
	facebookLinkImageSource: "Images/profileFacebookLink.gif",
	
	
	generate: function() {
		return '<a id="' + this.DOMID + '" class="' + this.facebookLinkClass + '" href="' + this.facebookLink + '" target="_blank" ><img  src="' + this.facebookLinkImageSource + '"  /></a>';	
	}
	
};