<?php

class LoginManager {
	

	private static $instance = false;
	
	
	private function __construct() {
		
		$instance = true;

	}
	
	
	public static function getLoginManager() {
		
		if (!LoginManager::$instance) {
			
			LoginManager::$instance = new LoginManager();
			
		}
		
		return LoginManager::$instance;
		
	}
	
	
	public function tryLogin($email, $password, $rememberMe) {
		
		$email = Verifier::validateEmail($email);
		$password = Verifier::validatePassword($password);
		$rememberMe = Verifier::validateBoolean($rememberMe);
					
		$dbc = DatabaseConnection::getDatabaseConnection();

		$loginManagerQuery = "SELECT id, facebook_id, twitter_token, twitter_secret, gender FROM user WHERE pass = SHA1('" . Verifier::dbReady($password) . "') AND email = '" . Verifier::dbReady($email) . "'";

		if ($result = @mysqli_query($dbc, $loginManagerQuery)) {

			try {
				
				if (mysqli_num_rows($result) > 0) {
					
					if ($infoAR = mysqli_fetch_array($result)) {
						
						$this->initializeSessionVariables($infoAR);
						
						if (isset($_SESSION['twitterSyncData']))
							TwitterManager::getTwitterManager()->updateTwitterData($_SESSION['user_id'], $_SESSION['twitterSyncData']);

						$socialMeter = SocialMeter::afterLoginConstructor();
						
						StatisticsManager::getStatisticsManager()->incrementLoginsStatistic();
						
						$socialMeter->save();
						
					}
					
				}
				else 
					throw new ValidationException("There was no match for that combination");
					
			}
				
			catch (validationException $e) {
			
				ExceptionsManager::getExceptionsManager()->handleException($e);
			
			}
				
		}
		
		if ($rememberMe == true) 
			$this->setRememberMe();
		
	}
	
	
	public function tryTestingLogin($userName, $password) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$userName = Verifier::validateText($userName);
		$password = Verifier::validatePassword($password);
		
		$loginManagerQuery= "SELECT id FROM test_login WHERE pass = SHA1('" . Verifier::dbReady($password) . "') AND username = '" . Verifier::dbReady($userName) . "'";
		
		if ($result = @mysqli_query($dbc, $loginManagerQuery)) {

			if (mysqli_num_rows($result) > 0) {
				$_SESSION['testing'] = true;
				return true;
			}
			else
				return false;
			
		}
		
