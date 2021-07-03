var Checkbox = function(DOMID, checked) {

	this.DOMID = DOMID;
	this.checked = checked;
	
};


Checkbox.prototype = {
	
	checkboxClass: "checkbox",
	
	
	generate: function() {
		var checkIns = this.checked == true ? 'checked=checked' : '';
		return '<input type="checkbox" id="' + this.DOMID + '" class="' + this.checkboxClass + '" ' + checkIns + '/>';	
	},
	
	
	bind: function() {
		var that = this;
		$("#" + this.DOMID).click(function() {
			that.checked = that.checked == true ? false : true;
		});
	},
	
	
	getValue: function() {
		return this.checked == true ? 1 : 0;
	},
	
	
	getDOMID: function() {
		return this.DOMID;
	},
	
	
	clearValue: function() {
		this.checked = false;
	}
	
};
