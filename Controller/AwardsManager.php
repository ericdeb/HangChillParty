<?php

class AwardsManager {
	
	
	private static $instance = false;
	private $awardUnknownSource = "Images/awardUnknown.png";
	private $socialMeterZeroToTwoSource = "Images/socialMeterZeroToTwo.png";
	private $socialMeterTwoToFourSource = "Images/socialMeterTwoToFour.png";
	private $socialMeterFourToSixSource = "Images/socialMeterFourToSix.png";
	private $socialMeterSixToEightSource = "Images/socialMeterSixToEight.png";
	private $socialMeterEightToTenSource = "Images/socialMeterEightToTen.png";
	private $barnvilleHabitSource = "Images/awardsBarnvilleHabit.gif";
	private $cuteBoobSource = "Images/awardsCuteBoob.gif";
	private $deactivatedSpacebookSource = "Images/awardsDeactivatedSpacebook.gif";
	private $fakeIDSource = "Images/awardsFakeID.gif";
	private $firstPartySource = "Images/awardsFirstParty.gif";
	private $freakyWithThreeSource = "Images/awardsFreakyWithThree.gif";
	private $friendedCopSource = "Images/awardsFriendedCop.gif";
	private $geraldSource = "Images/awardsGerald.gif";
	private $golfingWithCelebsSource = "Images/awardsGolfingWithCelebs.gif";
	private $jockJamsSource = "Images/awardsJockJams.gif";
	private $lostVirginitySource = "Images/awardsLostVirginity.gif";
	private $madeFunOfGeraldSource = "Images/awardsMadeFunOfGerald.gif";
	private $rappersDelightSource = "Images/awardsRappersDelight.gif";
	private $spacebookStalkingSource = "Images/awardsSpacebookStalking.gif";
	private $spacebookStatusesSource = "Images/awardsSpacebookStatuses.gif";
	
	

