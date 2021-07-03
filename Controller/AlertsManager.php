<?php

class AlertsManager {
	
	
	private static $instance = false;
	private $newNewsItems = array();
	private $newFriendships = array();
	private $newFriendRequests = array();
	private $newAlertCount = 0;
	private $alertCountTime;
	
	
	private function __construct() {
		
		$instance = true;

	}
	
	
	public static function getAlertsManager() {
		
		if (!AlertsManager::$instance) {
			
			AlertsManager::$instance = new AlertsManager();
			
		}
		
		return AlertsManager::$instance;
		
	}
	
	
	
	public function getNewNewsItems() {
		
		if ($this->newNewsItems != NULL)
			return $this->newNewsItems;
			
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$alertsManagerQuery = "SELECT id, text, link, update_time FROM news_item WHERE TIME_FORMAT(TIMEDIFF(update_time, '" . $_SESSION['lastUpdateTimeAlerts'] . "'), '%m%d%k%i%s') > 0 ORDER BY update_time DESC";
		
		if ($result = @mysqli_query($dbc, $alertsManagerQuery)) {

			while ($newsAlertsAR = mysqli_fetch_array($result)) {
				
				array_push( $this->newNewsItems, NewsItem::fullConstructor($newsAlertsAR['id'], $newsAlertsAR['text'], $newsAlertsAR['link'], $newsAlertsAR['update_time']));
				
				if (Time::compareTimes($newsAlertsAR['update_time'], $this->getAlertCountTime()) == 1)
					$this->newAlertCount++;
				
			}
			
		}
		
		return  $this->newNewsItems;
		
	}
	
	
	public function getNewFriendships() {
		
		if ($this->newFriendships != NULL)
			return $this->newFriendships;
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$alertsManagerQuery = "SELECT u.id, u.first_name, u.last_name, r.id AS request_id, r.first_name AS request_first_name, r.last_name AS request_last_name, ufr.update_time FROM user_friend_request AS ufr, user AS u, user AS r, friend AS f WHERE ufr.user_id = u.id AND f.user_id = '" . $_SESSION['user_id'] . "' AND (f.friend_id = ufr.request_id OR f.friend_id = ufr.user_id) AND ufr.request_id = r.id AND ufr.status = 1 AND ufr.request_id != '" . $_SESSION['user_id'] . "' AND TIME_FORMAT(TIMEDIFF(ufr.update_time, '" . $_SESSION['lastUpdateTimeAlerts'] . "'), '%m%d%k%i%s') > 0 GROUP BY ufr.user_id, ufr.request_id ORDER BY ufr.update_time DESC;";
		
		if ($result = @mysqli_query($dbc, $alertsManagerQuery)) {

			while ($newFriendshipsAR = mysqli_fetch_array($result)) {
				
				$friendship = FriendRequest::fullConstructor($newFriendshipsAR['id'], $newFriendshipsAR['first_name'], $newFriendshipsAR['last_name'], $newFriendshipsAR['request_id'], $newFriendshipsAR['request_first_name'], $newFriendshipsAR['request_last_name'], 1, $newFriendshipsAR['update_time']);
				
				array_push($this->newFriendships, $friendship);
				
				if (Time::compareTimes($newFriendshipsAR['update_time'], $this->getAlertCountTime()) == 1)
					$this->newAlertCount++;
				
			}
			
		}
		
		return $this->newFriendships;
		
		
	}
	
	
	private function getNewFriendRequests() {
		
		if ($this->newFriendRequests != NULL)
			return $this->newFriendRequests;
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$alertsManagerQuery = "SELECT u.id, u.first_name, u.last_name, r.id AS request_id, r.first_name AS request_first_name, r.last_name AS request_last_name, ufr.update_time FROM user_friend_request AS ufr, user AS u, user AS r WHERE ufr.user_id = u.id AND ufr.request_id = r.id AND ufr.status = 0 AND TIME_FORMAT(TIMEDIFF(ufr.update_time, '" . $_SESSION['lastUpdateTimeAlerts'] . "'), '%m%d%k%i%s') > 0 AND ufr.request_id = '" . $_SESSION['user_id'] . "' ORDER BY ufr.update_time DESC;";
		
		if ($result = @mysqli_query($dbc, $alertsManagerQuery)) {

			while ($newFriendRequestsAR = mysqli_fetch_array($result)) {
				
				$FriendRequest = FriendRequest::fullConstructor($newFriendRequestsAR['id'], $newFriendRequestsAR['first_name'], $newFriendRequestsAR['last_name'], $newFriendRequestsAR['request_id'], $newFriendRequestsAR['request_first_name'], $newFriendRequestsAR['request_last_name'], 0, $newFriendRequestsAR['update_time']);
				
				array_push($this->newFriendRequests, $FriendRequest);
				
				if (Time::compareTimes($newFriendRequestsAR['update_time'], $this->getAlertCountTime()) == 1)
					$this->newAlertCount++;
				
			}
			
		}
		
		return $this->newFriendRequests;
		
	}
	
	
	public function getAllAlertsJSON() {
		
		$_SESSION['lastUpdateTimeAlerts'] = Time::getFiveDaysAgoUnivTime();
		
		return $this->getNewAlertsJSON();
		
	}
	
	
	public function getNewAlertsJSON() {
		
		$newsItems = $this->getNewNewsItems();
		$newFriendships = $this->getNewFriendships();
		$newFriendRequests = $this->getNewFriendRequests();
		
		$_SESSION['lastUpdateTimeAlerts'] = Time::getNowUnivTime();
		
		$return_str = <<<EOD
			"AlertCount": [
				{ 
					"co": "{$this->newAlertCount}"
				},
				
			],		
EOD;
		
		$return_str .= '"NewsItems": [';
		
		foreach ($newsItems as $newsItem) {
				
			$return_str .= $newsItem->toPartJSONString();
			
		}
		
		$return_str .= '], "NewFriendships": [';
		
		foreach ($newFriendships as $friendship) {
				
			$return_str .= $friendship->toPartJSONString();
			
		}
		
		$return_str .= '], "FriendRequests": [';
		
		foreach ($newFriendRequests as $newFriendRequest) {
				
			$return_str .= $newFriendRequest->toPartJSONString();
			
		}
		
		$return_str .= ']';
		
		return $return_str;
		
	}

	
	public function updateAlertCountTime() {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$alertsManagerQuery = "UPDATE user SET alerts_update_time = '" . Time::getNowUnivTime() . "' WHERE id = '" . $_SESSION['user_id'] . "';";
				
		$result = @mysqli_query($dbc, $alertsManagerQuery);
		
	}
	
	
	private function getAlertCountTime() {
		
		if ($this->alertCountTime != NULL)
			return $this->alertCountTime;
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$alertsManagerQuery = "SELECT alerts_update_time FROM user WHERE id = '" . $_SESSION['user_id'] . "';";

		if ($result = @mysqli_query($dbc, $alertsManagerQuery)) {

			if ($alertsTimeAR = mysqli_fetch_array($result)) {
				
				$this->alertCountTime = $alertsTimeAR['alerts_update_time'];
				
			}
			
		}
		
		return $this->alertCountTime;
		
	}
	
	
}

?>