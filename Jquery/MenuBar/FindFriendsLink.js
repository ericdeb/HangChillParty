var FindFriendsLink = function() {

	var DOMID = "findFriendsLink";
	var tabNumber = 1;
	var imageSource = "Images/findFriendsWhite.png";
	var imageSourceHover = "Images/findFriendsGreen.png";
	var currentImageSource = "Images/findFriendsWhite.png";
	var firstTime = true;
	
	
	function selectTab() {
		$("#" + DOMID).attr('src', imageSourceHover);
		currentImageSource = imageSourceHover;
		HangchillpartyLink.superClass.selectTab(DOMID, tabNumber, false);
	}
	
	
	this.generate = function () {
		return '<img id="' + DOMID + '" src="' + imageSource + '" />';
	};	
	
	
	this.bind = function () {		
		$("#" + DOMID).click(function() {
			if (firstTime == true) {
				firstTime = false;
				var fl = FriendsSearchSideBar.getInstance().getFacebookYourFriendsLink();
				var login = FacebookManager.getInstance().isLoggedIn();
				if (fl.getRefreshPage() == true || login == true) {
					fl.selectLink();
					if (fl.getRefreshPage() == true)
						return false;	
				}
			}		
			selectTab();
			FriendsSearchOptionsBox.getInstance().rebindAutoCompletes();
		})
		.mouseenter(function() {
			currentImageSource = $(this).attr('src');
			$(this).attr('src', imageSourceHover);				
		})
		.mouseleave(function() {
			$(this).attr('src', currentImageSource);			 
		})
	};
	
	this.selectLink = function() {
		selectTab();	
	}
	
	this.setWhite = function() {
		$("#" + DOMID).attr('src', imageSource);
	}
		
};

Global.extend(FindFriendsLink, TopLink);