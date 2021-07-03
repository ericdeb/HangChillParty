var NewsItemAlert = function(DOMID, message, messageLink) {

	this.DOMID = DOMID;
	this.message = message;
	this.messageLink = messageLink;
	
}


NewsItemAlert.prototype = {
	
	newsItemClass: "newsItemAlert",
	linkClass: "newsItemLink",
	
	generate: function() {
		var insStr = this.messageLink != "" ? '<a href="' + this.messageLink + '" class="' + this.newsItemClass + '" target="_blank">' + this.message + '</a>' : '<span>' + this.message + '</span>';
		return '<div id="' + this.DOMID + '" class="' + this.newsItemClass + '">' + insStr + '</div>';
	},
	
	bind: function() {
		
	},
	
	getDOMID: function() {
		return this.DOMID;	
	},
	
	
	isNewRequest: function() {
		return false;	
	}
	
};