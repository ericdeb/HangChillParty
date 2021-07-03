var UserImage = function(DOMID, userID, width, height) {

	this.DOMID = DOMID;
	this.userID = userID;
	this.width = width;
	this.height = height;
	
};


Global.extend(UserImage, TopLink);


UserImage.prototype = {
	
	loadingImageClass: "userImageloadingImage",
	newImage: false,
	
	
	generate: function() {
		var uidIns = this.newImage == true ? '&uid=' + new Date().getTime() : '';
		var insLink = 'requestswitch.php?action=getImage&userID=' + this.userID + '&width=' + this.width + '&height=' + this.height + uidIns;
		return '<img id="' + this.DOMID + '" class="userImage" src="' + insLink + '" />';	
	},
	
	
	bind: function() {
		var that = this;
		$("#" + this.DOMID).click(function() {
				var insBool = that.userID == Global.getUserID() ? true : false;
				UserImage.superClass.selectTab(that.DOMID, 3, insBool);
				Profiles.getInstance().setUserProfile(that.userID);
				return false;
		});
	},
	
	getWidth: function() {
		return this.width;	
	},
	
	getHeight: function() {
		return this.height;	
	},
	
	ajaxSuspend: function() {
		var loadingImage = new LoadingImage(this.DOMID + "LoadingImageInner", this.width, this.height);
		var str = '<div id="' + this.DOMID + 'LoadingImage" class="' + this.loadingImageClass + ' userImage">' + loadingImage.generate() + '</div>';
		$("#" + this.DOMID).replaceWith(str);
	},
	
	ajaxUnsuspend: function() {
		$("#" + this.DOMID + "LoadingImage").replaceWith(this.generate());
		this.bind();
	},
	
	setNewImageTrue: function() {
		UserImage.prototype.newImage = true;
		return this;
	},
	
	getDOMID: function() {
		return this.DOMID;	
	}
	
	
};
