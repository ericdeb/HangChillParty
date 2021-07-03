var AutoCompleteInput = function(DOMID, type, value, dataValue) {

	var typeEnum = ['friends'];
	
	this.DOMID = DOMID;
	this.type = Global.isIn(typeEnum, type) ? type : "friends";
	this.value = value == null ? null : value;
	this.dataValue = dataValue == null ? null : dataValue;
	
}


AutoCompleteInput.prototype = {
	
	autoCompleteClass: "autoComplete",
	initialGrayClass: "autoCompleteGray",
	defaultValue: "type name and select",

	generate: function() {
		var ins = this.defaultValue, insTwo = this.initialGrayClass;
		if (this.value != null)
			ins = this.value, insTwo = '';
		return '<input class="' + this.autoCompleteClass + ' ' + insTwo + '" type="text" name="' + this.DOMID + '" id="' + this.DOMID + '" value="' + ins + '">';	
	},
	
	
	bind: function() {
		var that = this;
		$("#" + this.DOMID).unbind();
		var autoCompleteCallback = function (value, inputData) {
			that.value = value; 
			that.dataValue = inputData;
			$(".autocomplete").children().remove();
		}
		$("#" + this.DOMID).autocomplete({serviceUrl:"requestswitch.php?action=getAutoComplete&type="+this.type, minChars:2, onSelect: autoCompleteCallback})
		$("#" + this.DOMID).focus(function() {
			$(this).val("").removeClass(that.initialGrayClass);	
			that.value = null; that.dataValue = null;
		})
		.blur(function() {
			var blurCallback = function() {
				if (that.dataValue == null)
					$(this).val(that.defaultValue).addClass(that.initialGrayClass);					
			}
			$(this).oneTime(100, blurCallback);
		});
	},
	
	
	getData: function() {
		return this.dataValue;
	},
	
	
	clear: function() {
		this.value = null;
		this.dataValue = null;
		$("#" + this.DOMID).addClass(this.initialGrayClass).val(this.defaultValue);
	}
	
};