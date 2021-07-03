var InitializeLoginManager = (function() {


	var instance = false;


	function constructor() {

		var DOMID = "loginMain";
		var mainTabsDOMID = "loginMainTabs";
		var mainTabs = new Tabs(mainTabsDOMID, mainTabsDOMID + "Heading", 5);
		var login = Login.getInstance();
		var registerManager = RegisterManager.getInstance();
		var registerStepOne = RegisterStepOne.getInstance();
		var registerStepTwo = RegisterStepTwo.getInstance();
		var registerStepThree = RegisterStepThree.getInstance();
		var footer = new Footer("loginFooter", true);
		var help = Help.constructor(true);
		FacebookManager.constructor(null);
		TwitterManager.constructor(null);
		
        return {

            generate: function() {
				$("#" + mainTabsDOMID + "-1").prepend(login.generate());
				$("#" + mainTabsDOMID + "-2").append(registerStepOne.generate());
				$("#" + mainTabsDOMID + "-3").append(registerStepTwo.generate());
				$("#" + mainTabsDOMID + "-4").append(registerStepThree.generate());
				help.generate();
				$("#shareButton").after(login.getTwitterRetweetButton().generate());
				$("#loginMain").after(footer.generate());
				$('#rrt').relatedTweets({
					from_users:'hangchillparty',
					lang:'',
					status:0,
					realtime:1,
					n:20,
					show_avatar:1,
					show_author:1
				});
				return this;
			},
			
			
			bind: function() {
				help.bind();
				mainTabs.bind();
				if (startRegister == true)
					mainTabs.setCurrentTab(1);
				login.bind();
				registerStepOne.bind();
				registerStepTwo.bind();
				registerStepThree.bind();
				footer.bind();
			},
			
			getMainTabs: function() {
				return mainTabs;	
			},
			
			getFooter: function() {
				return footer;
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