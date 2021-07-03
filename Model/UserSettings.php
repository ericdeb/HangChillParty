<?php

class UserSettings extends FullUser implements Settings {
	
	private $timeZone;
	private $password;
	private $passwordVerified;
	private $numLogins;
	
	
	private function __construct() {
		
	}
	
	
	public static function fullConstructorUS($firstName, $lastName, $gender, $birthday, $phone, $email, $blurb, $timeZone, $password, $passwordVerified) {
		
		$userSettings = new UserSettings();
		
		$userSettings->setProfileData($firstName, $lastName, $gender, $birthday, $blurb, $timeZone);
		
		$userSettings->setContactFullUserData($phone, $email);
		
		$userSettings->setPasswordData($password, $passwordVerified);
		
		return $userSettings;
		
	}
	
	
	public static function profileConstructor($firstName, $lastName, $gender, $birthday, $blurb, $timeZone) {
		
		$userSettings = new UserSettings();
		
		$userSettings->setProfileData($firstName, $lastName, $gender, $birthday, $blurb, $timeZone);
		
		return $userSettings;
		
	}
	
	
	public static function contactConstructor($phone, $email) {
		
		$userSettings = new UserSettings();
		
		$userSettings->setContactFullUserData($phone, $email);
		
		return $userSettings;
		
	}
	
	
	public static function passwordConstructor($password, $passwordVerified) {
		
		$userSettings = new UserSettings();
		
		$userSettings->setPasswordData($password, $passwordVerified);

		return $userSettings;
		
	}
	
	
	private function setProfileData($firstName, $lastName, $gender, $birthday, $blurb, $timeZone) {
		
		$this->setMainFullUserData($firstName, $lastName, $gender, $birthday, $blurb);
		
		$this->timeZone = TimeZone::idOnlyConstructor($timeZone);
		
	}
	
	
	private function setPasswordData($password, $passwordVerified) {
	
		$this->password = Verifier::validatePassword($password);
		$this->passwordVerified = Verifier::validatePassword($passwordVerified);

		Verifier::validatePasswordsEqual($this->password, $this->passwordVerified);
		
	}
	
	
	public static function fullDBConstructor() {		
		
		$userSettings = new UserSettings();
		$userSettings->id = $_SESSION['user_id'];
		
		$userSettings->getFullUserFromDB();
		
		$dbc = DatabaseConnection::getDatabaseConnection();		
		
		$userSettingsQuery = "SELECT tz.id AS time_zone_id, tz.region, tz.time_zone, u.num_logins FROM user AS u, time_zone AS tz WHERE u.time_zone_id = tz.id AND u.id = '".$_SESSION['user_id']."';";

		if ($result = @mysqli_query($dbc, $userSettingsQuery)) {

			if ($userSettingsAR = mysqli_fetch_array($result)) {
							
				$userSettings->timeZone = TimeZone::fullConstructor($userSettingsAR['time_zone_id'], $userSettingsAR['region'], $userSettingsAR['time_zone']);				
				$userSettings->timeZone->updateTimeZone();
				$userSettings->numLogins = $userSettingsAR['num_logins'];		
				
			}
			
		}
		
		echo mysqli_error($dbc);
		
		return $userSettings;
		
	}
	
	
	public function save() {

		if (ExceptionsManager::getExceptionsManager()->areThereExceptions() == true)
			return false;
			
		$dbc = DatabaseConnection::getDatabaseConnection();

		$userSettingsQuery = "UPDATE user SET first_name = '" . $this->getDBFirstName() . "', last_name = '" . $this->getDBLastName() . "', gender = " . $this->getDBGender() . ", birthday = '" . $this->getDBBirthday() . "', phone = " . $this->getDBPhone() . ", email = '" . $this->getDBEmail() . "', blurb = " . $this->getDBBlurb() . ", time_zone_id = " . $this->timeZone->getID() . ", pass = SHA1(" . $this->getDBPass() . ") WHERE id = '" . $_SESSION['user_id'] . "';";
		
		$result = @mysqli_query($dbc, $userSettingsQuery);

	}
	
	
	public function saveProfileData() {
		
		if (ExceptionsManager::getExceptionsManager()->areThereExceptions() == true)
			return false;
			
		$dbc = DatabaseConnection::getDatabaseConnection();

		$userSettingsQuery = "UPDATE user SET first_name = '" . $this->getDBFirstName() . "', last_name = '" . $this->getDBLastName() . "', gender = " . $this->getDBGender() . ", birthday = " . $this->getDBBirthday() . ", blurb = " . $this->getDBBlurb() . ", time_zone_id = " . $this->timeZone->getID() . " WHERE id = '" . $_SESSION['user_id'] . "';";
		
		$result = @mysqli_query($dbc, $userSettingsQuery);
		
		while (mysqli_next_result($dbc)) {}
	}
	
	
	public function saveContactData() {
		
		if (ExceptionsManager::getExceptionsManager()->areThereExceptions() == true)
			return false;
			
		$dbc = DatabaseConnection::getDatabaseConnection();

		$userSettingsQuery = "UPDATE user SET phone = " . $this->getDBPhone() . ", email = " . $this->getDBEmail() . " WHERE id = '" . $_SESSION['user_id'] . "'";
		
		$result = @mysqli_query($dbc, $userSettingsQuery);

	}
	
	
	public function savePasswordData() {

		if (ExceptionsManager::getExceptionsManager()->areThereExceptions() == true)
			return false;
			
		$dbc = DatabaseConnection::getDatabaseConnection();

		$userSettingsQuery = "UPDATE user SET pass = SHA1(" . $this->getDBPass() . ") WHERE id = '" . $_SESSION['user_id'] . "';";

		$result = @mysqli_query($dbc, $userSettingsQuery);

	}
	
	
	public function toJSONString() {
		
		$phone = $this->phone == NULL ? '' :  $this->phone;
		$firstName = Verifier::JSONReadyName($this->firstName);
		$lastName = Verifier::JSONReadyName($this->lastName);
		$blurb = Verifier::JSONReadyText($this->blurb);
        
		$return_str = <<<EOD
		
        	"userSettings": [
				{ 
					"id": "{$_SESSION['user_id']}",
					"fn": "{$firstName}",
					"ln": "{$lastName}",
					"gn": "{$this->gender}",
					"bi": "{$this->birthday}",
					"ph": "{$phone}",
					"em": "{$this->email}",
					"bl": "{$blurb}",
					"tzr": "{$this->timeZone->getRegion()}",
					"tzz": "{$this->timeZone->getZone()}",
					"nl": "{$this->numLogins}"
				}
				
			],
EOD;

		
		return $return_str;
		
	}
	
	
	public function getDBPass() {
		
		return "'" . Verifier::dbReady($this->password) . "'";
		
	}
	
	
	public function getTimeZone() {
		
		return $this->timeZone;
		
	}
	
	


}


?>