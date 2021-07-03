var ListRow = function(listCellsAR) {

	this.listCellsAR = listCellsAR;
	
}


ListRow.prototype = {
	
	
	generate: function() {
		var retStr = '<tr>';
		for (var i = 0; i < this.listCellsAR.length; i++)
			retStr += '<td>' + this.listCellsAR[i].generate() + '</td>';
		retStr += '</tr>';	
		return retStr;
	},
	
	
	bind: function() {
		for (var i = 0; i < this.listCellsAR.length; i++)
			this.listCellsAR[i].bind();
	},
	
	
	getValue: function(index) {
		return this.listCellsAR[index].getValue();
	},
	
	
	clearValue: function(index) {
		this.listCellsAR[index].clearValue();
	},
	
	
	getContents: function(index) {
		return this.listCellsAR[index];
	}
	
	
	
};
