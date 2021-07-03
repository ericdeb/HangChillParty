var StepsToSuccess = function(DOMID, loginBool) {

	this.DOMID = DOMID;
	this.findFriendsLink = DOMID + "FindFriends";
	this.facebookLink = DOMID + "FacebookLink";
	this.facebookDoodle = DOMID + "FacebookDoodle";
	this.cellPhoneDoodle = DOMID + "CellPhoneDoodle";
	this.textLink = DOMID + "TextLink";
	this.loginBool = loginBool;
	
}


StepsToSuccess.prototype = {
	
	stepsToSuccessClass:  "stepsToSuccess",
	titleClass: "stepsToSuccessTitle",
	textClass: "stepsToSuccessText",
	addFriendsDoodleImage: "Images/addFriendsDoodle.png",
	facebookDoodleImage: "Images/facebookDoodle.png",
	cellPhoneDoodleImage: "Images/cellPhoneDoodle.png",
	greenLightDoodleImage: "Images/greenLightDoodle.png",
	joinYourFriendsDoodleImage: "Images/joinYourFriendsDoodle.png",
	addFriendsTitle: "stepsToSuccessAddFriends",
	connectTitleClass: "stepsToSuccessConnect",
	signalYourLightTitleClass: "stepsToSuccessSignal",
	joinYourFriendsTitleClass: "stepsToSuccessJoin",

	generate: function() {
		var retStr = '<div id="' + this.DOMID + '" class="' + this.stepsToSuccessClass + '">';
		retStr += '<span class="' + this.addFriendsTitle + ' ' + this.titleClass + '">Add Friends</span>';
		retStr += '<img src="' + this.addFriendsDoodleImage + '" />';
		var ins = this.loginBool == true ? 'Once you login, c' : 'C';
		retStr += '<span class="' + this.textClass + '">Just like a cell without numbers, Hangchillparty isn\'t as useful without your friends. ' + ins + 'lick <a id="' + this.findFriendsLink + '" href="#">Find Friends</a> at the top to search for people and invite your friends through facebook.</span>';
		retStr += '<span class="' + this.connectTitleClass + ' ' + this.titleClass + '">Connect your facebook and cell</span>';
		retStr += '<img id="' + this.facebookDoodle + '" src="' + this.facebookDoodleImage + '" />';
		retStr += '<img id="' + this.cellPhoneDoodle + '" src="' + this.cellPhoneDoodleImage + '" />';
		retStr += '<span class="' + this.textClass + '">Connect Hangchillparty to <a id="' + this.facebookLink + '" href="#">Facebook</a> and you\'ll have the option of posting updates onto Facebook. Receive <a id="' + this.textLink + '" href="#">texts</a> from friends who use Hangchillparty by just entering your cell in settings.</span>'; 
		retStr += '<span class="' + this.signalYourLightTitleClass + ' ' + this.titleClass + '">Signal your light</span>';
		retStr += '<img src="' + this.greenLightDoodleImage + '" />';
		retStr += '<span class="' + this.textClass + '">This is the easy part. Just update your light, which will then be signaled to your friends. More features allows you to add more info about your current socializing status.</span>'; 
		retStr += '<span class="' + this.joinYourFriendsTitleClass + ' ' + this.titleClass + '">Join your friends</span>';
		retStr += '<img src="' + this.joinYourFriendsDoodleImage + '" />';
		retStr += '<span class="' + this.textClass + '">Once your friends have added you, they\'ll show up when they signal. Join friends you\'re going to chill with to create real time groups.</span></div>';
		return retStr;

	},
	
	
	bind: function() {
		var that = this;
		if (this.loginBool == false) {
			var m = MainMenuBar.getInstance();
			$("#" + this.findFriendsLink).click(function() {
				m.getFindFriendsLink().selectLink();
			});
			$("#" + this.facebookDoodle + ", #" + this.facebookLink).click(function() {
				m.getSettingsLink().selectLink();
				SettingsSideBar.getInstance().getSocialNetworkSettingsLink().selectLink();
				
			});
			$("#" + this.cellPhoneDoodle + ", #" + this.textLink).click(function() {
				m.getSettingsLink().selectLink();
				SettingsSideBar.getInstance().getContactSettingsLink().selectLink();
			});
		}		
	}	
	
};
