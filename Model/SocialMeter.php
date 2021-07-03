<?php

class SocialMeter {

	private $userID;
	private $currentSocialRating;
	private $numLogins;
	private $numGreen;
	private $numYellow;
	private $numRed;
	private $gender;
	private $numTimesJoinedGuy;
	private $numTimesJoinedGirl;
	private $numSelfJoiningGuys;
	private $numSelfJoiningGirls;
	private $numJoiningGuys;
	private $numJoiningGirls;
	private $numDetailsProvided;
	private $registrationDate;
	private $numGuyFriends;
	private $numGirlFriends;
	private $numFacebookUpdates;
	private $numTwitterUpdates;
	private $friendAvgSocialRating;
	
	
	private function __construct() {

	}
	
	
	
	private static function innerConstructor($userIDEqualsString) {
		
		$socialMeter = new SocialMeter();
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		
		$socialMeterManagerQuery = "SELECT u.id, u.social_rating, u.num_logins, u.num_green, u.num_yellow, u.num_red, u.num_times_joining_guy, u.num_times_joining_girl, u.num_guy_self_join, u.num_girl_self_join, u.num_guy_nonself_joins, u.num_girl_nonself_joins, u.num_details_provided, u.registration_date, u.gender, u.num_facebook_updates, u.num_twitter_updates, IFNULL(u2.guys, 0) AS num_guy_friends, IFNULL(u2.girls, 0) AS num_girl_friends, IFNULL(u2.rating, 0) AS avg_friend_social_rating FROM user AS u 
		
			LEFT OUTER JOIN (SELECT f.user_id, COUNT(u.id) AS guys, COUNT(u2.id) AS girls, AVG(u3.social_rating) AS rating FROM friend AS f 
							 
				LEFT OUTER JOIN (SELECT id FROM user WHERE gender = 0) AS u ON u.id = f.friend_id
				
				LEFT OUTER JOIN (SELECT id FROM user WHERE gender = 1) AS u2 ON u2.id = f.friend_id
				
				LEFT OUTER JOIN (SELECT id, social_rating FROM user) AS u3 ON u3.id = f.friend_id
				
			GROUP BY f.user_id) AS u2 ON u2.user_id = u.id
			
		WHERE u.id = " . $userIDEqualsString;
			
			
		if ($result = @mysqli_query($dbc, $socialMeterManagerQuery)) {

			if ($constructorAR = mysqli_fetch_array($result)) {
				
				$socialMeter->userID = $constructorAR['id'];
				$socialMeter->currentSocialRating = $constructorAR['social_rating'];
				$socialMeter->numLogins = $constructorAR['num_logins'];
				$socialMeter->numGreen = $constructorAR['num_green'];
				$socialMeter->numYellow = $constructorAR['num_yellow'];
				$socialMeter->numRed = $constructorAR['num_red'];
				$socialMeter->gender = $constructorAR['gender'];
				$socialMeter->numDetailsProvided = $constructorAR['num_details_provided'];
				$socialMeter->registrationDate = $constructorAR['registration_date'];
				$socialMeter->numGuyFriends = $constructorAR['num_guy_friends'];
				$socialMeter->numGirlFriends = $constructorAR['num_girl_friends'];
				$socialMeter->friendAvgSocialRating = $constructorAR['avg_friend_social_rating'];
				$socialMeter->numTimesJoinedGuy = $constructorAR['num_times_joining_guy'];
				$socialMeter->numTimesJoinedGirl = $constructorAR['num_times_joining_girl'];
				$socialMeter->numSelfJoiningGuys = $constructorAR['num_guy_self_join'];
				$socialMeter->numSelfJoiningGirls = $constructorAR['num_girl_self_join'];
				$socialMeter->numJoiningGuys = $constructorAR['num_guy_nonself_joins'];
				$socialMeter->numJoiningGirls = $constructorAR['num_girl_nonself_joins'];
				$socialMeter->numFacebookUpdates = $constructorAR['num_facebook_updates'];
				$socialMeter->numTwitterUpdates = $constructorAR['num_twitter_updates'];
				
			}
			
		}	
		
		return $socialMeter;
		
	}
	
	
	public static function awardsConstructor() {
		
		$socialMeter = SocialMeter::innerConstructor($_SESSION['user_id']);	
		
		return $socialMeter;
		
	} 
	
	
	
	
	
