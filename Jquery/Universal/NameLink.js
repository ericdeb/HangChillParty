var NameLink = function(DOMID, basicUser) {

	this.DOMID = DOMID;
	this.basicUser = basicUser;
	
};


Global.extend(NameLink, TopLink);


NameLink.prototype = {
	
	topLinkDOMID: "mainMenuProfileLink",
	nameLinkClass:  "nameLink",
	tabNumber: 3,
	
	
	generate: function() {
		return '<a id="' + this.DOMID + '" href="#" class="' + this.nameLinkClass + '">' + this.basicUser.getFirstName() + " " + this.basicUser.getLastName() + '</a>';	
	},
	
	
	bind: function() {
		var that = this;
		$("#" + this.DOMID).click(function() {
				var insBool = that.basicUser.getUserID() == Global.getUserID() ? true : false;
				NameLink.superClass.selectTab(that.topLinkDOMID, that.tabNumber, insBool);
				Profiles.getInstance().setUserProfile(that.basicUser.getUserID());
				return false;
		});
	},
	
	
	getValue: function() {
		return this.basicUser.getUserID();
	},
	
	
	getBasicUser: function() {
		return this.basicUser;	
	}
	
	
};
