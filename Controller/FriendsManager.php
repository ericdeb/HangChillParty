<?php

class FriendsManager {
	
	
	private static $instance = false;
	private $availableFriends = array();
	private $allFriendsList = array();
	
	
	private function __construct() {
		
		$instance = true;

	}
	
	
	public static function getFriendsManager() {
		
		if (!FriendsManager::$instance) {
			
			FriendsManager::$instance = new FriendsManager();
			
		}
		
		return FriendsManager::$instance;
		
	}
	
	
	public function friendsTest($id) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
	
		$friendsManagerQuery = "SELECT friend_id FROM friend WHERE friend_id = " . $id . " AND user_id = " . $_SESSION['user_id'];

		if ($result = @mysqli_query($dbc, $friendsManagerQuery)) {

			if (mysqli_num_rows($result) > 0)
				return true;
			else
				return false;
			
		}
		
	}
	
	
	public function getAvailableFriends() {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		if ($this->availableFriends != NULL) 
			return $this->availableFriends;
			
		$friendsManagerQuery = "SELECT u.id, u.first_name, u.last_name, IF(s.user_id IS NULL, 0, 1) AS status_check FROM user AS u LEFT OUTER JOIN(SELECT user_id, MAX(time_start) AS time_start FROM status WHERE TIME_FORMAT(TIMEDIFF('" . Time::getNowUnivTime() . "', time_start), '%m%d%k%i%s') BETWEEN 0 AND 50000 AND canceled = 0 GROUP BY user_id) AS s ON s.user_id = u.id, friend AS f WHERE f.user_id = '" . $_SESSION['user_id'] . "' AND f.friend_id = u.id";
		
		if ($result = @mysqli_query($dbc, $friendsManagerQuery)) {

			while ($friendsAR = mysqli_fetch_array($result)) {
				
				$friend = new BasicUser($joinedUsersAR['id'], $joinedUsersAR['first_name'], $joinedUsersAR['last_name'], $joinedUsersAR['status_check']);
				
				array_push($this->availableFriends, $friend);
				
			}
			
		}
		
		return $this->availableFriends;
		
	}
	
	
	public function getAvailableFriendsJSON() {
		
		$return_str = '"Friends": [';
		
		foreach($availableFriends as $friend) {
			
			$return_str .= $friend->toPartJSONString();
			
		}
		
		$return_str .= ']';
			
		return $return_str;
		
	}
	
	
	public function deleteFriend($id) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$friendsManagerQuery = "DELETE lv.* FROM list AS l, list_value AS lv WHERE l.id = lv.list_id AND l.user_id = '" . $_SESSION['user_id'] . "' AND lv.friend_id = " . $id . ";";
		$friendsManagerQuery .= "DELETE friend.* FROM friend WHERE (user_id = '" . $_SESSION['user_id'] . "' AND friend_id = " . $id . ") OR (friend_id = '" . $_SESSION['user_id'] . "' AND user_id = " . $id . ");"; 
		
		$multiResult = @mysqli_multi_query($dbc, $friendsManagerQuery);	
		
		while (mysqli_next_result($dbc)) {}
		
	}
	
	
	private function getAllFriends() {
		
		if ($this->allFriendsList != NULL)
			return $this->allFriendsList;
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$friendsManagerQuery = "SELECT u.id, u.first_name, u.last_name FROM user AS u, friend AS f WHERE f.user_id = '" . $_SESSION['user_id'] . "' AND f.friend_id = u.id ORDER BY u.first_name ASC;";
		
		if ($result = @mysqli_query($dbc, $friendsManagerQuery)) {

			while ($friendsAR = mysqli_fetch_array($result)) {
				
				$friend = BasicUser::fullConstructor($friendsAR['id'], $friendsAR['first_name'], $friendsAR['last_name'], NULL);
				
				array_push($this->allFriendsList, $friend);
				
			}
			
		}
		
		return $this->allFriendsList;
		
	}
	
	
	public function getAllFriendsJSON() {
		
		$friendsList = $this->getAllFriends();
		
		$return_str = '"Friends": [';
		
		foreach ($friendsList as $friend) {
				
			$return_str .= $friend->toPartJSONString();
			
		}
		
		$return_str .= '],';
		
		return $return_str;
		
	}
	
	
	
	
}

?>