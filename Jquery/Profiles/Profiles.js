var Profiles = (function() {


	var instance = false;
	

	function constructor() {

		var DOMID = "profiles";
		var currentUserProfile = null;
		
		function getUserProfile(userID) {
			var callback = function(data) {
				createUserProfile(data);
				$("#" + DOMID).height('auto');
				$("#" + DOMID).html(currentUserProfile.generate());
				currentUserProfile.bind();				
			}
			$("#" + DOMID).height('500px');
			var loadingImage = new LoadingImage("friendProfile", 100, 100);
			$("#" + DOMID).html(loadingImage.generate());
			var profileRequest = new Request("getUserProfile", {id: userID}, {}, true, callback, null);
			profileRequest.getResponse();
		}
		
		function createUserProfile(data) {
			var user = data.Friend[0], joined = data.JoinedUsers != null ? data.JoinedUsers : [], friendRequestLink = null;
			var userImage = new UserImage(user.id + "profileImage", user.id, 50, 50);
			var userImageTwo = new UserImage(user.id + "profileUpdateImage", user.id, 50, 50);
			var basicUser = new BasicUser(user.fn, user.ln, user.id), insFC = user.fc == "" ? 0 : user.fc, insMU = user.mu == "" ? 0 : user.mu;
			var nameLink = new NameLink(user.id + "profileUpdateNameLink", basicUser);
			var facebookLink = user.fb != "" ? new FacebookLink(user.id + "profileFacebookLink", user.fb) : null;
			var twitterLink = user.tn != "" ? new TwitterLink(user.id + "profileTwitterLink", user.tn) : null;
			var friendsOfLink = new FriendsOfLink(user.id + "profileFriendsOfLink", insFC, insMU, user.id);
			var phoneIns = user.ph != "" ? Global.createPhoneNumberSpaces(user.ph) : "", friendsBool = user.fr == 1 ? true : false;
			var socialMeter = new SocialMeter(user.id + "ProfileSocialMeter", user.sr);
			if (friendsBool == false && user.re == "0")
				friendRequestLink = new FriendRequestLink(user.id + "profileRequestLink", user.id, true);
			if (data.Update != null) {
				var u = data.Update[0], insState = '', activity = '', userAR = [], t = TimeManager.getInstance();
				var userImagesAR = [], userNameLinksAR = [], timeStart = t.genJSDate(u.ts), timeEnd = u.te != "" ? t.genJSDate(u.te) : null;
				var updateTime = t.genJSDate(u.ut), yourUpdate = u.yu == 1 ? true : false, leaderNameLink = null, leaderUserImage = null;	
				var leaderNameLinkTwo = null, leaderUserImageTwo = null;
				if (u.li == 1)
					insState = 'green';
				else if (u.li == 2) 
					insState = 'yellow';
				else
					insState = 'red';
				for (var i = 0; i < joined.length; i++) {
					if (joined[i].id != user.id)
						userAR.push(Global.createNameLinkAndImage(joined[i].id, joined[i].fn, joined[i].ln, "profileUpdateList", 26, 26));
				}
				if (u.lid != user.id) {
					var obj = Global.createNameLinkAndImage(u.lid, u.lfn, u.lln, "profileUpdate", 26, 26);
					leaderNameLink = obj.nameLink;
					var obj2 = Global.createNameLinkAndImage(u.lid, u.lfn, u.lln, "profileUpdateList", 26, 26);
					leaderNameLinkTwo = obj2.nameLink;
					leaderUserImageTwo = obj2.userImage;
				}
				var insFriendCount = (u.lid != "" && u.lid != user.id) ? u.fc - 1 : u.fc;
				var updateFriendLink = new UpdateFriendLink(user.id + "friendLink", nameLink, leaderNameLink, insFriendCount);
				for (var k = userAR.length-1; k >= 0; k--) {
					userImagesAR.push(userAR[k].userImage);
					userNameLinksAR.push(userAR[k].nameLink);
				}
				var joinLight = new JoinLight(u.id + "profileJoinLightDiv", insState, u.id, yourUpdate, true);
				var update = new Update(u.id, u.id + "profileUpdate", joinLight, timeStart, timeEnd, userImageTwo, updateFriendLink, u.ac, u.pl, updateTime, u.sr, u.yu, true);
				var profileUpdate = new ProfileUpdate(u.id + "profileUpdateShell", friendsBool, basicUser, leaderNameLinkTwo, leaderUserImageTwo, update, userImagesAR, userNameLinksAR);
			}
			else 
				var profileUpdate = new ProfileUpdate(user.id + "ProfileNoneUpdate", friendsBool, basicUser);
			currentUserProfile = new UserProfile(user.id + "UserProfile", userImage, nameLink, user.csn, user.csc, friendRequestLink, phoneIns, facebookLink, twitterLink, friendsOfLink, socialMeter, user.sr, user.nu, profileUpdate, user.bl, friendsBool);
		}
		
			
		return {
				
            generate: function() {
				return '<div id="' + DOMID + '"></div>';
			},
			
			setUserProfile: function(userID) {
				getUserProfile(userID);
			}
			
			
		}
		
	}
	
	
	return {
	
		getInstance: function() {
			if(!instance) {
				instance = constructor();
			}
			return instance;
		}
		
	}
	
})();