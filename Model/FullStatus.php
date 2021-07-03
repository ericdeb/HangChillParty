<?php

abstract class FullStatus extends Status{
	
	protected $place;
	protected $activity;
	protected $partyID;
	protected $light;
	protected $joinedUsers = array();	
	
	
	public function joinedUsersToJSONString() {
		
		$return_str = '"JoinedUsers": [';
		
		foreach ($this->joinedUsers as $joinedUser) {
			
			$id = $joinedUser->getID();
			$firstName = Verifier::JSONReadyName($joinedUser->getFirstName());
			$lastName = Verifier::JSONReadyName($joinedUser->getLastName());
			
			$return_str .= <<<EOD
		
				{ 
					"id": "{$id}",
					"fn": "{$firstName}",
					"ln": "{$lastName}"
				},
				
EOD;
			
		}
		
		$return_str .= '],';
		
		return $return_str;
		
	}
	
	public function getJoinedUsers() {
		
		if ($this->joinedUsers != NULL)
			return $this->joinedUsers;
			
		$dbc = DatabaseConnection::getDatabaseConnection();
			
			//first join is to check if this user is your friend
			
		$fullStatusQuery = "SELECT s.user_id, u.first_name, u.last_name, IF(f.friend_id IS NOT NULL, 1, 0) AS friend_check FROM status AS s, user AS u 
		
			LEFT OUTER JOIN (SELECT friend_id FROM friend WHERE user_id = '" . $_SESSION['user_id'] . "') AS f ON f.friend_id = u.id 
			
		WHERE s.user_id = u.id AND s.canceled = 0 AND s.joined_with = " . $this->id;
		
		if ($result = @mysqli_query($dbc, $fullStatusQuery)) {

			while ($joinedUsersAR = mysqli_fetch_array($result)) {
						
				$joinedUser = BasicUser::fullConstructor($joinedUsersAR['user_id'], $joinedUsersAR['first_name'], $joinedUsersAR['last_name'], $joinedUsersAR['friend_check']);
						
				array_push($this->joinedUsers, $joinedUser);
						
			}
				
		}
		
		return $this->joinedUsers;
		
	}

	
}

?>