	private function __construct() {
		
	}
	
	
	public static function getAwardsManager() {
		
		if (!AwardsManager::$instance) {
			
			AwardsManager::$instance = new AwardsManager();
			
		}
		
		return AwardsManager::$instance;
		
	}

	
	public function getAwardsNumbersJSON() {
		
		$num = $this->getSocialMeterAwardNumber() + $this->getGeneralAwardNumber();
		
		$return_str = <<<EOD
		
        	"AwardNumber": [
				{ 
					"nu": "{$num}"
				}
				
			],
EOD;
		
		return $return_str;
		
	}
	
	
	private function getSocialMeterAwardNumber() {
	
		$csr = SocialMeter::getYourCurrentSocialRating();
		$ssr = $_SESSION['social_rating'];
		$_SESSION['social_rating'] = $csr;
		
		if (($ssr == 0 && $csr >= 0) || ($csr < 2 && $ssr >= 2)) {
			array_push($_SESSION['social_rating_awards'], $this->socialMeterZeroToTwoSource);
			return 1;
		}
		
		else if (($ssr < 2 && $csr >= 2) || ($csr < 4 && $ssr >= 4)) {
			array_push($_SESSION['social_rating_awards'], $this->socialMeterTwoToFourSource);
			return 1;	
		}
		
		else if (($ssr < 4 && $csr >= 4) || ($csr < 6 && $ssr >= 6)) {
			array_push($_SESSION['social_rating_awards'], $this->socialMeterFourToSixSource);
			return 1;	
		}
		
		else if (($ssr < 6 && $csr >= 6) || ($csr < 8 && $ssr >= 8)) {
			array_push($_SESSION['social_rating_awards'], $this->socialMeterSixToEightSource);
			return 1;	
		}
		
		else if ($ssr < 8 && $csr >= 8) {
			array_push($_SESSION['social_rating_awards'], $this->socialMeterEightToTenSource);
			return 1;	
		}			

		return 0;		
		
	}
	
	
	private function getGeneralAwardNumber() {
		
		$awardData = SocialMeter::awardsConstructor();
		
		$awardsAccepted = AwardsAccepted::myAwardsConstructor();
	
		$totalNum = 0;
		
		if ($awardData->getTotalSignals() >= 1 && $awardsAccepted->getAward("barnvilleHabit") == false) {

			if (!in_array($this->barnvilleHabitSource, $_SESSION['general_awards'])) {
				array_push($_SESSION['general_awards'], $this->barnvilleHabitSource, "barnville_habit");
				$totalNum++;
			}
			
		}
		
		if (($_SESSION['gender'] == 0 && $awardData->getNumGirlFriends() >= 1) || ($_SESSION['gender'] == 1 && $awardData->getNumGuyFriends() >= 1)) {
			
			if ($awardsAccepted->getAward("cuteBoob") == false && !in_array($this->cuteBoobSource, $_SESSION['general_awards'])) {
			
				array_push($_SESSION['general_awards'], $this->cuteBoobSource, "cute_boob");
				$totalNum++;
			
			}
			
		}		
		
		
		if ($awardData->getNumFacebookSignals() >= 10 && $awardsAccepted->getAward("deactivatedSpacebook") == false) {
			
			if (!in_array($this->deactivatedSpacebookSource, $_SESSION['general_awards'])) {
				array_push($_SESSION['general_awards'], $this->deactivatedSpacebookSource, "deactivate_spacebook");
				$totalNum++;
			}
			
		}	
		
		
		if ($awardData->getNumLogins() >= 25 && $awardsAccepted->getAward("fakeID") == false) {
			
			if (!in_array($this->fakeIDSource, $_SESSION['general_awards'])) {
				array_push($_SESSION['general_awards'], $this->fakeIDSource, "fake_id");
				$totalNum++;
			}
			
		}
		
		if ($awardData->getTotalJoins() >= 10 && $awardsAccepted->getAward("firstParty") == false) {
			
			if (!in_array($this->firstPartySource, $_SESSION['general_awards'])) {
				array_push($_SESSION['general_awards'], $this->firstPartySource, "first_party");
				$totalNum++;
			}
			
		}
		
		if ($awardData->getTotalSignals() >= 50 && $awardsAccepted->getAward("freakyWithThree") == false) {
			
			if (!in_array($this->freakyWithThreeSource, $_SESSION['general_awards'])) {
				array_push($_SESSION['general_awards'], $this->freakyWithThreeSource, "freaky_with_three");
				$totalNum++;
			}
			
		}
		
		if ($awardData->getTotalSignals() >= 30 && $awardsAccepted->getAward("friendedCop") == false) {
			
			if (!in_array($this->friendedCopSource, $_SESSION['general_awards'])) {
				array_push($_SESSION['general_awards'], $this->friendedCopSource, "friended_cop");
				$totalNum++;
			}
			
		}
		
		if (($_SESSION['gender'] == 0 && $awardData->getNumGuyFriends() >= 1) || ($_SESSION['gender'] == 1 && $awardData->getNumGirlFriends() >= 1)) {
			
			if ($awardsAccepted->getAward("gerald") == false && !in_array($this->geraldSource, $_SESSION['general_awards'])) {
			
				array_push($_SESSION['general_awards'], $this->geraldSource, "gerald");
				$totalNum++;
			
			}
			
		}
		
		if ($awardData->getTotalSignals() >= 100 && $awardsAccepted->getAward("golfingWithCelebs") == false) {
			
			if (!in_array($this->golfingWithCelebsSource, $_SESSION['general_awards'])) {
				array_push($_SESSION['general_awards'], $this->golfingWithCelebsSource, "golfing_with_celebs");
				$totalNum++;
			}
			
		}
		
		if ($awardData->getNumLogins() >= 7 && $awardsAccepted->getAward("jockJams") == false) {
			
			if (!in_array($this->jockJamsSource, $_SESSION['general_awards'])) {
				array_push($_SESSION['general_awards'], $this->jockJamsSource, "jock_jams");
				$totalNum++;
			}
			
		}
		
		if ($awardData->getTotalSignals() >= 100 && $awardsAccepted->getAward("lostVirginity") == false) {
		
			if (!in_array($this->lostVirginitySource, $_SESSION['general_awards'])) {
				array_push($_SESSION['general_awards'], $this->lostVirginitySource, "lost_virginity");
				$totalNum++;
			}
			
		}
		
		if ($awardData->getTotalSignals() >= 5 && $awardsAccepted->getAward("madeFunOfGerald") == false) {
			
			if (!in_array($this->madeFunOfGeraldSource, $_SESSION['general_awards'])) {
				array_push($_SESSION['general_awards'], $this->madeFunOfGeraldSource, "made_fun_of_gerald");
				$totalNum++;
			}
			
		}	
		
		if ($awardData->getTotalSignals() >= 15 && $awardsAccepted->getAward("rappersDelight") == false) {
			
			if (!in_array($this->rappersDelightSource, $_SESSION['general_awards'])) {
				array_push($_SESSION['general_awards'], $this->rappersDelightSource, "rappers_delight");
				$totalNum++;
			}
			
		}	
		
		if ($awardData->getNumFacebookSignals() >= 1 && $awardsAccepted->getAward("spacebookStalking") == false) {
			
			if (!in_array($this->spacebookStalkingSource, $_SESSION['general_awards'])) {
				array_push($_SESSION['general_awards'], $this->spacebookStalkingSource, "spacebook_stalking");
				$totalNum++;
			}
			
		}	
		
		if ($awardData->getNumFacebookSignals() >= 1 && $awardsAccepted->getAward("spacebookStatuses") == false) {
			
			if (!in_array($this->spacebookStatusesSource, $_SESSION['general_awards'])) {
				array_push($_SESSION['general_awards'], $this->spacebookStatusesSource, "spacebook_statuses");
				$totalNum++;
			}
			
		}
		
		return $totalNum;
		
		
	}
	
	
	public function getNewAwardImage() {
		
		$imagePath = $this->awardUnknownSource;
		
		if (count($_SESSION['social_rating_awards']) > 0)
			$imagePath = array_shift($_SESSION['social_rating_awards']);
		else if (count($_SESSION['general_awards']) > 0) {
			$imagePath = array_shift($_SESSION['general_awards']);
			$awardDBName = array_shift($_SESSION['general_awards']);
			
			AwardsAccepted::saveSingleAwardTrue($awardDBName);
			
		}
		
		$awardImage = @imagecreatefromgif($imagePath);
		
		imagegif($awardImage);		
		
	}
	
	
	public function getSocialMeterAwardImage($userID) {
		
		$usr = getSocialRating($userID);
		$ssr = $_SESSION['social_rating'];
	
		$imagePath = $this->awardUnknownSource;
		
		if (FriendsManager::getFriendsManager()->friendsTest($userID) == true || $userID == $_SESSION['user_id']) {
		
			if ($usr >= 8 && $ssr >= 8)
				$imagePath = $this->socialMeterEightToTenSource;
			else if ($usr >= 6 && $usr < 8 && $ssr >= 6 && $ssr < 8)
				$imagePath = $this->socialMeterSixToEightSource;
			else if ($usr >= 4 && $usr < 6 && $ssr >= 4 && $ssr < 6)
				$imagePath = $this->socialMeterFourToSixSource;
			else if ($usr >= 2 && $usr < 4 && $ssr >= 2 && $ssr < 4)
				$imagePath = $this->socialMeterTwoToFourSource;	
			else if ($usr >= 0 && $usr < 2 && $ssr >= 0 && $ssr < 2)
				$imagePath = $this->socialMeterZeroToTwoSource;
				
		}
		
		$awardImage = @imagecreatefrompng($imagePath);
		
		imagepng($awardImage);
		
	}

}


?>