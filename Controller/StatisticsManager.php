<?php

class StatisticsManager {
	
	
	private static $instance = false;
	private $hoursOffset = -80000;
	private $viewerTimeZone = "America/Los Angeles";
	private $daysAR = array();
	private $updateNumAR = array();
	private $newGuysAR = array();
	private $newGirlsAR = array();
	private $updatesAR = array();
	private $usersAR = array();
	private $statisticLogin;
	
	private function __construct() {
		
		$instance = true;

	}
	
	
	public static function getStatisticsManager() {
		
		if (!StatisticsManager::$instance) {
			
			StatisticsManager::$instance = new StatisticsManager();
			
		}
		
		return StatisticsManager::$instance;
		
	}

	
	public function incrementVisitStatistic() {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$statisticsManagerQuery = "UPDATE statistics SET num_visits = num_visits + 1";
		
		$result = @mysqli_query($dbc, $statisticsManagerQuery);		
		
	}
	
	
	public function incrementFacebookVisitStatistic() {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$statisticsManagerQuery = "UPDATE statistics SET num_facebook_visits = num_facebook_visits + 1";
		
		$result = @mysqli_query($dbc, $statisticsManagerQuery);
		
	}
	
	
	public function incrementLoginsStatistic() {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$statisticsManagerQuery = "UPDATE statistics SET num_logins = num_logins + 1";
		
		$result = @mysqli_query($dbc, $statisticsManagerQuery);
		
	}
	
	
	public function incrementRegisterStatistic() {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$statisticsManagerQuery = "UPDATE statistics SET num_register_visit = num_register_visit + 1";
		
		$result = @mysqli_query($dbc, $statisticsManagerQuery);
		
	}
	
	
	public function incrementNumberWhoRegisterStatistic() {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$statisticsManagerQuery = "UPDATE statistics SET num_who_register = num_who_register + 1";
		
		$result = @mysqli_query($dbc, $statisticsManagerQuery);
		
	}
	
	
	
	public function getNumbersPerDayTable() {
		
		if ($this->daysAR == NULL || $this->updateNumAR == NULL || $this->newUsersAR == NULL)
			$this->calculateNumbersPerDay();
			
		$returnStr = '<table><tr><th>Day</th><th>Updates</th><th>New Guys</th><th>New Girls</th><th>Total New Users</th><tr>';
		
		for ($i = 0; $i < count($this->daysAR); $i++) {
			
			$totalIns = $this->newGuysAR[$i] + $this->newGirlsAR[$i];
			
			$returnStr .= '<tr><td>' .  substr($this->daysAR[$i], 0, 1) . '-' . substr($this->daysAR[$i], 1, strlen($this->daysAR[$i])) . '</td><td>' .  $this->updateNumAR[$i] . '</td><td>' .  $this->newGuysAR[$i] . '</td><td>' .  $this->newGirlsAR[$i] . '</td><td>' .  $totalIns . '</td><tr>';
			
		}
		
		$totalIns = array_sum($this->newGuysAR) + array_sum($this->newGirlsAR);
			
		$returnStr .= '<tr><td style="font-weight:bold">Total:</td><td>' . array_sum($this->updateNumAR) . '</td><td>' . array_sum($this->newGuysAR) . '</td><td>' . array_sum($this->newGirlsAR) . '</td><td>' . $totalIns . '</td></tr>';
			
		return $returnStr . '</table>';		
		
	}
	
	
	public function getLastHundredUpdatesTable() {
		
		if ($this->updatesAR == NULL)
			$this->calculateLastHundredUpdates();
			
		$returnStr = '<table>' . StatisticUpdate::getTableHeading();
		
		for ($i = 0; $i < count($this->updatesAR); $i++)
			$returnStr .= $this->updatesAR[$i]->getTableRow();
			
		return $returnStr . '</table>';	
		
		
	}
	
	
	public function getTopFiftyUsersTable() {
		
		if ($this->usersAR == NULL)
			$this->calculateTopFiftyUserStatistics();
			
		$returnStr = '<table>' . StatisticUser::getTableHeading();
		
		for ($i = 0; $i < count($this->usersAR); $i++)
			$returnStr .= $this->usersAR[$i]->getTableRow();
			
		return $returnStr . '</table>';	
		
		
	}
	
	
	public function getLoginTable() {
		
		if ($this->statisticLogin == NULL)
			$this->calculateLoginStatistics();
			
		return '<table>' . $this->statisticLogin->getTableHeading() . $this->statisticLogin->getTableRow() . '</table>';	

	}
	
	
	
