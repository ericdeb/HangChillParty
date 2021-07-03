var SettingsSubmitButton = function(DOMID, callback) {

	var DOMID = DOMID;
	var imageSource = "Images/settingsSubmitButton.png";


	this.generate = function() {
		return '<div id="' + DOMID + '" class="settingsSubmitButton"><img src="' + imageSource + '" /></div>';
	};	
	
	
	this.bind = function() {
		$("#" + DOMID).click(function() {
			callback();
		});		
	};

};
