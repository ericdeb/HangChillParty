var FacebookPermissionsButton = function() {

	var DOMID = "facebookPermissionsButton";
	var ConnectedDOMID = "facebookPermissionsButtonSuccess";
	var imageSource = "Images/connectWithFacebookButton.png";
	
	this.generate = function () {
		return '<div id="' + DOMID + '"><img src="' + imageSource + '" /></div>';
	};	
	
	
	this.bind = function () {
		$("#" + DOMID).click(function() {
			var callback = function() {
				$(this).html('<span id="' + ConnectedDOMID + '">Successfully Connected</span>');
			};
			FacebookManager.getInstance().getInitialPermissions(callback);
			 
		});
	};
		
};

