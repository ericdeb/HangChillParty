var TextInput = function(DOMID, value, passwordBool) {

	this.DOMID = DOMID;
	this.value = value == null ? "" : value;
	this.passwordBool = passwordBool;
	
};


TextInput.prototype = {
	
	textInputClass: "textInput",
	
	generate: function() {
		var ins = this.passwordBool == true ? 'password' : 'text';
		return '<input type="' + ins + '" name="' + this.DOMID + '" id="' + this.DOMID + '" value="' + this.value + '" class="' + this.textInputClass + '">';	
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
	},
	
	focusOn: function() {
		$("#" + this.DOMID).focus();
	},
	
	getDOMID: function() {
		return this.DOMID;
	},
	
	saveCurrentValue: function() {
		this.value = $("#" + this.DOMID).val();
	}
	
};
