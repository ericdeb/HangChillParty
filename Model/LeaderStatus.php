<?php

class LeaderStatus extends FullStatus{
	
	protected $maxPeople;
	protected $maxGuys;
	protected $maxGirls;
	protected $signalList;
	protected $twitterPublish;

	private function __construct() {
		
	}			
	
								
	public static function fullConstructor($id, $timeStart, $timeEnd, $place, $activity, $partyID, $maxPeople, $maxGuys, $maxGirls, $light, $joinedUsers, $signalList, $twitterPublish) {
		
		$leaderStatus = LeaderStatus::limitedConstructor($timeStart, $timeEnd, $place, $activity, $partyID, $maxPeople, $maxGuys, $maxGirls, $light, $joinedUsers, $signalList, $facebookPublish, $twitterPublish);
		
		$leaderStatus->id = Verifier::validateNumber($id);
		
		return $leaderStatus;
		
	}
	
	
	public static function limitedConstructor($timeStart, $timeEnd, $place, $activity, $partyID, $maxPeople, $maxGuys, $maxGirls, $light, $joinedUsers, $signalList, $facebookPublish, $twitterPublish) {
		
		$leaderStatus = new LeaderStatus();
		$joinedUsers = Verifier::validateNumberArray($joinedUsers);
		$leaderStatus->timeStart = Verifier::validateTime($timeStart);
		$leaderStatus->timeEnd = Verifier::validateTime($timeEnd);
		$leaderStatus->place = Verifier::validateText($place);
		$leaderStatus->activity = Verifier::validateText($activity);
		$leaderStatus->partyID = Verifier::validateNumber($partyID);
		$leaderStatus->maxPeople = Verifier::validateMax($maxPeople);
		$leaderStatus->maxGuys = Verifier::validateMax($maxGuys);
		$leaderStatus->maxGirls = Verifier::validateMax($maxGirls);
		$leaderStatus->light = Verifier::validateNumber($light);
		$leaderStatus->signalList = $signalList;
		$leaderStatus->facebookPublish = Verifier::validateBoolean($facebookPublish);
		$leaderStatus->twitterPublish = Verifier::validateBoolean($twitterPublish);
		
		if ($joinedUsers != NULL) {
			
			$joinedUsers = explode(',', $joinedUsers);
			$leaderStatus->joinedUsers = $joinedUsers;			
			
		}
		
		return $leaderStatus;
		
	}
	
	
	public static function dbConstructor($id) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$leaderStatus = new LeaderStatus();
		
		$leaderStatusQuery = "SELECT s.id, s.time_start, s.time_end, s.update_time, sl.place, sl.activity, sl.party_id, sl.max_people, sl.max_guys, sl.max_girls, sl.light, sl.list_id FROM status AS s, status_leader AS sl WHERE s.id = " . $id . " AND sl.status_id = s.id;";

		if ($result = @mysqli_query($dbc, $leaderStatusQuery)) {
	
			if ($leaderStatusAR = mysqli_fetch_array($result)) {	
			
				$leaderStatus->id = $leaderStatusAR['id'];
				$leaderStatus->timeStart = Time::convertToUserTimeZone($leaderStatusAR['time_start']);
				$leaderStatus->timeEnd = $leaderStatusAR['time_end'] != NULL ? Time::convertToUserTimeZone($leaderStatusAR['time_end']) : NULL;
				$leaderStatus->place = $leaderStatusAR['place'];
				$leaderStatus->activity = $leaderStatusAR['activity'];
				$leaderStatus->maxPeople = $leaderStatusAR['max_people'];
				$leaderStatus->maxGuys = $leaderStatusAR['max_guys'];
				$leaderStatus->maxGirls = $leaderStatusAR['max_girls'];
				$leaderStatus->light = $leaderStatusAR['light'];
				$leaderStatus->updateTime = Time::convertMicroToUserTimeZone($leaderStatusAR['update_time']);
				
				if ($leaderStatusAR['list_id'] != NULL && $leaderStatusAR['light'] == 0)
					$leaderStatus->signalList = UserList::dbConstructor($leaderStatusAR['list_id']);

				if ($leaderStatusAR['party_id'] != NULL)
					$leaderStatus->partyID = $leaderStatusAR['party_id'];	
					
			}
			
		}

