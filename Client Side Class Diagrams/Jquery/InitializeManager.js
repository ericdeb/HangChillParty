$(document).ready(function(){
	
	initializeManager = InitializeManager.getInstance();
    initializeManager.initializeSite();
	
});


var InitializeManager = (function() {

	var instance = false;
	
	

	function constructor() {
	
		var loadManager = LoadManager.getInstance();
	
        return {
		
            initializeSite: function() {
                loadManager.loadAll();
				
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