
var Request = (function () {


	function serializeData(obj) {
		var returnStr = "";
		for(var key in obj)
			returnStr += encodeURI(key) + "=" + obj[key] + "&";
		return Global.shortenString(returnStr, 1);		
	}
	

	return function(action, getData, postData, callBackFunction, errorDOM) {

		var getData = getData;
		var postData = postData;
		var callBackFunction = callBackFunction;
		var errorDOM = errorDOM;
		
		getData.action = action;

		
		this.getGetData = function () {
			return getData;
		};	
		this.getPostData = function () {
			return postData;
		};
		this.getCallBackFunction = function () {
			return callBackFunction;
		};
		this.getErrorDOM = function () {
			return errorDOM;
		};
		this.getSerializedGetData = function() {
			return serializeData(getData);		
		};

	};	
	
})();
	
	
Request.prototype = {


	getResponse: function() {
		var type = !this.getPostData().length ? "GET" : "POST";
		var that = this;
		$.ajax({
			url: "requestswitch.php?" + this.getSerializedGetData(),
			cache: false,
			type: type,
			data: this.getPostData(),
			dataType: "json",
			error: function (obj, textStatus) {
				if (that.getErrorDOM())
					$(that.getErrorDOM()).append(textStatus);
			},
			success: function (data) {
				var callBackFunction = that.getCallBackFunction();
				callBackFunction(data);			
			} 
		});
	}
	

};
		