	public static function afterStatusUpdateConstructor($statusID, $facebookPublish, $twitterPublish) {
		
		$socialMeter = SocialMeter::innerConstructor($_SESSION['user_id']);
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$socialMeterManagerQuery = "SELECT sl.light, IF(sl.activity IS NULL AND sl.place IS NULL, 0, 1) AS details_provided, IFNULL(u.guys, 0) AS num_guys_joined, IFNULL(u2.girls, 0) AS num_girls_joined FROM status_leader AS sl
		
		LEFT OUTER JOIN (SELECT s.joined_with, COUNT(*) AS guys FROM status AS s, user AS u WHERE s.user_id = u.id AND u.gender = 0 AND s.canceled = 0 GROUP BY s.joined_with) AS u ON u.joined_with = sl.status_id
		
		LEFT OUTER JOIN (SELECT s.joined_with, COUNT(*) AS girls FROM status AS s, user AS u WHERE s.user_id = u.id AND u.gender = 1 AND s.canceled = 0 GROUP BY s.joined_with) AS u2 ON u2.joined_with = sl.status_id
		
		WHERE sl.status_id = " . $statusID;
		
		if ($result = @mysqli_query($dbc, $socialMeterManagerQuery)) {

			if ($constructorAR = mysqli_fetch_array($result)) {
				
				if ($constructorAR['light'] == 1)
					$socialMeter->numGreen++;
				else if ($constructorAR['light'] == 2)
					$socialMeter->numYellow++;
				else if ($constructorAR['light'] == 3)
					$socialMeter->numRed++;
					
				$socialMeter->numDetailsProvided += $constructorAR['details_provided'];
				$socialMeter->numSelfJoiningGuys += $constructorAR['num_guys_joined'];
				$socialMeter->numSelfJoiningGirls += $constructorAR['num_girls_joined'];
				
				if ($facebookPublish == 1)
					$socialMeter->numFacebookUpdates++;
					
				if ($twitterPublish == 1)
					$socialMeter->numTwitterUpdates++;				

			}
			
		}	
		
		return $socialMeter;
		
	}
	
	
	
	
	public static function afterJoinUpdateLeaderConstructor($joiningID) {
		
		$insString = "(SELECT user_id FROM status WHERE id = " . $joiningID . ")";
		
		$socialMeter = SocialMeter::innerConstructor($insString);
		
		$dbc = DatabaseConnection::getDatabaseConnection();	
		
		$socialMeterManagerQuery = "SELECT IFNULL(u.guys, 0) AS num_guys_joined, IFNULL(u2.girls, 0) AS num_girls_joined FROM status AS s
		
		LEFT OUTER JOIN (SELECT s.joined_with, COUNT(*) AS guys FROM status AS s, user AS u WHERE s.user_id = u.id AND u.gender = 0 AND s.update_time - " . Time::getNowUnivTimeMicro() . " > 0 AND s.canceled = 0 GROUP BY s.joined_with) AS u ON u.joined_with = s.id
		
		LEFT OUTER JOIN (SELECT s.joined_with, COUNT(*) AS girls FROM status AS s, user AS u WHERE s.user_id = u.id AND u.gender = 1 AND s.update_time - " . Time::getNowUnivTimeMicro() . " > 0 AND s.canceled = 0 GROUP BY s.joined_with) AS u2 ON u2.joined_with = s.id
		
		WHERE s.id = " . $joiningID;
		
		if ($result = @mysqli_query($dbc, $socialMeterManagerQuery)) {

			if ($constructorAR = mysqli_fetch_array($result)) {

				$socialMeter->numJoiningGuys += $constructorAR['num_guys_joined'];
				$socialMeter->numJoiningGirls += $constructorAR['num_girls_joined'];
				
			}
			
		}	
		
		return $socialMeter;
		
	}
	
	
	public static function afterJoinUpdateJoineeConstructor($joiningID) {
		
		$socialMeter = SocialMeter::innerConstructor($_SESSION['user_id']);
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$socialMeterManagerQuery = "SELECT u.gender FROM user AS u, status AS s WHERE u.id = s.user_id AND s.id = " . $joiningID;
		
		if ($result = @mysqli_query($dbc, $socialMeterManagerQuery)) {

			if ($constructorAR = mysqli_fetch_array($result)) {
				
				if ($constructorAR['gender'] == 0)
					$socialMeter->numTimesJoinedGuy++;
				else 
					$socialMeter->numTimesJoinedGirl++;
				
			}
			
		}	
		
		return $socialMeter;
		
	}
	
	
	public static function afterLoginConstructor() {
		
		$socialMeter = SocialMeter::innerConstructor($_SESSION['user_id']);
		
		$socialMeter->numLogins++;		
		
		return $socialMeter;
		
	}
	
	
	public function save() {
		
		$this->calculateSocialRating();
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$socialMeterManagerQuery = "UPDATE user SET social_rating = " . $this->currentSocialRating . ", num_logins = " . $this->numLogins . ", num_green = " . $this->numGreen . ", num_yellow = " . $this->numYellow . ", num_red = " . $this->numRed . ", num_times_joining_guy = " . $this->numTimesJoinedGuy . ", num_times_joining_girl = " . $this->numTimesJoinedGirl . ", num_guy_self_join = " . $this->numSelfJoiningGuys . ", num_girl_self_join = " . $this->numSelfJoiningGirls . ", num_guy_nonself_joins = " . $this->numJoiningGuys . ", num_girl_nonself_joins = " . $this->numJoiningGirls . ", num_facebook_updates = " . $this->numFacebookUpdates . ", num_twitter_updates = " . $this->numTwitterUpdates . ", num_details_provided = " . $this->numDetailsProvided . " WHERE id = " . $this->userID;
		
		$result = @mysqli_query($dbc, $socialMeterManagerQuery);
		
	}
	
	
	private function calculateSocialRating() {


		/********** Universal Variables ************/
		$daysRegistered = Time::getDaysSince($this->registrationDate) == 0 ? 1 : Time::getDaysSince($this->registrationDate);
		$totalUpdates = $this->numGreen + $this->numYellow + $this->numRed;
		$totalFriends = $this->numGuyFriends + $this->numGirlFriends;
		$loginsPerDay = $this->numLogins/$daysRegistered;
		$updatesPerDay = $totalUpdates/$daysRegistered;
		$friendsPerDay = $totalFriends/$daysRegistered;
		$facebooksPerUpdate = $totalUpdates > 0 ? $this->numFacebookUpdates/$totalUpdates : 0;
		$tweetsPerUpdate = $totalUpdates > 0 ? $this->numTwitterUpdates/$totalUpdates : 0;
			
		/********** Long term social meter growth ************/
		
			  /******** variable array ***********/
			  $variableArray = array(
				  $loginsPerDay,
				  $updatesPerDay,
				  $totalUpdates > 0 ? $this->numDetailsProvided/$totalUpdates : 0, 
				  $friendsPerDay, 
				  $facebooksPerUpdate,
				  $tweetsPerUpdate,
				  $daysRegistered
			  );
		
			  /******** perfect long term growth ***********/
			  $perfectArray = array(
				  2.5,
				  2.5,
				  .6, 
				  1, 
				  .1,
				  .05,
				  30
			  );
			  
			  /******** weights long term growth ***********/
			  $weightsArray = array(
				  .05,
				  .2,
				  .075, 
				  .175, 
				  .25,
				  .1,
				  .15
			  );
			  
			  /********* final sum *************/
			  $socialMeter = $this->calculateWeightedSum($variableArray, $perfectArray, $weightsArray) * 10;
			  
			  LoggingManager::getLoggingManager()->writeToLog(print_r($variableArray, true) . "|||||" . $socialMeter);
			  
			  if ($socialMeter > 9)				
				 $socialMeter = 9 - 1/rand(1, 5);
			  
			  $this->currentSocialRating = round($socialMeter, 1);
		
	}
	
	
	public static function getSocialRating($userID) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$socialMeterManagerQuery = "SELECT social_rating FROM user WHERE id = " . $userID;
		
