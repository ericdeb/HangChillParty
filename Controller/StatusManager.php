<?php

class StatusManager {
	
	
	private static $instance = false;
	private $currentStatus;
	
	
	private function __construct() {
		
		$instance = true;

	}
	
	
	public static function getStatusManager() {
		
		if (!StatusManager::$instance) {
			
			StatusManager::$instance = new StatusManager();
			
		}
		
		return StatusManager::$instance;
		
	}

	
	public function cancelCurrentStatus() {
		
		$currentStatus = $this->getCurrentStatus();
		
		if ($currentStatus != NULL) {
			
			$id = $currentStatus->getID();
			$joinedWithID = $this->getCurrentStatus()->isLeaderStatus() == false ? $this->getCurrentStatus()->getJoinedWithID() : NULL;
		
			$this->cancelStatus($id, $joinedWithID);
			
		}

		
	}
	
	
	public function hasCurrentStatus() {
		
		try {
			
			if ($this->getCurrentStatus() == NULL)
				throw new ValidationException("User does not have current status.", 89);

		}
				
		catch (validationException $e) {
		
			ExceptionsManager::getExceptionsManager()->handleException($e);
		
		}
		
	}


	
	
	public function getCurrentStatus() {
		
		if ($this->currentStatus != NULL)
			return $this->currentStatus;
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$statusManagerQuery = "SELECT id, joined_with FROM status AS s JOIN (SELECT user_id, MAX(time_start) AS time_start FROM status WHERE TIME_FORMAT(TIMEDIFF('" . Time::getNowUnivTime() . "', time_start), '%m%d%k%i%s') BETWEEN 0 AND 50000 GROUP BY user_id) AS s2 ON (s2.user_id = s.user_id AND s2.time_start = s.time_start) AND s.user_id = '" . $_SESSION['user_id']. "' AND s.canceled = 0 ";
		
		if ($result = @mysqli_query($dbc, $statusManagerQuery)) {

			if ($currentStatusAR = mysqli_fetch_array($result)) {
				
				if ($currentStatusAR['joined_with'] == NULL)
					$this->currentStatus = LeaderStatus::dbConstructor($currentStatusAR['id']);
				else
					$this->currentStatus = JoinedStatus::dbConstructor($currentStatusAR['id']);
					
				return $this->currentStatus;
				
			}
			
		}
		
		return NULL;
			
	}


	public function cancelStatus($id, $joinedWithID) {
		
		
		$id = Verifier::dbReady($id);
		$statusManagerQuery = "";
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		if ($joinedWithID == NULL) {
			
			$statusManagerQuery .= "DELETE lv.* FROM list_value AS lv, status_leader AS sl, status AS s WHERE sl.list_id = lv.list_id AND sl.status_id = " . $id . " AND s.id = sl.status_id AND s.user_id = '" . $_SESSION['user_id']. "';";
			$statusManagerQuery .= "DELETE l.* FROM list AS l, status_leader AS sl, status AS s WHERE sl.list_id = l.id AND s.id = sl.status_id AND s.user_id = '" . $_SESSION['user_id']. "' AND sl.status_id = " . $id . ";";
			$statusManagerQuery .= "UPDATE status AS s SET s.canceled = 1, s.update_time = '" . Time::getNowUnivTimeMicro() . "' WHERE s.joined_with = " . $id . ";";
		
		}
		else
			$statusManagerQuery .= "UPDATE status AS s SET s.update_time = '" . Time::getNowUnivTimeMicro() . "' WHERE s.id = " . $joinedWithID . " OR s.joined_with = " . $joinedWithID . ";";
		
		$statusManagerQuery .= "UPDATE status AS s SET s.canceled = 1, s.update_time = '" . Time::getNowUnivTimeMicro() . "' WHERE s.id = " . $id . ";";

		$multiResult = @mysqli_multi_query($dbc, $statusManagerQuery);
		
		while (mysqli_more_results($dbc)) { mysqli_next_result($dbc); };
		
		echo mysqli_error($dbc);
		
	}
	
	
	public function checkYourConflictingTimes($timeStart, $timeEnd) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$timeStartUniversal = Time::convertToUnivTimeZone($timeStart);
		$timeEndUniversal = Time::convertToUnivTimeZone($timeEnd);
		$timeStartUnix = strtotime($timeStartUniversal);
		$timeEndUnix = strtotime($timeEndUniversal);
		
		try {
			
			if ($timeStartUnix < (getNowUnix()+5*60))
				throw new ValidationException("Time start must be at least 5 minutes from now (leave it blank if you are trying to update now)");
				
			if (($timeEndUnix - $timeStartUnix) < 10*60)
				throw new ValidationException("Time end must be at least 10 minutes from time start");
				
			if (($timeEndUnix - $timeStartUnix) > 5*60*60)
				throw new ValidationException("Time end must be within 5 hours of time start");
		
			$statusManagerQuery = "SELECT time_start, time_end FROM status WHERE (TIME_FORMAT('" . $timeStartUniversal . "', '%m%d%k%i%s') BETWEEN TIME_FORMAT(time_start, '%m%d%k%i%s')-1000 AND TIME_FORMAT(time_end, '%m%d%k%i%s')+100) OR (TIME_FORMAT('" . $timeEndUniversal . "', '%m%d%k%i%s') BETWEEN TIME_FORMAT(time_start, '%m%d%k%i%s')-100 AND TIME_FORMAT(time_end, '%m%d%k%i%s')+1000) AND user_id = '" . $_SESSION['user_id']. "'";
			
			if ($result = @mysqli_query($dbc, $statusManagerQuery)) {
	
				while ($timeConflictsAR = mysqli_fetch_array($result)) {

						$testTimeStartUnix = strtotime($timeConflictsAR['time_start']);
						$testTimeEndUnix = $timeConflictsAR['time_end'] != NULL ? strtotime($timeConflictsAR['time_end']) : NULL;
						
						if (($timeStartUnix > ($testTimeStartUnix - 10*60)) && ($timeStartUnix < ($testTimeEndUnix + 60)))
							throw new ValidationException("Time start must be at least 10 minutes before your other activities");
						
						if ($testTimeEndUnix != NULL && ($timeEndUnix > ($testTimeStartUnix - 60)) && ($timeEndUnix < ($testTimeEndUnix + 10*60)))
							throw new ValidationException("Time end must not conflict with your other activities");
					
					
					
				}
				
			}
			
		}
		
