<?php

$test = new User("ted", "kennedy");

class User{
	
	private static $numUsers = 0;
	private $first_name;
	private $last_name;
	private $password;

	/*Could throw exceptions here or return error message.  Should use mysql validation if interacting with DB*/
	public static function isValidPassword($password) {

		if ($password != trim(strip_tags($password)))
			return false;

		if (!preg_match("/^[A-Za-z][A-Za-z]*[\s|\-]{0,1}[A-Za-z]*$/", $password))
			return false;

		if (strlen($password) < 5 || strlen($password) > 20)
			return false;
	}
	
	public function __construct($first_name, $last_name) {
		
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$numUsers++;

	}

	public function __get($property) {
		if (property_exists($this, $property))
			return $this->$property;
	}

	public function __set($property, $val) {
		if (property_exists($this, $property)) {
			$this->$property = $val;
		}
	}

}

?>