var LoadManager = (function() {

	var instance = false;
	
	var classPath = 'Jquery/', pluginsPath = 'IncludesJS/', cssPath = 'Styles/';

	var classesAR = [
	'Global',
	'Request'
	];

	var pluginsAR = [
	'timers'
	];

	var cssAR = [
	'main'
	];
	
	for (var i = 0; i < classesAR.length; i++) 
		classesAR[i] = classPath + classesAR[i] + ".js";

	for (i = 0; i < pluginsAR.length; i++) 
		pluginsAR[i] = pluginsPath + pluginsAR[i] + ".js";
		
	for (i = 0; i < cssAR.length; i++) 
		cssAR[i] = cssPath + cssAR[i] + ".css";		
	
	
	function constructor() {
	
        return {
		
            loadClasses: function(callback) {
				$.include(classesAR, callback);			
			}, 
			
			loadPlugins: function(callback) {
				$.include(pluginsAR, callback);			
			},
		
			loadStyles: function(callback) {
				$.include(cssAR, callback);			
			},

            loadAll: function() {
                $.include(classesAR); 
                $.include(pluginsAR);
                $.include(cssAR);	 
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