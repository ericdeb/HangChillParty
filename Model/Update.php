<?php

class Update extends FullStatus{
	
	private $leader; //user who is group leader or update creator
	private $friend; //optional: user who is your friend if leader is a non-friend.
	private $joinedCount;
	private $canceled;
	private $yourUpdate;
	private $socialRating;
	

	private function __construct() {
		
	}
	
	
	public static function fullConstructor($id, $timeStart, $timeEnd, $place, $activity, $light, $leader, $friend, $updateTime, $joinedCount, $canceled, $yourUpdate, $socialRating) {
		
		$update = new Update();
		
		$update->id = $id;
		$update->timeStart = $timeStart;
		$update->timeEnd = $timeEnd;
		$update->place = $place;
		$update->activity = $activity;
		$update->light = $light;
		$update->leader = $leader;
		$update->friend = $friend;
		$update->updateTime = $updateTime;
		$update->joinedCount = $joinedCount;
		$update->canceled = $canceled;
		$update->yourUpdate = $yourUpdate;
		$update->socialRating = $socialRating;
		
		return $update;
		
	}
	
	
	public static function dbConstructor($joinedWithID) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$update = new Update();
		
		$updateQuery = "SELECT u.id, u.first_name, u.last_name, u.social_rating, s.id AS status_id, s.time_start, s.time_end, s.update_time, IFNULL(s3.cnt, 0) AS cnt, sl.place, sl.activity, sl.max_people, sl.max_guys, sl.max_girls, s2.id AS friend_id, s2.first_name AS friend_first_name, s2.last_name AS friend_last_name FROM user AS u, status_leader AS sl, status AS s
		
		JOIN(SELECT s.joined_with, u.id, u.first_name, u.last_name FROM friend AS f, status AS s, user AS u WHERE s.user_id = f.friend_id AND f.user_id = '" . $_SESSION['user_id'] . "' AND s.user_id = u.id AND f.friend_id = u.id GROUP BY s.joined_with) AS s2 ON s2.joined_with = s.id
		
		LEFT OUTER JOIN (SELECT joined_with, COUNT(*) AS cnt FROM status) AS s3 ON s3.joined_with = s.id 
		
		WHERE s.user_id = u.id AND sl.status_id = s.id AND s.id = " . $joinedWithID;
		
		if ($result = @mysqli_query($dbc, $updateQuery)) {

			if ($updatesAR = mysqli_fetch_array($result)) {
				
				return UpdatesManager::getUpdatesManager()->constructUpdateFromDB($updatesAR);
				
			}
			
		}
		
		echo mysqli_error($dbc);
		
	}

	
	public function toFullJSONString() {
		
		$return_str = '"Update": [' . $this->toPartJSONString() . '],';
		
		if ($this->joinedUsers != NULL)
			$return_str .= $this->joinedUsersToJSONString();
		
		return $return_str;
		
	}
	
	
	public function toPartJSONString() { 
	
		$place = Verifier::JSONReadyText($this->place);
		$activity = Verifier::JSONReadyText($this->activity);
		$leaderID = $this->leader->getID();
		$leaderFirstName = Verifier::JSONReadyName($this->leader->getFirstName());
		$leaderLastName = Verifier::JSONReadyName($this->leader->getLastName());
		$friendID = NULL; $friendFirstName = NULL; $friendLastName = NULL;
		$joinedCount = isset($this->joinedCount) ? $this->joinedCount : NULL;
		$canceled = isset($this->canceled) ? $this->canceled : NULL;
		$yourUpdate = isset($this->yourUpdate) ? ($this->yourUpdate == true ? 1 : 0) : NULL;
		
		if ($this->friend != NULL) {
			
			$friendID = $this->friend->getID();
			$friendFirstName = Verifier::JSONReadyName($this->friend->getFirstName());
			$friendLastName = Verifier::JSONReadyName($this->friend->getLastName());
			
		}		
		
		$return_str = <<<EOD
		
				{ 
					"id": "{$this->id}",
					"ts": "{$this->timeStart}",
					"te": "{$this->timeEnd}",
					"pl": "{$place}",
					"ac": "{$activity}",
					"li": "{$this->light}",
					"lid": "{$leaderID}",
					"lfn": "{$leaderFirstName}",
					"lln": "{$leaderLastName}",
					"fid": "{$friendID}",
					"ffn": "{$friendFirstName}",
					"fln": "{$friendLastName}",
					"fc": "{$joinedCount}",
					"sr": "{$this->socialRating}",
					"ca": "{$canceled}",
					"yu": "{$yourUpdate}",
					"ut": "{$this->updateTime}"
				},
				
EOD;

	

		return $return_str;
	
	}
	
	public function getID() {
		
		return $this->id;
		
	}
	
	
	public function setYourStatusBoolean($yourStatus) {
		
		$this->yourUpdate = $yourStatus;
		/*if ($yourStatus == true && $this->leader != NULL && $this->leader->getID() != $_SESSION['user_id'])
			$this->joinedCount--;*/
	
	}
	
	
	public function setYourSocialRating($rating) {
		
		$this->socialRating = $rating;
	}
	
	
	public function getUpdateTime() {
	
		return $this->updateTime;
	
	}
	
}

?>