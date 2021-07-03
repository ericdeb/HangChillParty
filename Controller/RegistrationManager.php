<?php

class RegistrationManager {
	
	private $userSettings;
	private $facebookSynced;
	
	public function __construct($userSettings, $facebookSynced) {
		
		$this->userSettings = $userSettings;
		$this->facebookSynced = Verifier::validateBoolean($facebookSynced) == 1 ? true : false;
		
	}
	
	
	public function registerUser() {
		
		if (ExceptionsManager::getExceptionsManager()->areThereExceptions() == true)
			return false;
			
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$registrationManagerQuery = "INSERT INTO user (first_name, last_name, gender, birthday, phone, email, blurb, pass, registration_date, time_zone_id, alerts_update_time) VALUES ('" . $this->userSettings->getDBFirstName() . "','" . $this->userSettings->getDBLastName() . "'," . $this->userSettings->getDBGender() . "," . $this->userSettings->getDBBirthday() . "," . $this->userSettings->getDBPhone() . "," . $this->userSettings->getDBEmail() . "," . $this->userSettings->getDBBlurb() . "SHA1(" . $this->userSettings->getDBPass() . "),'" . Time::getNowUnivTime() . "'," . $this->userSettings->getTimeZone()->getID() . ",'" . Time::getNowUnivTime() . "');";
																																																																																																																																																																																																																																																																				
		$result = @mysqli_query($dbc, $registrationManagerQuery);
		
		
		$registrationManagerQuery = "SELECT id FROM user WHERE email = " . $this->userSettings->getDBEmail();

		if ($result = @mysqli_query($dbc, $registrationManagerQuery)) {

			if ($idAR = mysqli_fetch_array($result)) {
		
				LoginManager::getLoginManager()->initializeSessionVariablesRegister($idAR['id']);
				
				StatisticsManager::getStatisticsManager()->incrementNumberWhoRegisterStatistic();
				
				if ($this->facebookSynced == true)
					FacebookManager::getFacebookManager()->syncAccounts();
					
				UserImage::tryTransferRegisterImage();
				
			}
		}
		
	}
	
	
	public static function checkIfEmailExistsJSON($email) {
		
		$resultBool = Verifier::isEmailUnique($email);
		
		$response = $resultBool == true ? 1 : 0;
		
		$return_str = <<<EOD
			"emailStatus": [
				{ 
					"em": "{$response}",
				},	
			],			
EOD;

		return $return_str;	
		
	}
	
	
}


?>