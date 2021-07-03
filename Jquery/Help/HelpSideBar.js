
var HelpSideBar = (function() {


	var instance = false;


	function constructor() {
		
		var DOMID = "helpSideBar";
		var helpSideBarClass = "tabsSideBar";
		var stepsToSuccessLinkDOMID = "stepsToSuccessLink";
		var stepsToSuccessLabel = "Steps to Success";
		var facebookAndTwitterLinkDOMID = "facebookAndTwitterHelpLink";
		var facebookAndTwitterLabel = "Facebook and Twitter";
		var FAQsLinkDOMID = "FAQsLink";
		var FAQsLabel = "FAQs";
		var socialMeterLinkDOMID = "socialMeterHelpLink";
		var socialMeterLabel = "Social Meter";

		
		var intObj = {
			stepsToSuccessLink:  new HelpSideLink(stepsToSuccessLinkDOMID, stepsToSuccessLabel, stepsToSuccessLabel, 0, true),
			facebookAndTwitterLink:  new HelpSideLink(facebookAndTwitterLinkDOMID, facebookAndTwitterLabel, facebookAndTwitterLabel, 1, false),
			FAQsLink:  new HelpSideLink(FAQsLinkDOMID, FAQsLabel, FAQsLabel, 2, false),
			socialMeterLink: new HelpSideLink(socialMeterLinkDOMID, socialMeterLabel, socialMeterLabel, 3, false)
		}
		
	
        return {

            generate: function() {
				var retStr = '<div id="' + DOMID + '" class="' + helpSideBarClass + '">';
				for (var key in intObj)
					retStr += intObj[key].generate();
				retStr += '</div>';
				return retStr;
			},
			
			
			bind: function() {
				for (var key in intObj)
					intObj[key].bind();				
			},
			
			
			getDOMID: function() {
				return DOMID;	
			},
			
			getFacebookAndTwitterLink: function() {
				return intObj.facebookAndTwitterLink;
			},
			
			getStepsToSuccessLink: function() {
				return intObj.stepsToSuccessLink;
			},
			
			getSocialMeterLink: function() {
				return intObj.socialMeterLink;
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