		return false;
		
	}
	
	
	public function forgotPassword($email) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$newPass = $this->generateCode(12);
		
		$loginManagerQuery = "UPDATE user SET pass = SHA('" . $newPass . "') WHERE email = '" . Verifier::dbReady($email) . "'";

		try {

			if ($result = @mysqli_query($dbc, $loginManagerQuery)) {

				if (mysqli_affected_rows($dbc) == 1) 
					CommunicationsManager::getCommunicationsManager()->sendForgottenPassword($email, $newPass);
				else
					throw new ValidationException("There was no match for that email.", 4);
					
			}	
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
	}
	
	
	public function logoutUser() {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
      	setcookie('user_id', NULL, NULL, '/');
		setcookie('rem_me_series', NULL, NULL, '/');
		setcookie('rem_me_id', NULL, NULL, '/');
		setcookie('exp_time', NULL, NULL, '/');
	
		$loginManagerQuery = "UPDATE users SET rem_me_" . $_SESSION['environment'] . "_series = 0, rem_me_" . $_SESSION['environment'] . "_key = 0 WHERE id = '" . $_SESSION['user_id'] . "'";
	
		$_SESSION = array();
	
		session_destroy();
	
		setcookie('PHPSESSID', '', time()-3600, '/', '', 0, 0);
		
		$result = @mysqli_query($dbc, $loginManagerQuery);	
		
	}
	
	
	private function setRememberMe() {
		
		if (ExceptionsManager::getExceptionsManager()->areThereExceptions() == true)
			return false;
			
		$dbc = DatabaseConnection::getDatabaseConnection();
						
		$series = $this->generateCode(30);
		$key = $this->generateCode(30);
		
		$loginManagerQuery = "UPDATE user SET rem_me_" . $_SESSION['environment'] . "_series = '" . $series . "', rem_me_" . $_SESSION['environment'] . "_key = '" . $key . "' WHERE id = " . $_SESSION['user_id'];
		
		$cookieExp = time() + (60*60*24*90);
		
		setcookie('user_id', $_SESSION['user_id'], $cookieExp, '/');
		setcookie('rem_me_series', $series, $cookieExp, '/');
		setcookie('rem_me_id', $key, $cookieExp, '/');
		setcookie('exp_time', $cookieExp, $cookieExp, '/');
	
		$result = @mysqli_query($dbc, $loginManagerQuery);
	
	}
	
	
	public function tryRememberMe() {
		
		if (!isset($_SESSION['user_id'])) {
			
			Verifier::cookieCheck(array('user_id', 'rem_me_series', 'rem_me_id', 'exp_time'));

			if ($this->checkExitWeb() == true) 
				return false;

			ExceptionsManager::getExceptionsManager()->exceptionsCheck();

			Verifier::validateNumber($_COOKIE['user_id']);
			Verifier::validateRememberMe($_COOKIE['rem_me_series']);
			Verifier::validateRememberMe($_COOKIE['rem_me_id']);

			if ($this->checkExitWeb() == true) 
				return false;

			ExceptionsManager::getExceptionsManager()->exceptionsCheck();
			
			$dbc = DatabaseConnection::getDatabaseConnection();
	
			$loginManagerQuery = "SELECT id, facebook_id, gender, twitter_token, twitter_secret, rem_me_" . $_SESSION['environment'] . "_series, rem_me_" . $_SESSION['environment'] . "_key FROM user WHERE id =  " . $_COOKIE['user_id'];
			
			if ($result = @mysqli_query($dbc, $loginManagerQuery)) {
					
				if ($infoAR = mysqli_fetch_array($result)) {
					
					if ($infoAR["rem_me_" . $_SESSION['environment'] . "_series"] == $_COOKIE['rem_me_series']) {
						
						if ($infoAR['rem_me_'  . $_SESSION['environment'] . '_key'] == $_COOKIE['rem_me_id']) {
							
							$this->initializeSessionVariables($infoAR);

							$rem_me_id = $this->generateCode(30);
							
							$loginManagerQuery = "UPDATE user SET rem_me_" . $_SESSION['environment'] . "_key = '" . $rem_me_id . "' WHERE id = " . $_SESSION['user_id'];
							
							setcookie('rem_me_id', $rem_me_id, $_COOKIE['exp_time'], '/');
							
							$result = @mysqli_query($dbc, $loginManagerQuery);
						
						}
						
						else {
							
							setcookie('user_id', NULL, NULL, '/');
							setcookie('rem_me_series', NULL, NULL, '/');
							setcookie('rem_me_id', NULL, NULL, '/');
							setcookie('exp_time', NULL, NULL, '/');
							
						}
						
					}
					
				}
				
			}
			
		}
		
	}
	
	
	public function getLoginStatusJSON() {
		
		$login = isset($_SESSION['user_id']) ? 1 : 0;
		
		$return_str = <<<EOD
		
				{ 
					"lo": "{$login}"
				},
				
EOD;

		return $return_str;
		
	}
	
	
	public function isUserLoggedIn() {
		
		try {
			
			if (!isset($_SESSION['user_id']))
				throw new ValidationException("User is not logged in.", 89);

		}
				
		catch (validationException $e) {
		
			ExceptionsManager::getExceptionsManager()->handleException($e);
		
		}
		
	}
	
	
	public function isUserLoggedOut() {
		
		try {
			
			if (isset($_SESSION['user_id']))
				throw new ValidationException("User is already logged in.");

		}
				
		catch (validationException $e) {
		
			ExceptionsManager::getExceptionsManager()->handleException($e);
		
		}
		
	}
	
	
	private function generateCode($length) {
		
   		 $code="";
   		 $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
		 srand((double)microtime()*1000000);
		 
		 for ($i=0; $i<$length; $i++) {
			 
			$code .= substr ($chars, rand() % strlen($chars), 1);
			
		 }
		 
		 return $code;
		 
	}
	
	
	public function initializeSessionVariables($infoAR) {
		
		$_SESSION['user_id'] = $infoAR['id'];
		$_SESSION['gender'] = $infoAR['gender'];
		
		if ($infoAR['facebook_id'] != NULL) {
			$_SESSION['facebook_id'] = $infoAR['facebook_id'];
			FacebookManager::getFacebookManager()->updateFacebookImage($_SESSION['user_id'], $_SESSION['facebook_id']);	
		}
			
		if ($infoAR['twitter_token'] != NULL) {
			$_SESSION['twitter_token'] = $infoAR['twitter_token'];
			$_SESSION['twitter_secret'] = $infoAR['twitter_secret'];
		}
		
		$_SESSION['social_rating'] = SocialMeter::getYourCurrentSocialRating();
		$_SESSION['social_rating_awards'] = array();
		$_SESSION['general_awards'] = array();

		$_SESSION['lastUpdateTimeAlerts'] = Time::getFiveDaysAgoUnivTime();
		$_SESSION['lastUpdateTimeUpdates'] = Time::getFiveHoursAgoUnivMicroTime();
		
	}


	private function checkExitWeb() {

		 $exceptionsBool = ExceptionsManager::getExceptionsManager()->areThereExceptions();
		 $environBool = isset($_SESSION['environment']);

		 if ($exceptionsBool == true && (($environBool && $_SESSION['environment'] == "web") || !$environBool))
				return true;
		 else
				return false;

	}
	
	
	public function initializeSessionVariablesRegister($userID) {
		
		$_SESSION['user_id'] = $userID;	
		$_SESSION['lastUpdateTimeAlerts'] = Time::getFiveDaysAgoUnivTime();
		$_SESSION['lastUpdateTimeUpdates'] = Time::getFiveHoursAgoUnivMicroTime();
		
	}
	
	
	
	
}


?>