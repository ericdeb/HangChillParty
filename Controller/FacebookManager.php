<?php

class FacebookManager {
	
	
	private static $instance = false;
	/*
	private $appID = 133981963305612;
	private $APIKey = "6b64d6aac429b10b265b443eaccde8be";
	private $secret = "f6019ea80b04fb86cc6765ded6eb67b5";
	*/
	private $appID = 135461943153729;
	private $APIKey = "6c7d45d3accfb589594b1c7699bd4ebe";
	private $secret = "28bda78c89348d29bef1f76abfa64d85";
	
	private $cookieSupport = true;
	private $appInstance;
	private $facebookFriendsOnHangchillpartyAR = array();
	private $facebookUserID;
	private $facebookLink;
	
	
	private function __construct() {
		
		$instance = true;

	}
	
	
	public static function getFacebookManager() {
		
		if (!FacebookManager::$instance) {
			
			FacebookManager::$instance = new FacebookManager();
			require 'IncludesPHP/facebook.php';
			
		}
		
		return FacebookManager::$instance;
		
	}
	
	
	public function getAppInstance() {
		
		if ($this->appInstance != NULL)
			return $this->appInstance;
			
		$appInstance = new Facebook(array(
  			'appId'  => $this->appID,
  			'secret' => $this->secret,
  			'cookie' => $this->cookieSupport,
		));
		
		$this->appInstance = $appInstance;
		
		return $appInstance;
		
	}


	public function tryLogin() {
		
		if ($this->getAppInstance()->getUser() == NULL) 
			return false;
			
		if (isset($_SESSION['user_id']) && isset($_SESSION['facebook_id']))
			return false;
			
		$session = $this->getAppInstance()->getSession();
					
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$facebookManagerQuery = "SELECT id, facebook_id, twitter_token, twitter_secret, gender FROM user WHERE facebook_id = " . $this->getAppInstance()->getUser();
		
		if ($result = @mysqli_query($dbc, $facebookManagerQuery)) {
			
			try {
				
				if (mysqli_num_rows($result) > 0) {
					
					if ($infoAR = mysqli_fetch_array($result)) {
						
						LoginManager::getLoginManager()->initializeSessionVariables($infoAR);
						
						StatisticsManager::getStatisticsManager()->incrementLoginsStatistic();
						
						$socialMeter = SocialMeter::afterLoginConstructor();
						
						$socialMeter->save();
						
						if (isset($_SESSION['twitterSyncData']))
							TwitterManager::getTwitterManager()->updateTwitterData($_SESSION['user_id'], $accessToken);
						
					}
					
				}
				else
					throw new ValidationException("There was no match for that Facebook ID");
					
			}
				
			catch (validationException $e) {
			
				ExceptionsManager::getExceptionsManager()->handleException($e);
			
			}
			
		}
		
	}
	
	
	public function syncAccounts() {
		
		if (isset($_SESSION['facebook_id']) && $_SESSION['facebook_id'] == $this->getAppInstance()->getUser())
			return true;

		LoginManager::getLoginManager()->isUserLoggedIn();

		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$dbc = DatabaseConnection::getDatabaseConnection();

		$facebookManagerQuery = "UPDATE user SET facebook_id = " . $this->getAppInstance()->getUser() . ", facebook_link = '" . $this->getProfileLink() . "' WHERE id = " . $_SESSION['user_id'] ;	
		
		if ($result = @mysqli_query($dbc, $facebookManagerQuery)) {

			if (mysqli_affected_rows($dbc) == 1) {
				
				$_SESSION['facebook_id'] = $this->getAppInstance()->getUser();
				return true;
				
			}
			
		}
		
		return false;
		
	}
	

	public function getLoginStatus() {
		
		$session = $this->getAppInstance()->getSession();

		if ($session) {
			
			try {			
				$me = $this->getAppInstance()->api('/me');		  
			}
		  
			catch (FacebookApiException $e) {			  

				return false;
		    }
		  
		  	return true;
		  
		}		
		
		return false;		
		
	}
	
	
	public function isFacebookIDKnown() {
		
		try {
			
			if (!isset($_SESSION['facebook_id']))
				throw new ValidationException("Facebook ID is not known.", 67);

		}
				
		catch (validationException $e) {

			ExceptionsManager::getExceptionsManager()->handleException($e);
		
		}
		
	}
	
	
	private function getBasicUsers($userIDAR) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
			
		$valuesString = "";  $friendsAR = array();
		
		foreach($friendsAR as $friend) 
			$valuesString .= $friend . " OR ";
			
		$valuesString = substr($valuesString, 0 , strlen($valuesString)-4);
		
		$facebookManagerQuery = "SELECT id, first_name, last_name FROM user WHERE id = " . $valuesString . " LIMIT 3";
		
		if ($result = @mysqli_query($dbc, $facebookManagerQuery)) {

			if ($usersAR = mysqli_fetch_array($result)) {
				
				$basicUser = BasicUser::fullConstructor($usersAR['id'], $usersAR['first_name'], $usersAR['last_name'], NULL);
				
				array_push($friendsAR, $basicUser);
				
			}
			
		}
		
		return $friendsAR;
		
	}
	
	
	public function removeFacebookData() {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$facebookManagerQuery = "UPDATE user SET facebook_id = NULL, facebook_link = NULL, facebook_publish = 0 WHERE id = '" . $_SESSION['user_id'] . "'";
		
		$result = @mysqli_query($dbc, $facebookManagerQuery);
		
	}
	
	
	public function getProfileLink() {
		
				
		$session = $this->getAppInstance()->getSession();

		if ($session) {
			
			try {			
				$me = $this->getAppInstance()->api('/me');
				return $me['link'];
			}
		  
			catch (FacebookApiException $e) {			  

				return false;
		    }
		  
		}		
		
		return false;		
		
	}
	
	
	public function updateFacebookImage($userID, $facebookID) {
		
		$pathToImages = GlobalSettings::getGlobalSettings()->getPathToImages();
	
		$facebookImg = "http://graph.facebook.com/" . $facebookID . "/picture";
		$path = $pathToImages . $userID . "_fb.jpg";
		
		UserImage::saveImageToFile($facebookImg, $path);
		
	}
	
	
	
	public function updateAllFacebookImages() {
				
		$dbc = DatabaseConnection::getDatabaseConnection();
	
		$facebookManagerQuery = "SELECT id, facebook_id FROM user WHERE facebook_id IS NOT NULL";
		
		if ($result = @mysqli_query($dbc, $facebookManagerQuery)) {

			while ($usersAR = mysqli_fetch_array($result)) {
				
				$this->updateFacebookImage($usersAR['id'], $usersAR['facebook_id']);
				
			}
			
		}	
		
	}
	
	
	
		
}

	
?>