<?php

class UpdatesManager {
	
	
	private static $instance = false;
	private $newUpdates = array();
	
	
	private function __construct() {
		
		$instance = true;

	}
	
	
	public static function getUpdatesManager() {
		
		if (!UpdatesManager::$instance) {
			
			UpdatesManager::$instance = new UpdatesManager();
			
		}
		
		return UpdatesManager::$instance;
		
	}
	
	
	public function getNewUpdates() {
		
		if ($this->newUpdates != NULL)
			return $this->newUpdates;
		else if ($_SESSION['environment'] == "web")
			return $this->getNewUpdatesWeb();
		else if ($_SESSION['environment'] == "iphone" || $_SESSION['environment'] == "android")
			return $this->getNewUpdatesSmartphone();
		
	}
	
	
	public function getNewUpdatesJSON() {
		
		$newUpdates = $this->getNewUpdates();
		
		$return_str = '"Updates": [';
		
		foreach ($newUpdates as $update) {
				
			$return_str .= $update->toPartJSONString();
			
		}
		
		$return_str .= ']';
		
		return $return_str;
		
	}
	
	
	public function getAllUpdatesJSON() {
		
		$_SESSION['lastUpdateTimeUpdates'] = Time::getFiveHoursAgoUnivMicroTime();
		getNewUpdatesJSON();
		
	}
	
	
	public function getUpdateJSON($userID, $friendBool) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		/*
		-First join gets your friend's current status
			-First subjoin gets current statuses time start which is joined to get the actual status
		-Second join gets your light (or list) value in relation to your friend's status.				
		*/
		
		$updatesManagerQuery = "SELECT u.id, u.first_name, u.last_name, s2.social_rating, s.id AS status_id, s.time_start, s.time_end, s.update_time, IFNULL(s3.cnt, 0) AS joined_count, sl.place, sl.activity, sl.max_people, sl.max_guys, sl.max_girls, sl.light, l.value, s2.id AS friend_id, s2.first_name AS friend_first_name, s2.last_name AS friend_last_name FROM user AS u, status AS s
		
		JOIN(SELECT IFNULL(s.joined_with, s.id) AS status_id, u.id, u.first_name, u.last_name, u.social_rating FROM status AS s
						   
			JOIN(SELECT user_id, MAX(time_start) AS time_start FROM status WHERE TIME_FORMAT(TIMEDIFF('" . Time::getNowUnivTime() . "', time_start), '%m%d%k%i%s') BETWEEN 0 AND 50000 AND canceled = 0 GROUP BY user_id) AS s2 ON (s2.time_start = s.time_start AND s2.user_id = s.user_id)
																																																										
		, user AS u WHERE s.user_id = " . $userID . " AND s.user_id = u.id) AS s2 ON s2.status_id = s.id
		
		LEFT OUTER JOIN (SELECT joined_with, COUNT(*) AS cnt FROM status WHERE canceled = 0 GROUP BY joined_with) AS s3 ON s3.joined_with = s.id
		
		LEFT OUTER JOIN (SELECT IFNULL(s.joined_with, s.id) AS status_id, COUNT(*) AS friends_joined FROM status AS s, friend AS f WHERE f.user_id = '" . $_SESSION['user_id'] . "' AND (f.friend_id = s.user_id OR s.user_id = '" . $_SESSION['user_id'] . "') AND s.canceled = 0 GROUP BY status_id) AS s4 ON s4.status_id = s.id,
		
		status_leader AS sl
		
		LEFT OUTER JOIN (SELECT list_id, value FROM list_value WHERE friend_id = '" . $_SESSION['user_id'] . "') AS l ON l.list_id = sl.list_id
		
		WHERE s.user_id = u.id AND sl.status_id = s.id AND s4.friends_joined > 0;";

