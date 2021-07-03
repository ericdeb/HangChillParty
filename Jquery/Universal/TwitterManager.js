var TwitterManager = (function() {


	var instance = false;


	function constructor(twitterSynced) {

		var twitterSynced = twitterSynced == 1 ? true : false;
		var popupOpen = false;
		var twitterURL = "http://www.hangchillparty.com/requestswitch.php?action=twitterDisplayLogin";


        return {
			
			isSynced: function() {
				return twitterSynced;
			},
			
			
			openTwitterWindow: function(successCallback, syncNeededCallback, failedCallback) {
				if (popupOpen != true) {
					popupOpen = true;
					var twitterPopup;
					var twitterCallbackFunction = function(status) {
						twitterPopup.close();
						if (status == "success") 
							twitterSynced = true;
						if (status == "success" && successCallback != null)
							successCallback();
						else if (status == "syncNeeded" && syncNeededCallback != null)
							syncNeededCallback();
						popupOpen = false;
					};
					window.twitterCallback = twitterCallbackFunction;
					twitterPopup = window.open(twitterURL,'Twitter Login', 'menubar=no,toolbar=no,width=900,height=400,menubar=no,location=no');
					var left = Math.floor(((screen.width-20)/2)-450);
					twitterPopup.moveTo(left, 225);
					$(window).everyTime(50, function() {
						if (twitterPopup.closed) {
							$(this).stopTime();
							popupOpen = false;
							if (failedCallback != null)
								failedCallback();						
						}
					});
				}
			},			
			
			disconnectFromTwitter: function(callback) {
				 innerCallback = function() {
					 twitterSynced = false;
					 callback();
				 }
				 var disconnectRequest = new Request("disconnectFromTwitter", {}, {}, false, innerCallback, null);
				 disconnectRequest.getResponse();
			}
			
		}
	
	}
	
	
	return {
	
		getInstance: function() {
			if(!instance) { // Instantiate only if the instance doesn't exist.
				instance = constructor();
			}
			return instance;
		},
		
		
		constructor: function(twitterSynced) {
			
			if (!instance) 
				return instance = constructor(twitterSynced);
			
		}
		
	}		
	
})();