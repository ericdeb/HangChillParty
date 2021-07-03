var TopLink = function () {
	
};


TopLink.prototype = {
	
	highlightColor: "#00FF8C",
	
	selectTab: function (DOMID, tabNumber, highlight) {
		var mainTabs = InitializeManager.getInstance().getMainTabs(), mb = MainMenuBar.getInstance();
		mainTabs.setCurrentTab(tabNumber);
		var menuDOMID = mb.getDOMID();
		mb.setAllWhite();
		if (highlight == true)
			$("#" + DOMID).css('color', this.highlightColor);
	}
	
};