		if ($result = @mysqli_query($dbc, $updatesManagerQuery)) {

			if ($updatesAR = mysqli_fetch_array($result)) {
				
				$update = $this->constructUpdateFromDB($updatesAR);

				$joinedUsers = $update->getJoinedUsers();
				
				$currentStatus = StatusManager::getStatusManager()->getCurrentStatus();
				
				$curID = 0; $joinedWithID = 0;
				
				if ($currentStatus != NULL) {
					
					$curID = $currentStatus->getID();
					$joinedWithID = $currentStatus->isLeaderStatus() == false ? $currentStatus->getJoinedWithID() : 0;
					
				}
				
				$updID = $update->getID();
					
				if ($updID == $curID || $updID == $joinedWithID) 
					$update->setYourStatusBoolean(true);


				return $update->toFullJSONString();
					
				return NULL;
				
			}
			
		}
	
		
	}
	
	
	public function constructUpdateFromDB($updatesAR) {
		
		$groupLeader = BasicUser::fullConstructor($updatesAR['id'], $updatesAR['first_name'], $updatesAR['last_name'], NULL);
		$timeStart = Time::convertToUserTimeZone($updatesAR['time_start']);
		$timeEnd = $updatesAR['time_end'] != NULL ? Time::convertToUserTimeZone($updatesAR['time_end']) : NULL;
		$updateTime = Time::convertMicroToUserTimeZone($updatesAR['update_time']); 
		$friend = NULL; 
		$joinedCount = !isset($updatesAR['joined_count']) ? 0 : $updatesAR['joined_count'];

		//joined coint could be null, and if it's one, then it is actually 0 EXCEPT when it is your status.
		//Also note that in Update::setYourStatusBoolean this count is increased by 1 if it is your status.
		//$joinedCount = (!isset($updatesAR['joined_count']) || $updatesAR['joined_count'] == 1) ? 0 : $updatesAR['joined_count']-1;
		$canceled = isset($updatesAR['canceled']) ? $updatesAR['canceled'] : NULL;

		if ($updatesAR['id'] != $updatesAR['friend_id']) {

			$friend = BasicUser::fullConstructor($updatesAR['friend_id'], $updatesAR['friend_first_name'], $updatesAR['friend_last_name'], NULL);
			
			//$joinedCount--;
			
		}
		
		if (isset($updatesAR['light'])) {
			if ($updatesAR['light'] != 0)
				$light = $updatesAR['light'];
			else if ($updatesAR['value'] != NULL)
				$light = $updatesAR['value'];
			else 
				$light = 2;			
		}
		else
			$light = NULL;
		
				
		$update = Update::fullConstructor($updatesAR['status_id'], $timeStart, $timeEnd, $updatesAR['place'], $updatesAR['activity'], $light, $groupLeader, $friend, $updateTime, $joinedCount, $canceled, NULL, $updatesAR['social_rating']);
		
		return $update;
		
	}
	
	
	private function setYourStatusBooleanValues() {
		
		$currentStatus = StatusManager::getStatusManager()->getCurrentStatus();
		$curID = $currentStatus->getID();
		$joinedWithID = $currentStatus->isLeaderStatus() == false ? $currentStatus->getJoinedWithID() : 0;
		
		$retVar = NULL;
		
		for ($i = 0; $i < count($this->newUpdates); $i++) {
			
			$updID = $this->newUpdates[$i]->getID();
			
			if ($updID == $curID || $updID == $joinedWithID) {
				$this->newUpdates[$i]->setYourStatusBoolean(true);
				
				$currentSocialRating = SocialMeter::getYourCurrentSocialRating();
				
				$this->newUpdates[$i]->setYourSocialRating($currentSocialRating);
				
				$retVar = $i;
				
			}
			else
				$this->newUpdates[$i]->setYourStatusBoolean(false);
			
		}
		
		return $retVar;		
		
	}
	
	
	private function getNewUpdatesWeb() {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		/*
		-First join gets all your friends statuses, whether they have created it or are joined with it.  It also gets your friend's info (first name, last name) that represents your assocation to the status in case the leader is not your friend.
		-Second join gets a count of the number of people joined with a status
		-Third join gets total number of friends joined with update
			-Third subjoin gets joined_with id or actual id if friend is leader of group
				-Third sub-subjoin gets all friend's current status updates where canceled = 0, that is their actual current updates.
		-Fourth join gets your light (or list) value in relation to your friend's status.				
		*/
		
		$updatesManagerQuery = "SELECT u.id, u.first_name, u.last_name, IF(s2.canceled = 1, u.social_rating, s2.social_rating) AS social_rating, s.id AS status_id, s.time_start, s.time_end, IF (s4.friends_joined IS NULL, 1, s.canceled) AS canceled, s.update_time, IFNULL(s3.cnt, 0) AS joined_count, sl.place, sl.activity, sl.max_people, sl.max_guys, sl.max_girls, sl.light, l.value, IF(s2.canceled = 1, NULL, s2.id) AS friend_id, IF(s2.canceled = 1, NULL, s2.first_name) AS friend_first_name, IF(s2.canceled = 1, NULL, s2.last_name) AS friend_last_name FROM user AS u, status AS s
		
		JOIN(SELECT IFNULL(s.joined_with, s.id) AS status_id, u.id, u.first_name, u.last_name, u.social_rating, s.canceled FROM status AS s, user AS u 
						   
			LEFT OUTER JOIN (SELECT friend_id FROM friend WHERE user_id = '" . $_SESSION['user_id'] . "') AS f ON f.friend_id = u.id 
			
		WHERE (u.id = '" . $_SESSION['user_id'] . "' OR (s.user_id = f.friend_id AND f.friend_id IS NOT NULL)) AND s.user_id = u.id AND s.update_time - " . $_SESSION['lastUpdateTimeUpdates'] . " > 0 GROUP BY status_id) AS s2 ON s2.status_id = s.id
		
		LEFT OUTER JOIN (SELECT joined_with, COUNT(*) AS cnt FROM status WHERE canceled = 0 GROUP BY joined_with) AS s3 ON s3.joined_with = s.id
		
		LEFT OUTER JOIN (SELECT IFNULL(s.joined_with, s.id) AS status_id, COUNT(*) AS friends_joined FROM status AS s
																				
			LEFT OUTER JOIN (SELECT friend_id FROM friend WHERE user_id = '" . $_SESSION['user_id'] . "') AS f ON f.friend_id = s.user_id
			
		WHERE (f.friend_id IS NOT NULL OR s.user_id = '" . $_SESSION['user_id'] . "') AND s.canceled = 0 GROUP BY status_id) AS s4 ON s4.status_id = s.id, 
		
		status_leader AS sl 
		
		LEFT OUTER JOIN (SELECT list_id, value FROM list_value WHERE friend_id = '" . $_SESSION['user_id'] . "') AS l ON l.list_id = sl.list_id		
		
		WHERE s.user_id = u.id AND sl.status_id = s.id ORDER BY s.canceled DESC, s.update_time ASC;";
		
		if ($result = @mysqli_query($dbc, $updatesManagerQuery)) {

			while ($updatesAR = mysqli_fetch_array($result)) {
				
				$update = $this->constructUpdateFromDB($updatesAR);
				
				array_push($this->newUpdates, $update);
				
			}
			
		}
		
		$this->setYourStatusBooleanValues();
		
		$_SESSION['lastUpdateTimeUpdates'] = Time::getNowUnivTimeMicro();
		
		return $this->newUpdates;
		
	}
	
	
	private function getNewUpdatesSmartphone() {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		/*
		-First join gets all your friends statuses, whether they have created it or are joined with it.  It also gets your friend's info (first name, last name) that represents your assocation to the status in case the leader is not your friend.
		-Second join gets a count of the number of people joined with a status
		-Third join gets total number of friends joined with update
			-Third subjoin gets joined_with id or actual id if friend is leader of group
				-Third sub-subjoin gets all friend's current status updates where canceled = 0, that is their actual current updates.
		-Fourth join gets your light (or list) value in relation to your friend's status.				
		*/
		
		$updatesManagerQuery = "SELECT u.id, u.first_name, u.last_name, s2.social_rating, s.id AS status_id, s.time_start, s.time_end, s.update_time, IFNULL(s3.cnt, 0) AS joined_count, sl.place, sl.activity, sl.max_people, sl.max_guys, sl.max_girls, sl.light, l.value, s2.id AS friend_id, s2.first_name AS friend_first_name, s2.last_name AS friend_last_name FROM user AS u, status AS s
		
		JOIN(SELECT IFNULL(s.joined_with, s.id) AS status_id, u.id, u.first_name, u.last_name, u.social_rating FROM user AS u, status AS s 
						   
			LEFT OUTER JOIN (SELECT friend_id FROM friend WHERE user_id = '" . $_SESSION['user_id'] . "') AS f ON f.friend_id = s.user_id
			
			JOIN(SELECT user_id, MAX(time_start) AS time_start FROM status WHERE TIME_FORMAT(TIMEDIFF('" . Time::getNowUnivTime() . "', time_start), '%m%d%k%i%s') BETWEEN 0 AND 50000 AND canceled = 0 GROUP BY user_id) AS s2 ON (s2.time_start = s.time_start AND s2.user_id = s.user_id)
			
		WHERE (u.id = '" . $_SESSION['user_id'] . "' OR (s.user_id = f.friend_id AND f.friend_id IS NOT NULL)) AND s.user_id = u.id AND s.canceled = 0 GROUP BY status_id) AS s2 ON s2.status_id = s.id
		
		LEFT OUTER JOIN (SELECT joined_with, COUNT(*) AS cnt FROM status WHERE canceled = 0 GROUP BY joined_with) AS s3 ON s3.joined_with = s.id
		
		LEFT OUTER JOIN (SELECT IFNULL(s.joined_with, s.id) AS status_id, COUNT(*) AS friends_joined FROM status AS s
																				
			LEFT OUTER JOIN (SELECT friend_id FROM friend WHERE user_id = '" . $_SESSION['user_id'] . "') AS f ON f.friend_id = s.user_id
			
		WHERE (f.friend_id IS NOT NULL OR s.user_id = '" . $_SESSION['user_id'] . "') AND s.canceled = 0 GROUP BY status_id) AS s4 ON s4.status_id = s.id, 
		
		status_leader AS sl 
		
		LEFT OUTER JOIN (SELECT list_id, value FROM list_value WHERE friend_id = '" . $_SESSION['user_id'] . "') AS l ON l.list_id = sl.list_id		
		
		WHERE s.user_id = u.id AND sl.status_id = s.id ORDER BY s.canceled DESC, s.update_time ASC;";
	
		
		if ($result = @mysqli_query($dbc, $updatesManagerQuery)) {

			while ($updatesAR = mysqli_fetch_array($result)) {
				
				$update = $this->constructUpdateFromDB($updatesAR);
				
				array_push($this->newUpdates, $update);
				
			}
			
		}
		
		$this->setYourStatusBooleanValues();
		
		return $this->newUpdates;	
		
	}
	
}

?>