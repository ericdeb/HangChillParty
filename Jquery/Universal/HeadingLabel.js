var HeadingLabel = function(DOMID, label, subLabel) {

	this.DOMID = DOMID;
	this.label = label;
	this.subLabel = subLabel;
	
};


HeadingLabel.prototype = {
	
	headingClass: "headingLabel",
	headingLabelClass: "headingLabelLabel",
	headingSubLabelClass: "headingLabelSubLabel",
	horizontalLineClass: "headingHorizontalLine",
	
	generate: function() {
		var ins = this.subLabel != null ? '<div class="' + this.headingSubLabelClass + '"><span>' + this.subLabel + '</span></div>' : "";
		var retStr = '<div id="' + this.DOMID + '" class="' + this.headingClass + '">';
		retStr += '<span class="' + this.headingLabelClass + '">' + this.label + '</span>' + ins;
		retStr += '<div class="' + this.horizontalLineClass + '"></div></div>';
		return retStr;	
	},
	
	
	setLabel: function(label) {
		this.label = label;
		$("#" + this.DOMID + " span").html(label);
	}
	
	
};