		$leaderStatus->getJoinedUsers();
		
		return $leaderStatus;
		
	}		
	
	
	public function cancelJoinedUsers($usersAR, $id) {
		
		if (ExceptionsManager::getExceptionsManager()->areThereExceptions() == true)
			return false;
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$id = Verifier::dbReady($id);
		$usersAR = Verifier::validateNumberArray($usersAR);
		$usersAR = explode(',', $usersAR);
		$valuesString = "";
		
		foreach($usersAR as $user) {
			
			$user = Verifier::dbReady($user);
			
			$valuesString .= "user_id = " . $user . " OR ";
			
		}
		
		$valuesString = substr($valuesString, 0, strlen($valuesString)-4);
		
		$leaderStatusQuery = "UPDATE status SET canceled = 1 WHERE joined_with =" . $id . " AND (" . $valuesString . ")";
		
		$result = @mysqli_query($dbc, $leaderStatusQuery);
		
	}
	
	
	public function save() {
		
		if (ExceptionsManager::getExceptionsManager()->areThereExceptions() == true)
			return false;
			
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$insTimeStart = $this->timeStart != NULL ? "'" . Verifier::dbReady(Time::convertToUnivTimeZone($this->timeStart)) . "'" : "'" . Time::getNowUnivTime() . "'";
		$insTimeEnd = $this->timeEnd != NULL ? "'" . Verifier::dbReady(Time::convertToUnivTimeZone($this->timeEnd)) . "'" : "NULL";
		$insPlace = $this->place != NULL ? "'" . Verifier::dbReady($this->place) . "'" : "NULL";
		$insActivity = $this->activity != NULL ? "'" . Verifier::dbReady($this->activity) . "'" : "NULL";
		$insPartyID = $this->partyID != NULL ? Verifier::dbReady($this->partyID) : "NULL";
		$insMaxPeople = $this->maxPeople != NULL ? Verifier::dbReady($this->maxPeople) : "NULL";
		$insMaxGuys = $this->maxGuys != NULL ? Verifier::dbReady($this->maxGuys) : "NULL";
		$insMaxGirls = $this->maxGirls != NULL ? Verifier::dbReady($this->maxGirls) : "NULL";
		$insLight = Verifier::dbReady($this->light);
		$insListID = $this->signalList != NULL ? $this->signalList->getID() : "NULL";

		if ($this->id != NULL) {
			
			$new = false;
			
			$leaderStatusQuery = "UPDATE status SET time_start = " .  $insTimeStart . ", time_end = " . $insTimeEnd . ", update_time = '" . Time::getNowUnivTimeMicro() . "' WHERE id = " . $this->id . ";";
			$leaderStatusQuery .= "UPDATE status SET update_time = '" . Time::getNowUnivTimeMicro() . "' WHERE joined_with = " . $this->id . ";";
			$leaderStatusQuery .= "UPDATE status_leader SET place = " .  $insPlace . ", activity = " . $insActivity . "', party_id = " . $insPartyID . ", max_people = " . $insMaxPeople . ", max_guys = " . $insMaxGuys . ", max_girls = " . $insMaxGirls . " WHERE status_id = " . $this->id;
			$leaderStatusQuery .= "UPDATE status SET time_start = " .  $insTimeStart . " WHERE joined_with = " . $this->id . " AND TIME_FORMAT(TIMEDIFF(time_start, " .  $insTimeStart . "), '%m%d%k%i%s') < 0;";
			
			if ($insTimeEnd != "NULL")
				$leaderStatusQuery .= "UPDATE status SET time_end = " .  $insTimeEnd . " WHERE joined_with = " . $this->id . " AND TIME_FORMAT(TIMEDIFF(time_end, " .  $insTimeEnd . "), '%m%d%k%i%s') > 0;";
			
			$multiResult = @mysqli_multi_query($dbc, $leaderStatusQuery);
			
			while (mysqli_next_result($dbc)) {}
			
		}
		
		else {
			
			$new = true;
			
			StatusManager::getStatusManager()->cancelCurrentStatus();
			
			$leaderStatusQuery = "INSERT IGNORE INTO status (user_id, time_start, time_end, update_time) VALUES ('" . $_SESSION['user_id'] . "', " . $insTimeStart . ", " . $insTimeEnd . ", '" . Time::getNowUnivTimeMicro() . "');";
			$leaderStatusQuery .= "UPDATE user SET num_updates = num_updates + 1";
			
			$multiResult = @mysqli_multi_query($dbc, $leaderStatusQuery);
			
			while (mysqli_next_result($dbc)) {}
			
			if (mysqli_affected_rows($dbc) == 0)  //this is to ensure that the inserted status is not a duplicate
				return false;
			
			$leaderStatusQuery = "SELECT id FROM status WHERE user_id = '" . $_SESSION['user_id']. "' AND time_start = " . $insTimeStart;
			
			if ($result = @mysqli_query($dbc, $leaderStatusQuery)) {

				if ($statusID = mysqli_fetch_array($result)) {
					
					$this->id = $statusID['id'];
					
				}
				
			}
				
			$leaderStatusQuery = "INSERT INTO status_leader (status_id, place, activity, party_id, max_people, max_guys, max_girls, light, list_id) VALUES (" . $this->id . ", " .  $insPlace . "," . $insActivity . ", " . $insPartyID . ", " . $insMaxPeople . ", " . $insMaxGuys . ", " . $insMaxGirls . ", " . $insLight . ", " . $insListID . ")";
			
			$result = @mysqli_query($dbc, $leaderStatusQuery);
			
			
		}

		if ($this->joinedUsers != NULL) {
			
			$valuesString  = "";
			
			foreach($this->joinedUsers as $joinedUser) {
				
				$userID = Verifier::dbReady($joinedUser);
				
				$valuesString .= "(" . $userID . ", " . $insTimeStart . ", " . $insTimeEnd . ", '" . Time::getNowUnivTimeMicro() . "', " . $this->id . "), ";
				
			}
			
			$valuesString = substr($valuesString, 0, strlen($valuesString)-2);
				
			/*NOTE: There is a unique index on user_id and joined_with so that insert will ignore if joined user is already joined */
			
			$leaderStatusQuery = "INSERT IGNORE INTO status(user_id, time_start, time_end, update_time, joined_with) VALUES " . $valuesString;

			$result = @mysqli_query($dbc, $leaderStatusQuery);
			
			echo mysqli_error($dbc);
			
		}
		
		if ($new == true) {
			
			CommunicationsManager::getCommunicationsManager()->tryUpdateCommunication($this->id, $this->place, $this->activity, $this->joinedUsers, $this->light);
			
			if ($this->twitterPublish == 1)		
				TwitterManager::getTwitterManager()->publishData($this->place, $this->light, $this->joinedUsers);
				
			$socialMeter = SocialMeter::afterStatusUpdateConstructor($this->id, $this->facebookPublish, $this->twitterPublish);
						
			$socialMeter->save();		
			
		}
	
	}
	
	
	public function toFullJSONString() {
		
		$place = Verifier::JSONReadyText($this->place);
		$activity = Verifier::JSONReadyText($this->activity);
		
		$return_str = <<<EOD
		
        	"Status": [
				{ 
					"id": "{$this->id}",
					"ts": "{$this->timeStart}",
					"te": "{$this->timeEnd}",
					"pl": "{$place}",
					"ac": "{$activity}",
					"pa": "{$this->partyID}",
					"mp": "{$this->maxPeople}",
					"mgu": "{$this->maxGuys}",
					"mgi": "{$this->maxGirls}",
					"li": "{$this->light}",
					"ut": "{$this->updateTime}"
				}
				
			],
EOD;

		if ($this->joinedUsers != NULL)
			$return_str .= $this->joinedUsersToJSONString();
			
		if ($this->signalList != NULL)
			$return_str .= $this->signalList->toJSONString();
			
		return $return_str;
		
	}
	
	
	public function isLeaderStatus() {
		return true;
		
	}
	
	
	public function cancelJoiningUsersStatuses() {
		
		if ($this->joinedUsers != NULL)
			StatusManager::getStatusManager()->cancelStatuses($this->joinedUsers);
			
	}
	
	
}

?>