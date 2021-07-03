<?php

class BasicUser extends User{
	
	private $status;
	private $gender;
	
	private function __construct() {
		
	}
	
	public static function fullConstructor($id, $first_name, $last_name, $status) {
		
		$basicUser = new BasicUser();
		
		$basicUser->id = $id;
		$basicUser->firstName = $first_name;
		$basicUser->lastName = $last_name;
		$basicUser->status = $status;
		
		return $basicUser;
		
	}


	public static function dbConstructor($id) {

		  $basicUser = new BasicUser();

		  $dbc = DatabaseConnection::getDatabaseConnection();

		  $basicUserQuery = "SELECT first_name, last_name FROM user WHERE id = " . $id;


		  if ($result = @mysqli_query($dbc, $basicUserQuery )) {

				if ($userAR = mysqli_fetch_array($result)) {
			
				   $basicUser->id = $id;
				   $basicUser->firstName = $userAR['first_name'];
				   $basicUser->lastName = $userAR['last_name'];
			
				}
		
		  }

		  return $basicUser;              

	}	
	
	
	public function getID() {
		
		return $this->id;
		
	}
	
	
	public function getFirstName() {
		
		return $this->firstName;
		
	}
	
	
	public function getLastName() {
		
		return $this->lastName;
		
	}
	
	
	public function getStatus() {
		
		return $this->status;
		
	}
	
	
	public function getGender() {
	
		if ($this->gender != NULL)
			return $this->gender;
	   
	    $basicUserQuery = "SELECT gender FROM user WHERE id = " . $this->id;	
	
		if ($result = @mysqli_query($dbc, $basicUserQuery )) {
	
			  if ($userAR = mysqli_fetch_array($result)) {
		  
				 $this->gender = $userAR['gender'];
				 
			  }
	  
		}
	
		return $this->gender; 
		  
	}
	
	
	public function toFullJSONString() {
		
		return '"User": [' . $this->toPartJSONString() . '],';
		
	}
	
	
	public function toPartJSONString() { 
	
		$firstName = Verifier::JSONReadyName($this->firstName);
		$lastName = Verifier::JSONReadyName($this->lastName);
	
		$return_str = <<<EOD
		
				{ 
					"id": "{$this->id}",
					"fn": "{$firstName}",
					"ln": "{$lastName}",
					"st": "{$this->status}"
				},
				
EOD;

		return $return_str;
	
	}
	

}

?>