		if ($result = @mysqli_query($dbc, $socialMeterManagerQuery)) {

			if ($constructorAR = mysqli_fetch_array($result)) {
				
				return $constructorAR['social_rating'];
				
			}
			
		}
		
		return NULL;
		
	}
	
	
	public static function getYourCurrentSocialRating() {
		
		return SocialMeter::getSocialRating($_SESSION['user_id']);
				
	}
	
	
	public static function getYourCurrentSocialRatingJSON() {
		
		$socialRating = SocialMeter::getYourCurrentSocialRating();
		
		$return_str = <<<EOD
		
        	"SocialRating": [
				{ 
					"sr": "{$socialRating}"
				}
				
			],
EOD;
		
	}
	
	
	private function calculateWeightedSum($variableAR, $perfectAR, $weightsAR) {
		
		$sum = 0;
		
		for ($i = 0; $i < count($variableAR); $i++) {
			$temp = $weightsAR[$i] * ($variableAR[$i]/$perfectAR[$i]);
			$sum += $temp > $weightsAR[$i] ? $weightsAR[$i] : $temp;
		}
		
		return $sum;
		
	}
	
	
	
	private function calculateSubtractSum($variableAR, $maxAR, $subtractPerAR) {
		
		$sum = 0;
		
		for ($i = 0; $i < count($variableAR); $i++) {
			if ($variableAR[$i] > $maxAR[$i]) {
				$j = $variableAR[$i];
				while($j > $maxAR[$i]) {
					$sum += $subtractPerAR[$i];
					$j--;
				}
			}
		}
		
		return $sum;
		
	}
	
	
	public function getNumLogins() {
		return $this->numLogins;	
	}
	
	public function getTotalSignals() {
		return $this->numGreen + $this->numYellow + $this->numRed;	
	}
	
	public function getTotalJoins() {
		return $this->numTimesJoinedGuy + $this->numTimesJoinedGirl + $this->numSelfJoiningGuys + $this->numSelfJoiningGirls;	
	}
	
	public function getNumFacebookSignals() {
		return $this->numFacebookUpdates;	
	}
	
	public function getNumGuyFriends() {
		return $this->numGuyFriends;
	}
	
	public function getNumGirlFriends() {
		return $this->numGirlFriends;
	}  
	
}

?>