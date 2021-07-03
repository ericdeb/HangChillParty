var DropDownBox = function(DOMID, namesAR, valuesAR, selectName, selectCallback) {

	this.DOMID = DOMID;
	this.namesAR = namesAR;
	this.valuesAR = valuesAR;
	this.selectName = selectName;
	this.selectedValue = valuesAR[0];
	this.selectCallback = selectCallback;
	
};


DropDownBox.prototype = {
	
	
	generate: function() {
		var retStr = '<select id="' + this.DOMID + '" name="' + this.DOMID + 'dropDown">';
		for (var i = 0; i < this.namesAR.length; i++) {
			var selIns = '';
			if (this.namesAR[i] == this.selectName) {
				 selIns = 'selected="selected"';	
				 this.selectedValue = this.valuesAR[i];
			}
			retStr += '<option value="' + this.valuesAR[i] +'" ' + selIns + '>' + this.namesAR[i] +'</option>';			
		}
		retStr += '</select>';
		return retStr;	
	},
	
	
	bind: function() {
		var that = this;
		$("#" + this.DOMID).blur(function() {
				that.selectedValue = $("#" + that.DOMID + ' option:selected').val();
		});
		$("#" + this.DOMID).change(function() {
			that.selectedValue = $("#" + that.DOMID + ' option:selected').val();	
			if (that.selectCallback != null)
				that.selectCallback(that.selectedValue);
		});
	},
	
	
	clear: function() {
		var that = this;
		$("#" + this.DOMID + ' option:selected').attr('selected', "");
		$("#" + this.DOMID + ' option:first').attr('selected', "selected");
		$("#" + this.DOMID + ' option').each(function () {
			if ($(this).text() == this.selectName) {
				$("#" + that.DOMID + ' option:selected').attr('selected', "");
				$(this).attr('selected', "selected");
				return false;
			}				
		});
	},
	
	
	getValue: function() {
		return this.selectedValue;
	}
	
	
};