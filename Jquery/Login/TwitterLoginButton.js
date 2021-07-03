var TwitterLoginButton = function(DOMID, syncNeededCallback) {

	var DOMID = DOMID;
	var twitterLoginButtonClass="twitterLoginButton";
	var imageSource = "Images/twitterLoginButton.png";
	
	this.generate = function () {
		return '<div id="' + DOMID + '" class="' + twitterLoginButtonClass + '"><img src="' + imageSource + '" /></div>';
	};	
	
	
	this.bind = function () {
		$("#" + DOMID).click(function() {
			var successCallback = function() {
				window.location = "index.php";
			}
			var syncCallback = function() {
				$("#" + DOMID).unbind();
				syncNeededCallback();
			}
			TwitterManager.getInstance().openTwitterWindow(successCallback, syncCallback);
		});
	};
		
};

