var NameLink = function(DOMID, basicUser) {

	this.DOMID = DOMID;
	this.basicUser = basicUser;
		
}

NameLink.prototype = {

	generate: function() {
		return '<a id="' + this.DOMID + '" href="#" >' + this.basicUser.getFirstName() + " " + this.basicUser.getLastName() + '</a>';	
	},
	
	bind: function() {
	
	}

}