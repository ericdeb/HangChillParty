var Global = (function() {

	var userID, firstName, lastName, gender;
	
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
		
		getGender: function() {
			return gender;
		},
	
		setUserID: function(inUserID) {
			userID = inUserID;
		},
	
		setFirstName: function(inFirstName) {
			firstName = inFirstName;
		},
	
		setLastName: function(inLastName) {
			lastName = inLastName;
		},
		
		setGender: function(inGender) {
			gender = inGender;
		},
		
		extend: function (subClass, superClass) {
			var F = function() {};
			F.prototype = superClass.prototype;
			subClass.prototype = new F();
			subClass.prototype.constructor = subClass;
			subClass.superClass = superClass.prototype;
			if(superClass.prototype.constructor == Object.prototype.constructor)
				superClass.prototype.constructor = superClass;
		},
		
		printObject: function(obj) {
			retstr = typeof(obj) + " ";
			for (var key in obj)
				retstr += key + " " + obj[key] + ", ";
			alert(retstr);
		},
		
		isIn: function isIn(insAR, value) {
			for (var i = 0; i < insAR.length; i++) {
				if (insAR[i] == value)
					return true;
			}
			return false;
		},
		
		arrayToString: function(insAR) {
			var retStr = "";
			for (var i = 0; i < insAR.length; i++)
				retStr += insAR[i] + ",";
			return this.shortenString(retStr,1);
		},
		
		arrayMatch: function(insAR, key) {
			for (var i = 0; i < insAR.length; i++) {
				if (insAR[i] == key)
					return i;
			}
			return false;
		},
		
		createNameLinkAndImage: function(id, fn, ln, addDOMID, imageWidth, imageHeight) {
			  basicUserOne = new BasicUser(fn, ln, id);
			  var nameLinkOne = new NameLink(id + addDOMID + "NameLink", basicUserOne);
			  var userImageOne = new UserImage(id + addDOMID + "UserImage", id, imageWidth, imageHeight);
			  return {nameLink: nameLinkOne, userImage: userImageOne};
		},
		
		createPhoneNumberSpaces: function(ph) {
			return '(' + ph.substr(0,3) + ") " + ph.substr(3,3) + "-" + ph.substr(6,4);
		}

	}		

})();