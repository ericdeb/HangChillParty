var AlertDay = function(DOMID, JSDate) {

	this.DOMID = DOMID;
	this.messagesAR = [];
	this.newMessagesAR = [];
	this.newMessagesTimesAR = [];
	this.JSDate = JSDate;
	
}


AlertDay.prototype = {
	
	dateClass: "alertDayDate",
	alertDayClass: "alertDay",
	alertDayInnerClass: "alertDayInner",
	
	generate: function() {
		var retStr = '<div id="' + this.DOMID + '" class="' + this.alertDayClass + '">';
		retStr += '<span class="' + this.dateClass + '">' + TimeManager.getInstance().getShortMonth(this.JSDate) + " " + this.JSDate.getUTCDate() + '</span>';
		retStr += '<div class="' + this.alertDayInnerClass + '">';
		for (var i = 0; i < this.messagesAR.length; i++)
			retStr += this.messagesAR[i].generate();
		retStr += '</div></div>';
		return retStr;
	},
	
	
	bind: function() {
		for (var i = 0; i < this.messagesAR.length; i++)
			this.messagesAR[i].bind();	
	},
	
	
	addNewMessage: function(message, JSUpdateTime) {
		//Global.printObject(message);
		var length = this.newMessagesTimesAR.length;
		var that = this, index = 0;
		if (length == 0) {
			this.newMessagesAR.push(message);
			this.newMessagesTimesAR.push(JSUpdateTime);
		}
		else {
			var skip = false;
			for (var i = 0; i < length; i++) {
				if (this.newMessagesTimesAR[i].getTime() <= JSUpdateTime.getTime()) {
					this.newMessagesTimesAR.splice(i, 0, JSUpdateTime);
					this.newMessagesAR.splice(i, 0, message);
					index = i;
					skip = true;
					break;
				}
			}
			if (skip == false) {
				this.newMessagesAR.push(message);
				this.newMessagesTimesAR.push(JSUpdateTime);
				index = length;
			}
		}
		if (message.isNewRequest() == true) {
			var callback = function(DOMID) {
				that.removeMessage(DOMID);
			}
			this.newMessagesAR[index].setRemoveCallback(callback);
		}
	},
	
	
	generateNewMessages: function() {
		var retStr = "";
		for (var i = 0; i < this.newMessagesAR.length; i++)
			retStr += this.newMessagesAR[i].generate();
		$("#" + this.DOMID + " ." + this.alertDayInnerClass).prepend(retStr);
		return this;
	},
	
	
	bindNewMessages: function() {
		for (var i = 0; i < this.newMessagesAR.length; i++) {
			if (this.newMessagesAR[i].bind != null)
				this.newMessagesAR[i].bind();
		}
		this.messagesAR = this.messagesAR.concat(this.newMessagesAR);
		this.newMessagesAR = []; this.newMessagesTimesAR = [];
	},
	
	
	getJSDate: function() {
		return this.JSDate;
	},
	
	
	removeMessage: function(DOMID) {
		for (var i = 0; i < this.messagesAR.length; i++) {
			if (this.messagesAR[i].getDOMID() == DOMID) {
				this.messagesAR.splice(i, 1);
				if (this.messagesAR.length == 0) {
					Alerts.getInstance().removeAlertDay(this.DOMID);
					$("#" + this.DOMID).remove();	
				}
			}
		}		
		
	},
	
	
	getDOMID: function() {
		return this.DOMID;	
	}
	
	/*,
	
	
	printNewMessagesUpdateTimes: function() {
		var str = "";
		for (var i = 0; i < this.newMessagesAR.length; i++) {
			str += this.newMessagesTimesAR[i] + " ";
		}
		console.log(str);
	}*/
	
};
