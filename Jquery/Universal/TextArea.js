var TextArea = function(DOMID, value) {

	this.DOMID = DOMID;
	this.value = value == null ? "" : value;

	
};


TextArea.prototype = {
	
	textAreaClass: "textArea",
	
	
	generate: function() {
		return '<textarea name="' + this.DOMID + '" id="' + this.DOMID + '" class="' + this.textAreaClass + '">' + this.value + '</textarea>';	
	},
	
	
	bind: function() {
		var that = this;
		$("#" + this.DOMID).blur(function() {
			that.value = $(this).val();
		});
	},
	
	clear: function() {
		this.value = "";
		$("#" + this.DOMID).val("");		
	},
	
	getValue: function() {
		if (this.value == "")
			return null;
		else
			return this.value;
	},
	
	setValue: function(value) {
		this.value = value;
		$("#" + this.DOMID).val(value);	
	}
	
	
	
};
