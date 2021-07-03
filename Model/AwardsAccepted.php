<?php

class AwardsAccepted {
	
	private $userID = false;
	private $barnvilleHabit = false;
	private $cuteBoob = false;
	private $deactivatedSpacebook = false;
	private $fakeID = false;
	private $firstParty = false;
	private $freakyWithThree = false;
	private $friendedCop = false;
	private $gerald = false;
	private $golfingWithCelebs = false;
	private $jockJams = false;
	private $lostVirginity = false;
	private $madeFunOfGerald = false;
	private $rappersDelight = false;
	private $spacebookStalking = false;
	private $spacebookStatuses = false;
	
	

	private function __construct() {
		
	}
	
	
	private static function innerConstructor($userID) {
		
		$awardsAccepted = new AwardsAccepted();
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$awardsAcceptedQuery = "SELECT * FROM awards WHERE user_id = " . $userID;		
			
		if ($result = @mysqli_query($dbc, $awardsAcceptedQuery)) {

			if ($constructorAR = mysqli_fetch_array($result)) {
				
				foreach ($constructorAR as $key => $value) {
					
					if (is_numeric($key))
						continue;
				
					if ($key != "user_id") 
						$constructorAR[$key] = $value == 1 ? true : false;
				
				}
				
				$awardsAccepted->barnvilleHabit = $constructorAR['barnville_habit'];
				$awardsAccepted->cuteBoob = $constructorAR['cute_boob'];
				$awardsAccepted->deactivatedSpacebook = $constructorAR['deactivate_spacebook'];
				$awardsAccepted->fakeID = $constructorAR['fake_id'];
				$awardsAccepted->firstParty = $constructorAR['first_party'];
				$awardsAccepted->freakyWithThree = $constructorAR['freaky_with_three'];
				$awardsAccepted->friendedCop = $constructorAR['friended_cop'];
				$awardsAccepted->gerald = $constructorAR['gerald'];
				$awardsAccepted->golfingWithCelebs = $constructorAR['golfing_with_celebs'];
				$awardsAccepted->jockJams = $constructorAR['jock_jams'];
				$awardsAccepted->lostVirginity = $constructorAR['lost_virginity'];
				$awardsAccepted->madeFunOfGerald = $constructorAR['made_fun_of_gerald'];
				$awardsAccepted->rappersDelight = $constructorAR['rappers_delight'];
				$awardsAccepted->spacebookStalking = $constructorAR['spacebook_stalking'];
				$awardsAccepted->spacebookStatuses = $constructorAR['spacebook_statuses'];
				
			}
			
		}	
		
		return $awardsAccepted;
		
	}
	
	
	public static function myAwardsConstructor() {
		
		return AwardsAccepted::innerConstructor($_SESSION['user_id']);
		
	}
	
	
	public static function friendsAwardsConstructor($userID) {
		
		return AwardsAccepted::innerConstructor($userID);
		
	}
	
	
	public function getAward($awardName) {
	
		foreach ($this as $key => $value) {
			
			if ($awardName == $key)
				return $value;
				
		}
		
	}
	
	
	public function setAward($awardName, $value) {
		
		foreach ($this as $key => $value) {
			
			if ($awardName == $key)
				$this[$key] = $value;
				
		}
		
	}
	
	
	public function save() {
		
		if ($this->userID != $_SESSION['user_id'])	
			return false;
			
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$insAR = array();
		
		foreach ($this as $key => $value) {
			
			if ($key != "user_id")
				$insAR[$key] = $value == true ? 1 : 0;
				
		}
		
		$awardsAcceptedQuery = "UPDATE awards SET barnville_habit =  " . $insAR['barnvilleHabit'] . ", gerald = " . $insAR['gerald'] . ", spacebook_stalking = " . $insAR['spacebookStalking'] . ", cute_boob = " . $insAR['cute_boob'] . ", jock_jams = " . $insAR['jockJams'] . ", made_fun_of_gerald = " . $insAR['madeFunOfGerald'] . ", first_party = " . $insAR['firstParty'] .	", spacebook_statuses = " . $insAR['spacebookStatuses'] . ", fake_id = " . $insAR['fakeID'] . ", rappers_delight = " . $insAR['rappersDelight'] . ", lost_virginity = " . $insAR['lostVirginity'] . ", friended_cop = " . $insAR['friended_cop'] . ", freaky_with_three = " . $insAR['freakyWithThree'] . ", golfing_with_celebs = " . $insAR['golfingWithCelebs'] . ", deactivate_spacebook = " . $insAR['deactivatedSpacebook'] . " WHERE user_id = " . $_SESSION['user_id'] . ";";  
			
		$result = @mysqli_query($dbc, $socialMeterManagerQuery);
			
	}
	
	
	public static function saveSingleAwardTrue($awardDBName) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$awardsAcceptedQuery = "UPDATE awards SET " . $awardDBName . " = 1 WHERE user_id = " . $_SESSION['user_id'] . ";"; 
		
		$result = @mysqli_query($dbc, $awardsAcceptedQuery);
		
	}

}


?>