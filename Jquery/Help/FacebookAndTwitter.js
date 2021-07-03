var FacebookAndTwitterHelp = function(DOMID) {

	this.DOMID = DOMID;
	this.facebookAndTwitterClass = "facebookAndTwitterHelp";
	this.facebookLabel = "Signal published to Facebook example:";
	this.twitterLabel = "Signal published to Twitter example:";
	this.facebookExampleImageSrc = "Images/facebookExample.png";
	this.twitterExampleImageSrc = "Images/twitterExample.png";
	this.facebookAndTwitterHelpLabel = "facebookAndTwitterLabel";


	this.generate = function() {
		var retStr = '<div id="' + this.DOMID + '" class="' + this.facebookAndTwitterClass + '">';
		retStr += '<span class="' + this.facebookAndTwitterHelpLabel + '" >' + this.facebookLabel + '</span>';
		retStr += '<img src="' + this.facebookExampleImageSrc + '" />';
		retStr += '<span class="' + this.facebookAndTwitterHelpLabel + '" >' + this.twitterLabel + '</span>';
		retStr += '<img src="' + this.twitterExampleImageSrc + '" /></div>';
		return retStr;

	};
	
};