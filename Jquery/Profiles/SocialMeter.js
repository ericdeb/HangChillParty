var SocialMeter = function(DOMID, socialRating) {

	this.DOMID = DOMID;
	this.percentage = socialRating != "" ? socialRating * 10 : null;
	
};


SocialMeter.prototype = {
	
	socialMeterClass: "socialMeter",
	barClass: "socialMeterBar",
	hiddenBarClass: "socialMeterHiddenBar",
	
	
	generate: function() {
		var insClass = this.percentage == null ? this.hiddenBarClass : this.barClass;
		return '<div id="' + this.DOMID + '" class="' + this.socialMeterClass + '"><div class="' + insClass + '"></div></div>';	
	},
	
	bind: function() {
		if (this.percentage != null) 
			$("." + this.barClass).css('width', this.percentage + '%');
	}
	
};
