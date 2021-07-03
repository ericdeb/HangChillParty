var LoadingImage = function(DOMID, width, height) {

	this.DOMID = DOMID;
	this.width = width;
	this.height = height;
	
}


LoadingImage.prototype = {
	
	loadingDivClass: "loadingImage",
	loadingImageSource: "Images/loadingSwirl.gif",
	
	
	generate: function() {
		return '<div id="' + this.DOMID + '" class="' + this.loadingDivClass + '"><img src="' + this.loadingImageSource + '" width="' + this.width + '" height="' + this.height + '" /></div>';	
	}	
	
};
