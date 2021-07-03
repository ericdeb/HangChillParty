var SettingsSaveButton = function(DOMID, callback) {

	var imageSource = "Images/settingsSaveButton.png";
	var settingsSaveButtonClass = "settingsSaveButton";

	this.generate = function() {
		return '<div id="' + DOMID + '" class="' + settingsSaveButtonClass + '"><img src="' + imageSource + '" /></div>';
	};	
	
	
	this.bind = function() {
		$("#" + DOMID).click(function() {
			callback();
		});		
	};

};
