var RegisterStepThree = (function() {


	var instance = false;


	function constructor() {
			
		var DOMID = "registerStepThree";
		var backButtonDOMID = "registerStepThreeBack";
		var loginHeader = new LoginHeader("registerStepThreeHeader", false);
		var stepThreeHeadingLabel = new HeadingLabel("registerStepThreeHeading", "Complete your profile (optional)", "Step 3 of 3");
		var currentPhoneInputOne = new TextInput("registerPhoneInputOne");
		var currentPhoneInputTwo = new TextInput("registerPhoneInputTwo");
		var currentPhoneInputThree = new TextInput("registerPhoneInputThree");
		var currentPhoneLabelDOMID = "registerPhoneLabel";
		var currentPhoneRightLabelDOMID = "registerPhoneRightLabel";
		var currentPhoneRightLabel = "Get texts when your friends want to hang out.  Can be turned off.";
		var uploadImageLabelDOMID = "registerUploadPicLabel";
		var uploadImageDOMID = "registerUploadPic";
		var blurbLabelDOMID = "registerBlurbLabel";
		var blurbTextArea = new TextArea("registerBlurbTextArea");
		var errorDOMID = "registerStepThreeError";
		var horizontalLineDOMID = "registerStepThreeHorizontalLine";
		var yellowLineDOMID = "registerYellowLine";
		var registerCallback = function () {
			registerStepButton.unbind(); registerSkipStepButton.unbind();
			
			var phoneIns = currentPhoneInputOne.getValue() + currentPhoneInputTwo.getValue() + currentPhoneInputThree.getValue()
			var checkObj = {
				phone: phoneIns == 0 ? null : phoneIns,
				blurb: blurbTextArea.getValue()
			}
			RegisterManager.getInstance().setStepThree(checkObj, errorDOMID, registerStepButton, registerSkipStepButton);
		}
		var registerStepButton = new RegisterStepButton("registerStepThreeButton", "saveAndFinish", registerCallback);
		var registerSkipStepButton = new RegisterStepButton("registerStepThreeButtonSkip", "skipPage", registerCallback);
		
		
        return {

            generate: function() {
				var retStr = loginHeader.generate() + '<div id="' + DOMID + '" class="register">' + stepThreeHeadingLabel.generate();
				retStr += '<a href="#" id="' + backButtonDOMID + '" class="registerBackButton">Back</a>' + registerSkipStepButton.generate();
				retStr += '<span id="' + currentPhoneLabelDOMID + '">Cell</span>' + currentPhoneInputOne.generate() + currentPhoneInputTwo.generate();
				retStr += currentPhoneInputThree.generate() + '<span id="' + currentPhoneRightLabelDOMID + '">' + currentPhoneRightLabel + '</span>';
				retStr += '<div id="' + yellowLineDOMID + '"></div>';
				retStr += '<span id="' + uploadImageLabelDOMID + '">Upload pic</span><input id="' + uploadImageDOMID + '" type="file" name="upload" />';
				retStr += '<span id="' + blurbLabelDOMID + '">Quickie</span>' + blurbTextArea.generate();
				retStr += registerStepButton.generate() + '<div id="' + errorDOMID + '"></div><div id="' + horizontalLineDOMID + '" class="loginHorizontalLine">';
				retStr += '</div></div>';
				return retStr;
			},
			
			
			bind: function() {
				loginHeader.bind(); currentPhoneInputOne.bind(); currentPhoneInputTwo.bind(); currentPhoneInputThree.bind(); blurbTextArea.bind(); registerStepButton.bind(); registerSkipStepButton.bind();
				$("#" + uploadImageDOMID).change(function() {
					var imageID = new Date().getTime();
					var callback = function(){};
					$("#" + uploadImageDOMID).upload('requestswitch.php?action=uploadImage&imageID=' + imageID, callback, 'html');	
        		});	
				$("#" + backButtonDOMID).click(function() {
					InitializeLoginManager.getInstance().getMainTabs().setCurrentTab(2);									
				});
			},
			
			setFacebookValues: function(quickie) {
				blurbTextArea.setValue(quickie);
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