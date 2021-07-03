var RadioButton = function(DOMID, labelOne, labelTwo, valueOne, valueTwo, selectedValue) {

	this.DOMID = DOMID;
	this.name = DOMID + "name";
	this.radioOneDOMID = DOMID + "RadioOne";
	this.radioTwoDOMID = DOMID + "RadioTwo";
	this.labelOne = labelOne;
	this.labelTwo = labelTwo;
	this.valueOne = valueOne;
	this.valueTwo = valueTwo;
	this.selectedValue = selectedValue;

};


RadioButton.prototype = {
	
	radioButtonClass:  "radioButton",

	
	generate: function() {
		var insOne = this.selectedValue == this.valueOne ? 'checked="checked"' : '';
		var insTwo = this.selectedValue == this.valueTwo ? 'checked="checked"' : '';
		var retStr = '<div id="' + this.DOMID + '" class="' + this.radioButtonClass + '">';
		retStr += '<span>' + this.labelOne + '</span>';
		retStr += '<input id="' + this.radioOneDOMID + '" type="radio" name="' + this.name + '" value="' + this.valueOne + '" ' + insOne + '/>'; 
		retStr += '<span>' + this.labelTwo + '</span>';
		retStr += '<input id="' + this.radioTwoDOMID + '" type="radio" name="' + this.name + '" value="' + this.valueTwo + '" ' + insTwo + '/>';
		retStr += '</div>';
		return retStr;
	},
	
	
	bind: function() {
		var that = this;
		$("#" + this.radioOneDOMID).click(function() {
			that.selectedValue = that.valueOne;
			console.log("1 " + that.selectedValue);
		});
		$("#" + this.radioTwoDOMID).click(function() {
			that.selectedValue = that.valueTwo;
			console.log("2 " + that.selectedValue);
		});
	},
	
	
	getValue: function() {
		return this.selectedValue;
	},
	
	
	setValue: function(value) {
		if (value == this.valueOne)
			$("#" + this.radioOneDOMID).click();
		else if (value == this.valueTwo)
			$("#" + this.radioTwoDOMID).click();		
	}
	
};
