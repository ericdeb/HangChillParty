var TwitterRetweetButton = function(DOMID) {

	var DOMID = DOMID;
	var imageSource = "Images/twitterRetweetButton.png";
	var messagesAR = [
		"Hangchillparty.com is the shit. what's up yall",
		"yo new site, Hangchillparty is poppin",
		"it's hangchillparty time.  Your social life will thank me later.  Signal me at hangchillparty.com"
	];
	
	function getRandomLink() {
		var index = Math.round(Math.random() * (messagesAR.length-1));
		var message = encodeURI(messagesAR[index]);
		var insLink = "http://twitter.com/home?status=" + message;
		return insLink;
	}
	
	this.generate = function () {
		return '<a id="' + DOMID + '" target="_blank" href="' + getRandomLink() + '"><img src="' + imageSource + '" /></a>';
	};	
	
	this.bind = function() {
		$("#" + DOMID).click(function() {
			$(this).attr("href", getRandomLink());						  
		});
	}
	
};

