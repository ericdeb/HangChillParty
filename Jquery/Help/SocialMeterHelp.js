var SocialMeterHelp = function(DOMID) {

	this.DOMID = DOMID;
	this.SocialMeterClass = "socialMeterHelp";
	this.titleClass = "socialMeterTitle";


	this.generate = function() {
		var retStr = '<div id="' + this.DOMID + '" class="' + this.SocialMeterClass + '">';
		retStr += '<span><span class="' + this.titleClass + '">The social meter represents how social people are.</span><br />The more a user signals, joins friends, and hangs out, the higher their social rating will be.<br /><br /><br />';
		retStr += '<span class="' + this.titleClass + '">How is the social meter calculated?</span><br />We can\'t let you know exactly how it works, but as long as you\'re being a social person your meter should be good.<br /><br /><br />';
		retStr += '<span class="' + this.titleClass + '">Can I disable the social meter?</span><br />It can\'t be disabled, but don\'t worry.  It\'s just some random calculations, so don\'t take it too seriously.</span></div>';
		return retStr;
	};
	
};