var TermsLink = function(DOMID, message) {

	this.DOMID = DOMID;
	this.message = message;
	this.hiddenDOMID = DOMID + "Hidden";
	this.hiddenInnerDOMID = DOMID + "HiddenInner";
	this.termsAjaxed = false;
	
};

TermsLink.prototype = {
	
	termsLinkClass:  "termsLink",
	hiddenClass: "termsHidden",
	hiddenInnerClass: "termsHiddenInner",
	
	generate: function() {
		return '<div id="' + this.hiddenDOMID + '" class="' + this.hiddenClass + '"><div id="' + this.hiddenInnerDOMID + '" class="' + this.hiddenInnerClass + '"></div></div><a id="' + this.DOMID + '" href="#" class="' + this.termsLinkClass + '">' + this.message + '</a>';	
	},
	
	
	bind: function() {
		var that = this;
		$("#" + this.DOMID).click(function() {
			var onloadFunction =  function() { 
				if (that.termsAjaxed == false) {
					var loadingImage = new LoadingImage("termsLoading", 50, 50);
					var termsCallback = function(data) {
						$("#" + that.hiddenInnerDOMID).html(data);
					}
					var termsRequest = new Request("getTermsOfService", {}, {}, false, termsCallback, null, 'html');
					termsRequest.getResponse();	
					that.termsAjaxed = true;
				}
			}
			var insObj = {
				centered: true, 
				onLoad: onloadFunction
			}
			var onCloseFunction = function() {
				$("#" + that.hiddenInnerDOMID).css('display', 'none');	
			}
			$('#' + that.hiddenDOMID).lightbox_me(insObj);
			return false;
		});
	}	
	
};
