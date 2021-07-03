var FacebookManager = (function() {


	var instance = false;


	function constructor(serverFBID) {

		var permissionToPublish = false;
		var serverFBID = serverFBID;
		/*
		var greenImageLink = "http://www.hangchillparty.com/Images/facebookGreenLight.png";
	    var yellowImageLink = "http://www.hangchillparty.com/Images/facebookYellowLight.png";
		var redImageLink = "http://www.hangchillparty.com/Images/facebookRedLight.png";
		*/
		var picSource = "http://www.hangchillparty.com/Images/fake.png";
		var loggedOut = false;

		//HCP 133981963305612
		FB.init({
		  appId   : '135461943153729',
		  status  : true,
		  cookie  : true,
		  xfbml   : true
		});	
	
		FB.Event.subscribe('auth.login', function() {
			 loggedOut = false;
			 if (window.location.toString().search(/index.php/) > 0) {
				  FriendsSearchSideBar.getInstance().getFacebookYourFriendsLink().setPageRefreshTrue();	
				  SocialNetworkSettings.getInstance().getFacebookSettingsButton().regenerate();
				  if (serverFBID == null || FB.getSession().uid != serverFBID) {
					  var synchronizeCallback = function () {
						  serverFBID = FB.getSession().uid;	
					  }
					  var synchronizeRequest = new Request("synchronizeWithFacebook", {}, {}, false, synchronizeCallback, null);
					  synchronizeRequest.getResponse();
				  }
			  }
        });
		
		FB.Event.subscribe('auth.logout', function() {
			 loggedOut = true;
        });
		
		FB.getLoginStatus(callback);
		
		function callback(response) {
			if (!response.session)
			  return;	
			setPublishPermission();
		}
		
		function setPublishPermission() {
			var permissionsQuery = FB.Data.query('SELECT status_update FROM permissions WHERE uid = ' + FB.getSession().uid);
			FB.Data.waitOn([permissionsQuery], function() {
		    	FB.Array.forEach(permissionsQuery.value, function(row) {
			    	permissionToPublish = row.status_update == 1 ? true : false;
			 	});
			});
		}


        return {
			
			
			isLoggedIn: function() {
				if (loggedOut == true)
					return false;
				if (FB.getSession() != null)
					return true;
				else
					return false;
			},
			
			
			tryLogin: function(callback, finallyCallback) {
				//callback is run when a user is successfully deemed to be logged in.
				//finallyCallback is run regardless.
				var loginCallback = function(response) {
					if (response.session) {
						if (callback != null)
							callback();
					}
					if (finallyCallback != null)
						finallyCallback();
				}
				var statusCallback = function(response) {
					if (!response.session)
			 			FB.login(loginCallback);
					else {
						if (callback != null)
							callback();
						if (finallyCallback != null)
							finallyCallback();
					}
				}
				FB.getLoginStatus(statusCallback);
			},
			
			
			havePublishPermission: function() {
				return permissionToPublish;
			},
			
			
			getPublishPermission: function(callback) {
				if (permissionToPublish == false) {
					var permissionCallback = function(response) {
						if (response.session) {
							var regExp = /publish_stream/;
							permissionToPublish = regExp.test(response.perms);
						}
						callback(permissionToPublish);
						return permissionToPublish;
					}
					FB.login(permissionCallback, {perms:'publish_stream'});
				}		
			},
			
			
			getFriendsOnHangchillparty: function(callback) {
				//callback must take an Array of UIDs
				var retAR = [];
				var query = FB.Data.query('SELECT uid FROM user WHERE uid in (SELECT uid2 FROM friend WHERE uid1=' + FB.getSession().uid + ') AND is_app_user = 1');
				FB.Data.waitOn([query], function() {
			 		FB.Array.forEach(query.value, function(row) {
			 			retAR.push(row.uid);
			 		});
					callback(retAR);
				});
			},
			
			
			disconnectFromFacebook: function(callback) {
				var disconnectCallback = function() {
					var removeFacebookDataRequest = new Request("disconnectFromFacebook", {}, {}, false, callback, null);
					removeFacebookDataRequest.getResponse();
				}
				FB.api({ method: 'Auth.revokeAuthorization' }, disconnectCallback);
			},
			
			
			getInitialPermissions: function(callback) {
				if (window.location.toString().search(/login.php/) > 0) {
					var permissionCallback = function(response) {
						if (response.session && response.perms.length > 5) {
							FB.api('/me', function(response) {
								var birthday = response.birthday != null ? response.birthday : null;
								var about = response.about != null ? response.about : null;
								RegisterManager.getInstance().setFacebookData(birthday);
								RegisterStepOne.getInstance().setFacebookValues(response.first_name, response.last_name, response.email);
								RegisterStepTwo.getInstance().setFacebookValues(response.gender);
								RegisterStepThree.getInstance().setFacebookValues(about);
							});
						}
					}
					FB.login(permissionCallback, {perms:'email,user_about_me,user_birthday,user_education_history'});
				}		
			},
			
			
			publishToFacebook: function(activity, place, light, friendsAR, callback) {
				if (light == 1)
					var defaultActivity = "I'm free right now.  Let me know if you want to hang out.", regActivity = "I'm free to hang out";
				else if (light == 2)
					var defaultActivity = "I'm probably down to chill.  Call or text me.", regActivity = "call or text me if you want to chill";
				else if (light == 3)
					var defaultActivity = "I'm busy right now.  Let me know if you want to hang out later.", regActivity = "I'm busy right now";
				message = friendsAR.length > 0 ? " is with " : null;
				for (var i = 0; (i < friendsAR.length && i < 2); i++) {
					var ins = (i == 0 && friendsAR.length == 2) ? ' and ' : ', ';
					message += friendsAR[i].firstName + " " + friendsAR[i].lastName + ins;
				}
				if (friendsAR.length > 0)
					message = message.substr(0, message.length-2);
				if (friendsAR.length-2 > 0) {
					var ins = friendsAR.length-2 == 1 ? '' : 's';
					var num = friendsAR.length-2;
					message += " and " + num.toString() + " other friend" + ins + "\n";	
				}
				var secondLine = " ";
				if (activity == null && place != null)
					secondLine = place;
				else if (activity != null && place == null)
					secondLine = regActivity;
				else if (activity != null && place != null)
					secondLine = place + ", " + regActivity + ".";
				if (activity == null)
					activity = defaultActivity;
				var insObj = {
					message: message,
					name: activity,
					picture: picSource,
					link: "http://www.hangchillparty.com/index.php?fbpost=true",
					caption: secondLine,
					description: " "					
				}
				FB.api('/me/feed', 'post', insObj, callback);		
			}
			
		}
	
	}
	
	
	return {
	
		getInstance: function() {
			if(!instance) { // Instantiate only if the instance doesn't exist.
				instance = constructor();
			}
			return instance;
		},
		
		
		constructor: function(serverFBID) {
			
			if (!instance) 
				return instance = constructor(serverFBID);
			
		}
		
	}		
	
})();