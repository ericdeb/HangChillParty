var Update = function(updateID, DOMID, joinLight, timeStart, timeEnd, userImage, updateFriendLink, activity, place, updateTime, socialRating, yourUpdate, profileBool) {

	this.updateID = updateID;
	this.shellDOMID = DOMID + "shell";
	this.DOMID = DOMID;
	this.friendLinkDOMID = DOMID + "friendLink";
	this.joinLight = joinLight;
	this.userImage = userImage;
	this.updateFriendLink = updateFriendLink;
	this.activity = activity;
	this.place = place;
	this.updateTime = updateTime;
	this.timeStart = timeStart;
	this.timeEnd = timeEnd;
	this.yourUpdate = yourUpdate;
	this.socialRating = socialRating;
	this.profileBool = profileBool;
	this.currentHoverClass;
	
	var that = this;
	var joinLightMouseEnter = function(state) {
		that.setHoverJoin(state);
	};
	var joinLightMouseLeave = function() {
		that.removeHoverJoin();
	};
	
	this.joinLight.setMouseEnterCallback(joinLightMouseEnter).setMouseLeaveCallback(joinLightMouseLeave);

};	

	
Update.prototype = {
	
	updateClass: "update",
	shellClass: "updateShell",
	updateLeftClass: "updateUpdateLeft",
	profileLeftClass: "updateProfileLeft",
	updateRightClass: "updateRight",
	updateFriendLinkClass: "updateFriendLinkDiv",
	activityClass: "updateActivity",
	timeClass: "updateTimes",
	placeClass: "updatePlace",
	hoverGreenClass: "updateJoinGreenHover",
	hoverYellowClass: "updateJoinYellowHover",
	hoverRedClass: "updateJoinRedHover",
	greenMessage: "I'm down to hang out",
	yellowMessage: "I'm probably down to chill",
	redMessage: "I'm busy or unavailable",
	


	generateInner: function() {
		var retStr = '', leftClass = this.profileBool == true ? this.profileLeftClass : this.updateLeftClass;
		var timeIns = '', activityIns = this.activity;
		if (this.activity == "") {
			if (this.joinLight.getState() == 'green')
				activityIns = this.greenMessage;
			else if (this.joinLight.getState() == 'yellow')
				activityIns = this.yellowMessage;
			else
				activityIns = this.redMessage;
		}
		if (this.profileBool == true && this.timeEnd != null)
			timeIns = '<span><br />Ending at ' + TimeManager.getInstance().genUpdateTime(this.timeEnd) + '</span>';
		var placeIns = this.place != "" ? '<div class="' + this.placeClass + '"><span>' + this.place + '</span></div>' : '';
		retStr += this.userImage.generate() + '<div class="' + leftClass + '"><span>' + this.socialRating + '</span></div>';
		retStr +=  '<div class="' + this.updateRightClass + '">' + this.joinLight.generate();
		retStr +=  '<div id="' + this.friendLinkDOMID + '"class="' + this.updateFriendLinkClass + '">' + this.updateFriendLink.generate();
		retStr +=  '</div><div class="' + this.activityClass + '"><span>' + activityIns + '</span></div>' + placeIns;
		retStr += '<div class="' + this.timeClass + '"><span>' + TimeManager.getInstance().genUpdateTime(this.updateTime) + '</span>' + timeIns + '</div></div>';
		return retStr;
	},
	
	
	generateCore: function() {
		return '<div id="' + this.DOMID + '" class="' + this.updateClass + '">' + this.generateInner() + '</div>';
	},
	
	
	generateCoreHidden: function() {
		return '<div id="' + this.DOMID + '" class="' + this.updateClass + '" style="display:none">' + this.generateInner() + '</div>';
	},
	
	
	generateShell: function() {
		return '<div id="' + this.shellDOMID + '" class="' + this.shellClass + '"></div>';
	},
	
	
	generateShellHidden: function() {
		return '<div id="' + this.shellDOMID + '" class="' + this.shellClass + '" style="display:none"></div>';
	},
	
	
	generateFull: function() {
		return '<div id="' + this.shellDOMID + '" class="' + this.shellClass + '">' + this.generateCore() + "</div>";
	},


	bind: function() {
		this.joinLight.bind();
		this.userImage.bind();
		this.updateFriendLink.bind();	
	},
	
	
	getUpdateID: function() {
		return this.updateID;	
	},
	
	
	getDOMID: function() {
		return this.DOMID;
	},
	
	
	getShellDOMID: function() {
		return this.shellDOMID;
	},
	
	
	getYourUpdate: function() {
		return this.yourUpdate;
	},
	
	
	getTimeStart: function() {
		return this.timeStart;	
	},
	
	
	getTimeEnd: function() {
		return this.timeEnd;	
	},
	
	setHoverJoin: function(state) {
		var insClass = this.hoverGreenClass;
		if (state == "yellow")
			insClass = this.hoverYellowClass;
		else if (state == "red")
			insClass = this.hoverRedClass;
		$("#" + this.friendLinkDOMID).addClass(insClass);
		this.currentHoverClass = insClass;
	},
	
	removeHoverJoin: function() {
		$("#" + this.friendLinkDOMID).removeClass(this.currentHoverClass);
		this.currentHoverClass = null;
	}
	
	
	

};
		

