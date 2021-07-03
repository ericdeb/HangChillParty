var BirthdayInput = function(DOMID, birthday) {

	if (birthday != "") {
		var year = birthday.substr(0,4);
		var monthNum = birthday.charAt(5) == '0' ? birthday.substr(6,1) : birthday.substr(5,2);
		var monthShort = TimeManager.getInstance().getShortMonthFromNum(monthNum)
		var day = birthday.charAt(8) == '0' ? birthday.substr(9,1) : birthday.substr(8,2);
	}
	else
		var year = 1988, monthShort = null, day = null, monthShort = null;
		
	var monthsShortAR = TimeManager.getInstance().getMonthsShort();
	var yearsAR = TimeManager.getInstance().getYearsAR(1950, 2000);
	
	this.DOMID = DOMID;
	this.birthdayMonthDropDown = new DropDownBox("birthdayMonthsDropDown", monthsShortAR, monthsShortAR, monthShort);
	this.birthdayDayInput = new TextInput("birthdayDayInput", day);
	this.birthdayYearDropDown = new DropDownBox("birthdayDayYearDropDown", yearsAR, yearsAR, year);
	
};


BirthdayInput.prototype = {
	
	birthdayInputClass: "birthdayInput",


	generate: function() {
		return '<div id="' + this.DOMID + '" class="' + this.birthdayInputClass + '">' + this.birthdayMonthDropDown.generate() + this.birthdayDayInput.generate() + this.birthdayYearDropDown.generate() + '</div>';	
	},
	
	
	bind: function() {
		this.birthdayMonthDropDown.bind(); this.birthdayDayInput.bind(); this.birthdayYearDropDown.bind();
	},
	
	
	getValue: function() {
		if (this.birthdayDayInput.getValue() == null)
			return null;
		var shortMonth = this.birthdayMonthDropDown.getValue(), birthdayDay =  this.birthdayDayInput.getValue();
		var birthdayYear = this.birthdayYearDropDown.getValue(), birthdayMonthNumber = TimeManager.getInstance().getMonthNumberFromShort(shortMonth);
		birthdayDay.replace(/\s/g, "");
		birthdayDay = birthdayDay < 10 ?  0 + birthdayDay.toString() : birthdayDay;
		birthdayMonthNumber = birthdayMonthNumber < 10 ?  0 + birthdayMonthNumber.toString() : birthdayMonthNumber;
		return birthdayYear + '-' + birthdayMonthNumber + '-' + birthdayDay;
	}
	
	
};

		