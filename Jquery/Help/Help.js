
var Help = (function() {


	var instance = false;


	function constructor(loginBool) {
		
		var DOMID = "help";
		var headingDOMID = "helpHeading";
		var backButtonDOMID = "helpBackButton";
		var helpHorizontalLineDOMID = "helpHorizontalLine";
		var helpHeadingLabel = new HeadingLabel(headingDOMID, "Welcome to Hangchillparty's Steps to Success");
		var helpTabs = new Tabs("helpTabs", "helpTabsHeading", 4);
		var helpSideBar = HelpSideBar.getInstance();
		var faqs = new FAQs("helpFAQs");
		var socialMeterHelp = new SocialMeterHelp("socialMeterHelp");
		var facebookAndTwitterHelp = new FacebookAndTwitterHelp("facebookAndTwitterHelp");
		var stepsToSuccessHelp = new StepsToSuccess("stepsToSuccessHelp", loginBool);
		
		if (loginBool == true)
			var loginHeader = new LoginHeader("helpHeader", false);
		
	
        return {

            generate: function() {
				var ins = loginBool == true ? loginHeader.generate() : '';
				var insTwo = loginBool == true ? '<a href="#" id="' + backButtonDOMID + '" class="registerBackButton">Back</a>' : '';
				var retStr = ins + '<div id="' + DOMID + '">' + helpHeadingLabel.generate() + insTwo + helpSideBar.generate() + helpTabs.generate();
				retStr += '<div class="floatFake"></div><div id="' + helpHorizontalLineDOMID + '"></div></div>';
				if (loginBool == true) 
					$("#" + InitializeLoginManager.getInstance().getMainTabs().getDOMID() + "-5").html(retStr);
				else
					$("#" + InitializeManager.getInstance().getMainTabs().getDOMID() + "-7").html(retStr);
				$("#" + helpTabs.getDOMID() + '-1').html(stepsToSuccessHelp.generate());
				$("#" + helpTabs.getDOMID() + '-2').html(facebookAndTwitterHelp.generate());
				$("#" + helpTabs.getDOMID() + '-3').html(faqs.generate());
				$("#" + helpTabs.getDOMID() + '-4').html(socialMeterHelp.generate());
			},
			
			
			bind: function() {
				helpSideBar.bind(); helpTabs.bind(); stepsToSuccessHelp.bind();
				if (loginBool == true) {
					loginHeader.bind();
					$("#" + backButtonDOMID).click(function() {
						InitializeLoginManager.getInstance().getMainTabs().setCurrentTab(0);	
						$(".rrt-inner li").css('display', 'none');
					});	
				}
			},
			
			getHelpTabs: function() {
				return helpTabs;
			},
			
			getHeadingLabel: function() {
				return helpHeadingLabel;	
			}
			
		}
	
	}
	
	
	return {
	
		getInstance: function() {
			if(instance)
				return instance;		
		},
		
		
		constructor: function(loginBool) {
			
			if (!instance) 
				return instance = constructor(loginBool);
			
		}
		
	}		

})();	