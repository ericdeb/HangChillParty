<?php

class AutoCompleteManager {
	
	
	private static $instance = false;
	
	
	private function __construct() {
		
		$instance = true;

	}
	
	
	public static function getAutoCompleteManager() {
		
		if (!AutoCompleteManager::$instance) {
			
			AutoCompleteManager::$instance = new AutoCompleteManager();
			
		}
		
		return AutoCompleteManager::$instance;
		
	}
	
	
	
	public function getFriends($query) {
		
		$autoCompleteManagerQuery = $this->createFriendsQuery($query);
		
		if ($_SESSION['environment'] == "web")
			return $this->getFriendsText($autoCompleteManagerQuery, $query);
		else if ($_SESSION['environment'] == "android" || $_SESSION['environment'] == "iphone")
			return $this->getFriendsJSON($autoCompleteManagerQuery);
		
	}
	
	
	private function getFriendsText($autoCompleteManagerQuery, $query) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$returnMainString = "{ query: " . '"' . $query . '", suggestions:[';

		$returnDataString = '';
																																																																																																																																																																																																	
		if ($result = @mysqli_query($dbc, $autoCompleteManagerQuery)) {
				
			while ($usersAR = mysqli_fetch_array($result)) {
				
				$returnMainString .= "'" . $usersAR['first_name'] . ' ' . $usersAR['last_name'] . "',";
				$returnDataString .= "'" . $usersAR['id'] . "',";
				
			}
			
		}
		
		return substr($returnMainString, 0, strlen($returnMainString)-1) . "], data:[" . substr($returnDataString, 0, strlen($returnDataString)-1) . '] }';
		
	}
	
	
	private function getFriendsJSON($autoCompleteManagerQuery) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$return_str = '"Suggestions": [';
																																																																																																																																																																																																	
		if ($result = @mysqli_query($dbc, $autoCompleteManagerQuery)) {
				
			while ($usersAR = mysqli_fetch_array($result)) {
				
				$firstName = $usersAR['first_name'];
				$lastName = $usersAR['last_name'];
				$id = $usersAR['id'];
				
				$return_str .= <<<EOD
		
				{ 
					"fn": "{$firstName}",
					"ln": "{$lastName}",
					"id": "{$id}"
				},
				
EOD;
				
			}
			
		}
		
		$return_str .= '],';
		
		return $return_str;
		
	}
	
	public function createFriendsQuery($query) {
		
		$query = Verifier::validateText($query);
		
		if (ExceptionsManager::getExceptionsManager()->areThereExceptions() == true)
			return false;
		
		$autoCompleteManagerQuery = "SELECT u.id, u.first_name, u.last_name FROM user AS u JOIN(SELECT f.friend_id FROM friend AS f, user AS u WHERE f.user_id = '" . $_SESSION['user_id'] . "' AND f.friend_id = u.id AND (MATCH(u.first_name) AGAINST ('" . $query . "*' IN BOOLEAN MODE) OR MATCH(u.last_name) AGAINST ('" . $query . "*' IN BOOLEAN MODE))) AS f ON f.friend_id = u.id WHERE (u.first_name LIKE '%" . $query . "%' OR u.last_name LIKE '%" . $query . "%')";
		
		return $autoCompleteManagerQuery;	
		
	}
	
}

?>