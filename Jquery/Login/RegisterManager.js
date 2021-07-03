var RegisterManager = (function() {


	var instance = false;


	function constructor() {
			
		var DOMID = "registerManager";
		var registerObject = {
			birthday: null,
			facebookConnected: null
		};


		var registerUser = function (errorDOMID) {
			var callback = function() {
				window.location = "index.php";
			}
			var errorCallback = function() {
				$("#" + errorDOMID).html(ExceptionsManager.getInstance().printExceptions());
			}
			var registerRequest = new Request("registerUser", {}, registerObject, false, callback, errorCallback);
			registerRequest.getResponse();		
		}

		
		
        return {

            setStepOne: function(checkObj, errorDOMID, registerStepButton) {
				var e = ExceptionsManager.getInstance(), v = VerificationManager.getInstance(); 
				e.clearExceptions();
				v.verifyFirstName(checkObj.firstName); v.verifyLastName(checkObj.lastName); v.verifyLastName(checkObj.lastName); v.verifyEmail(checkObj.email);
				v.verifyPassword(checkObj.password); v.verifyPassword(checkObj.passwordVerified); v.verifyPasswordsEqual(checkObj.password, checkObj.passwordVerified);
				var errorCallback = function() {
					$("#" + errorDOMID).html(e.printExceptions());
					registerStepButton.bind();
				}
				if (e.areThereExceptions() == false) {
					var emailCallback = function(data) {
						if (data.emailStatus[0].em == 1) {
							$("#" + errorDOMID).html('');
							registerObject = $.extend(registerObject, checkObj);
							InitializeLoginManager.getInstance().getMainTabs().setCurrentTab(2);
						}
						else 
							$("#" + errorDOMID).html('email already in use, please use another');
						registerStepButton.bind();
					}
					var loadingImage = new LoadingImage("registerEmailLoad", 25, 25);
					$("#" + errorDOMID).html(loadingImage.generate());
					var emailRequest = new Request("checkIfEmailExists", {email: checkObj.email}, {}, false, emailCallback, errorCallback);
					emailRequest.getResponse();
				}
				else 
					errorCallback();
			},
			
			
			setStepTwo: function(checkObj, errorDOMID, registerStepButton) {
				var e = ExceptionsManager.getInstance(), v = VerificationManager.getInstance(); 
				e.clearExceptions();
				v.verifyReturnBoolean(checkObj.gender); v.verifyTermsCheckbox(checkObj.termsCheckbox);
				if (e.areThereExceptions() == false) {
					registerObject = $.extend(registerObject, checkObj);
					InitializeLoginManager.getInstance().getMainTabs().setCurrentTab(3);
				}
				else
					$("#" + errorDOMID).html(e.printExceptions());
				registerStepButton.bind();		
			},
			
			
			setStepThree: function(checkObj, errorDOMID, registerStepButton, registerSkipStepButton) {
				var e = ExceptionsManager.getInstance(), v = VerificationManager.getInstance(); 
				e.clearExceptions();
				if (checkObj.phone != null)
					v.verifyPhone(checkObj.phone);
				if (checkObj.blurb != null)
					v.verifyBlurb(checkObj.blurb); 
				if (e.areThereExceptions() == false) {
					registerObject = $.extend(registerObject, checkObj);
					registerUser(errorDOMID);
				}
				else
					$("#" + errorDOMID).html(e.printExceptions());
				registerStepButton.bind(); registerSkipStepButton.bind();	
			},
			
			
			setFacebookData: function(birthday) {
				if (birthday == null || birthday.length < 7)
					return false;
				registerObject.birthday = birthday.substr(6,4) + "-" + birthday.substr(0,2) + "-" + birthday.substr(3,2);
			}

		}
	
	}
	
	
	return {
	
		getInstance: function() {
			if(!instance) {
				instance = constructor();
			}
			return instance;
		}
		
	}		
	
})();