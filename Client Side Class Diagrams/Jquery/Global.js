
var Global = (function() {

	var userID, firstName, lastName;
	
	return {
	
		shortenString: function(str, shrt) {
			return str.substr(0, str.length-shrt);	
		},
	
		getUserID: function() {
			return userID;
		},
	
	    getFirstName: function() {
			return firstName;
		},
	
		getLastName: function() {
			return lastName;
		},
	
		setUserID: function(inUserID) {
			userID = inUserID;
		},
	
		setFirstName: function(inFirstName) {
			firstName = inFirstName;
		},
	
		setLastName = function(inLastName) {
			lastName = inLastName;
		}

	}		

})();