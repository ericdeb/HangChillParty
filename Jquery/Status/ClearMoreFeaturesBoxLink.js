var ClearMoreFeaturesBoxLink = function() {

	var DOMID = "clearMoreFeaturesBoxLink";
	

	this.generate = function () {
		return '<a id="' + DOMID + '" href="#">clear</a>';
	};	
	
	
	this.bind = function () {		
		$("#" + DOMID).click(function() {
			MoreFeaturesBox.getInstance().clear();	
			return false;
		});
	};
		
};