var BasicUser = function(firstName, lastName, userID) {

	this.firstName = firstName;
	this.lastName = lastName;
	this.userID = userID;
		
};

BasicUser.prototype = {

	getFirstName: function() {
		return this.firstName;
	},
	
	getLastName: function() {
		return this.lastName;
	},
	
	getUserID: function() {
		return this.userID;
	}

};