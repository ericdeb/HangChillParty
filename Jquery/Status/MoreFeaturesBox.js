var MoreFeaturesBox = (function() {


	var instance = false;
	
	
	function constructor(friendsList) {
		
		
		var DOMID = "moreFeaturesBox";
		var hidden = true;
		
		var activityDivDOMID = "activityDiv";
		var activityLabelDOMID = "activityLabel";
		var activityInputBorderDOMID = "activityBorder";
		
		var placeDivDOMID = "placeDiv";
		var placeLabelDOMID = "placeLabel";
		var placeInputBorderDOMID = "placeBorder";
		
		var timeEndDivDOMID = "timeEndDiv";
		var timeEndLabelDOMID = "timeEndLabel";
		var currHours = TimeManager.getInstance().getUserDate().getUTCHours();
		var insTimeEndSelect = (currHours > 22 || currHours < 10) ? 'am' : 'pm';
		
		var optionalFeaturesLabelDOMID = "optionalFeaturesLabel";
		
		var withMeListDiv = "withMeListDiv";
		var withMeListLabel = "withMeListLabel";
		var withMeClearFunction = function() {
			$("#statusList :checkbox").attr('checked', '');
		}
		
		
		var intObj = {
			
			activityInput: new TextArea("activityTextArea"),
			placeInput: new TextInput("placeTextInput"),
			timeEndInputOne: new TextInput("timeEndTextInputOne"),
			timeEndInputTwo: new TextInput("timeEndTextInputTwo"), 
			timeEndDropDownBox: new DropDownBox("timeEndDropDownBox", ['am', 'pm'], [0,1], insTimeEndSelect),
			clearMoreFeaturesBoxLink: new ClearMoreFeaturesBoxLink(),	
			withMeList: new FriendsList("statusList", processFriendsList(friendsList), "status", 2, 0, null, withMeClearFunction)
			
		}
		
				
	
        return {
		
		
            generate: function() {
				var io = intObj;
				var hiddenIns = hidden == true ? 'display:none' : '';
				var retStr = '<div id="' + DOMID + '" style="' + hiddenIns + '" class="' + DOMID + '">';
				retStr += '<div id="moreFeaturesLeft">';
				retStr += '<div id="' + activityDivDOMID + '"><span>Activity and Plans</span>';
				retStr += '<div id="' + activityInputBorderDOMID + '">' + io.activityInput.generate() + '</div></div>';
				retStr += '<div id="' + placeDivDOMID + '"><span>Place</span>';
				retStr += '<div id="' + placeInputBorderDOMID + '">'+ io.placeInput.generate() + '</div></div>';
				retStr += '<div id="' + timeEndDivDOMID + '"><span>Ending at</span>' + io.timeEndInputOne.generate() + '<span style="font-weight:bold">:</span>' + io.timeEndInputTwo.generate() + io.timeEndDropDownBox.generate() + '</div>';
				retStr += '</div><div id="moreFeaturesRight">';
				retStr += io.clearMoreFeaturesBoxLink.generate();
				retStr += '<div id="' + withMeListDiv + '"><span>Friends with me</span>' + io.withMeList.generate() + '</div>';
				retStr += '</div></div>';
				return retStr;
			},
			
			
			bind: function() {
				for (var key in intObj) 
					intObj[key].bind();				
			},
			
			
			clear: function() {
				for (var key in intObj) { 
					if (key != "clearMoreFeaturesBoxLink")
						intObj[key].clear();
				}
				
			},
			
			
			toggleDisplay: function() {
				ins = hidden == true ? 'block' : 'none';
				$("#" + DOMID).css('display', ins);
				hidden = hidden == true ? false : true;
			},
			
			
			isHidden: function() {
				return hidden;
			},
			
			
			getValues: function() {
				var v = VerificationManager.getInstance();
				var teValOne = intObj.timeEndInputOne.getValue();
				if (teValOne != null)
					var timeEndInputOneStripped = teValOne.substr(0,1) == '0' ?  teValOne.substr(1,2) : teValOne;
				v.verifyActivity(intObj.activityInput.getValue());
				v.verifyPlace(intObj.placeInput.getValue());
				if (teValOne != null && intObj.timeEndInputTwo.getValue() != null) {
					v.verifyTimeEnd(timeEndInputOneStripped, intObj.timeEndInputTwo.getValue(), intObj.timeEndDropDownBox.getValue());
					var insTimeEnd = TimeManager.getInstance().genPHPDate(timeEndInputOneStripped + ":" + intObj.timeEndInputTwo.getValue(), intObj.timeEndDropDownBox.getValue());	
				}
				else 
					var insTimeEnd = null;	
				v.verifyNumberList(intObj.withMeList.getStatusListValues());
				if (ExceptionsManager.getInstance().areThereExceptions() == true)
					return {};
				var insActivity = intObj.activityInput.getValue();
				var insPlace = intObj.placeInput.getValue();
				var retobj = {
					activity: insActivity,
					place: insPlace,
					timeEnd: insTimeEnd
				}
				if (intObj.withMeList.getStatusListValues() != "")
					retobj.usersToJoin = intObj.withMeList.getStatusListValues();	
				return retobj;
			},
			
			
			getSocialNetworkValues: function() {
				var v = VerificationManager.getInstance();
				v.verifyActivity(intObj.activityInput.getValue());
				v.verifyPlace(intObj.placeInput.getValue());
				if (ExceptionsManager.getInstance().areThereExceptions() == true)
					return null;
				var insActivity = intObj.activityInput.getValue();
				var insPlace = intObj.placeInput.getValue();
				var retobj = {
					activity: insActivity,
					place: insPlace
				}
				retobj.friendsAR = intObj.withMeList.getSocialNetworkAR();	
				return retobj;			
			}
				
		}
		
		
		function processFriendsList(friendsList) {
			var listRowAR = [];
			var length = $.browser.msie ? friendsList.length-1 : friendsList.length
			for (var i = 0; i <length; i++) {
				var friend = friendsList[i];
				var checkbox = new Checkbox("list" + friend.id + "checkbox", false);
				var userImage = new UserImage("list" + friend.id + "image", friend.id, 24, 22);
				var basicUser = new BasicUser(friend.fn, friend.ln, friend.id);
				var nameLink = new NameLink("list" + friend.id + "namelink", basicUser);
				var listRow = new ListRow([checkbox, userImage, nameLink]);
				listRowAR.push(listRow);				
			}
			return listRowAR;		
		}
	
	
	}
	
	
	return {
	
		getInstance: function() {
			if(instance)
				return instance;		
		},
		
		
		constructor: function(friendsList) {
			
			if (!instance) 
				return instance = constructor(friendsList);
			
		}
		
	}		
	
})();