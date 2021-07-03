var LogoutLink = function(DOMID) {

	var DOMID = DOMID;
	
	
	function logoutCallback() {
		window.location = "index.php";		
	};
	
	
	this.generate = function () {
		return '<a id="' + DOMID + '" href="#" >Logout</a>';
	};	
	
	
	this.bind = function () {
		$("#" + DOMID).click(function() {
			var logoutRequest = new Request("logoutUser", {}, {}, false, logoutCallback, null);
			logoutRequest.getResponse();
		});
	};
		
};
