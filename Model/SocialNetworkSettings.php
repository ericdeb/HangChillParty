<?php

class SocialNetworkSettings implements Settings {
	
	private $facebookAutoPublish;
	private $twitterAutoPublish;
	
	private function __construct() {
				
	}


	public static function mainConstructor($facebookAutoPublish, $twitterAutoPublish) {
		
		$socialNetworkSettings = new SocialNetworkSettings();
	
		$socialNetworkSettings->facebookAutoPublish = Verifier::validateBoolean($facebookAutoPublish);
		$socialNetworkSettings->twitterAutoPublish = Verifier::validateBoolean($twitterAutoPublish);
		
		return $socialNetworkSettings;
		
	}
	
	public static function fullDBConstructor() {
		
		$socialNetworkSettings = new SocialNetworkSettings();
		
		$dbc = DatabaseConnection::getDatabaseConnection();

		$socialNetworkSettingsQuery = "SELECT facebook_publish, twitter_publish FROM user WHERE id = '".$_SESSION['user_id']."';";
		
		if ($result = @mysqli_query($dbc, $socialNetworkSettingsQuery)) {
		
			if ($socialNetworkSettingsAR = mysqli_fetch_array($result)) {
				
				$socialNetworkSettings->facebookAutoPublish = $socialNetworkSettingsAR['facebook_publish'];
				$socialNetworkSettings->twitterAutoPublish = $socialNetworkSettingsAR['twitter_publish'];

			}
			
		}

		return $socialNetworkSettings;		

	}
	
	
	public function save() {
		
		if (ExceptionsManager::getExceptionsManager()->areThereExceptions() == true)
			return false;
		
		$dbc = DatabaseConnection::getDatabaseConnection();

		$socialNetworkSettingsQuery = "UPDATE user SET facebook_publish = " . $this->getDBFacebookAutoPublish() . ", twitter_publish = " . $this->getDBTwitterAutoPublish() . " WHERE id = '".$_SESSION['user_id']."';";

		$result = @mysqli_query($dbc, $socialNetworkSettingsQuery);
		
	}
	
	
	public function toJSONString() {
		
		$return_str = <<<EOD
		
        	"socialNetworkSettings": [
				{ 
					"fbp": "{$this->facebookAutoPublish}",
					"twp": "{$this->twitterAutoPublish}"
				}
			],
EOD;
		
		return $return_str;
		
	}
	
	
	public function getDBFacebookAutoPublish() {
		
		return Verifier::dbReady($this->facebookAutoPublish);
		
	}
	
	
	
	public function getDBTwitterAutoPublish() {
		
		return Verifier::dbReady($this->twitterAutoPublish);
		
	}
	
}
?>