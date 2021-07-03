<?php

abstract class FullUser extends User {
	
	protected $gender;
	protected $birthday;
	protected $phone;
	protected $email;
	protected $blurb;


	public function getFullUserFromDB() {
									  
		$dbc = DatabaseConnection::getDatabaseConnection();		
		
		$fullUserQuery = "SELECT u.id, u.first_name, u.last_name, u.gender, u.birthday, u.phone, u.email, u.blurb FROM user AS u
		
		WHERE u.id = '". $this->id ."';";

		if ($result = @mysqli_query($dbc, $fullUserQuery)) {

			if ($fullUserAR = mysqli_fetch_array($result)) {
				
				$this->setMainFullUserData($fullUserAR['id'], $fullUserAR['first_name'], $fullUserAR['last_name'], $fullUserAR['gender'], $fullUserAR['birthday'],$fullUserAR['blurb']);
				$this->setContactFullUserData($fullUserAR['phone'], $fullUserAR['email']);	
				
			}
			
		}
		
	}
	
	
	public function setMainFullUserData($firstName, $lastName, $gender, $birthday, $blurb) {
		
		$this->firstName = Verifier::ValidateName($firstName);
		$this->lastName = Verifier::ValidateName($lastName);
		$this->gender = Verifier::validateBoolean($gender);
		$this->birthday = Verifier::validateBirthday($birthday);
		$this->blurb = Verifier::validateBlurb($blurb);
		
	}
	

	public function setContactFullUserData($phone, $email) {
			
		$this->phone = Verifier::validatePhone($phone);
		$this->email = Verifier::validateEmail($email);
		
	}
	
	
	public function getDBGender() {
		
		return Verifier::dbReady($this->gender);
		
	}
	
	
	public function getDBBirthday() {
		
		return $this->birthday != NULL ? "'" . Verifier::dbReady($this->birthday) . "'" : "NULL";
		
	}
	
	
	public function getDBPhone() {
		
		return $this->phone != NULL ? "'" . Verifier::dbReady($this->phone) . "'" : "NULL";
		
	}
	
	
	public function getDBEmail() {
		
		return "'" . Verifier::dbReady($this->email) . "'";
		
	}
	
	
	public function getDBBlurb() {
		
		return $this->blurb != NULL ? "'" . Verifier::dbReady($this->blurb) . "'" : "NULL";
		
	}
	
	
}

?>