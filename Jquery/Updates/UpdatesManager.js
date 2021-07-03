var UpdatesManager = (function() {


	var instance = false;
	

	function constructor() {
		
		var hasCurrentStatus;
		var initialMove = true;
		
		
		function getNewUpdates() {
			var updatesRequest = new Request("getNewUpdates", {}, {}, true, newUpdatesCallback, newUpdatesErrorCallback);
			updatesRequest.getResponse();
		}
			
			
		function newUpdatesCallback(data) {
			var u = Updates.getInstance();
			if (hasCurrentStatus == false || hasCurrentStatus == null) {
				hasCurrentStatus = true;
				var openCallback = function() {
					u.addNewUpdates(processUpdates(data), true)
				}
				u.openUpdates(initialMove, openCallback);
			}
			else
				u.addNewUpdates(processUpdates(data), false)
			$("#" + u.getDOMID()).stopTime().oneTime(15000, getNewUpdates);
			intialMove = false;
		}
		
		
		function newUpdatesErrorCallback(errors) {
			var u = Updates.getInstance();
			if (errors[0].ms == "User does not have current status.") {
				if (hasCurrentStatus == true || hasCurrentStatus == null) {
					hasCurrentStatus = false;
					u.closeUpdates(initialMove);
				}				
				$("#" + u.getDOMID()).stopTime();
			}
			intialMove = false;
		}
		
		
		function processUpdates(data) {
			var retAR = [];
			var length = $.browser.msie ? data.Updates.length-1 : data.Updates.length;
			for (var i = 0; i < length; i++) {
				if (data.Updates[i].ca == 1) { //if this update is a cancel only
					retAR.push(data.Updates[i].id);
					continue;
				}					
				var u = data.Updates[i], insState = '', activity = '', t = TimeManager.getInstance();
				var timeStart = t.genJSDate(u.ts), timeEnd = u.te != "" ? t.genJSDate(u.te) : null, updateTime = t.genJSDate(u.ut);
				if (u.yu == 1) {//if you are joined with update
					var basicUserUser = new BasicUser(Global.getFirstName(), Global.getLastName(), Global.getUserID());
					var basicUserUserNameLink = new NameLink(Global.getUserID() + "updateNameLink", basicUserUser);
					var basicUserLeaderNameLink = null;
					if (u.lid != Global.getUserID()) {
						var basicUserLeader = new BasicUser(u.lfn, u.lln, u.lid);
						var basicUserLeaderNameLink = new NameLink(u.lid + "updateNameLink", basicUserLeader);
					}					
					var insUserID = Global.getUserID(), yourUpdate = true;
				}
				else {
					var basicUserLeader = u.lid != "" ? new BasicUser(u.lfn, u.lln, u.lid) : null;
					if (u.fid == "" || u.fid == Global.getUserID())
						var basicUserUser = new BasicUser(u.lfn, u.lln, u.lid), basicUserLeader = null;
					else 
						var basicUserUser = new BasicUser(u.ffn, u.fln, u.fid), basicUserLeader = new BasicUser(u.lfn, u.lln, u.lid);
					var basicUserLeaderNameLink = basicUserLeader != null ? new NameLink(u.lid + "updateNameLink", basicUserLeader) : null;
					var basicUserUserNameIns = u.fid == "" ? u.lid : u.fid;
					var basicUserUserNameLink = new NameLink(basicUserUserNameIns + "updateNameLink", basicUserUser);
					var insUserID = u.fid == "" ? u.lid : u.fid, yourUpdate = false; 
				}
				var userImage = new UserImage(insUserID + "updateUserImage", insUserID, 52, 52);
				var insFriendCount = (u.yu == 1 || (u.fid != "" && u.fid != Global.getUserID())) && u.lid != Global.getUserID() ? u.fc - 1 : u.fc;
				var updateFriendLink = new UpdateFriendLink(insUserID + "friendLink", basicUserUserNameLink, basicUserLeaderNameLink, insFriendCount);
				if (u.li == 1)
					insState = 'green';
				else if (u.li == 2) 
					insState = 'yellow';
				else
					insState = 'red';
				if (u.ac == "") {
					var s = Status.getInstance().getStatusLight();
					if (insState == 'green' || insState == 'me')
						activity = s.getGreenMsg();
					else if (insState == 'yellow')
						activity = s.getYellowMsg();
					else if (insState == 'red')
						activity = s.getRedMsg();
				}
				else
					activity = u.ac;
				var joinLight = new JoinLight(u.id + "joinLightDiv", insState, u.id, yourUpdate, false);
				var update = new Update(u.id, u.id + "update", joinLight, timeStart, timeEnd, userImage, updateFriendLink, activity, u.pl, updateTime, u.sr, yourUpdate);
				retAR.push(update);
			}
			return retAR;
		}
		
		
		return {
			
			
			tryToGetNewUpdates: function() {
		  		$("#" + Updates.getInstance().getDOMID()).stopTime();
		  		getNewUpdates();
			},
			
			
			setHasCurrentStatus: function(bool) {
				hasCurrentStatus = bool;
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