		catch (validationException $e) {
					
			ExceptionsManager::getExceptionsManager()->handleException($e);
					
		}
		
		
	}
	
	public function checkJoinedUserConflictingTimes($timeStart, $timeEnd, $joinedID) {
		
		checkConflictingTimes($timeStart, $timeEnd);
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$timeStartUniversal = Time::convertToUnivTimeZone($timeStart);
		$timeEndUniversal = Time::convertToUnivTimeZone($timeEnd);
		$timeStartUnix = strtotime($timeStartUniversal);
		$timeEndUnix = strtotime($timeEndUniversal);
		
		try {
			
			$statusManagerQuery = "SELECT u.first_name, u.last_name, s.time_start, s.time_end FROM status AS s, user AS u WHERE u.id = s.user_id AND s.id = " . $joinedID;
		
			if ($result = @mysqli_query($dbc, $statusManagerQuery)) {
	
			  	if ($timeConflictsAR = mysqli_fetch_array($result)) {
				  
				  	$testTimeStartUnix = strtotime($timeConflictsAR['time_start']);
				  	$testTimeEndUnix = $timeConflictsAR['time_end'] != NULL ? strtotime($timeConflictsAR['time_end']) : NULL;
				  
				  	if ($timeStartUnix < $testTimeStartUnix || ($testTimeEndUnix != NULL && $timeStartUnix > $testTimeEndUnix - 10 * 60))
				  		throw new ValidationException("Time start must be at least 10 minutes before " . $timeConflictsAR['first_name'] . " " . $timeConflictsAR['last_name'] . "'s time end (" . Time::convertToUserTimeZone($timeConflictsAR['time_end']) . ")");
					
				  	if ($timeEndUnix > $testTimeEndUnix)
				  		throw new ValidationException("Time end must be before " . $timeConflictsAR['first_name'] . " " . $timeConflictsAR['last_name'] . "'s time end (" . Time::convertToUserTimeZone($timeConflictsAR['time_end']) . ")");
				  
			  	}
			  
			}
			
		}
		
		catch (validationException $e) {
					
			ExceptionsManager::getExceptionsManager()->handleException($e);
					
		}
		
		
	}
	
	
	public function cancelStatuses($usersAlsoJoiningAR) {
		
		$currentStatusAR = $this->getCurrentStatusIDs($usersAlsoJoiningAR);

		$mainValuesString = ""; $joinValuesString = ""; $deleteValuesString = "";
		
		for ($i = 0; $i < count($currentStatusAR); $i++) {
			$mainValuesString .= "s.id = " . $currentStatusAR[$i] . " OR ";
			$joinValuesString .= "s.joined_with = " . $currentStatusAR[$i] . " OR ";
			$deleteValuesString .= "sl.status_id = " . $currentStatusAR[$i] . " OR ";
		}
		
		$mainValuesString =  "(" . substr($mainValuesString, 0, strlen($mainValuesString)-4) . ")";
		$joinValuesString =  "(" . substr($joinValuesString, 0, strlen($joinValuesString)-4) . ")";
		$deleteValuesString =  "(" . substr($deleteValuesString, 0, strlen($deleteValuesString)-4) . ")";

		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$statusManagerQuery = "DELETE lv.*, l.* FROM list AS l, list_value AS lv, status_leader AS sl WHERE l.id = sl.list_id AND  sl.list_id = lv.list_id AND " . $deleteValuesString . ";";
		$statusManagerQuery .= "UPDATE status AS s SET s.canceled = 1, s.update_time = '" . Time::getNowUnivTimeMicro() . "' WHERE " . $mainValuesString . " OR " . $joinValuesString . ";";

		$multiResult = @mysqli_multi_query($dbc, $statusManagerQuery);
		
		while (mysqli_more_results($dbc)) { mysqli_next_result($dbc); };
		
	}
	
	
	private function getCurrentStatusIDs($usersAR) {
		
		$valuesString = "";
		
		for ($i = 0; $i < count($usersAR); $i++) 
			$valuesString .= "s.user_id = " . $usersAR[$i] . " OR ";
		
		$valuesString = "(" . substr($valuesString, 0, strlen($valuesString)-4) . ")";
		
		$dbc = DatabaseConnection::getDatabaseConnection();

		$retAR = array();

		$statusManagerQuery = "SELECT id FROM status AS s JOIN (SELECT user_id, MAX(time_start) AS time_start FROM status WHERE TIME_FORMAT(TIMEDIFF('" . Time::getNowUnivTime() . "', time_start), '%m%d%k%i%s') BETWEEN 0 AND 50000 GROUP BY user_id) AS s2 ON (s2.user_id = s.user_id AND s2.time_start = s.time_start) AND s.canceled = 0 AND " . $valuesString;

		if ($result = @mysqli_query($dbc, $statusManagerQuery)) {
			
			while ($currentStatusAR = mysqli_fetch_array($result)) {

				array_push($retAR, $currentStatusAR['id']);
				
			}

			return $retAR;
			
		}
		
		return $retAR;	
		
		
	}
	
	
	
}

?>