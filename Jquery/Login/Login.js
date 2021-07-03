var Login = (function() {


	var instance = false;
	

	function constructor() {
		
		var DOMID = 'login';
		var loginBottomDOMID = "loginBottom";
		var loginHeader = new LoginHeader("loginLoginHeader", true);
		var loginLight = new StatusLight("loginLight", "green");
		var registerButtonSignal = new RegisterButton("signalRegister", "signal");
		var registerButtonSignUp = new RegisterButton("signUpRegister", "signUp");
		var descriptionLabelDOMID = "loginDescription";
		var descriptionLabelSource = "Images/loginDescription.gif";
		var twitterRetweetButton = new TwitterRetweetButton("loginTwitterRetweet");
		var horizontalLineDOMID = "loginHorizontalLine";
		var leftDivDOMID = "loginLeftSide";
		var loginLeftGetInfoDOMID = "loginLeftSideGetInfo";
		var loginLeftGetTextsDOMID = "loginLeftSideGetTexts";
		var loginLeftGetTextsLink = "loginLeftSideGetTextsLink"; 
		var loginLeftGetEmailsDOMID = "loginLeftSideGetEmails";
		var loginLeftGetEmailsLink = "loginLeftSideGetEmailsLink";
		var loginLeftFriendsChillSpan = "loginLeftSideFriendsChillSpan";
		var loginLeftSeeCoolnessDOMID = "loginLeftSideSeeCoolness";
		var loginLeftSideSocialMeterLabelDOMID = "loginLeftSideSocialMeterLabel";
		var loginLeftSideSocialMeterDivDOMID = "loginLeftSideSocialMeterDiv";
		var loginLeftSideSocialMeterDOMID = "loginLeftSideSocialMeter";
		var loginLeftSignalAndInviteDOMID = "LoginLeftSideSignalAndInvite";
		var loginLeftSignalAndInviteIconsDOMID = "LoginLeftSideSignalAndInviteIcons";
		var loginLeftSideYellowDotImageSource = "Images/loginYellowDot.png";
		var loginLeftSideTextsImageSource = "Images/loginLeftSideTexts.png";		
		var loginLeftSideEmailsImageSource = "Images/loginLeftSideEmails.png";
		var loginLeftSideSocialMeter = "Images/loginLeftSideSocialMeter.png";
		var loginLeftSideFacebookIcon = "Images/loginLeftSideFacebookIcon.png";
		var loginLeftSideTwitterIcon = "Images/loginLeftSideTwitterIcon.png";
		var loginLeftSideFacebookIconDOMID = "loginLeftSideFacebookIcon";
		var loginLeftSideTwitterIconDOMID = "loginLeftSideTwitterIcon";
		
		
        return {
		
		
            generate: function() {
				var retStr = loginHeader.generate() + '<div id="' + DOMID + '">' + registerButtonSignUp.generate();
				retStr += '<div id="' + leftDivDOMID + '"><div id="' + loginLeftGetInfoDOMID + '"><img src="' + loginLeftSideYellowDotImageSource + '" />';
				retStr += '<span>Get</span><div id="' + loginLeftGetTextsDOMID + '">';
				retStr += '<img id="' + loginLeftGetTextsLink + '" src="' +  loginLeftSideTextsImageSource + '" /></div>';
				retStr += '<div id="' + loginLeftGetEmailsDOMID + '"><img id="' + loginLeftGetEmailsLink + '" src="' + loginLeftSideEmailsImageSource + '" /></div>';
				retStr += '<span id="' + loginLeftFriendsChillSpan + '">when friends want to chill</span></div>';
				retStr += '<div id="' + loginLeftSeeCoolnessDOMID + '"><img src="' + loginLeftSideYellowDotImageSource + '" />';
				retStr += '<div id="' + loginLeftSideSocialMeterLabelDOMID + '"><span>See how cool you are, in real life.</span></div>';
				retStr += '<div id="' + loginLeftSideSocialMeterDivDOMID + '">';
				retStr += '<img id="' + loginLeftSideSocialMeterDOMID + '" src="' + loginLeftSideSocialMeter + '" /></div></div>';
				retStr += '<div id="' + loginLeftSignalAndInviteDOMID + '"><img src="' + loginLeftSideYellowDotImageSource + '" />';
				retStr += '<span>Signal and invite friends on </span><div id="' + loginLeftSignalAndInviteIconsDOMID + '">';
				retStr += '<img id="' + loginLeftSideFacebookIconDOMID + '" src="' + loginLeftSideFacebookIcon + '" />';
				retStr += '<img id="' + loginLeftSideTwitterIconDOMID + '" src="' + loginLeftSideTwitterIcon + '" /></div></div></div>';
				retStr += loginLight.generate() + registerButtonSignal.generate() + '<div class="floatFake"></div>';
				retStr += '<div id="' + horizontalLineDOMID + '" class="loginHorizontalLine"></div></div>';
				return retStr;
			},
			
			
			bind: function() {
				loginHeader.bind();
				twitterRetweetButton.bind();
				loginLight.bind();
				registerButtonSignal.bind();
				registerButtonSignUp.bind();
				$("#" + loginLeftGetTextsDOMID + ", #" + loginLeftGetEmailsDOMID).click(function() {
					InitializeLoginManager.getInstance().getFooter().selectHelpLink();
					HelpSideBar.getInstance().getStepsToSuccessLink().selectLink();									   
				});
				$("#" + loginLeftSideSocialMeterDOMID).click(function() {
					InitializeLoginManager.getInstance().getFooter().selectHelpLink();
					HelpSideBar.getInstance().getSocialMeterLink().selectLink();										   
				});
				$("#" + loginLeftSideFacebookIconDOMID + ", #" + loginLeftSideTwitterIconDOMID).click(function() {
					InitializeLoginManager.getInstance().getFooter().selectHelpLink();
					HelpSideBar.getInstance().getFacebookAndTwitterLink().selectLink();								   
				});
			},
			
			getTwitterRetweetButton: function() {
				return twitterRetweetButton;
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