	private function calculateNumbersPerDay() {
		
		if ($this->daysAR != NULL && $this->updateNumAR != NULL && $this->newUsersAR != NULL)
			return NULL;
			
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$statisticsManagerQuery = "SELECT COUNT(*) AS update_cnt, FLOOR((DATE_FORMAT(time_start, '%m%d%H%i%s') + " . $this->hoursOffset . ")/1000000) AS day FROM status WHERE user_id != 1 AND user_id != 2 AND user_id != 626 GROUP BY day ORDER BY day ASC";
		
		if ($result = @mysqli_query($dbc, $statisticsManagerQuery)) {

			while ($updatesAR = mysqli_fetch_array($result)) {
				
				array_push($this->daysAR, $updatesAR['day']);
				array_push($this->updateNumAR, $updatesAR['update_cnt']);
				
			}
				
		}
		
		$statisticsManagerQuery = "SELECT IFNULL(COUNT(*), 0) AS new_users_cnt, FLOOR((DATE_FORMAT(u.registration_date, '%m%d%H%i%s') + " . $this->hoursOffset . ")/1000000) AS day FROM user AS u WHERE id != 1 AND id != 2 AND id != 626 AND u.gender = 0 GROUP BY day HAVING day != 715 AND day != 716 ORDER BY day ASC";
		
		if ($result = @mysqli_query($dbc, $statisticsManagerQuery)) {
			
			$index = 0;

			while ($updatesAR = mysqli_fetch_array($result)) {
				
				while ($updatesAR['day'] > $this->daysAR[$index]) {
					array_push($this->newGuysAR, 0);
					$index++;
				}
					
				array_push($this->newGuysAR, $updatesAR['new_users_cnt']);
				
				$index++;

			}
				
		}
		
		$statisticsManagerQuery = "SELECT IFNULL(COUNT(*), 0) AS new_users_cnt, FLOOR((DATE_FORMAT(u.registration_date, '%m%d%H%i%s') + " . $this->hoursOffset . ")/1000000) AS day FROM user AS u WHERE id != 1 AND id != 2 AND id != 626 AND u.gender = 1 GROUP BY day HAVING day != 715 AND day != 716 ORDER BY day ASC";
		
		if ($result = @mysqli_query($dbc, $statisticsManagerQuery)) {
			
			$index = 0;

			while ($updatesAR = mysqli_fetch_array($result)) {
				
				while ($updatesAR['day'] > $this->daysAR[$index]) {
					array_push($this->newGirlsAR, 0);
					$index++;
				}
					
				array_push($this->newGirlsAR, $updatesAR['new_users_cnt']);
				
				$index++;

			}
				
		}
		
	}
	
	
	private function calculateLastHundredUpdates() {
		
		if ($this->updatesAR != NULL)
			return NULL;
			
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$currentTimeZone = date_default_timezone_get();
		date_default_timezone_set($this->viewerTimeZone);
		
		$statisticsManagerQuery = "SELECT u.first_name, u.last_name, s.time_start , s.canceled, sl.activity, sl.place, cn.cnt FROM user AS u 
		
		LEFT OUTER JOIN (SELECT user_id, COUNT(*) AS cnt FROM status AS s GROUP BY user_id) AS cn ON cn.user_id = u.id,
		
		status AS s, status_leader AS sl WHERE sl.status_id = s.id AND u.id = s.user_id AND u.id != 1 AND u.id != 2 AND u.id != 626 ORDER BY s.time_start DESC LIMIT 100";

		if ($result = @mysqli_query($dbc, $statisticsManagerQuery)) {

			while ($updatesAR = mysqli_fetch_array($result)) {
				
				$timeStart = Time::convertToUserTimeZone($updatesAR['time_start']);
				
				$statisticUpdate = new StatisticUpdate($updatesAR['first_name'], $updatesAR['last_name'], $updatesAR['name'], $updatesAR['canceled'], $updatesAR['activity'], $updatesAR['place'], $timeStart, $updatesAR['cnt']);
				
				array_push($this->updatesAR, $statisticUpdate);
				
			}
				
		}
		
		date_default_timezone_set($currentTimeZone);
		
	}
	
	
	private function calculateTopFiftyUserStatistics() {
		
		if ($this->usersAR != NULL)
			return NULL;
			
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$statisticsManagerQuery = "SELECT u.first_name, u.last_name, u2.cnt AS updatesOneDayAgo, u3.cnt AS updatesTwoDaysAgo, u4.cnt AS updatesThreeDaysAgo, u5.cnt AS updatesFourDaysAgo, u.num_facebook_updates, u.num_twitter_updates, cn.cnt AS total_updates FROM user AS u 
		
		LEFT OUTER JOIN (SELECT user_id, COUNT(*) AS cnt FROM status AS s GROUP BY user_id) AS cn ON cn.user_id = u.id
		
		LEFT OUTER JOIN (SELECT user_id, COUNT(*) AS cnt FROM status WHERE TIME_FORMAT(TIMEDIFF(time_start, '" . Time::getNowUnivTime() . "'), '%m%d%H%i%s') BETWEEN -240000 AND 0 GROUP BY user_id) AS u2 ON u2.user_id = u.id
		
		LEFT OUTER JOIN (SELECT user_id, COUNT(*) AS cnt FROM status WHERE TIME_FORMAT(TIMEDIFF(time_start, '" . Time::getNowUnivTime() . "'), '%m%d%H%i%s') BETWEEN -480000 AND -240000 GROUP BY user_id) AS u3 ON u3.user_id = u.id
		
		LEFT OUTER JOIN (SELECT user_id, COUNT(*) AS cnt FROM status WHERE TIME_FORMAT(TIMEDIFF(time_start, '" . Time::getNowUnivTime() . "'), '%m%d%H%i%s') BETWEEN -720000 AND -480000 GROUP BY user_id) AS u4 ON u4.user_id = u.id
		
		LEFT OUTER JOIN (SELECT user_id, COUNT(*) AS cnt FROM status WHERE TIME_FORMAT(TIMEDIFF(time_start, '" . Time::getNowUnivTime() . "'), '%m%d%H%i%s') BETWEEN -960000 AND -720000 GROUP BY user_id) AS u5 ON u5.user_id = u.id
		
		WHERE u.id != 1 AND u.id != 2 AND u.id != 626 ORDER BY cn.cnt DESC LIMIT 50";
		
		if ($result = @mysqli_query($dbc, $statisticsManagerQuery)) {

			while ($updatesAR = mysqli_fetch_array($result)) {
				
				$statisticUser = new StatisticUser($updatesAR['first_name'], $updatesAR['last_name'], $updatesAR['updatesOneDayAgo'], $updatesAR['updatesTwoDaysAgo'], $updatesAR['updatesThreeDaysAgo'], $updatesAR['updatesFourDaysAgo'], $updatesAR['num_facebook_updates'], $updatesAR['num_twitter_updates'],$updatesAR['total_updates']);
				
				array_push($this->usersAR, $statisticUser);
				
			}
				
		}		
		
	}
	
	
	private function calculateLoginStatistics() {
		
		if ($this->statisticLogin != NULL)
			return NULL;
			
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$statisticsManagerQuery = "SELECT num_visits, num_facebook_visits, num_logins, num_register_visit, num_who_register FROM statistics";
		
		if ($result = @mysqli_query($dbc, $statisticsManagerQuery)) {

			if ($updatesAR = mysqli_fetch_array($result)) {
				
				$this->statisticLogin = new StatisticLogin($updatesAR['num_visits'], $updatesAR['num_facebook_visits'], $updatesAR['num_logins'], $updatesAR['num_register_visit'], $updatesAR['num_who_register']);
				
			}
				
		}	
		
	}
	
	
}

?>