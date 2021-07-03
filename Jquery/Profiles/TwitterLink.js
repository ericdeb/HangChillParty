var TwitterLink = function(DOMID, twitterName) {

	this.DOMID = DOMID;
	this.twitterName = twitterName;
	
};



TwitterLink.prototype = {
	
	twitterLinkClass: "twitterLink",
	twitterLinkImageSource: "Images/profileTwitterLink.gif",
	
	
	generate: function() {
		return '<a id="' + this.DOMID + '" class="' + this.twitterLinkClass + '" href="http://www.twitter.com/' + this.twitterName + '" target="_blank" ><img  src="' + this.twitterLinkImageSource + '"  /></a>';	
	}
	
};