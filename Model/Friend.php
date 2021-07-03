<?php

class Friend extends FullUser{
	
	private $mutualFriendsCount;
	private $totalFriends;
	private $facebookLink;
	private $twitterName;
	private $socialRating;
	private $numberOfUpdates;
	private $friendRequestCheck;
	
	private function __construct() {
		
	}
	
	public static function dbConstructor($id) {
		
		$friend = new Friend();

		$friend->id = Verifier::validateNumber($id);
		
		$friend->getFullUserFromDB();
		
		$dbc = DatabaseConnection::getDatabaseConnection();	

		//Second join gets mutual friend count, third join gets total friend count
		
		$friendQuery = "SELECT u.facebook_link, u.twitter_name, u.social_rating, (u.num_green + u.num_yellow + num_red) AS number_updates, f2.cnt AS mut_friends, f3.cnt AS friend_count, IF(ufr.request_id IS NULL AND (ufr2.status IS NULL OR ufr2.status != 0), 0, 1) AS friend_req_check FROM user AS u 
			
		LEFT OUTER JOIN (SELECT f.user_id, count(*) AS cnt FROM friend AS f JOIN (SELECT friend_id FROM friend WHERE user_id = '".$_SESSION['user_id']."') AS f2 ON f2.friend_id = f.friend_id GROUP BY f.user_id) AS f2 ON f2.user_id = u.id 
		
		LEFT OUTER JOIN (SELECT count(*) AS cnt, user_id FROM friend GROUP BY user_id) AS f3 ON f3.user_id = u.id
		
		LEFT OUTER JOIN (SELECT request_id, status FROM user_friend_request WHERE user_id = '".$_SESSION['user_id']."') AS ufr ON ufr.request_id = u.id 
		
		LEFT OUTER JOIN (SELECT user_id, status FROM user_friend_request WHERE request_id = '".$_SESSION['user_id']."') AS ufr2 ON ufr2.user_id = u.id 
		
		WHERE u.id = " . $id;

		if ($result = @mysqli_query($dbc, $friendQuery)) {

			if ($friendAR = mysqli_fetch_array($result)) {
				
				$friend->mutualFriendsCount = $friendAR['mut_friends'];
				$friend->totalFriends = $friendAR['friend_count'];
				$friend->facebookLink = $friendAR['facebook_link'];
				$friend->twitterName = $friendAR['twitter_name'];
				$friend->socialRating = $friendAR['social_rating'];
				$friend->numberOfUpdates = $friendAR['number_updates'];
				$friend->friendRequestCheck = $friendAR['friend_req_check'];
				
			}
			
		}
		
		return $friend;
		
	}
	
	
	public function toFullJSONString($limited) {
		
		$firstName = Verifier::JSONReadyName($this->firstName);
		$lastName = Verifier::JSONReadyName($this->lastName);
		$blurb = Verifier::JSONReadyText($this->blurb);
		$phone = $limited == false ? $this->phone : '';
		$friendBool = $limited == true ? 0 : 1;
		$socialRating = $limited == true ? "" : $this->socialRating;
        
		$return_str = <<<EOD
		
        	"Friend": [
				{ 
					"id": "{$this->id}",
					"fn": "{$firstName}",
					"ln": "{$lastName}",
					"ph": "{$phone}",
					"bl": "{$blurb}",
					"fb": "{$this->facebookLink}",
					"tn": "{$this->twitterName}",
					"sr": "{$socialRating}",
					"fc": "{$this->totalFriends}",
					"mu": "{$this->mutualFriendsCount}",
					"fr": "{$friendBool}",
					"re": "{$this->friendRequestCheck}",
					"nu": "{$this->numberOfUpdates}"
				}
				
			],
EOD;


		
		return $return_str;
		
	}
	

}

?>