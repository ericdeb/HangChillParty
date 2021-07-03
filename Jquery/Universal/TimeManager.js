var TimeManager = (function() {


	var instance = false;


	function constructor(offset) {
	
		var offset = offset;
		var date = new Date();
		var logonTime = date.getTime();
		var shortMonths = ['Jan', 'Feb', 'Mar', 'April', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        return {
		
		
			getUserDate: function() {
				var d = new Date();	
				d.setTime(d.getTime()-logonTime + offset*1000);
				return d;
			},
			
			
			isAM: function() {
				var date = this.getUserDate();
				if (date.getUTCHours() < 12)
					return true;
				else 
					return false;
			},
			
			
			genJSDate: function(sqlDate) {
				var mons = sqlDate.substring(5,6) == '0' ? parseInt(sqlDate.substring(6,7))-1 : parseInt(sqlDate.substring(5,7))-1;
				var days = sqlDate.substring(8,9) == '0' ? parseInt(sqlDate.substring(9,710)) : parseInt(sqlDate.substring(8,10));
				var hours = sqlDate.substring(11,12) == '0' ? parseInt(sqlDate.substring(12,13)) : parseInt(sqlDate.substring(11,13));
				var mins = sqlDate.substring(14,15) == '0' ? parseInt(sqlDate.substring(15,16)) : parseInt(sqlDate.substring(14,16));
				var secs = sqlDate.substring(17,18) == '0' ? parseInt(sqlDate.substring(17,19)) : parseInt(sqlDate.substring(17,19));
				return new Date(Date.UTC(parseInt(sqlDate.substring(0,4)), mons, days, hours, mins, secs));
			},
			
			
			genPHPDate: function(argOne, argTwo) {
				//can take either a JSDate as one argument or timeStr, ampm as two arguments
				if (arguments.length == 2) {
					var hours = argOne.length == 5 ? parseInt(argOne.substring(0,2)) : parseInt(argOne.substring(0,1));
					var mins = argOne.length == 5 ? argOne.substring(3,5) : argOne.substring(2,4);
					if (argTwo == 1 && hours != 12)
						hours += 12;
					else if (argTwo == 0 && hours == 12)
						hours = 0;
					var tempDate = this.getUserDate();
					var addDate = tempDate.getUTCHours() > hours ? true : false;
					tempDate.setUTCHours(hours, mins);
					if (addDate == true)
						tempDate.setTime(tempDate.getTime()+24*60*60*1000);
				}
				else 
					tempDate = argOne, hours = argOne.getUTCHours();
				var month = parseInt(tempDate.getUTCMonth());
				var day = parseInt(tempDate.getUTCDate());
				var mins = parseInt(tempDate.getUTCMinutes());
				var month =  month < 9 ? "0" + (month+1) : month + 1;
				var day = day < 10 ? "0" + day : day;
				var hours = hours < 10 ? "0" + hours : hours;
				var mins = mins < 10 ? "0" + mins : mins;
				return tempDate.getUTCFullYear() + '-' + month + '-' + day + ' ' + hours + ':' + mins + ':00';	
			},
			
			
			genUpdateTime: function(JSDate) {
				var ampm = JSDate.getUTCHours() > 11 ? 'pm' : 'am';
				var hours = JSDate.getUTCHours() > 12 ? JSDate.getUTCHours() - 12 : JSDate.getUTCHours();
				hours = hours == 0 ? 12 : hours;
				var mins = JSDate.getUTCMinutes() < 10 ? '0'+JSDate.getUTCMinutes() : JSDate.getUTCMinutes();
				return hours+':'+mins+ ' ' + ampm;
			},
			
			
			getShortMonth: function(JSDate) {
				return shortMonths[JSDate.getUTCMonth()];				
			},
			
			
			getShortMonthFromNum: function(num) {
				return shortMonths[num-1];				
			},
			
			
			getMonthsShort: function() {
				return shortMonths;
			},
			
			
			getMonthNumberFromShort: function(shortMonth) {
				for(var i = 0; i < shortMonths.length; i++) {
					if (shortMonths[i] == shortMonth)
						return i+1;
				}
				return null;				
			},
			
			
			getYearsAR: function(startingYear, endingYear) {
				var retAR = [];
				for (var i = 0; i < endingYear; i++) {
					retAR.push(i);
				}
				return retAR;
			},
			
			
			getTimeZoneRegions: function() {
				return timeZoneRegions;
			}
			
			
		}
	
	}
	
	
	return {
	
		getInstance: function() {
			if(instance)
				return instance;		
		},
		
		
		constructor: function(offset) {
			
			if (!instance) 
				return instance = constructor(offset);
			
		}
		
	}		
	
})();