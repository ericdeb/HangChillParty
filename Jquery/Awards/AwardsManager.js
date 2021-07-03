
var AwardsManager = (function() {


	var instance = false;


	function constructor() {
		
		var awardsLightBox =  new AwardsLightBox("awardsLightBox");
		var newAwardsCount = 0;
		var awardsHearbeatStarted = false;


		function getNewAwardsNumbers() {
			var getNewAwardsCallback = function(data) {
				newAwardsCount += parseInt(data.AwardNumber[0].nu);
			}
			var newAwardsRequest = new Request("getAwardsNumbers", {}, {}, true, getNewAwardsCallback, null);
			newAwardsRequest.getResponse();
			$("#mainTabs").stopTime().oneTime(30000, getNewAwardsNumbers);
		}
		
		
		function displayNewAwards() {
			if (newAwardsCount > 0) {
				awardsLightBox.displayNewAward();
				newAwardsCount--;
			}
			$("#mainTabs-1").stopTime().oneTime(10000, displayNewAwards);
		}
		
        return {
			
			generate: function() {
				return awardsLightBox.generate();
			},
			
			initialize: function() {
				if (awardsHearbeatStarted == false) {
					awardsHearbeatStarted = true;
					getNewAwardsNumbers();
					displayNewAwards();
				}
			},
			
			getAwardsLightBox: function() {
				return awardsLightBox;
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