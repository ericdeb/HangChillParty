<?php


class SynchronizeManager {
	
	
	private static $instance = false;
	
	private $indexJSAR = array();
	private $indexCSSAR = array();
	private $loginJSAR = array();
	private $loginCSSAR = array();
	private $phpAR = array();
	
	private $combinedIndexJSPath = '../Javascript/combinedIndexJavascript.js';
	private $combinedLoginJSPath = '../Javascript/combinedLoginJavascript.js';
	private $combinedIndexCSSPath = '../Styles/combinedIndexStyles.css';
	private $combinedLoginCSSPath = '../Styles/combinedLoginStyles.css';
	
	private $rootPath = "../";
	private $testRootPath = '';
	private $classPath = 'Jquery/';
	private $pluginsPath = 'IncludesJS/';
	private $cssPath = 'Styles/';	
	private $alertsPath = 'Alerts/';
	private $friendsSearchPath = 'FriendsSearch/';
	private $menuBarPath = 'MenuBar/';
	private $statusPath = 'Status/';
	private $universalPath = 'Universal/';
	private $updatesPath = 'Updates/';
	private $profilesPath = 'Profiles/';
	private $settingsPath = 'Settings/';
	private $helpPath = 'Help/';
	private $loginPath = 'Login/';
	private $controllerPath = 'Controller/';
	private $modelPath = 'Model/';

/****************** Index Arrays ******************/

	private $alertsAR = array(
		'AlertDay',
		'Alerts',
		'FriendRequestAlert',
		'FriendshipAlert',
		'NewsItemAlert',
		'RequestAcceptedAlert'		  
	);	
	private $friendsSearchAR = array(
		'EmailFriendsLink',
		'FacebookYourFriendsLink',
		'FindFriends',
		'FriendsFromFacebook',
		'FriendsOfSearch',
		'FriendsOfSearchBackButton',
		'FriendsSearch',
		'FriendsSearchButton',
		'FriendsSearchOptionsBox',	
		'FriendsSearchProfileBox',
		'FriendsSearchResults',
		'FriendsSearchSideBar',
		'InviteEmailFriends',
		'InviteEmailFriendsButton',
		'SearchLink',
		'SearchPageBox',
		'WithFacebookLink'
	);	
	private $menuBarAR = array(
		'AlertsLink',
		'FindFriendsLink',
		'LogoutLink',
		'MainMenuBar',
		'SettingsLink',
		'HangchillpartyLink',
		'HangchillpartyLogo'
	);	
	private $profilesAR = array(
		'FacebookLink',
		'FriendsOfLink',
		'Profiles',
		'ProfileUpdate',
		'UserProfile',
		'SocialMeter',
		'TwitterLink'
	);	
	private $settingsAR = array(
		'ContactSettings',
		'EmailSettings',
		'FacebookSettingsButton',
		'ImageSettings',
		'PasswordSettings',
		'ProfileSettings',
		'Settings',
		'SettingsResults',
		'SettingsSaveButton',
		'SettingsSideBar',
		'SettingsSideLink',
		'SettingsSubmitButton',
		'SocialNetworkSettings',
		'TextSettings',
		'TwitterSettingsButton'
	);	
	private $statusAR  = array(
		'CancelStatusButton',
		'ClearMoreFeaturesBoxLink',
		'FacebookCheckbox',
		'FriendsList',
		'ListRow',
		'MoreFeaturesBox',
		'MoreFeaturesButton',
		'Status',
		'StatusLight',
		'TwitterCheckbox',
		'SignalButton'
	);	
	private $universalAR = array(
		'Global',
		'TopLink',
		'BasicUser',
		'BirthdayInput',
		'AutoCompleteInput',
		'Checkbox',
		'DropDownBox',
		'ExceptionsManager',
		'FacebookManager',
		'Footer',
		'FriendRequestLink',
		'GlobalFunctions',
		'HeadingLabel',
		'InitializeManager',
		'LoadingImage',
		'NameLink',
		'PasswordInput',
		'RadioButton',
		'Request',
		'TwitterManager',
		'Tabs',
		'TermsLink',
		'TextArea',
		'TextInput',
		'TimeManager',
		'TimeZoneInput',
		'UserImage',
		'VerificationManager'
	);	
	private $updatesAR = array(
		'JoinLight',
		'Update',
		'UpdateFriendLink',
		'Updates',
		'UpdatesManager'
	);
	private $pluginsAR = array(
		'jquery',
		'ajaxUpload',
		'autocomplete',
		'timers',
		'ui.core',
		'ui.tabs',
		'effects.core',
		'effects.slide',
		'lightbox',
		'scrollTo'
	);	
	private $helpAR = array(
		'Help',
		'FAQs',
		'SocialMeterHelp',
		'FacebookAndTwitter',
		'HelpSideBar',
		'HelpSideLink',
		'StepsToSuccess',
		'StepsToSuccessTab'
	);
	private $cssAR = array(
		'main',
		'findFriends',
		'ui.core',
		'ui.tabs',
		'mainMenuBar',
		'status',
		'updates',
		'autocomplete',
		'alerts',
		'profiles',
		'settings',
		'help'
	);
	

/**************************** Login Arrays *****************************/

