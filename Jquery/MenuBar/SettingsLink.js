var SettingsLink = function() {

	var DOMID = "settingsLink";
	var tabNumber = 5;
	
	
	function selectTab() {
		HangchillpartyLink.superClass.selectTab(DOMID, tabNumber, true);
	}
	
	
	this.generate = function () {
		return '<a id="' + DOMID + '" href="#" >Settings</a>';
	};	
	
	this.bind = function () {
		$("#" + DOMID).click(function() {
				selectTab();
		});
	};
	
	this.selectLink = function() {
		selectTab();	
	}
		
};

Global.extend(SettingsLink, TopLink);