var HangchillpartyLink = function() {

	var DOMID = "hangchillpartyLink";
	var tabNumber = 0;
	var pageRefresh = false;
	var imageSource = "Images/signalsWhite.png";
	var imageSourceHover = "Images/signalsGreen.png";
	var currentImageSource = "Images/signalsGreen.png";
	
	
	function selectTab() {
		HangchillpartyLink.superClass.selectTab(DOMID, tabNumber, false);
	}

	this.generate = function () {
		return '<img id="' + DOMID + '" src="' + imageSourceHover + '" />';
	};	
	
	
	this.bind = function () {		
		$("#" + this.getDOMID()).click(function() {
			if (pageRefresh == true)
				window.location.reload();
			else {
				selectTab();	
				$(this).attr('src', imageSourceHover);
				currentImageSource = imageSourceHover;
			}
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
	
	this.getDOMID = function() {
		return DOMID;
	}
	
	this.setPageRefresh = function() {
		pageRefresh = true;	
	}
	
	this.setWhite = function() {
		$("#" + DOMID).attr('src', imageSource);
	};
	
	this.selectLink = function() {
		selectTab();
		$("#" + DOMID).attr('src', imageSourceHover);
		currentImageSource = imageSourceHover;
	}
		
};

Global.extend(HangchillpartyLink, TopLink);