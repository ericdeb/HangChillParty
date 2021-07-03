var FacebookSettingsButton = function() {

	var DOMID = "facebookSettingsButton";
	var loginImageDOMID = "facebookSettingsLoginButton";
	var connectMessageDOMID = "facebookSettingsConnectedMessage";
	var removeLinkDOMID ="facebookSettingsRemoveLink";
	var loginImageButtonSource = "Images/facebookLoginButton.png";
	var connectMessage = "Connected to Facebook";
	
	
	function generateFacebookLoginImage() {
		return '<img id="' + loginImageDOMID + '" src="' + loginImageButtonSource + '" />';
	}
	
	
	function generateFacebookDisconnect() {
		return '<span id="' + connectMessageDOMID + '">' + connectMessage + '</span><a id="' + removeLinkDOMID + '" class="tinyMessage" href="#">Remove</a>';
	}
	
	
	function bindFacebookLoginImage() {
		$("#" + loginImageDOMID).click(function() {
			loggedInCallback = function() {
				$("#" + DOMID).html(generateFacebookDisconnect());
				bindFacebookDisconnect();
			};
			FacebookManager.getInstance().tryLogin(loggedInCallback);
		});	
	}
	
	
	function bindFacebookDisconnect() {
		$("#" + removeLinkDOMID).click(function() {
			disconnectCallback = function() {
				$("#" + DOMID).html(generateFacebookLoginImage());
				bindFacebookLoginImage();
				SocialNetworkSettings.getInstance().getFacebookCheckbox().setUnchecked();
				Status.getInstance().getFacebookCheckbox().setUnchecked();
			};
			FacebookManager.getInstance().disconnectFromFacebook(disconnectCallback);									
		});
	}


	this.generate = function() {
		var ins = FacebookManager.getInstance().isLoggedIn() == true ? generateFacebookDisconnect() : generateFacebookLoginImage();
		return '<div id="' + DOMID + '">' + ins + '</div>';
	};	
	
	
	this.regenerate = function() {
		$("#" + DOMID).replaceWith(this.generate());
	};
	
	
	this.bind = function() {
		if (FacebookManager.getInstance().isLoggedIn() == true)
			bindFacebookDisconnect();
		else
			bindFacebookLoginImage();
	};

};
