var HelpSideLink = function(DOMID, label, headingLabel, tabNumber, initialHighlight) {

	var DOMID = DOMID;
	var tabNumber = tabNumber;
	var label = label;
	var headingLabel = headingLabel;
	var helpSideLinkClass = "helpSideLink";
	var initialHighlight = initialHighlight;
	
	
	this.generate = function () {
		var ins = initialHighlight == true ? 'helpTabHighlight' : '';
		return '<div id="' + DOMID + '" class="' + ins + '"><span>' + label + '</span></div>';
	};	
	
	
	this.bind = function () {
		$("#" + DOMID).click(function() {
			var s = Help.getInstance();
			s.getHelpTabs().setCurrentTab(tabNumber);
			$("#" + HelpSideBar.getInstance().getDOMID() + " div").removeClass('helpTabHighlight');
			$("#" + DOMID).addClass('helpTabHighlight');
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
