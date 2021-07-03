var LoginLoadManager = (function() {

	var instance = false;
	var classPath = 'Jquery/', pluginsPath = 'IncludesJS/', cssPath = 'Styles/';
	var universalPath = 'Universal/', loginPath = 'Login/', statusPath = 'Status/', helpPath = 'Help/';
	
	
	var universalAR = [
	'BasicUser',
	'AutoCompleteInput',
	'Checkbox',
	'DropDownBox',
	'ExceptionsManager',
	'FacebookManager',
	'Footer',
	'Global',
	'HeadingLabel',
	'LoadingImage',
	'PasswordInput',
	'RadioButton',
	'Request',
	'Tabs',
	'TermsLink',
	'TextArea',
	'TextInput',
	'TimeZoneInput',
	'TwitterManager',
	'VerificationManager'
	];
	
	var statusAR = [
	'StatusLight',
	];
	
	
	var loginAR = [
	'FacebookLoginButton',
	'FacebookPermissionsButton',
	'InitializeLoginManager',
	'Login',
	'LoginButton',
	'LoginForgotPass',
	'LoginHeader',
	'LoginLightBox',
	'RegisterButton',
	'RegisterManager',
	'RegisterStepButton',
	'RegisterStepOne',
	'RegisterStepThree',
	'RegisterStepTwo',
	'LoginLoadManager',
	'TwitterLoginButton',
	'TwitterRetweetButton'
	];

	var cssAR = [
	'autocomplete',
	'login',
	'main',
	'ui.core',
	'ui.tabs',
	'help',
	'realTimeTweets'
	];
	
	var helpAR = [
	'Help',
	'FAQs',
	'SocialMeterHelp',
	'FacebookAndTwitter',
	'HelpSideBar',
	'HelpSideLink',
	'StepsToSuccess'
	];
	
	var pluginsAR = [
	'ajaxUpload',
	'autocomplete',
	'timers',
	'ui.core',
	'ui.tabs',
	'lightbox',
	'relatedTweets',
	'diggButton'
	];
	
		
	for (var i = 0; i < universalAR.length; i++)
		universalAR[i] = classPath + universalPath + universalAR[i] + ".js";
		
	for (var i = 0; i < statusAR.length; i++) 
		statusAR[i] = classPath + statusPath + statusAR[i] + ".js";
		
	for (var i = 0; i < loginAR.length; i++)
		loginAR[i] = classPath + loginPath + loginAR[i] + ".js";
		
	for (var i = 0; i < helpAR.length; i++) 
		helpAR[i] = classPath + helpPath + helpAR[i] + ".js";

	for (i = 0; i < pluginsAR.length; i++) 
		pluginsAR[i] = pluginsPath + pluginsAR[i] + ".js";
		
	for (i = 0; i < cssAR.length; i++) 
		cssAR[i] = cssPath + cssAR[i] + ".css";
		
		
		
	
	function constructor() {
	
        return {
		
            loadClasses: function(callback) {
				$.include(classesAR, callback);			
			}, 
			
			loadPlugins: function(callback) {
				$.include(pluginsAR, callback);			
			},
		
			loadStyles: function(callback) {
				$.include(cssAR, callback);			
			},

            loadAll: function(callback) {
				
				finalAR = [];
				finalAR = finalAR.concat(universalAR, helpAR, statusAR, loginAR, cssAR, pluginsAR);
				
				$.include(finalAR, callback);

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