	private $loginUniversalAR = array(
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
	);	
	private $loginStatusAR = array(
		'StatusLight',
	);	
	private $loginAR = array(
		'FacebookLoginButton',
		'FacebookPermissionsButton',
		'InitializeLoginManager',
		'Login',
		'LoginFunctions',
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
	);
	private $loginCssAR = array(
		'autocomplete',
		'login',
		'main',
		'ui.core',
		'ui.tabs',
		'help',
		'realTimeTweets'
	);	
	private $loginHelpAR = array(
		'Help',
		'FAQs',
		'SocialMeterHelp',
		'FacebookAndTwitter',
		'HelpSideBar',
		'HelpSideLink',
		'StepsToSuccess'
	);	
	private $loginPluginsAR = array(
		'jquery',							
		'ajaxUpload',
		'autocomplete',
		'timers',
		'ui.core',
		'ui.tabs',
		'lightbox',
		'relatedTweets',
		'diggButton'
	);

/**************************** PHP Arrays *****************************/

	private $modelAR = array(
		"Verifier",
		"Settings",
		"User",
		"FullUser",
		"FindFriends",
		"FindFriendsSimple",
		"Status",
		"ValidationException",
		"AlertSettings",
		"BasicUser",
		"Friend",
		"FriendRequest",
		"FriendsSearch",
		"FriendsFromFacebook",
		"FriendsEmailSearch",
		"FriendsOfSearch",
		"FullStatus",
		"GlobalSettings",
		"JoinedStatus",
		"LeaderStatus",
		"NewsItem",
		"Party",
		"SocialMeter",
		"SocialNetworkSettings",
		"StyleSettings",
		"Time",
		"TimeZone",
		"Update",
		"UserImage",
		"UserList",
		"UserSettings"
	);	
	private $controllerAR = array(
		"AlertsManager",
		"AutoCompleteManager",
		"AwardsManager",
		"CommunicationsManager",
		"ExceptionsManager",
		"FacebookManager",
		"FriendsManager",
		"InitializeManager",
		"ListsManager",
		"LoggingManager",
		"LoginManager",
		"PartyManager",
		"RegistrationManager",
		"RequestsManager",
		"RequestsManagerJSON",
		"RequestsManagerAndroid",
		"RequestsManagerIphone",
		"RequestsManagerSmartPhone",
		"RequestsManagerWeb",
		"StatusManager",
		"StatisticsManager",
		"TwitterManager",
		"UpdatesManager"
	);	
	private $mainPHPAR = array(
		"tos",
		"twitterResultPopup",
		"ClassLibrary"
	);	

