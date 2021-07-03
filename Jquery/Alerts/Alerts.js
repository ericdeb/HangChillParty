
var Alerts = (function() {


	var instance = false;


	function constructor() {
		
		var DOMID = "alerts";
		var headingDOMID = "alertsHeading";
		var daysDOMID = "alertsDays";
		var noAlertsMessageDOMID = "noAlertsMessage";
		var headingLabel = new HeadingLabel(headingDOMID, "Alerts");
		var daysAR = [];
		var totalAlertsCount = 0;
		var alertsHearbeatStarted = false;
		var processingRequest = false;
		var noAlertsMessage = "There are no new friend alerts.";


		function getNewAlerts() {
			if (processingRequest == false) {
				processingRequest = true;
		 		var newAlertsRequest = new Request("getNewAlerts", {}, {}, true, processNewAlerts, null);
		 		newAlertsRequest.getResponse();
		 		$("#" + DOMID).stopTime().oneTime(20000, getNewAlerts);
			}
		}
		
		
		function processNewAlerts(data) {
			processingRequest = false;
			var currTab = InitializeManager.getInstance().getMainTabs().getCurrentTab(), alertsLink = MainMenuBar.getInstance().getAlertsLink();
			if (currTab != alertsLink.getTabNumber() && data.AlertCount[0].co > 0)
				alertsLink.updateNewAlertCount(data.AlertCount[0].co);
			var newsAR = data.NewsItems, friendshipsAR = data.NewFriendships, requestsAR = data.FriendRequests;
			for (var i = 0; i < newsAR.length; i++)  {
				var newsItem = new NewsItemAlert(newsAR[i].id + "NewsItem", newsAR[i].tx, newsAR[i].li);
				assignToDate(newsItem, newsAR[i].up);
				totalAlertsCount++;
			}
			for (var i = 0; i < friendshipsAR.length; i++)  {
				var cur = friendshipsAR[i], userObj = Global.createNameLinkAndImage(cur.id2, cur.fn2, cur.ln2, "friendshipAlert", 23, 23);
				if (cur.id1 == Global.getUserID())
					var message = new RequestAcceptedAlert("requestAccepted" + cur.id2, userObj.nameLink, userObj.userImage);
				else {
					userObjTwo = Global.createNameLinkAndImage(cur.id1, cur.fn1, cur.ln1, "friendshipAlert", 23, 23);
					var message = new FriendshipAlert("friendshipAlert" + cur.id1, userObjTwo.nameLink, userObj.nameLink, userObjTwo.userImage, userObj.userImage);									
				}
				assignToDate(message, cur.up);
				totalAlertsCount++;
			}
			for (var i = 0; i < requestsAR.length; i++)  {
				var cur = requestsAR[i], userObj = Global.createNameLinkAndImage(cur.id1, cur.fn1, cur.ln1, "requestAlert", 23, 23);
				var requestAlert = new FriendRequestAlert("friendRequestAlert" + cur.id1, userObj.nameLink, userObj.userImage)
				assignToDate(requestAlert, cur.up);
				totalAlertsCount++;
			}
			for (var i = 0; i < daysAR.length; i++)
				daysAR[i].generateNewMessages().bindNewMessages();
			if (totalAlertsCount == 0)
				$("#" + noAlertsMessageDOMID + " span").css('display', 'block').html(noAlertsMessage);
			else
				$("#" + noAlertsMessageDOMID).css('display', 'none');
		}
		
		
		function assignToDate(alertMessage, updateTime) {
			var JSUpdateTime = TimeManager.getInstance().genJSDate(updateTime);
			for (var i = 0; i < daysAR.length; i++)  {
				if (daysAR[i].getJSDate().getUTCDate() == JSUpdateTime.getUTCDate()) {
					daysAR[i].addNewMessage(alertMessage, JSUpdateTime);
					return;
				}
			}
			var alertDay = new AlertDay(JSUpdateTime.getUTCDate() + "AlertDay", JSUpdateTime);
			alertDay.addNewMessage(alertMessage, JSUpdateTime);
			var skip = false;
			for (var i = 0; i < daysAR.length; i++)  {
				if (alertDay.getJSDate() > daysAR[i].getJSDate()) {
					skip = true;
					if (i == 0) {
						$("#" + daysAR[0].getDOMID()).before(alertDay.generate());
						daysAR.unshift(alertDay);
							
					}
					else {
						$("#" + daysAR[i].getDOMID()).before(alertDay.generate());
						daysAR.splice(i-1, 0, alertDay);
					}
					break;
				}
			}
			if (skip == false) {
				daysAR.push(alertDay);
				$("#" + daysDOMID).append(alertDay.generate());
			}			
		}
		
        return {

            generate: function() {
				var retStr = '<div id="' + DOMID + '">' + headingLabel.generate() + '<div id="' + noAlertsMessageDOMID + '"><span></span></div>';
				retStr += '<div id="' + daysDOMID + '">';
				for (var i = 0; i < daysAR.length; i++)
					retStr += daysAR[i].generate();
				retStr += '</div><div class="floatFake"></div></div>';
				return retStr;
			},
			
			
			bind: function() {
				for (var i = 0; i < daysAR.length; i++)
					daysAR[i].bind();
			},
			
			
			initialize: function() {
				alertsHearbeatStarted = true;
				getNewAlerts();
			},
			
			
			removeAlertDay: function(DOMID) {
				for (var i = 0; i < daysAR.length; i++) {
//					console.log(daysAR.length);
					if (daysAR[i].getDOMID() == DOMID) {
//						daysAR.splice(i, 1);
						if (daysAR.length == 0) {
							$("#" + noAlertsMessageDOMID).css('display', 'block');
							$("#" + noAlertsMessageDOMID + " span").css('display', 'block').html(noAlertsMessage);
						}
					}
				}				
			},
			
			
			subtractTotalAlertsCount: function() {
				totalAlertsCount--;
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