<?php

class Verifier {


	private static function removeExtras($input) {
		
		return trim(strip_tags($input));		
		
	}
	
	private static function decodeText($text) {
		
		return utf8_decode(urldecode($text));
		
	}
	
	private static function encodeText($text) {
		
		return utf8_encode($text);
		
	}
	

	public static function validateNumber($number) {

		if ($number == '0') 
			return $number;
			
		if ($number == NULL)
			return NULL;	
			
		if ($number == "null")
			return NULL;
		
		$number = Verifier::removeExtras($number);
		
		try {
			
			if (!is_int(intval($number)))
				throw new ValidationException("A number received was invalid", 0);
		
		}
		
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $number;
		
	}
	
	
	public static function validateText($text) {
		
		if ($text == 'null')
			return NULL;
		
		$text = Verifier::removeExtras($text);
		$text = str_replace("\\'","'",$text);
		
		try {
			
			if (!is_string($text))
				throw new ValidationException("A text value received was invalid", 1);
		
		}
		
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $text;
		
	}
	
	
	public static function validateListName($listName) {
		
		$listName = Verifier::decodeText(Verifier::validateText($listName));
		
		try {
			
			if (!preg_match("/^[A-Za-z0-9]*[A-Za-z0-9\s]?[A-Za-z0-9]*[A-Za-z0-9\s]?[A-Za-z0-9]*$/", $listName))
				throw new ValidationException("List names can only contain letters and numbers", 2);
			else if (strlen($listName) == 0 || strlen($listName) > 30)
				throw new ValidationException("List name must be between 1 and 30 characters", 2);
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $listName;
		
		
	}
	
	
	public static function validateTime($timeValue) {
		
		if ($timeValue == 'null')
			return NULL;	
		
		$timeValue = Verifier::validateText($timeValue);
		
		try {

			if (!preg_match("/^[1-2][09][0-5][0-9]-(0[0-9])|(1[12])-([0-2][0-9])|(3[01])\s[0-1][0-9]:[0-5][0-9]:[0-5][0-9]$/", $timeValue))
				throw new ValidationException("A time value received was not valid", 3);
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $timeValue;		
		
	}
	
	
	public static function validateNumberArray($numberAR) {
		
		if ($numberAR == 'null')
			return NULL;
		
		$numberAR = Verifier::validateText($numberAR);
		
		try {
			
			if (!preg_match("/^([0-9]*,)*[0-9]*$/", $numberAR))
				throw new ValidationException("An array received was not valid", 4);
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $numberAR;		
		
	}
	
	
	public static function dbReady($input) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$input = str_replace("'","''",$input);
		
		return mysqli_real_escape_string($dbc, $input);
		
	}
	
	
	private static function JSONReadyQuotes($input) {
	
		$from_ar = array('"', "''");
		$to_ar = array('\"', "'");
	
		return str_replace($from_ar,$to_ar,$input);
		
	}
	
	
	public static function JSONReadyName($name) {
		
		return Verifier::encodeText($name);
		
	}
	
	
	public static function JSONReadyText($text) {
		
		return Verifier::encodeText(Verifier::JSONReadyQuotes($text));
		
	}
	
	public static function getOrPostCheck($getOrPostAR) {
		
		try {
			
			foreach($getOrPostAR as $getOrPostValue) {
			
				if (!isset($_GET[$getOrPostValue]) && !isset($_POST[$getOrPostValue]))
					throw new ValidationException("One or more inputs were not sent correctly", 4);
					
			}
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
	}
	
	
	public static function validateMax($max) {
		
		if ($max == 'null')
			return NULL;			
		
		$max = Verifier::validateNumber($max);
		
		try {
			
			if ($max < 0 || $max > 999)
				throw new ValidationException("Max number is invalid, must be between 0 and 999");
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $max;
		
	}
	
	
	public static function validateEmail($email) {
		
		if ($email == 'null') 
			return NULL;
			
		$email = Verifier::validateText($email);
		
		try {
			
			if (!preg_match("/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/", $email))
				throw new ValidationException("Email is invalid.");
				
			if (strlen($email) > 35)
				throw new ValidationException("Email must be shorter than 35 characters.");
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $email;
		
	}
	
	
	public static function validatePassword($password) {
		
		if ($password == 'null') 
			return NULL;
		
		$password = Verifier::decodeText($password);
		$password = Verifier::validateText($password);
		
		
		try {
			
			if (strlen($password) < 5)
				throw new ValidationException("Password is too short.");
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $password;
		
	}
	
	
	public static function validateBoolean($boolean) {
		
		if ($boolean == "null")
			$boolean = 0;
		
		try {
			
			if ($boolean != 0 && $boolean != 1)
				throw new ValidationException("A value received was incorrect");
		
		}
		
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $boolean;
		
	}
	
	
	public static function validateBirthday($birthday) {
		
		if ($birthday == 'null') 
			return NULL;
		
		$birthday = Verifier::validateText($birthday);
		
		try {
			
			if (!preg_match("/^[1-2][09][0-9][0-9]-(0[0-9])|(1[012])-([0-2][0-9])|(3[01])$/", $birthday))
				throw new ValidationException("The birthday received was invalid", 4);
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $birthday;				
		
	}
	
	
	public static function validatePhone($phone) {
		
		if ($phone == 'null')
			return NULL;
			
		$phone = Verifier::validateText($phone);
		
		try {
			
			if (!preg_match("/^[1-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]$/", $phone))
				throw new ValidationException("The phone number received was invalid", 4);
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $phone;				
		
	}
	
	
	public static function validateObject($object) {
		
		if ($object == NULL)
			return NULL;
			
		try {
			
			if (!is_object($object))
				throw new ValidationException("An object created was invalid", 4);
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $object;				
		
	}
	
	
	public static function validateName($name) {
		
		if ($name == NULL)
			return NULL;
		
		$name = Verifier::decodeText($name);
		
		try {
			
			if (!preg_match("/^[A-Za-z][A-Za-z]*[\s|\-]{0,1}[A-Za-z]*$/", $name))
				throw new ValidationException("Names can only contain letters and numbers", 2);
			else if (strlen($name) == 0 || strlen($name) > 30)
				throw new ValidationException("Name must be between 1 and 30 characters", 2);
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		$name = strtoupper(substr($name, 0, 1)) . substr($name, 1);
		
		return $name;
		
	}
	
	
	public static function validateClass($class) {

		if ($class == 'null' || $class == "")
			return NULL;
		
		$class = Verifier::validateNumber($class);
		
		try {
			
			if ($class < 1975 || $class > 2050)
				throw new ValidationException("A class year submitted was invalid.");
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $class;
		
	}
	
	
	public static function validatePasswordsEqual($passwordOne, $passwordTwo) {
		
		try {
			
			if ($passwordOne != $passwordTwo)
				throw new ValidationException("The two passwords submitted are not equal.");
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
	}
	
	
	public static function validateDistance($distance) {
		
		if ($distance == NULL)
			return NULL;			
		
		$distance = Verifier::validateNumber($distance);
		
		try {
			
			if ($distance < 0 || $distance > 999)
				throw new ValidationException("Distance is invalid, must be between 0 and 999");
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $distance;
		
	}
	
	
	public static function cookieCheck($cookieAR) {
		
		try {
			
			foreach($cookieAR as $cookie) {
			
				if (!isset($_COOKIE[$cookie]))
					throw new ValidationException("A cookie needed is not set", 4);
					
			}
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
	}
	
	
	public static function validateRememberMe($rememberMeKey) {
		
		try {

			if (!preg_match("/^[A-Za-z0-9]{30,30}$/", $rememberMeKey))
				throw new ValidationException("Remember me element is invalid", 4);
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
	}
	
	
	public static function validateDimension($dimension) {
		
		$dimension = Verifier::validateNumber($dimension);
		
		try {

			if ($dimension < 10 || $dimension > 1000)
				throw new ValidationException("Image dimension is invalid", 4);
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $dimension;
		
	}
	
	
	public static function validateFileSet() {
		
		try {

			if (!isset($_FILES['upload']))
				throw new ValidationException("The uploaded file was not received", 4);
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
	}
	
	
	public static function validateImageType() {
		
		Verifier::validateFileSet();
		
		try {

			$allowed = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png', 'image/gif', 'image/GIF');
			
			if (!in_array($_FILES['upload']['type'], $allowed))
				throw new ValidationException("Uploaded images can only be jpg, png, or gif extensions", 4);
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
	}
	
	
	public static function validateImageCreated($image) {
		
		try {

			if (!$image)
				throw new ValidationException("Image upload failed.  Try again.", 4);
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
	}
	
	
	public static function checkForDuplicateFriendRequests($requesterID, $receiverID, $status) {
		
		try {

			$dbc = DatabaseConnection::getDatabaseConnection();
			
			$verifierQuery = "SELECT status FROM user_friend_request WHERE requesterID = " . $requesterID . " AND receiverID = " . $receiverID;
			
			if ($result = @mysqli_query($dbc, $verifierQuery)) {
				
				if (mysqli_num_rows($result) == 0)
					return;

				if ($friendRequestAR = mysqli_fetch_array($result)) {
					
					$dbStatus = $friendRequestAR['status'];
					
					if (($dbStatus == 0 && $status == 0) || $dbStatus == 1 || $dbStatus == 2)
						throw new ValidationException("Invalid friend request submission.", 4);
					
				}
				
			}
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
	}
	
	
	public static function checkForDuplicateUsers($id) {
		
		try {

			if ($id == $_SESSION['user_id'])
				throw new ValidationException("ID submitted cannot be the same as user's id.", 4);
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
	}
	
	
	public static function validateEmailArray($emailAR) {
		
		try {

			if (preg_match("/^([A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4},)+$/", $emailAR . ",") == 0)
				throw new ValidationException("The email list received was invalid", 4);
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $emailAR;
		
	}
	
	
	public static function validateGeneralFriendsType($type) {
		
		try {

			if ($type != "generalFriends" && $type != "mutualFriends")
				throw new ValidationException("The search type received was invalid", 4);
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $type;
		
	}
	
	
	public static function validateCurrentPassword($currentPassword) {
		
		try {

			$dbc = DatabaseConnection::getDatabaseConnection();
			
			$verifierQuery = "SELECT id FROM user WHERE pass = SHA1('" . $currentPassword . "') AND id = " . $_SESSION['user_id'];

			if ($result = @mysqli_query($dbc, $verifierQuery)) {
				
				if (mysqli_num_rows($result) == 0)
					throw new ValidationException("Password submitted was incorrect.", 4);
			}
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $currentPassword;
		
	}
	
	
	public static function verifyStatusNotCanceled($statusID) {
		
		try {

			$dbc = DatabaseConnection::getDatabaseConnection();
			
			$verifierQuery = "SELECT canceled FROM status WHERE id = " . $statusID;

			if ($result = @mysqli_query($dbc, $verifierQuery)) {
				
				if ($statusAR = mysqli_fetch_array($result)) {

					if ($statusAR['canceled'] == 1)
						throw new ValidationException("Update has been canceled.", 4);
					
				}
				else
					throw new ValidationException("Update has been canceled.", 4);
					
			}
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
	
	
	}
	
	
	
	public static function validateBlurb($blurb) {
		
		$blurb = Verifier::decodeText($blurb);
		$blurb = Verifier::validateText($blurb);
		
		try {

			if (strlen($blurb) > 70)
				throw new ValidationException("Quickie must be shorter than 70 characters", 4);
				
		}
				
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $blurb;
		
	}
	
	
	public static function isEmailUnique($email) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$resultBool = true;
		
		$verifierQuery = "SELECT id FROM user WHERE email = '" . $email . "'";

		try {
			
			if ($result = @mysqli_query($dbc, $verifierQuery)) {
				
				if ($emailAR = mysqli_fetch_array($result)) {
					
					if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $emailAR['id']) {
						
						$resultBool = false;
					
						throw new ValidationException("Email is already in use", 4);
					
					}
					
				}
					
			}
			
		}
		
		catch (validationException $e) {
			
			ExceptionsManager::getExceptionsManager()->handleException($e);
			
		}
		
		return $resultBool;		
		
	}
		

	
}

?>