var FacebookLoginButton = function(DOMID, syncCallback) {

	var DOMID = DOMID;
	var facebookClass="facebookLoginButton";
	var imageSource = "Images/facebookLoginButton.png";
	
	this.generate = function () {
		return '<div id="' + DOMID + '" class="' + facebookClass + '"><img src="' + imageSource + '" /></div>';
	};	
	
	
	this.bind = function () {
		$("#" + DOMID).click(function() {
			var loginCallback = function() {
				var facebookLoginCallback = function() {
					window.location = "index.php";
				}
				var errorCallback = function(errors) {
					if (errors[0].ms == "There was no match for that Facebook ID")
						syncCallback();
				}
				var loginRequest = new Request("facebookLoginUser", {}, {}, false, facebookLoginCallback, errorCallback);
				loginRequest.getResponse();	
			}
			FacebookManager.getInstance().tryLogin(loginCallback);
		});
	};
		
};

