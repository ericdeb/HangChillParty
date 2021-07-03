var MoreFeaturesButton = function() {

	var DOMID = "moreFeaturesButton";
	var rightArrowSrc = "Images/moreFeaturesArrowRight.png";
	var downArrowSrc = "Images/moreFeaturesArrowDown.png";
	var orientedRight = true;

	this.generate = function () {
		return '<div id="' + DOMID + '" class="moreFeaturesBotRound"><img src="' + rightArrowSrc + '" /></div>';
	};	
	
	
	this.bind = function () {	
		$("#" + DOMID).click(function() {
			if (orientedRight == true) {
				insSrc = downArrowSrc;
				//$("html, body").css('height', $("html").height()+700 + "px"); //random bug
			}
			else {
				insSrc = rightArrowSrc;
				//$("html, body").css('height', $("html").height()-500 + "px"); //random bug
			}
			$("#" + DOMID + " img").attr('src', insSrc);
			orientedRight = !orientedRight;
			MoreFeaturesBox.getInstance().toggleDisplay();
		});
	};
	
	this.toggleOrientation = function() {
		$("#" + DOMID).click();	
	}
		
};