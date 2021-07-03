var AlertsLink = function() {

	var DOMID = "alertsLink";
	var numberDOMID = "alertsLinkNumber";
	var tabNumber = 2;
	var imageSource = "Images/alertsWhite.png";
	var imageSourceHover = "Images/alertsGreen.png";
	var currentImageSource = "Images/alertsWhite.png";
	var currentAlertCount = 0;
	
	
	function selectTab() {
		AlertsLink.superClass.selectTab(DOMID, tabNumber, false);
	}
	
	
	this.generate = function() {
		return '<img id="' + DOMID + '" src="' + imageSource + '" /><span id="' + numberDOMID + '"></span>';
	};	
	
	
	this.bind = function() {
		$("#" + DOMID).click(function() {
			currentImageSource = imageSourceHover;
			selectTab();
			$(this).attr('src', imageSourceHover);
			$("#" + numberDOMID).html('');
			if (currentAlertCount != 0) {
				var alertsRequest = new Request("updateAlertCountTime", {}, {}, false, null, null);
				alertsRequest.getResponse();
			}
			currentAlertCount = 0;
		})
		.mouseenter(function() {
			currentImageSource = $(this).attr('src');
			$(this).attr('src', imageSourceHover);				
		})
		.mouseleave(function() {
			$(this).attr('src', currentImageSource);				 
		})
	};


	this.getTabNumber = function() {
		return tabNumber;
	};
	
	
	this.updateNewAlertCount = function(num) {
		if (num > 0) {
			currentAlertCount = currentAlertCount + parseInt(num);
			$("#" + numberDOMID).html(currentAlertCount);			
		}
	}
	
	this.setWhite = function() {
		$("#" + DOMID).attr('src', imageSource);
	}
	
		
};

Global.extend(AlertsLink, TopLink);