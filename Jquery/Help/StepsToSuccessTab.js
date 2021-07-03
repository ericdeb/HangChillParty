var StepsToSuccessTab = (function() {


	var instance = false;
	

	function constructor() {

		var mainDOMID = "stepsToSuccessTab";
		var innerTab = "stepsToSuccessTabInner";
		var skipLinkDOMID = "skipPageLink";
		var stepsToSuccess = new StepsToSuccess("stepsToSuccessTabSteps", false);
		var headingLabel = new HeadingLabel("StepsToSuccessTabHeading", "Welcome to Hangchillparty's Steps to Success");
		var coolImDoneImageSource = "Images/coolImDoneButton.png";
		var coolImDoneImageDOMID = "coolImDoneButton";
		var horizontalLineDOMID = "stepsToSuccessHorizontalLine";
		
		
		return {
			
				
            generate: function() {
				var retStr = '<div id="' + mainDOMID + '">' + headingLabel.generate();
				retStr += '<a href="#" id="' + skipLinkDOMID + '">Skip this page >></a>';
				retStr += '<div id="' + innerTab + '">' + stepsToSuccess.generate() + '</div>';
				retStr += '<img id="' + coolImDoneImageDOMID + '" src="' + coolImDoneImageSource + '" />';
				retStr += '<div class="floatFake"></div><div id="' + horizontalLineDOMID + '"></div></div>';
				return retStr;
			},
			
			
			bind: function() {
				stepsToSuccess.bind();
				$("#" + skipLinkDOMID + ", #" + coolImDoneImageDOMID).click(function() {
					MainMenuBar.getInstance().getHangchillpartyLink().selectLink();	
					AwardsManager.getInstance().initialize();
				})
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