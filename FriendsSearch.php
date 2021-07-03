<?php

class FriendsSearch {
		
	private $name;
	private $schoolID;
	private $classYear;
	private $cityID;
	private $distance;
	private $pageNumber;
	private $orderByName;
	private $newSearch;
	private $resultsUserAR;
	private $resultsSearchCount;


	public function __construct($name, $schoolID, $classYear, $cityID, $distance, $pageNumber, $orderByName, $newSearch) {
		
		$this->name = Verifier::validateName($name);
		$this->schoolID = Verifier::validateNumber($schoolID);
		$this->classYear = Verifier::validateClass($classYear);
		$this->cityID = Verifier::validateNumber($cityID);
		$this->distance = Verifier::validateDistance($distance);
		$this->orderByName = Verifier::validateBoolean($orderByName);
		$this->newSearch = Verifier::validateBoolean($newSearch);
		
	}
	
	
	public function getResultsJSON() {
		
		$resultsUserAR = $this->getResultsUserAR();
		
		$return_str = '"searchResults": [';
		
		foreach ($resultsUserAR as $resultUser) {
				
			$return_str .= $resultUser->toSearchProfileJSONString();
			
		}
		
		$return_str .= '],';
		
		if ($this->newSearch == 1) {
		
			$return_str .= <<<EOD
			
				"searchCount": [
					{ 
						"co": "{$this->resultsSearchCount}"
					}
					
				],
EOD;

		}
		
		return $return_str;
		
		
	}
	
	
	private function getResultsUserAR() {
		
		if ($this->resultsUserAR != NULL)
			return resultsUserAR;
		
		$this->getResults();
	
	}
	
	
	private function getResultsSearchCount() {
		
		if ($this->resultsSearchCount != NULL)
			return resultsSearchCount;
		
		$this->getResults();
	
	}
	
	
	private function getResults() {
		
		$friendsManagerQuery = $this->createQueryString();
		
		if (ExceptionsManager::getExceptionsManager()->areThereExceptions() == true)
			return false;
			
		$dbc = DatabaseConnection::getDatabaseConnection();
			
		if ($multiResult = @mysqli_multi_query($dbc, $friendsManagerQuery)) {
				
			if ($result = mysqli_store_result($dbc)) { 
			
				while ($resultsAR = mysqli_fetch_array($result)) {
					
					$currentSchool = NULL;
					
					if ($resultsAR['school_id'] != NULL) 
						$currentSchool = School::limitedConstructor($resultsAR['school_id'], $resultsAR['sc_name'], $resultsAR['type']);
				
					$limitedUser = LimitedUser::fullConstructor($resultsAR['id'], $resultsAR['first_name'], $resultsAR['last_name'], $resultsAR['twitter'], $currentSchool, $resultsAR['school_class'], NULL, NULL);
					
					array_push($resultsUserAR, $limitedUser);
					
				}
				
			}
			
			if (mysqli_next_result($dbc)) {
				
				if ($result = mysqli_store_result($dbc)) {
					
					if (mysqli_num_rows($result) > 0) {
					
						if ($searchCountAR = mysqli_fetch_array($result)) {
							
							$this->resultsSearchCount = $searchCountAR['search_count'];
							
						}
						
					}
					else
						$this->resultsSearchCount = 0;
					
				}
				
			}
			
		}
					
	}
	
	
	private function createQueryString() {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$addString = "";
		
		if ($this->name != NULL)
			$addString .= " AND MATCH(u.first_name, u.last_name) AGAINST ('" . Verifier::dbReady($this->name) ."') ";
		
		if ($this->schoolID != NULL)	
			$addString .= " AND us.school_id = '" . Verifier::dbReady($this->schoolID)  ."' ";
			
		if ($this->classYear != NULL)
			$addString .= " AND us.class = '". Verifier::dbReady($this->classYear) ."' ";
		
		if ($this->cityID != NULL && $this->distance != NULL) {
			
			$friendsManagerQuery = "SELECT longitude, latitude FROM city WHERE id = '". Verifier::dbReady($this->cityID) ."'";
			
			if ($result = @mysqli_query($dbc, $friendsManagerQuery)) {
				
				if($cityAR = mysqli_fetch_array($result))	{
					
					$addString .= "AND 3956.5 * 2 * ASIN(SQRT(POWER(SIN((ABS(c.latitude-".$cityAR['latitude'].")) * pi()/180 / 2), 2) + COS(c.latitude * pi()/180)*COS(ABS('".$cityAR['latitude']."') * pi()/180)*POWER(SIN(ABS(c.longitude-'".$cityAR['longitude']."') * pi()/180 / 2), 2) )) < '". Verifier::dbReady($this->distance) ."'";
					
				}
				
			}
			
		}
			
		$addStringTwo = $addString;
		$addStringTwo = $this->orderByName == 0 ? 'ORDER BY f2.cnt DESC ' : 'ORDER BY u.first_name ASC ';	
		$addStringTwo .= "LIMIT " . ($this->pageNumber-1) * 10 . "," . 10;
		
		//First join gets users' school values, second join gets mutual friend count, third and fourth join get friend request values to check to see if you have already requested this person or if they have rejected you
		
		//Core string is used in both search results count and getting the actual search results.
		
		$coreString = "FROM user AS u
		
		LEFT OUTER JOIN(SELECT us.user_id, us.school_id, us.class, s.name, s.type FROM user_school AS us, schools AS s WHERE us.school_id = s.id AND us.current = 1) AS us ON us.user_id = u.id 
		
		LEFT OUTER JOIN (SELECT f.user_id, count(*) AS cnt FROM friend AS f JOIN (SELECT friend_id FROM friend WHERE user_id = '".$_SESSION['user_id']."') AS f2 ON f2.friend_id = f.friend_id GROUP BY f.user_id) AS f2 ON f2.user_id = u.id 
		
		LEFT OUTER JOIN (SELECT request_id, status FROM user_friend_request WHERE user_id = '".$_SESSION['user_id']."') AS ufr ON ufr.request_id = u.id 
		
		LEFT OUTER JOIN (SELECT user_id, status FROM user_friend_request WHERE request_id = '".$_SESSION['user_id']."') AS ufr2 ON ufr.user_id = u.id
		
		, cities AS c 
		
		WHERE u.id != '".$_SESSION['user_id']."' AND u.city_id = c.id AND ufr.status != 2 AND ufr2.status != 2 ";
		
		//The actual results string simply adds the select part of the query, so as to actually receive the results
		
		$friendsManagerQuery .= "SELECT u.id, u.first_name, u.last_name, u.twitter, us.school_id, us.type, us.name AS sc_name, us.class AS school_class, ufr.request_id AS friend_request_check, f2.cnt AS mut_friends  " . $coreString . $addStringTwo . ";";
		
		
		//If this is a new search and a total result count is wanted, this part of the query simply counts all the results, without 
		
		if ($this->newSearch == "1" && strlen($addString) > 0)
			$friendsManagerQuery .= "SELECT COUNT(*) AS search_count FROM users AS u LEFT OUTER JOIN(SELECT u.id " . $coreString . $addString . " GROUP BY u.id) AS u2 ON u2.id = u.id WHERE u2.id IS NOT NULL";
			
		return $friendsManagerQuery;
		
	}
	
	
}

?>

