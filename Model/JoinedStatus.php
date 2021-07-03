<?php

class JoinedStatus extends Status{
	
	protected $joinedWithID;
	protected $joinedWithUpdate;
	protected $usersAlsoJoining = array();
	
	private function __construct() {
		
	}
	
	
	public static function fullConstructor($id, $timeStart, $timeEnd, $joinedWithID) {
		
		$joinedStatus = JoinedStatus::limitedConstructor($timeStart, $timeEnd, NULL, $joinedWithID);
		
		$joinedStatus->id = Verifier::validateNumber($id);
		
		return $joinedStatus;
		
	}
	
	
	public static function limitedConstructor($timeStart, $timeEnd, $usersAlsoJoining, $joinedWithID) {
		
		$joinedStatus = new JoinedStatus();
		
		if (is_string($usersAlsoJoining)) {
				$joinedStatus->usersAlsoJoining = Verifier::validateNumberArray($usersAlsoJoining);	
				$joinedStatus->usersAlsoJoining = explode(',', $usersAlsoJoining);
		}
		else if (is_array($usersAlsoJoining)) {
			$retAR = array();
			for ($i = 0; $i < count($usersAlsoJoining); $i++) {
				array_push($retAR, $usersAlsoJoining[$i]->getID());
			}
			$joinedStatus->usersAlsoJoining = $retAR;
		}
		
		$joinedStatus->timeStart = Verifier::validateTime($timeStart);
		$joinedStatus->timeEnd = Verifier::validateTime($timeEnd);
		$joinedStatus->joinedWithID = Verifier::validateNumber($joinedWithID);

		return $joinedStatus;
		
	}
	
	
	public static function dbConstructor($id) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$joinedStatus = new joinedStatus();
		
		$joinedStatusQuery = "SELECT id, time_start, time_end, joined_with, update_time FROM status WHERE id = " . $id;
		
		if ($result = @mysqli_query($dbc, $joinedStatusQuery)) {

			if ($joinedStatusAR = mysqli_fetch_array($result)) {
				
				$joinedStatus->id = $joinedStatusAR['id'];
				$joinedStatus->timeStart = Time::convertToUserTimeZone($joinedStatusAR['time_start']);
				$joinedStatus->timeEnd = $joinedStatusAR['time_end'] != NULL ? Time::convertToUserTimeZone($joinedStatusAR['time_end']) : NULL;
				$joinedStatus->updateTime = Time::convertMicroToUserTimeZone($joinedStatusAR['update_time']);
				$joinedStatus->joinedWithID = $joinedStatusAR['joined_with'];
				
			}
			
		}

		
		return $joinedStatus;	
		
	}
	
	
	public function save() {
		
		if (ExceptionsManager::getExceptionsManager()->areThereExceptions() == true)
			return false;
			
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$new = false;
		
		$insTimeStart = $this->timeStart != NULL ? "'" . Verifier::dbReady(Time::convertToUnivTimeZone($this->timeStart)) . "'" : "'" . Time::getNowUnivTime() . "'";
		$insTimeEnd = $this->timeEnd != NULL ? "'" . Verifier::dbReady(Time::convertToUnivTimeZone($this->timeEnd)) . "'" : "NULL";
		$insJoinedWith = Verifier::dbReady($this->joinedWithID);
		$valuesString  = "";
		$insUpdateTime = Time::getNowUnivTimeMicro();
		
		if ($this->id != NULL)
			$joinedStatusQuery = "UPDATE status SET time_start = " .  $insTimeStart . ", time_end = " . $insTimeEnd . ", joined_with = " . $insJoinedWith . " WHERE id = " . $this->id;
		else {
			
			$new = true;
			
			StatusManager::getStatusManager()->cancelCurrentStatus();
			
			$joinedStatusQuery = "REPLACE INTO status(user_id, time_start, time_end, update_time, joined_with) VALUES ('" . $_SESSION['user_id']. "', " . $insTimeStart . ", " . $insTimeEnd . ", '" . $insUpdateTime . "', " . $insJoinedWith . ");";
			
		}
		
		$joinedStatusQuery .= "UPDATE status SET update_time = '" . $insUpdateTime . "' WHERE id = " . $insJoinedWith . ";";
			
		if ($this->usersAlsoJoining != NULL) {
			
			foreach($this->usersAlsoJoining as $user) {
				
				$userID = Verifier::dbReady($user);
				
				$valuesString .= "('" . $userID . "', " . $insTimeStart . ", " . $insTimeEnd . ", '" . $insUpdateTime . "', " . $insJoinedWith . "), ";
				
			}
			
			$valuesString = substr($valuesString, 0, strlen($valuesString)-2);
				
			$joinedStatusQuery .= "REPLACE INTO status(user_id, time_start, time_end, update_time, joined_with) VALUES " . $valuesString . ";";
			
		}
			
		$multiResult = @mysqli_multi_query($dbc, $joinedStatusQuery);	
		
		while (mysqli_next_result($dbc)) {};
		
		//this query is needed for joined update communication
		
		if ($this->id == NULL) {
			
			$joinedStatusQuery = "SELECT id FROM status WHERE user_id = " . $_SESSION['user_id'] . " AND time_start = " . $insTimeStart . " AND update_time = " . $insUpdateTime . " AND joined_with = " . $this->joinedWithID;
			
			if ($result = @mysqli_query($dbc, $joinedStatusQuery)) {

				if ($joinedStatusAR = mysqli_fetch_array($result)) {
					
					$this->id = $joinedStatusAR['id'];
					
				}
				
			}
			
		}
		
		if ($new == true) {
			
			CommunicationsManager::getCommunicationsManager()->tryJoinedUpdateCommunication($this->id, $this->usersAlsoJoining);
			
			$leaderSocialMeter = SocialMeter::afterJoinUpdateLeaderConstructor($this->joinedWithID);
			
			$leaderSocialMeter->save();
			
			$joiningSocialMeter = SocialMeter::afterJoinUpdateJoineeConstructor($this->joinedWithID);
			
			$joiningSocialMeter->save();						
				
		}
		
	}
	
	
	public function toFullJSONString() {
		
		$this->createJoinedWithUpdate();
		
		$return_str = <<<EOD
		
        	"JoinedStatus": [
				{ 
					"id": "{$this->id}",
					"ts": "{$this->timeStart}",
					"te": "{$this->timeEnd}",
					"ut": "{$this->updateTime}"
				}
				
			],
EOD;

		$return_str .= $this->joinedWithUpdate->toFullJSONString();
		

		return $return_str;
		
	}
	
	
	private function createJoinedWithUpdate() {
		
		if ($this->joinedWithUpdate == NULL)
			$this->joinedWithUpdate = Update::dbConstructor($this->joinedWithID);

	}
	
	public function isLeaderStatus() {
		return false;
		
	}
	
	public function getJoinedWithID() {
		return $this->joinedWithID;
	}

		
}

?>