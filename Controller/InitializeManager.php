<?php

class InitializeManager {
	
	
	private static $instance = false;


	private function __construct() {
		
	}
	
	
	public static function getInitializeManager() {
		
		if (!InitializeManager::$instance) {
			
			if ($_SESSION['environment'] == "web")
				InitializeManager::$instance =  InitializeManager::webConstructor();
			else if ($_SESSION['environment'] == "iphone" || $_SESSION['environment'] == "android")
				InitializeManager::$instance =  InitializeManager::smartPhoneConstructor();
			
		}
		
		return InitializeManager::$instance;
		
	}

	
	private static function webConstructor() {
		
		$initializeManager = new InitializeManager();
		
		$initializeManager->currentTime = Time::getUserTimeUnixJSON();
		$initializeManager->friendsManager = FriendsManager::getFriendsManager();
		$initializeManager->userSettings = UserSettings::fullDBConstructor();
		$initializeManager->alertSettings = AlertSettings::dbConstructor();
		$initializeManager->socialNetworkSettings = SocialNetworkSettings::fullDBConstructor();
		Time::initializeLastUpdateTimes();
		
		return $initializeManager;
		
	}
	
	
	private static function smartPhoneConstructor() {
		
		$initializeManager = new InitializeManager();
		
		$initializeManager->currentTime = Time::getUserTimeUnixJSON();
		$initializeManager->basicUser = BasicUser::dbConstructor($_SESSION['user_id']);
		
		return $initializeManager;
		
	}
	
	
	public function getInitialJSON() {
		
		if ($_SESSION['environment'] == "web")
			return $this->getInitialWebJSON();
		else if ($_SESSION['environment'] == "iphone" || $_SESSION['environment'] == "android")
			return $this->getInitialSmartPhoneJSON();
		
	}


	private function getInitialWebJSON() {
		
		$return_str = $this->friendsManager->getAllFriendsJSON() . " ";
		$return_str .= $this->currentTime . " ";
		$return_str .= $this->getTwitterSyncedJSON() . " ";
		$return_str .= $this->getFacebookIDJSON() . " ";
		$return_str .= $this->getInviteFacebookFriendsJSON() . " ";
		$return_str .= $this->userSettings->toJSONString() . " ";
		$return_str .= $this->alertSettings->toJSONString() . " ";
		$return_str .= $this->socialNetworkSettings->toJSONString() . " ";

		return $return_str;
		
	}
	
	
	private function getInitialSmartPhoneJSON() {
		
		$return_str = $this->currentTime . " ";
		$return_str .= $this->basicUser->toFullJSONString() . " ";

		return $return_str;	
		
	}
	
	
	private function getFacebookIDJSON() {
		
		$facebookID =  isset($_SESSION['facebook_id']) ? $_SESSION['facebook_id'] : "";

		$return_str = <<<EOD
			"FacebookID": [
				{ 
					"id": "{$facebookID}"
				},	
			],			
EOD;

		return $return_str;
	
	}
	
	
	private function getInviteFacebookFriendsJSON() {
		
		if (isset($_SESSION['facebookInvitesDone'])) {
			$done = 1;
			unset($_SESSION['facebookInvitesDone']);
		}
		else
			$done = 0;
			
		if (isset($_SESSION['inviteFacebookFriends'])) {
			$set = 1;
			unset($_SESSION['inviteFacebookFriends']);
		}
		else
			$set = 0;	
		
		$return_str = <<<EOD
			"inviteFacebook": [
				{ 
					"set": "{$set}",
					"done": "{$done}"
				},	
			],			
EOD;

		return $return_str;
		
	}
	
	
	private function getTwitterSyncedJSON() {
			
		$set = isset($_SESSION['twitter_token']) ? 1 : 0;

		$return_str = <<<EOD
			"twitterSynced": [
				{ 
					"set": "{$set}"
				},	
			],			
EOD;

		return $return_str;
		
	}
	
}


?>