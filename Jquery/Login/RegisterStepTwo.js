var RegisterStepTwo = (function() {


	var instance = false;


	function constructor() {
			
		var DOMID = "registerStepTwo";
		var backButtonDOMID = "registerStepTwoBack";
		var loginHeader = new LoginHeader("registerStepTwoHeader", false);
		var stepTwoHeadingLabel = new HeadingLabel("registerStepTwoHeading", "Sign Up", "Step 2 of 3");
		var genderLabelDOMID = "registerGenderLabel";
		var genderRadio = new RadioButton("genderRadio", "male", "female", 0, 1, 0);
		var timeZoneInput = new TimeZoneInput("registerTimeZoneInput", "America" , "West Coast Time");
		var timeZoneLabelDOMID = "registerStepTwoTimeZoneLabel"
		var timeZoneLabel = "Hangchillparty works globally in English";
		var termsCheckbox = new Checkbox("registerStepTwoTermsCheckbox", false);
		var termsLabelDOMID = "registerStepTwoTermsLabel";
		var termsLabel = "I understand and agree to the ";
		var errorDOMID = "registerStepTwoError";
		var horizontalLineDOMID = "registerStepTwoHorizontalLine";
		var termsLink = "http://blog.hangchillparty.com/?page_id=162";
		var termsLinkDOMID = "registerStepTwoTerms";
		
		var registerCallback = function () {
			var checkObj = {
				gender: genderRadio.getValue(),
				timeZoneID: timeZoneInput.getValue(),
				termsCheckbox: termsCheckbox.getValue()
			}
			RegisterManager.getInstance().setStepTwo(checkObj, errorDOMID, registerStepButton);
		}
		var registerStepButton = new RegisterStepButton("registerStepTwoButton", "enter", registerCallback);

		
		
        return {

            generate: function() {
				var retStr = loginHeader.generate() + '<div id="' + DOMID + '" class="register">' + stepTwoHeadingLabel.generate();
				retStr += '<a href="#" id="' + backButtonDOMID + '" class="registerBackButton">Back</a>';
				retStr += '<span id="' + genderLabelDOMID + '">Sex</span>' + genderRadio.generate();
				retStr += '<span id="' + timeZoneLabelDOMID + '">' + timeZoneLabel + '</span>' + timeZoneInput.generate();
				retStr += termsCheckbox.generate() + '<span id="' + termsLabelDOMID + '">' + termsLabel + '</span>';
				retStr += '<a id="' + termsLinkDOMID + '" href="' + termsLink + '" target="_blank">Terms Of Service</a>';
				retStr += registerStepButton.generate() + '<div id="' + errorDOMID + '"></div><div id="' + horizontalLineDOMID + '" class="loginHorizontalLine">';
				retStr += '</div></div>';
				return retStr;
			},
			
			
			bind: function() {
				loginHeader.bind(); genderRadio.bind(); timeZoneInput.bind(); termsCheckbox.bind(); registerStepButton.bind();
				$("#" + backButtonDOMID).click(function() {
					InitializeLoginManager.getInstance().getMainTabs().setCurrentTab(1);
				});
			},
			
			setFacebookValues: function(gender) {
				genderRadio.setValue(gender);
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