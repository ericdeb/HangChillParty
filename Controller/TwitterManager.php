<?php

class TwitterManager {
	
	
	private static $instance = false;
	private $APIKey = "MUstZnN6HIS9H8mAJ4Ag";
	private $secret = "mG2vNyiJ62Scb7eYw9M3yxVUYiOojUZzGgTpous0Jzs";
	private $oAuthToken = "116585809-c1MUOirxltShqHkJYU6DMwmHdYz1O1coFXG5jLci";
	private $accessTokenSecret = "yYqqICtsyyxK4YEbJfM1sfpbRSaQI7lSqehg28E";
	private $callbackLink = "http://www.hangchillparty.com/requestswitch.php?action=twitterLoginUser";
	
	
	private function __construct() {
		
		$instance = true;

	}
	
	
	public static function getTwitterManager() {
		
		if (!TwitterManager::$instance) {
			
			TwitterManager::$instance = new TwitterManager();
			require 'IncludesPHP/twitterOAuth.php';
			
		}
		
		return TwitterManager::$instance;
		
	}


	public function displayLoginWindow() {

		$connection = new TwitterOAuth($this->APIKey, $this->secret);

		$request_token = $connection->getRequestToken($this->callbackLink);

		$_SESSION['tempTwitterOAuthToken'] = $token = $request_token['oauth_token'];
		$_SESSION['tempTwitterOAuthSecret'] = $request_token['oauth_token_secret'];
		 
		switch ($connection->http_code) {
		  case 200:
			$url = $connection->getAuthorizeURL($token);
			header('Location: ' . $url);
			break;
		  default:
			echo 'Could not connect to Twitter. Refresh the page or try again later.';
		}			
	}
	
	
	public function disconnectFromTwitter() {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$facebookManagerQuery = "UPDATE user SET twitter_id = NULL, twitter_name = NULL, twitter_token = NULL, twitter_secret = NULL, twitter_publish = 0 WHERE id = '" . $_SESSION['user_id'] . "'";
		
		$result = @mysqli_query($dbc, $facebookManagerQuery);
		
	}
	
	
	public function tryLogin() {
		
		$_SESSION['twitterLoginStatus'] = "unknown";
		
		$connection = new TwitterOAuth($this->APIKey, $this->secret, $_SESSION['tempTwitterOAuthToken'], $_SESSION['tempTwitterOAuthSecret']);
		
		unset($_SESSION['tempTwitterOAuthToken'], $_SESSION['tempTwitterOAuthSecret']);

		$accessToken = $connection->getAccessToken($_REQUEST['oauth_verifier']);
		
		if (!isset($accessToken['user_id'])) {
			$_SESSION['twitterLoginStatus'] = "failed";
			header('Location: http://www.hangchillparty.com/twitterResultPopup.php');
			return;
		}	
		
		$dbc = DatabaseConnection::getDatabaseConnection();
			
		$twitterManagerQuery = "SELECT id, facebook_id, twitter_token, twitter_secret, gender FROM user WHERE twitter_id = " . $accessToken['user_id'];
		
		if ($result = @mysqli_query($dbc, $twitterManagerQuery)) {
				
			if (mysqli_num_rows($result) > 0) {
				
				if ($infoAR = mysqli_fetch_array($result)) {
					
					if ($infoAR['twitter_token'] != $accessToken['oauth_token']) {
						
						$this->updateTwitterData($infoAR['id'], $accessToken);
						
						$infoAR['twitter_token'] = $accessToken['oauth_token'];
						$infoAR['twitter_secret'] = $accessToken['oauth_token_secret'];
						
					}				
					
					LoginManager::getLoginManager()->initializeSessionVariables($infoAR);
					
					StatisticsManager::getStatisticsManager()->incrementLoginsStatistic();
					
					if (!isset($_SESSION['user_id'])) {		
					
						$socialMeter = SocialMeter::afterLoginConstructor();
						
						$socialMeter->save();		
						
					}
					
					$_SESSION['twitterLoginStatus'] = "success";
					header('Location: http://www.hangchillparty.com/twitterResultPopup.php');
					return;
					
				}
				
			}
			
			else if (!isset($_SESSION['user_id'])){
				$_SESSION['twitterSyncData'] = $accessToken;
				$_SESSION['twitterLoginStatus'] = "syncNeeded";
				header('Location: http://www.hangchillparty.com/twitterResultPopup.php');
				return;
			}
			
			else {
				TwitterManager::getTwitterManager()->updateTwitterData($_SESSION['user_id'], $accessToken);
				$_SESSION['twitterLoginStatus'] = "success";
				header('Location: http://www.hangchillparty.com/twitterResultPopup.php');
				return;
			}
			
		}		
	
	}
	
	
	public function updateTwitterData($userID, $accessToken) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$twitterManagerQuery = "UPDATE user SET twitter_name = '" . $accessToken['screen_name'] . "', twitter_id = '" . $accessToken['user_id'] . "', twitter_token = '" . $accessToken['oauth_token'] . "', twitter_secret = '" . $accessToken['oauth_token_secret'] . "' WHERE id = " . $userID;
		
		$result = @mysqli_query($dbc, $twitterManagerQuery);
		
		if (isset($_SESSION['twitterSyncData']))
			unset($_SESSION['twitterSyncData']);
		
	}
	
	
	public function publishData($place, $light, $friendsAR) {

		if (!isset($_SESSION['twitter_token']) || !isset($_SESSION['twitter_secret']))
			return false;
			
		$connection = new TwitterOAuth($this->APIKey, $this->secret, $_SESSION['twitter_token'], $_SESSION['twitter_secret']);
		
		$totalCount = 0; $addFriendCountStr = "";
		
		if ($light == 1)
			$message = "I'm down to hang out. ";	
		else if ($light == 2)
			$message = "I'm probably down to chill. ";
		else if ($light == 3)
			$message = "I'm busy right now. ";
			
		$totalCount += strlen($message);
		
		if (count($friendsAR) > 0) {
			$message .= "w/ ";
			$totalCount += 2;
		}
		
		if (count($friendsAR) > 2) {
			$ins = count($friendsAR)-2 == 1 ? '' : 's';
			$insTwo = count($friendsAR) - 2;
			$addFriendCountStr = " and " . $insTwo . " other friend" . $ins;			
		}
			
		$totalCount += strlen($addFriendCountStr);
		
		for ($i = 0; ($i < 2 && ($i < count($friendsAR))); $i++) {
			
			$tempUser = BasicUser::dbConstructor($friendsAR[$i]);
			$insTwo = '';
			
			if ($i == 1)
				$insTwo = count($friendsAR) == 2 ? ' and ' : ', ';
			
			$ins = $insTwo . $tempUser->getFirstName() . " " . $tempUser->getLastName();
			
			if (($totalCount + $ins) <= 140)
				$message .= $ins;
		}
		
		$message .= $addFriendCountStr;
		
		if ($place != NULL && strlen($message . " @ " . $place) <= 140) 
			$message .= " @ " . $place;

		$postAR = array(
			'status' => $message
		);
			
		$connection->post('statuses/update', $postAR);

	}
	

}

	
?>