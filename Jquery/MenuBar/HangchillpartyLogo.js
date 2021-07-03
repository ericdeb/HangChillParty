var HangchillpartyLogo = function(DOMID) {

	var width = width;

	
	this.generate = function () {
		return '<div id = "' + DOMID + '"></div>';
	};
	
	
	this.bind = function () {		
		$("#" + DOMID).click(function() {
				MainMenuBar.getInstance().getHangchillpartyLink().selectLink();				
		});
	};
		
};
		