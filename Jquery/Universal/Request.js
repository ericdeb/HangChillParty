
var Request = (function () {


	function serializeData(obj) {
		var returnStr = "";
		for(var key in obj)
			returnStr += encodeURI(key) + "=" + obj[key] + "&";
		return Global.shortenString(returnStr, 1);		
	}
	

	return function(action, getData, postData, syncBoolean, callBackFunction, errorCallback, dataType) {

		var getData = getData;
		var postData = postData;
		var syncBoolean = syncBoolean;
		var callBackFunction = callBackFunction;
		var errorCallback = errorCallback;
		var dataType = dataType == null ? 'json' : dataType;
		
		getData.action = action;

		
		this.getGetData = function () {
			return getData;
		};	
		this.getPostData = function () {
			return postData;
		};
		this.getSyncBoolean = function () {
			return syncBoolean;
		};
		this.getCallBackFunction = function () {
			return callBackFunction;
		};
		this.getErrorCallback = function () {
			return errorCallback;
		};
		this.getSerializedGetData = function() {
			return serializeData(getData);		
		};
		this.getDataType = function() {
			return dataType;		
		};

	};	
	
})();
	
	
Request.prototype = {


	getResponse: function() {
		var type = this.getPostData().length == 0 ? "GET" : "POST";
		var that = this;
		var requestErrorCallback = function(errors) {
			try {
				for (var i = 0; i < errors.length; i++) 
					throw new Error(errors[i].ms);							
			}
			catch (error) {
				ExceptionsManager.getInstance().addException(error);
			}
			finally {
				if (that.getErrorCallback() != null) {
					that.getErrorCallback()(errors);
				}
			}			
		}

		$.ajax({
			url: "requestswitch.php?" + this.getSerializedGetData(),
			cache: false,
			type: type,
			async: this.getSyncBoolean(),
			data: this.getPostData(),
			dataType: this.getDataType(),
			error: function (obj, textStatus) {
				requestErrorCallback([{ms: textStatus, co: 0}]);
			},
			success: function (data) {
				if (data.Errors == null) {
					var callBackFunction = that.getCallBackFunction();
					if (callBackFunction != null) 
						callBackFunction(data);	
				}
				else 
					requestErrorCallback(data.Errors);
			} 
		});
	}
	

};
		

