var TwitterSettingsButton = function() {

	var DOMID = "twitterSettingsButton";
	var loginImageDOMID = "twitterSettingsLoginButton";
	var connectMessageDOMID = "twitterSettingsConnectedMessage";
	var removeLinkDOMID ="twitterSettingsRemoveLink";
	var loginImageButtonSource = "Images/twitterLoginButton.png";
	var connectMessage = "Connected to Twitter";
	
	
	function generateTwitterLoginImage() {
		return '<img id="' + loginImageDOMID + '" src="' + loginImageButtonSource + '" />';
	}
	
	
	function generateTwitterDisconnect() {
		return '<span id="' + connectMessageDOMID + '">' + connectMessage + '</span><a id="' + removeLinkDOMID + '" class="tinyMessage" href="#">Remove</a>';
	}
	
	
	function bindTwitterLoginImage() {
		$("#" + loginImageDOMID).click(function() {
			successCallback = function() {
				$("#" + DOMID).html(generateTwitterDisconnect());
				bindTwitterDisconnect();
			};
			TwitterManager.getInstance().openTwitterWindow(successCallback);
		});	
	}
	
	
	function bindTwitterDisconnect() {
		$("#" + removeLinkDOMID).click(function() {
			disconnectCallback = function() {
				$("#" + DOMID).html(generateTwitterLoginImage());
				bindTwitterLoginImage();
				SocialNetworkSettings.getInstance().getTwitterCheckbox().setUnchecked();
				Status.getInstance().getTwitterCheckbox().setUnchecked();
			};
			TwitterManager.getInstance().disconnectFromTwitter(disconnectCallback);									
		});
	}


	this.generate = function() {
		var ins = TwitterManager.getInstance().isSynced() == true ? generateTwitterDisconnect() : generateTwitterLoginImage();
		return '<div id="' + DOMID + '">' + ins + '</div>';
	};	
	
	
	this.regenerate = function() {
		$("#" + DOMID).replaceWith(this.generate());
	};
	
	
	this.bind = function() {
		if (TwitterManager.getInstance().isSynced() == true)
			bindTwitterDisconnect();
		else
			bindTwitterLoginImage();
	};

};
