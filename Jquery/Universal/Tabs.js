var Tabs = function(DOMID, tabHeadingDOMID, numTabs) {

	this.DOMID = DOMID;
	this.numTabs = numTabs;
	this.tabHeadingDOMID = tabHeadingDOMID;
	this.currentTab = 0;
		
};

Tabs.prototype = {

	genTabsList: function() {
		var str = '<div id="' + this.DOMID + '"><ul id="' + this.tabHeadingDOMID + '" class="hiddenTabs">';
		for (var i = 1; i < this.numTabs+1; i++)
			str += '<li><a href="#' + this.DOMID + "-" + i + '"></a></li>';
		str += "</ul>";
		return str;
	},
	
	
	generate: function() {
		var str = this.genTabsList();
		for (var i = 1; i < this.numTabs+1; i++)
			str += '<div id="' + this.DOMID + "-" + i + '"></div>';
		str += "</div>";
		return str;               				
	},
	
	
	bind: function() {
		$("#" + this.DOMID).tabs();	
	},
	
	
	getDOMID: function() {
		return this.DOMID;
	},
	
	
	getCurrentTab: function() {
		return this.currentTab;
	},
	
	
	setCurrentTab: function(num) {
		this.currentTab = num;
		$("#" + this.DOMID).tabs('select', num);
	},
	
	
	generateUpToTab: function(num) {
		var str = this.genTabsList();
		for (var i = 1; i < num+1; i++)
			str += '<div id="' + this.DOMID + "-" + i + '">' + (i != num ? '</div>' : '');
		return str; 
	},
	
	
	generateFromTab: function(num) {
		var str = "</div>";
		for (var i = num+1; i < this.numTabs+1; i++)
			str += '<div id="' + this.DOMID + "-" + i + '"></div>';
		str += "</div>";
		return str; 		
	}	

};
