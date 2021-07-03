var Updates = (function() {


	var instance = false;
	

	function constructor() {

		var mainDOMID = "updates";
		var alignedCenterDOMID = "updatesAlignedCenter";
		var topDOMID = "updatesTop";
		var topMsgDOMID = "updatesTopMsg";
		var topMsgImageSource = "Images/selectLightLabel.png";
		var middleDOMID = "updatesMiddle";
		var myUpdateDOMID = "myUpdate";
		var myUpdateTopDOMID = "myUpdateTop";
		var friendsUpdateTopDOMID = "friendsUpdatesTop";
		var friendsUpdateDOMID = "friendsUpdates";
		var bottomDOMID = "updatesBottom";
		var horizontalLineDOMID = "updateLine";
		var nobodysUpdatedDOMID = "nobodysUpdated";
		var errorMsgDOMID = "updateError";
		
		var topMsg = "Select light and click Signal";
		var myUpdateImageSource = "Images/mySignalLabel.png";
		var friendsUpdatesImageSource = "Images/friendsSignalsLabel.png";
		var nobodysUpdatedMsg = "There are no new signals";
		
		var updateCancelButton = new CancelStatusButton();
		
		var newUpdatesQueue = [];
		var currentUpdatesAR = [];
		var suspendedUpdatesAR = [];
		var runningQueue = false;
		var pauseQueue = false;
		
		var myUpdateFirst = false;
		
		var opened = false;
		
		
		//NOTES:  all isNumber is to test if update is a CANCEL ONLY update.
		function generateNewUpdate(justOpened) {
			var timerCallback = function() {
				generateNewUpdate(false);
			}
			if (pauseQueue == true) {
				$("#" + middleDOMID).stopTime().oneTime(3000, timerCallback);
				return false;
			}
			var v = VerificationManager.getInstance();
			if (justOpened == true) {
				var realUpdates = 0;
				for (var i = 0; i < newUpdatesQueue.length; i++) {
					if (v.isNumber(newUpdatesQueue[i]) == false) {
						prependUpdate(newUpdatesQueue[i]); 	
						realUpdates++;
					}
				}
				if (realUpdates == 1)
					$("#" + friendsUpdateDOMID).append('<span id="' + nobodysUpdatedDOMID + '">' + nobodysUpdatedMsg + '</span>');
				else
					$("#" + nobodysUpdatedDOMID).remove();
				$("#" + updateCancelButton.getDOMID()).remove();
				$("#" + myUpdateTopDOMID).append(updateCancelButton.generate());
				newUpdatesQueue = [];					
			}
			else if (newUpdatesQueue.length > 0) {
				//console.log("here");
				if (myUpdateFirst == true) {
					moveMyUpdateToTop();
					myUpdateFirst = false;
				}					
				var curUpd = newUpdatesQueue[0];
				var insID = v.isNumber(curUpd) ? curUpd : curUpd.getUpdateID();
				//console.log(insID);
				if (deleteMatch(insID) == false || v.isNumber(curUpd) == true) {
					//console.log("here3");
					newUpdatesQueue.shift();
					if (v.isNumber(curUpd) != true) //if not cancel only, prepend update
						prependUpdate(curUpd);
					if (newUpdatesQueue.length > 0) {
						$("#" + middleDOMID).stopTime().oneTime(2000, timerCallback);
						runningQueue = true;
					}
					else
						runningQueue = false;
				}
				else {
					$("#" + middleDOMID).stopTime().oneTime(2500, timerCallback);
					runningQueue = true;
				}
			}
			
			function moveMyUpdateToTop() {
				for (var i = 0; i < newUpdatesQueue.length; i++) {
					if (v.isNumber(newUpdatesQueue[i]) == false && newUpdatesQueue[i].getYourUpdate() == true) {
						newUpdatesQueue.unshift(newUpdatesQueue[i]);
						newUpdatesQueue.splice(i+1,1);	
					}
				}			
			}
			
			function prependUpdate(update) {
				//console.log("here22");
				if (update.getYourUpdate() == true)
					$("#" + myUpdateDOMID).html('');
				currentUpdatesAR.push(update);
				var insDOMID = update.getYourUpdate() == true ? myUpdateDOMID : friendsUpdateDOMID;
				//console.log("here66");
				if (justOpened == true) {
					//console.log("here55");
					/*if (update.getYourUpdate() == false) {
						var h = $("#" + middleDOMID).height();
						$("#" + middleDOMID).height(h + 100);
					}*/
					$("#" + insDOMID).prepend(update.generateFull());
					update.bind();
					$("#" + middleDOMID + ", #" + friendsUpdateDOMID).height("auto");
				}
				else 
					prependUpdateAnimate(update, insDOMID);
				if (update.getYourUpdate() == false || currentUpdatesAR.length > 1)
					$("#" + nobodysUpdatedDOMID).remove();					
			}

			function deleteMatch(updateID) {
				//console.log("here2");
				var index = findUpdateMatch(currentUpdatesAR, updateID, false);
				if (index == null) {
					tryToAddBottomSpan();
					return false
				}
				var delUpd = currentUpdatesAR[index];
				//console.log("1 deleting " + delUpd.getUpdateID() + test(currentUpdatesAR));
				currentUpdatesAR.splice(index,1);
				//console.log("after " + test(currentUpdatesAR));
				deleteUpdateAnimate(delUpd);	
				return true;
			}
			
			function prependUpdateAnimate(update, insDOMID) {
				//console.log("here11");
				var slideInCallback = function() {
					//console.log("here77");
					$(this).css('padding-top', "0px");
					$("#" + insDOMID).prepend(update.generateShell());
					$("#" + update.getShellDOMID()).html(update.generateCoreHidden());
					$("#" + update.getDOMID()).fadeIn(1000, fadeInCallback);
					$("#" + middleDOMID + ", #" + friendsUpdateDOMID).height("auto");
					//console.log("here99");
				};
				var fadeInCallback = function() {
					//console.log("here2");
					update.bind();	
					tryToAddBottomSpan();
				}
				if (insDOMID == friendsUpdateDOMID) {
					if (currentUpdatesAR.length != 2) {
						$("#" + insDOMID).animate({"padding-top": "+=130px"}, 1000, slideInCallback);
						$("#" + middleDOMID).animate({"height": "+=130px"}, 900);
					}
					else 
						$("#" + middleDOMID).animate({"height": "+=30px"}, 300, slideInCallback);
				}
				else {
					//$("#" + insDOMID).html('').css('margin-top', '0px');
					slideInCallback();	
					tryToAddBottomSpan();
				}
			}
			
			function deleteUpdateAnimate(delUpd) {
				//console.log("deleteID: " + delUpd.getDOMID());
				var fadeOutCallback = function() {
					var par = $(this).parent();
					$(this).remove();
					if (delUpd.getYourUpdate() == false) {
						$(par).animate({"height": "0px"}, 1000, slideUpCallback);
						//console.log("deleteing " + currentUpdatesAR.length);
						if (currentUpdatesAR.length != 1)
							$("#" + middleDOMID + ", #" + friendsUpdateDOMID).animate({"height": "-=130px"}, 900);	
					}
					else {
						$(par).remove();
						//console.log("subHere: " + currentUpdatesAR.length);
						//$("#" + myUpdateDOMID).css('margin-top', '25px');
						tryToAddBottomSpan();
					}
				}
				var slideUpCallback = function() {
					$("#" + middleDOMID + ", #" + friendsUpdateDOMID).height("auto");
					$(this).remove();	
					//console.log("subHere2: " + currentUpdatesAR.length);
					tryToAddBottomSpan()
				}
				$("#" + delUpd.getDOMID()).fadeOut(1000, fadeOutCallback);
			}
			
			function tryToAddBottomSpan() {
				if (currentUpdatesAR.length == 1 && newUpdatesQueue.length == 0) {
					$("#" + nobodysUpdatedDOMID).remove();
					$("#" + friendsUpdateDOMID).append('<span id="' + nobodysUpdatedDOMID + '">' + nobodysUpdatedMsg + '</span>');
				}
			}
			
		}
		
		
		function findUpdateMatch(inputAR, updateID, retUpdate) {//retUpdate is a boolen for return update or index
			for (var i = 0; i < inputAR.length; i++) {
				if (inputAR[i].getUpdateID() == updateID) {
					//console.log(inputAR[i].getUpdateID() + " here8 " + updateID);
					if (retUpdate == true)
						return inputAR[i];
					else
						return i;
				}
			}
			return null;
		}
		
		function test(inputAR) {
			var str = ""
			for (var i = 0; i < inputAR.length; i++) 
				str += inputAR[i].getUpdateID() + " " ;
			return str;			
		}
		
		
		return {
				
            generate: function() {
				var retStr = '<div id="' + mainDOMID + '">';
				retStr += '<div id="' + topDOMID + '"><div id="' + topMsgDOMID + '"><img src="' + topMsgImageSource + '" /></div></div>';
				retStr += '<div id="' + middleDOMID + '">';
				retStr += '<div id="' + myUpdateTopDOMID + '"><img src="' + myUpdateImageSource + '"/></div><div id="' + myUpdateDOMID + '"></div>';
				retStr += '<div id="' + friendsUpdateTopDOMID + '"><img src="' + friendsUpdatesImageSource + '"/>';
				retStr += '</div><div id="' + friendsUpdateDOMID + '"></div><div class="floatFake"></div></div>';
				retStr += '<div id="' + bottomDOMID + '"></div></div>';	
				return retStr; 
			},
			
			
			closeUpdates: function(firstTime) {
				var closeCallback = function() {
					var middleCallback = function() {
						$("#" + middleDOMID).css('display', 'none');
						$("#" + myUpdateDOMID + ", #" + friendsUpdateDOMID).html('');
					}
					$("#" + middleDOMID).stopTime().oneTime(300, middleCallback);
					middleCallback();
					$("#" + topDOMID + ", #" + bottomDOMID).css('display', 'block');
					$("#" + myUpdateDOMID + ", #" + friendsUpdateDOMID).html('');
					newUpdatesQueue = []; currentUpdatesAR = []; suspendedUpdatesAR = [];  runningQueue = false; pauseQueue = false;
					updateCancelButton.unbind();
					UpdatesManager.getInstance().setHasCurrentStatus(false);
				}
				if (firstTime == false)
					$("#" + middleDOMID).stopTime().oneTime(2000, closeCallback);
				else
					closeCallback();
				opened = false;
			},
			
		
			openUpdates: function(firstTime, openCallback) {
				$("#" + middleDOMID).css('display', 'block');
				$("#" + topDOMID + ", #" + bottomDOMID).css('display', 'none');
				openCallback();
				updateCancelButton.bind();
				opened = true;
			},
			
		
			addNewUpdates: function(updatesAR, justOpened) {
				newUpdatesQueue = newUpdatesQueue.concat(updatesAR);
				if (runningQueue == false && justOpened == false)
					generateNewUpdate(false);
				else if (justOpened == true)
					generateNewUpdate(true);
			},
			
			
			ajaxSuspendUpdate: function(updateID) {
				//console.log("suspending " + updateID);
				var update = findUpdateMatch(currentUpdatesAR, updateID, true);
				if (update == null)
					return false;
				pauseQueue = true;
				suspendedUpdatesAR.push(update);
				$("#" + update.getDOMID()).remove();
				var loadingImage = new LoadingImage("updateLoad", 75, 75);
				$("#" + update.getShellDOMID()).append(loadingImage.generate());				
			},
			
			
			ajaxUnsuspendUpdate: function(updateID, errorMsg) {
				var index = findUpdateMatch(suspendedUpdatesAR, updateID, false);
				var that = this;
				if (index == null)
					return false;
				var update = suspendedUpdatesAR[index];
				suspendedUpdatesAR.splice(index,1);
				var errorCallback = function() {
					$("#" + update.getShellDOMID()).html(update.generateCore());
					update.bind();
					if (suspendedUpdatesAR.length == 0)
						that.ajaxClearAllSuspendedUpdates();				
				}
				if (errorMsg != null) {
					$("#" + update.getShellDOMID()).html('<div id="' + errorMsgDOMID + '"><span>' + errorMsg + '</span></div>');
					$("#" + errorMsgDOMID).fadeOut(2000, errorCallback);
				}
				else
					$("#" + update.getShellDOMID()).oneTime(2000, errorCallback);
			},
			
			
			ajaxRemoveSuspendedUpdate: function(updateID) {
				var index = findUpdateMatch(suspendedUpdatesAR, updateID, false);
				if (index == null)
					return false;
				var update = suspendedUpdatesAR[index];
				suspendedUpdatesAR.splice(index,1);
				var indexTwo = findUpdateMatch(currentUpdatesAR, updateID, false);
				//console.log("2 deleting " + updateID + test(currentUpdatesAR));
				currentUpdatesAR.splice(indexTwo,1);
				if (currentUpdatesAR.length <= 1 && suspendedUpdatesAR.length == 0) {
					$("#" + nobodysUpdatedDOMID).remove();
					$("#" + friendsUpdateDOMID).append('<span id="' + nobodysUpdatedDOMID + '">' + nobodysUpdatedMsg + '</span>');					
				}
				$("#" + update.getShellDOMID()).remove();
				$("#" + middleDOMID + ", #" + friendsUpdateDOMID).height("auto");	
				if (suspendedUpdatesAR.length == 0) {
						pauseQueue = false;
						$("#" + middleDOMID).stopTime();
						generateNewUpdate(false);
				}
			},
			
			
			ajaxClearAllSuspendedUpdates: function() {
				/*for (var i = 0; i < suspendedUpdatesAR.length; i++) {
					console.log("MADDDDDDDDNESSS");
					var index = findUpdateMatch(suspendedUpdatesAR, suspendedUpdatesAR[i].getUpdateID(), false);
					if (index != null)
						currentUpdatesAR.splice(index,1);
				}*/
				suspendedUpdatesAR = [];
				pauseQueue = false;
				$("#" + middleDOMID).stopTime();
				generateNewUpdate(false);				
			},
			
			
			getMyCurrentUpdate: function() {
				for (var i = 0; i < currentUpdatesAR.length; i++) {
					if (currentUpdatesAR[i].getYourUpdate() == true)
						return currentUpdatesAR[i];
				}
				return null;
			},
			
			
			getUpdate: function(updateID) {
				return findUpdateMatch(currentUpdatesAR, updateID, true);
			},
			
			
			
			getDOMID: function() {
				return mainDOMID;	
			},
			
			
			setMyUpdateFirst: function(insBool) {
				if (typeof insBool == "boolean")
					myUpdateFirst = insBool; 	
			},
			
			
			isOpened: function() {
				return opened;	
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