<?php

class AlertSettings implements Settings {
	
	private $text_friend_joins;
	private $text_green;
	private $text_yellow;
	private $email_friend_joins;
	private $email_fri_accept_request;
	private $email_new_fri_request;
	private $email_hangchillparty_updates;
	private $email_green;
	private $email_yellow;
	
	private function __construct() {
		
	}
	
	
	public static function fullConstructor($text_friend_joins, $text_green, $text_yellow, $email_friend_joins, $email_fri_accept_request, $email_new_fri_request, $email_hangchillparty_updates, $email_green, $email_yellow) {
		
		$alertSettings = new AlertSettings();
		
		$alertSettings->setTextData($text_friend_joins, $text_green, $text_yellow);
		
		$alertSettings->setEmailData($email_friend_joins, $email_fri_accept_request, $email_new_fri_request, $email_hangchillparty_updates, $email_green, $email_yellow);
		
		return $alertSettings;
		
	}
	
	
	public static function textConstructor($text_friend_joins, $text_green, $text_yellow) {
		
		$alertSettings = new AlertSettings();
		
		$alertSettings->setTextData($text_friend_joins, $text_green, $text_yellow);
		
		return $alertSettings;
		
	}
	
	
	public static function emailConstructor($email_friend_joins, $email_fri_accept_request, $email_new_fri_request, $email_hangchillparty_updates, $email_green, $email_yellow) {
		
		$alertSettings = new AlertSettings();
		
		$alertSettings->setEmailData($email_friend_joins, $email_fri_accept_request, $email_new_fri_request, $email_hangchillparty_updates, $email_green, $email_yellow);
		
		return $alertSettings;
		
	}
	
	
	public function setTextData($text_friend_joins, $text_green, $text_yellow) {
		
		$this->text_friend_joins = Verifier::validateBoolean($text_friend_joins);
		$this->text_green = Verifier::validateBoolean($text_green);
		$this->text_yellow = Verifier::validateBoolean($text_yellow);
		
	}
	
	
	public function setEmailData($email_friend_joins, $email_fri_accept_request, $email_new_fri_request, $email_hangchillparty_updates, $email_green, $email_yellow) {
		
		$this->email_friend_joins = Verifier::validateBoolean($email_friend_joins);
		$this->email_fri_accept_request = Verifier::validateBoolean($email_fri_accept_request);
		$this->email_new_fri_request = Verifier::validateBoolean($email_new_fri_request);
		$this->email_hangchillparty_updates = Verifier::validateBoolean($email_hangchillparty_updates);
		$this->email_green = Verifier::validateBoolean($email_green);
		$this->email_yellow = Verifier::validateBoolean($email_yellow);
		
	}
	
	
	public static function dbConstructor() {
		
		$alertSettings = new AlertSettings();
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$alertSettingsQuery = "SELECT txt_friend_joins, txt_green, txt_yellow, em_friend_joins, em_fri_acc_req, em_fri_new_req, em_weu_upg, em_green, em_yellow FROM user WHERE id = '".$_SESSION['user_id']."';";

		if ($result = @mysqli_query($dbc, $alertSettingsQuery)) {
		
			if ($alertSettingsAR = mysqli_fetch_array($result)) {
				
				$alertSettings->text_friend_joins = $alertSettingsAR['txt_friend_joins'];
				$alertSettings->text_green = $alertSettingsAR['txt_green'];
				$alertSettings->text_yellow = $alertSettingsAR['txt_yellow'];
				$alertSettings->email_friend_joins = $alertSettingsAR['em_friend_joins'];
				$alertSettings->email_fri_accept_request = $alertSettingsAR['em_fri_acc_req'];
				$alertSettings->email_new_fri_request = $alertSettingsAR['em_fri_new_req'];
				$alertSettings->email_hangchillparty_updates = $alertSettingsAR['em_weu_upg'];
				$alertSettings->email_green = $alertSettingsAR['em_green'];
				$alertSettings->email_yellow = $alertSettingsAR['em_yellow'];
				
			}
			
		}
		
		return $alertSettings;
		
	}
	
	
	public function save() {
		
		if (ExceptionsManager::getExceptionsManager()->areThereExceptions() == true)
			return false;
		
		$dbc = DatabaseConnection::getDatabaseConnection();

		$alertSettingsQuery = "UPDATE user SET txt_friend_joins = " . $this->getDBTextFriendJoins() . ", txt_green = " . $this->getDBTextGreen() . ", txt_yellow = " . $this->getDBTextYellow() . ", em_friend_joins = " . $this->getDBEmailFriendJoins() . ", em_fri_acc_req = " . $this->getDBEmailFriAcceptRequest() . ", em_fri_new_req = " . $this->getDBEmailNewFriRequest() . ", em_weu_upg = " . $this->getDBEmailHangchillpartyUpdates() . ", em_green = " . $this->getEmailGreen() . ", em_yellow = " . $this->getEmailYellow() . " WHERE id = '".$_SESSION['user_id']."';";
		
		$result = @mysqli_query($dbc, $alertSettingsQuery);
		
	}
	
	
	public function saveTextData() {
		
		if (ExceptionsManager::getExceptionsManager()->areThereExceptions() == true)
			return false;
		
		$dbc = DatabaseConnection::getDatabaseConnection();

		$alertSettingsQuery = "UPDATE user SET txt_friend_joins = " . $this->getDBTextFriendJoins() . ", txt_green = " . $this->getDBTextGreen() . ", txt_yellow = " . $this->getDBTextYellow() . " WHERE id = '".$_SESSION['user_id']."';";
		
		$result = @mysqli_query($dbc, $alertSettingsQuery);
		
	}
	
	
	public function saveEmailData() {
		
		if (ExceptionsManager::getExceptionsManager()->areThereExceptions() == true)
			return false;
		
		$dbc = DatabaseConnection::getDatabaseConnection();

		$alertSettingsQuery = "UPDATE user SET em_friend_joins = " . $this->getDBEmailFriendJoins() . ", em_fri_acc_req = " . $this->getDBEmailFriAcceptRequest() . ", em_fri_new_req = " . $this->getDBEmailNewFriRequest() . ", em_weu_upg = " . $this->getDBEmailHangchillpartyUpdates() . ", em_green = " . $this->getEmailGreen() . ", em_yellow = " . $this->getEmailYellow() . " WHERE id = '".$_SESSION['user_id']."';";
		
		$result = @mysqli_query($dbc, $alertSettingsQuery);
		
	}
	
	
	public function toJSONString() {
		
		$return_str = <<<EOD
		
        	"alertSettings": [			  
				{ 
					"tj": "{$this->text_friend_joins}",
					"tg": "{$this->text_green}",
					"ty": "{$this->text_yellow}",
					"ej": "{$this->email_friend_joins}",
					"efar": "{$this->email_fri_accept_request}",
					"efnr": "{$this->email_new_fri_request}",
					"ewu": "{$this->email_hangchillparty_updates}",
					"eg": "{$this->email_green}",
					"ey": "{$this->email_yellow}"
				}
				
			],
EOD;
		
		return $return_str;
		
	}
	
	
	public function getDBEmailFriendJoins() {
		
		return Verifier::dbReady($this->email_friend_joins);	
		
	}
	
	
	public function getDBTextFriendJoins() {
		
		return Verifier::dbReady($this->text_friend_joins);	
		
	}
	
	
	public function getDBTextGreen() {
		
		return Verifier::dbReady($this->text_green);
		
	}
	
	public function getDBTextYellow() {
		
		return Verifier::dbReady($this->text_yellow);
		
	}
	
	public function getDBEmailFriAcceptRequest () {
		
		return Verifier::dbReady($this->email_fri_accept_request);
		
	}
	
	public function getDBEmailNewFriRequest() {
		
		return Verifier::dbReady($this->email_new_fri_request);
		
	}
	
	public function getDBEmailHangchillpartyUpdates() {
		
		return Verifier::dbReady($this->email_hangchillparty_updates);
		
	}
	
	public function getEmailGreen() {
		
		return Verifier::dbReady($this->email_green);
		
	}
	
	public function getEmailYellow() {
		
		return Verifier::dbReady($this->email_yellow);
		
	}

	
}

?>