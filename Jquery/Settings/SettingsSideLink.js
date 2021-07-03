var SettingsSideLink = function(DOMID, label, headingLabel, tabNumber, initialHighlight) {

	var DOMID = DOMID;
	var tabNumber = tabNumber;
	var label = label;
	var headingLabel = headingLabel;
	var settingsSideLinkClass = "settingsSideLink";
	var initialHighlight = initialHighlight;
	
	
	this.generate = function () {
		var ins = initialHighlight == true ? 'settingsTabHighlight' : '';
		return '<div id="' + DOMID + '" class="friendsSearchTabs ' + ins + '"><span>' + label + '</span></div>';
	};	
	
	
	this.bind = function () {
		$("#" + DOMID).click(function() {
			var s = Settings.getInstance();
			s.getSettingsTabs().setCurrentTab(tabNumber);
			$("#" + SettingsSideBar.getInstance().getDOMID() + " div").removeClass('settingsTabHighlight');
			$("#" + DOMID).addClass('settingsTabHighlight');
			s.getHeadingLabel().setLabel(headingLabel);
		});
	};
	
	this.getTabNumber = function() {
		return tabNumber;
	};
	
	this.getDOMID = function() {
		return DOMID;
	};
	
	this.selectLink = function() {
		$("#" + DOMID).click();	
	}
		
};