	private function __construct() {
		
		$instance = true;

		/************ index Array Processing *****************/
		
		for ($i = 0; $i < count($this->alertsAR); $i++) 
			$this->alertsAR[$i] = $this->testRootPath . $this->classPath . $this->alertsPath . $this->alertsAR[$i] . ".js";
		
		for ($i = 0; $i < count($this->friendsSearchAR); $i++) 
			$this->friendsSearchAR[$i] = $this->testRootPath . $this->classPath . $this->friendsSearchPath . $this->friendsSearchAR[$i] . ".js";
		
		for ($i = 0; $i < count($this->menuBarAR); $i++) 
			$this->menuBarAR[$i] = $this->testRootPath . $this->classPath . $this->menuBarPath . $this->menuBarAR[$i] . ".js";
			
		for ($i = 0; $i < count($this->profilesAR); $i++) 
			$this->profilesAR[$i] = $this->testRootPath . $this->classPath . $this->profilesPath . $this->profilesAR[$i] . ".js";
			
		for ($i = 0; $i < count($this->settingsAR); $i++) 
			$this->settingsAR[$i] = $this->testRootPath . $this->classPath . $this->settingsPath . $this->settingsAR[$i] . ".js";
			
		for ($i = 0; $i < count($this->helpAR); $i++) 
			$this->helpAR[$i] = $this->testRootPath . $this->classPath . $this->helpPath . $this->helpAR[$i] . ".js";
			
		for ($i = 0; $i < count($this->statusAR); $i++) 
			$this->statusAR[$i] = $this->testRootPath . $this->classPath . $this->statusPath . $this->statusAR[$i] . ".js";
			
		for ($i = 0; $i < count($this->universalAR); $i++)
			$this->universalAR[$i] = $this->testRootPath . $this->classPath . $this->universalPath . $this->universalAR[$i] . ".js";
			
		for ($i = 0; $i < count($this->updatesAR); $i++)
			$this->updatesAR[$i] = $this->testRootPath . $this->classPath . $this->updatesPath . $this->updatesAR[$i] . ".js";

		for ($i = 0; $i < count($this->pluginsAR); $i++) 
			$this->pluginsAR[$i] = $this->testRootPath . $this->pluginsPath . $this->pluginsAR[$i] . ".js";
					
		for ($i = 0; $i < count($this->cssAR); $i++) 
			$this->cssAR[$i] = $this->testRootPath . $this->cssPath . $this->cssAR[$i] . ".css";

		/************ login Array Processing *************/

		for ($i = 0; $i < count($this->loginUniversalAR); $i++)
			$this->loginUniversalAR[$i] = $this->testRootPath . $this->classPath . $this->universalPath . $this->loginUniversalAR[$i] . ".js";
			
		for ($i = 0; $i < count($this->loginStatusAR); $i++) 
			$this->loginStatusAR[$i] = $this->testRootPath . $this->classPath . $this->statusPath . $this->loginStatusAR[$i] . ".js";
			
		for ($i = 0; $i < count($this->loginAR); $i++)
			$this->loginAR[$i] = $this->testRootPath . $this->classPath . $this->loginPath . $this->loginAR[$i] . ".js";
			
		for ($i = 0; $i < count($this->loginHelpAR); $i++) 
			$this->loginHelpAR[$i] = $this->testRootPath . $this->classPath . $this->helpPath . $this->loginHelpAR[$i] . ".js";

		for ($i = 0; $i < count($this->loginPluginsAR); $i++) 
			$this->loginPluginsAR[$i] = $this->testRootPath . $this->pluginsPath . $this->loginPluginsAR[$i] . ".js";
			
		for ($i = 0; $i < count($this->loginCssAR); $i++) 
			$this->loginCssAR[$i] = $this->testRootPath . $this->cssPath . $this->loginCssAR[$i] . ".css";
			
		/************ PHP Array Processing *************/

		for ($i = 0; $i < count($this->modelAR); $i++)
			$this->modelAR[$i] = $this->modelPath . $this->modelAR[$i] . ".php";
			
		for ($i = 0; $i < count($this->controllerAR); $i++)
			$this->controllerAR[$i] = $this->controllerPath . $this->controllerAR[$i] . ".php";
			
		for ($i = 0; $i < count($this->mainPHPAR); $i++) 
			$this->mainPHPAR[$i] = $this->mainPHPAR[$i] . ".php";
			
		$this->phpAR = array_merge($this->modelAR, $this->controllerAR, $this->mainPHPAR);
	
		$this->indexJSAR = array_merge($this->pluginsAR, $this->universalAR, $this->alertsAR, $this->friendsSearchAR, $this->menuBarAR, $this->profilesAR, $this->settingsAR, $this->helpAR, $this->statusAR, $this->updatesAR);
		
		$this->indexCSSAR = $this->cssAR;
		
		$this->loginJSAR = array_merge($this->loginPluginsAR, $this->loginUniversalAR, $this->loginStatusAR, $this->loginAR, $this->loginHelpAR);
				
		$this->loginCSSAR = $this->loginCssAR;

	}
	
	
	public static function getSynchronizeManager() {
		
		if (!SynchronizeManager::$instance) {
			
			SynchronizeManager::$instance = new SynchronizeManager();
			require('IncludesPHP/JSMin.php');
			require('IncludesPHP/CSSCompressor.php');
		}
		
		return SynchronizeManager::$instance;
		
	}
	
	
	public function synchronizeSites() {
		
		$this->synchronizeFile($this->combinedIndexJSPath, $this->indexJSAR, 'js');
		$this->synchronizeFile($this->combinedLoginJSPath, $this->loginJSAR, 'js');
		$this->synchronizeFile($this->combinedIndexCSSPath, $this->indexCSSAR, 'css');
		$this->synchronizeFile($this->combinedLoginCSSPath, $this->loginCSSAR, 'css');
		
		$this->phpReplaceFiles();
				
	}
	
	
	private function synchronizeFile($combinedFilePath, $array, $type) {
		
		$combinedFile = fopen($combinedFilePath, "w");
		$str = "";
		
		for ($i = 0; $i < count($array); $i++) {
			
			$tempFile = fopen($array[$i], "r");
			$tempFileContents = fread($tempFile, filesize($array[$i]));
			
			if ($type == 'js')
				$str .= JSMin::minify($tempFileContents);
			else if ($type == 'css')
				$str .= Minify_CSS_Compressor::process($tempFileContents);
													  
		}
		
		fwrite($combinedFile, $str);
		
		fclose($combinedFile);
		
	}
	
	
	private function phpReplaceFiles() {
		
		for ($i = 0; $i < count($this->phpAR); $i++) {
			
			$testFilePath = $this->testRootPath . $this->phpAR[$i];
			$filePath = $this->rootPath . $this->phpAR[$i]; 
			
			$testFile = fopen($testFilePath, "r");
			$testFileContents = fread($testFile, filesize($testFilePath));
			
			$file = fopen($filePath, "w");
			
			fwrite($file, $testFileContents);
			
			fclose($testFile);
			
			fclose($file);
			
		}
		
	}

}

?>