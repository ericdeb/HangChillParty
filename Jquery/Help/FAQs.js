var FAQs = function(DOMID) {

	this.DOMID = DOMID;
	this.FAQsClass = "FAQs";
	this.titleClass = "FAQsTitle";


	this.generate = function() {
		var retStr = '<div id="' + this.DOMID + '" class="' + this.FAQsClass + '">';
		retStr += '<span><span class="' + this.titleClass + '">What is Hangchillparty?</span><br />Hangchillparty answers the question who\'s down to hang out. Right now.<br /><br />Signal to your friends either a green, yellow, or red, and then you\'ll immediately see who\'s down to chill. Let friends know through facebook or twitter when you are open to hanging out.<br /><br /><br />';
		retStr += '<span class="' + this.titleClass + '">Isn\'t this just like facebook and twitter?</span><br />No. Hangchillparty is for friends that hang out with each other in real life. It\'s built for real socializing, and every signal communicates whether the signaler wants to socialize right now. We know some people think gps-location is a little creepy, so our location is optional and entered by the user.<br /><br /><br />';
		retStr += '<span class="' + this.titleClass + '">Is there a Hangchillparty mobile app?</span><br />Not yet, but we are currently working on apps for the iphone and android.</span></div>';
		return retStr;

	};
	
};