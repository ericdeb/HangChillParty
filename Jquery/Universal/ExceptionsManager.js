var ExceptionsManager = (function() {


	var instance = false;


	function constructor() {

		var exceptionsAR = [];
		
        return {
		
			addException: function(e) {
				for (var i = 0; i < exceptionsAR.length; i++) {
					if (e.toString() == exceptionsAR[i].toString())
						return;
				}
				exceptionsAR.push(e);
			},
			
			
			areThereExceptions: function() {
				if (exceptionsAR.length > 0)
					return true;
				return false;
			},
			
			
			clearExceptions: function() {
				exceptionsAR = [];
			},
			
			
			printExceptions: function() {
				var retStr = "";
				for (var i = 0; i < exceptionsAR.length; i++) 
					retStr += exceptionsAR[i].message + " <br /> ";
				return Global.shortenString(retStr, 8);
			}
			
			
		}
	
	}
	
	
	return {
	
		getInstance: function() {
			if(!instance) { // Instantiate only if the instance doesn't exist.
				instance = constructor();
			}
			return instance;
		}
		
	}		
	
})();