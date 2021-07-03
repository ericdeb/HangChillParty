var JoinLight = function(DOMID, state, updateID, me, profileBoolean) {

	var stateEnum = ['green', 'yellow', 'red'];

	this.DOMID = DOMID + "Shell";
	this.linkDOMID = DOMID + "Link";
	this.updateID = updateID;
	this.state = Global.isIn(stateEnum, state) ? state : "green";
	this.me = me;
	this.profileBoolean = profileBoolean;
	this.mouseEnterCallback;
	this.mouseLeaveCallback;

};


JoinLight.prototype = {
	
	greenLightClass: "joinLightGreen",
	yellowLightClass: "joinLightYellow",
	redLightClass: "joinLightRed",
	lightClass: "joinLight",
	linkClass: "joinLightLink",

	
	generate: function() {
		if (this.state == 'green')
			var insClass = this.greenLightClass;
		else if (this.state == 'yellow')
			var insClass = this.yellowLightClass;
		else	
			var insClass = this.redLightClass;
		var insLink = (this.me != true && this.state != "red") ? '<a href="#" id="' + this.linkDOMID + '" class="' + this.linkClass + '">Join</a>' : '';
		return '<div id="' + this.DOMID + '" class="' + this.lightClass + ' ' + insClass + '">' + insLink + '</div>';	
	},
	
	
	bind: function() {
		if (this.me != true && this.state != 'red') {
			var that = this;
			$("#" + this.linkDOMID).mouseenter(function() {
				that.mouseEnterCallback(that.state);					 
			}).mouseleave(function() {
				that.mouseLeaveCallback();	
			})
			.click(function() {
				var selectTabCallback = function() {
					var u = Updates.getInstance(), update = u.getUpdate(that.updateID), t = TimeManager.getInstance();
					if (update != null) {
						var insTimeEnd = update.getTimeEnd() != null ? t.genPHPDate(update.getTimeEnd()) : null;
						var insData = {timeStart: t.genPHPDate(update.getTimeStart()), timeEnd: insTimeEnd, joinedWithID: that.updateID};
						u.ajaxSuspendUpdate(that.updateID);
						var myUpdate = u.getMyCurrentUpdate().getUpdateID();
						u.ajaxSuspendUpdate(myUpdate);
						var joinStatusCallback = function() {
							var removeSuspendedCallback = function() {
								u.ajaxRemoveSuspendedUpdate(myUpdate);
								u.ajaxRemoveSuspendedUpdate(that.updateID);
							}
							$("#" + update.getShellDOMID()).oneTime(1000, removeSuspendedCallback);	
							UpdatesManager.getInstance().tryToGetNewUpdates();
							u.setMyUpdateFirst(true);
						}
						var joinStatusErrorCallback = function() {
							if (ExceptionsManager.getInstance().printExceptions() == 'Update has been canceled.  Please wait...') {
								u.ajaxUnsuspendUpdate(u.getMyCurrentUpdate().getUpdateID(), ExceptionsManager.getInstance().printExceptions());
								u.ajaxRemoveSuspendedUpdate(that.updateID);
							}
							else {
								u.ajaxUnsuspendUpdate(u.getMyCurrentUpdate().getUpdateID(), ExceptionsManager.getInstance().printExceptions());
								u.ajaxUnsuspendUpdate(that.updateID);							
							}
						}
						var joinRequest = new Request("joinStatus", {}, insData, false, joinStatusCallback, joinStatusErrorCallback);
						joinRequest.getResponse();
					}
				}
				if (that.profileBoolean == true) {
					InitializeManager.getInstance().getMainTabs().setCurrentTab(0);
					$("#" + that.DOMID).oneTime(200, function() {
						selectTabCallback();						   
					});
				}
				else
					selectTabCallback();
				return false;				
			});
		}
	},
	
	
	getValue: function() {
		if (this.state == 'green')
			return 1;
		else if (this.state == 'yellow')
			return 2;
		else
			return 3;
	},
	
	
	getState: function() {
		return this.state;
	},
	
	
	getDOMID: function() {
		return this.DOMID;	
	},
	
	setMouseEnterCallback: function(callback) {
		this.mouseEnterCallback	= callback;
		return this;
	},
	
	setMouseLeaveCallback: function(callback) {
		this.mouseLeaveCallback	= callback;
		return this;
	}

};
