var AwardsLightBox = function(DOMID) {

	this.DOMID = DOMID;
	this.imageDOMID = DOMID + "Image";
	this.lightboxOpen = false;
	
}


AwardsLightBox.prototype = {
	
	awardsLightBoxClass: "awardsLightBox",
	newAwardImageSource: 'requestswitch.php?action=getNewAwardImage',
	profileSocialMeterAwardBase: 'requestswitch.php?action=getSocialMeterAwardImage&userID=', 
	
	generate: function() {
		var retStr = '<div id="' + this.DOMID + '" class="' + this.awardsLightBoxClass + '"><img id="' + this.imageDOMID + '" /></div>';
		return retStr;
	},
	
	displayNewAward: function() {
		var that = this;
		if (this.lightboxOpen == false) {
			this.lightboxOpen = true;
			var imageLoadCallback = function() {
				var onCloseFunction = function() {
					that.lightboxOpen = false;
					$("#" + that.imageDOMID).attr('src', '');
				}
				var insObj = {
					onClose: onCloseFunction,
					modalCSS: {top: '110px'}
				}
				$('#' + that.DOMID).lightbox_me(insObj);
			}
			var uid = new Date().getTime();
			var ins = this.newAwardImageSource + "&uid=" + uid;
			$("#" + this.imageDOMID).unbind().attr('src', ins).load(imageLoadCallback);
		}
		else {
			$("#" + this.DOMID).oneTime(5000, function() {
				that.displayNewAward();
			});
		}
	},
	
	displaySocialMeterAward: function(userID) {
		var that = this;
		if (this.lightboxOpen == false) {
			this.lightboxOpen = true;
			var imageLoadCallback = function() {
				var onCloseFunction = function() {
					that.lightboxOpen = false;
				}
				var insObj = {
					onClose: onCloseFunction,
					modalCSS: {top: '136px'}
				}
				$('#' + this.DOMID).lightbox_me(insObj);
			}
			$("#" + this.imageDOMID).attr('src', this.profileSocialMeterAwardBase + userID).load(imageLoadCallback);
		}
	}
	
};
