var FriendsList = function(DOMID, listRowAR, type, userIDCell, valueCell, valueTwoCell, clearCallBack) {

	this.DOMID = DOMID;
	this.listRowAR = listRowAR;
	this.type = type;
	this.userIDCell = userIDCell;
	this.valueCell = valueCell;
	this.valueTwoCell = valueTwoCell;
	this.clearCallBack = clearCallBack;
	
}


FriendsList.prototype = {
	
	
	generate: function() {
		var retStr = '<div id="' + this.DOMID + 'Border"><div id="' + this.DOMID + '">';
		retStr += '<table>';
		for (var i = 0; i < this.listRowAR.length; i++)
			retStr += '<tr>' + this.listRowAR[i].generate() + '</tr>';
		retStr += '</table></div></div>';
		return retStr;		
	},			
	
	
	bind: function() {
		var that = this;
		for (var i = 0; i < this.listRowAR.length; i++)
			this.listRowAR[i].bind();
	},
	
	
	clear: function() {
		this.clearCallBack();
		for (var i = 0; i < this.listRowAR.length; i++)
			this.listRowAR[i].clearValue(this.valueCell);
	},
	
	
	getStatusListValues: function() {
		if (this.type != "status")
			return '';
		var retStr = '';
		for (var i = 0; i < this.listRowAR.length; i++) {
			if (this.listRowAR[i].getValue(this.valueCell) == 1)
				retStr += this.listRowAR[i].getValue(this.userIDCell) + ",";
		}
		return Global.shortenString(retStr, 1);
	},
	
	
	getSocialNetworkAR: function() {
		if (this.type != "status")
			return null;
		var retAR = [];
		for (var i = 0; i < this.listRowAR.length; i++) {
			if (this.listRowAR[i].getValue(this.valueCell) == 1) {
				var basicUser = this.listRowAR[i].getContents(this.userIDCell).getBasicUser();
				var insObj = {
					firstName: basicUser.getFirstName(),
					lastName: basicUser.getLastName()
				}
				retAR.push(insObj);
			}
		}	
		return retAR;
	}
	
	
	
};