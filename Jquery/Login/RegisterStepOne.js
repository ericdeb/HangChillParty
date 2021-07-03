var RegisterStepOne = (function() {


	var instance = false;


	function constructor() {
			
		var DOMID = "registerStepOne";
		var backButtonDOMID = "registerStepOneBack";
		var registerStepOneClass = "register";
		var loginHeader = new LoginHeader("registerStepOneHeader", false);
		var stepOneHeadingLabel = new HeadingLabel("registerStepOneHeading", "Sign Up", "Step 1 of 3");
		var emailLabelSpanDOMID = "registerStepOneEmailLabel";
		var emailInput = new TextInput("registerStepOneEmail", null, false);
		var firstNameLabelSpanDOMID = "registerStepOneFirstNameLabel";
		var firstNameInput = new TextInput("registerStepOneFirstName", null, false);
		var lastNameLabelSpanDOMID = "registerStepOneLastNameLabel";
		var lastNameInput = new TextInput("registerStepOneLastName", null, false);
		var emailTinyMessageDOMID = "registerEmailTinyMessage";
		var emailTinyMessage = "Your login name.  We don't do junk mail";
		var bigOrDOMID = "registerStepOneOr";
		var errorDOMID = "registerStepOneError";
		var passwordInput = new PasswordInput("register", false);
		var horizontalLineDOMID = "registerStepOneHorizontalLine";
		var facebookPermissionsButton = new FacebookPermissionsButton();
		var registerCallback = function () {
			var checkObj = {
				firstName: firstNameInput.getValue(),
				lastName: lastNameInput.getValue(),
				email: emailInput.getValue(),
				password: passwordInput.getNewPassword(),
				passwordVerified: passwordInput.getNewPasswordAgain()
			}
			RegisterManager.getInstance().setStepOne(checkObj, errorDOMID, registerStepButton);
		}
		var registerStepButton = new RegisterStepButton("registerStepOneButton", "enter", registerCallback);
		
		
        return {

            generate: function() {
				var retStr = loginHeader.generate() + '<div id="' + DOMID + '" class="' + registerStepOneClass + '">' + stepOneHeadingLabel.generate();
				retStr += '<a href="#" id="' + backButtonDOMID + '" class="registerBackButton">Back</a>';
				retStr += '<span id="' + emailLabelSpanDOMID + '">Email</span>' + emailInput.generate();
				retStr += '<span id="' + bigOrDOMID + '">or</span>' + facebookPermissionsButton.generate();
				retStr += '<span id="' + emailTinyMessageDOMID + '">' + emailTinyMessage + '</span>';
				retStr += '<span id="' + firstNameLabelSpanDOMID + '">First Name</span>' + firstNameInput.generate();
				retStr += '<span id="' + lastNameLabelSpanDOMID + '">Last Name</span>' + lastNameInput.generate() + passwordInput.generate();
				retStr += registerStepButton.generate() + '<div id="' + errorDOMID + '"></div><div id="' + horizontalLineDOMID + '" class="loginHorizontalLine">';
				retStr += '</div></div>';
				return retStr;
			},
			
			
			bind: function() {
				loginHeader.bind(); emailInput.bind(); facebookPermissionsButton.bind(); passwordInput.bind(); registerStepButton.bind(); firstNameInput.bind(); lastNameInput.bind();
				var that = this;
				$("#" + backButtonDOMID).click(function() {
					InitializeLoginManager.getInstance().getMainTabs().setCurrentTab(0);
					$(".rrt-inner li").css('display', 'none');
				});
				$("#registerNewPasswordAgainInput").keydown(function(e) {
					if (e.which == 13) {
						passwordInput.getNewPasswordAgainInput().saveCurrentValue();
						registerCallback();	
					}
				});		
			},
			
			
			setFacebookValues: function(firstName, lastName, email) {
				firstNameInput.setValue(firstName); lastNameInput.setValue(lastName); emailInput.setValue(email);
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