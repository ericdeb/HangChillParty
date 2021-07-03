var LoginButton = function(DOMID, callback) {

	var DOMID = DOMID;
	var imageDOMID = DOMID + "Image";
	var loginButtonClass="loginButton";
	var imageClass = "loginButtonImage";
	var imageSource = "Images/loginButton.gif";
	var callback = callback;
	var fadeOutErrorDOMID = DOMID + "fadeOutError";
	var successMessageDOMID = DOMID + "fadeOutSuccess";
	var fadeOutErrorClass = "loginButtonError";
	var fadeOutSuccessClass = "loginButtonSuccess";
	
	this.generate = function () {
		return '<div id="' + DOMID + '" class="' + loginButtonClass + '">' + this.generateImage() + '</div>';
	};	
	
	this.generateImage = function() {
		return '<img id="' + imageDOMID + '" class="' + imageClass + '" src="' + imageSource + '" />';
	};	
	
	this.bind = function () {
		var that = this;
		$("#" + imageDOMID).click(function() {
			callback();
		});
	};
	
	this.ajaxSuspend = function() {
		$("#" + imageDOMID).unbind();
		var loadingImage = new LoadingImage(DOMID + "LoadingImage", 25, 25);
		$("#" + DOMID).html(loadingImage.generate());
	};
	
	this.ajaxUnsuspend = function() {
		$("#" + DOMID).html(this.generateImage());
		this.bind();
	};
	
	this.displayError = function(error) {
		var that = this;
		$("#" + DOMID).html('<span id="' + fadeOutErrorDOMID + '" class="' + fadeOutErrorClass + '">' + error + '</span>');	
		$("#" + fadeOutErrorDOMID).fadeOut(4000, function() {
			$(this).replaceWith(that.generateImage());
			that.bind();
		})
	};
	
	this.displaySuccessMessage = function(message) {
		var that = this;
		$("#" + DOMID).html('<span id="' + successMessageDOMID + '" class="' + fadeOutSuccessClass + '">' + message + '</span>');	
		$("#" + successMessageDOMID).fadeOut(2500, function() {
			$(this).replaceWith(that.generateImage());
			that.bind();
		})
		
	}
		
};

