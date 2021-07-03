var StatusLight = function(DOMID, initialState) {

	var greenLightImageSrc = "Images/greenLight.gif";
	var yellowLightImageSrc = "Images/yellowLight.gif"; 
	var redLightImageSrc = "Images/redLight.gif";
	
	var greenLightDOMID = "bigLightGreen";
	var yellowLightDOMID = "bigLightYellow";
	var redLightDOMID = "bigLightRed";
	
	var leftArrowDOMID = "leftArrowImg";
	var rightArrowDOMID = "rightArrowImg";
	var leftArrowImageSrc = "Images/leftArrow.gif";
	var rightArrowImageSrc = "Images/rightArrow.gif";
	
	var lightDivDOMID = "bigLightContainer";
	
	var stateEnum = ['green', 'yellow', 'red'];
	
	var labelDivDOMID = "statusLightLabel";
	var msgDivDOMID = "statusLightMsg";
	var redMsg = "I'm busy or unavailable.";
	var yellowMsg = "Probably down to chill.";	
	var greenMsg = "I'm free to hang out.";
	
	this.DOMID = DOMID;
	this.currentState = Global.isIn(stateEnum, initialState) ? initialState : "green";
	
	this.getValue = function() {
		if (this.currentState == 'green')
			return 1;
		else if (this.currentState == 'yellow')
			return 2;
		return 3;
	}
	
	
	this.getMsgDivDOMID = function () {
		return msgDivDOMID;
	}
	
	
	this.getLabelDivDOMID = function () {
		return labelDivDOMID;
	}
	
	
	this.getRedMsg = function () {
		return redMsg;
	}
	
	this.getGreenMsg = function () {
		return greenMsg;
	}
	
	this.getYellowMsg = function () {
		return yellowMsg;
	}
	
	
	this.getLightDivDOMID = function () {
		return lightDivDOMID;
	};
	
	
	this.getRightArrowDOMID = function () {
		return rightArrowDOMID;
	};
	
	
	this.getLeftArrowDOMID = function () {
		return leftArrowDOMID;
	};
	
	
	this.getGreenLightImageSrc = function () {
		return greenLightImageSrc;
	};
	
	
	this.getYellowLightImageSrc = function () {
		return yellowLightImageSrc;
	};
	
	
	this.getRedLightImageSrc = function () {
		return redLightImageSrc;
	};
	
	
	this.getLeftArrowImageSrc = function () {
		return leftArrowImageSrc;
	};
	
	
	this.getRightArrowImageSrc = function () {
		return rightArrowImageSrc;
	};
	
	
	this.getGreenLightDOMID = function() {
		return greenLightDOMID;
	};
	
	
	this.getYellowLightDOMID = function() {
		return yellowLightDOMID;
	};
	
	
	this.getRedLightDOMID = function() {
		return redLightDOMID;
	};


}


StatusLight.prototype = {
	
	
	generate: function() {
		if (this.currentState == 'green')
			var insRed = "left: -120px", insYellow = "left: 120px", insGreen="left: 0px", insMsg = this.getGreenMsg();
		else if (this.currentState == 'yellow')
			var insRed = "left: 120px", insYellow = "left: 0px", insGreen="left: -120px", insMsg = this.getYellowMsg();
		else 
			var insRed = "left: 0px", insYellow = "left: -120px", insGreen="left: 120px", insMsg = this.getRedMsg();
		var retStr = '<div id="' + this.DOMID + '"><div id="' + this.getLabelDivDOMID() + '"><span>Let my friends know</span></div>';
		retStr += '<img id="' + this.getLeftArrowDOMID() + '" src="' + this.getLeftArrowImageSrc() + '" />';
		retStr += '<div id="' + this.getLightDivDOMID() + '">';
		retStr += '<img id="' + this.getGreenLightDOMID() + '" src="' + this.getGreenLightImageSrc() + '" style="' + insGreen + '"/>';
		retStr += '<img id="' + this.getYellowLightDOMID() + '" src="' + this.getYellowLightImageSrc() + '" style="' + insYellow + '"/>';
		retStr += '<img id="' + this.getRedLightDOMID() + '" src="' + this.getRedLightImageSrc() + '" style="' + insRed + '"/></div>';
		retStr += '<img id="' + this.getRightArrowDOMID() + '" src="' + this.getRightArrowImageSrc() + '" />';
		retStr += '<div id="' + this.getMsgDivDOMID() + '"><span>' + insMsg + '</span></div></div>';
		return retStr;		
	},	
	
	
	bind: function() {
		//To switch to click only simply comment out mouseenter and mouseleave events (and change mouse cursor to pointer on arrows).
		var that = this;
		var bindArrow = function(direction) {
			var insDOMID = direction == 'left' ? that.getLeftArrowDOMID() : that.getRightArrowDOMID();
			var clicks = 0, mouseEntered = false, rotating = false;
			var rotationCallback = function() {
				if (clicks > 0) {
					$("#" + insDOMID).stopTime();
					that.rotateLight(direction, rotationCallback);
					rotating = true;
					clicks--;
				}
				else if (mouseEntered == true) {
					that.rotateLight(direction, rotationCallback);	
					rotating = true;
				}
				else
					rotating = false;
			}
			$("#" + insDOMID).click(function() {
				clicks++;
				if (mouseEntered == false && rotating == false)
					rotationCallback();					
			});/*
			.mouseenter(function() {
				mouseEntered = true;
				if (rotating == false) {
					$(this).oneTime(200, function() {
						that.rotateLight(direction, rotationCallback);
						rotating = true;
					});
				}
			})
			.mouseleave(function() {
				$(this).stopTime();
				clicks = 0;
				mouseEntered = false;
			});*/
			
		}
		bindArrow('left');
		bindArrow('right');
	},
	
	
	rotateLight: function(direction, insCallback) {
		var that = this;
		var insNum = direction == 'left' ? '+=120' : '-=120';
		var finalIns = direction == 'left' ? '-120px' : '120px';
		var once = true;
		if (this.currentState == 'green')
			var insMsg = direction == 'left' ? that.getRedMsg() : that.getYellowMsg();
		else if (this.currentState == 'yellow')
			var insMsg = direction == 'left' ? that.getGreenMsg() : that.getRedMsg();
		else
			var insMsg = direction == 'left' ? that.getYellowMsg() : that.getGreenMsg();
		var callback = function() {
			if (once == true) {
				once = false;
				if (that.currentState == 'green') {
					that.currentState = direction == 'left' ? 'red' : 'yellow';
					var insDOM = direction == 'left' ? that.getYellowLightDOMID() : that.getRedLightDOMID();					
				}
				else if (that.currentState == 'yellow') {
					that.currentState = direction == 'left' ? 'green' : 'red';
					var insDOM = direction == 'left' ? that.getRedLightDOMID() : that.getGreenLightDOMID();
				}
				else {
					that.currentState = direction == 'left' ? 'yellow' : 'green';
					var insDOM = direction == 'left' ? that.getGreenLightDOMID() : that.getYellowLightDOMID() ;
				}
				$("#" + that.getMsgDivDOMID()).html('<span>' + insMsg + '</span>');
				$("#" + insDOM).oneTime(100, function() {
					$("#" + insDOM).css('left', finalIns);
					if (insCallback != null)
					insCallback();
				});	
			}
		}
		$("#" + this.getLightDivDOMID() + " img").animate({left: insNum}, {complete: callback, duration: 700});
		$("#" + that.getMsgDivDOMID()).oneTime(500, function() {
			$(this).html('<span>' + insMsg + '</span>');
		});	

	}
	
	
};