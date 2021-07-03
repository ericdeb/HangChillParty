var WeuttLogo = function(width, height, DOMID) {

	var imageSource = "Images/weuttLogo.jpg";
	var width = width;
	var height = height;
	var DOMID = DOMID;
	
	
	this.generate = function () {
		return '<img id = "' + DOMID + '" src="' + imageSource + '" width="' + width + '" height="' + height + '" />';
	};	
	
	this.bind = function () {
		
	};
		
}
		