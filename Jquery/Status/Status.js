var Status = (function() {


	var instance = false;
	

	function constructor(friendsList, facebookPublish, twitterPublish) {

		var DOMID = 'status';
		var errorDOMID = 'statusError';
		var errorMsgDOMID = 'statusErrorMsg';
		var moreFeaturesBox = MoreFeaturesBox.constructor(friendsList);
		var moreFeaturesButton = new MoreFeaturesButton();
		var statusLight = new StatusLight("statusLightDiv", "green");
		var facebookInsert = facebookPublish == 1 ? true : false, twitterInsert = false;
		if (twitterPublish == 1 && TwitterManager.getInstance().isSynced() == true)
			twitterInsert = true;
		var facebookCheckboxBox = new Checkbox("facebookCheckbox", facebookInsert);
		var twitterCheckboxBox = new Checkbox("twitterCheckbox", twitterInsert);
		var facebookCheckbox = new FacebookCheckbox("facebookCheckboxDiv", "Publish to my Facebook", facebookCheckboxBox);
		var twitterCheckbox = new TwitterCheckbox("twitterCheckboxDiv", "Publish to my Twitter", twitterCheckboxBox);
		var signalButton = new SignalButton(errorMsgDOMID);
		var facebookAndTwitterQuestion = "facebookAndTwitterQuestion";
		var facebookAndTwitterImageSrc = "Images/facebookAndTwitterQuestion.png";
			
        return {
		
		
            generate: function() {
				var retStr = '<div id="' + DOMID + '">' + statusLight.generate() + moreFeaturesButton.generate() + moreFeaturesBox.generate();
				retStr += facebookCheckbox.generate() + twitterCheckbox.generate();
				retStr += '<img id="' + facebookAndTwitterQuestion + '" src="' + facebookAndTwitterImageSrc + '" />';
				retStr += signalButton.generate() + '<div id="' + errorDOMID + '"><span id="' + errorMsgDOMID + '"></span></div></div>';     
				return retStr;
			},
			
			
			bind: function() {
				statusLight.bind();
				moreFeaturesBox.bind();
				moreFeaturesButton.bind();
				facebookCheckbox.bind();
				signalButton.bind();
				twitterCheckbox.bind();
				$("#" + facebookAndTwitterQuestion).click(function() {
					InitializeManager.getInstance().getFooter().selectHelpLink();
					HelpSideBar.getInstance().getFacebookAndTwitterLink().selectLink();			  			   
				});
				
			},
			
			
			getValues: function() {
				retObj = {partyID: null, maxPeople: null, maxGuys: null, maxGirls: null, timeStart: null};
				retObj.light = statusLight.getValue();
				$.extend(retObj, retObj, moreFeaturesBox.getValues());
				retObj.facebookPublish = facebookCheckbox.getValue();
				retObj.twitterPublish = twitterCheckbox.getValue();
				return retObj;
			},
			
			
			getSocialNetworkValues: function() {
				if (facebookCheckbox.getValue() == 0)
					return null;
				retObj = {};
				retObj.light = statusLight.getValue();
				$.extend(retObj, retObj, moreFeaturesBox.getSocialNetworkValues());
				return retObj;
			},
			
			
			getStatusLight: function() {
				return statusLight;
			},
			
			getFacebookCheckbox: function() {
				return facebookCheckbox;
			},
			
			getMoreFeaturesButton: function() {
				return moreFeaturesButton;
			},
			
			getTwitterCheckbox: function() {
				return twitterCheckbox;
			}
			
		}
	
	}
	
	
	return {
	
		getInstance: function() {
			if(instance)
				return instance;		
		},
		
		
		constructor: function(friendsList, facebookPublish, twitterPublish) {
			
			if (!instance) 
				return instance = constructor(friendsList, facebookPublish, twitterPublish);
			
		}
		
	}
	
})();