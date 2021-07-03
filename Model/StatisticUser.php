<?php

class StatisticUser {
	
	private $firstName;
	private $lastName;
	private $updatesOneDayAgo;
	private $updatesTwoDaysAgo;
	private $updatesThreeDaysAgo;
	private $updatesFourDaysAgo;
	private $totalUpdates;


	public function __construct($firstName, $lastName, $updatesOneDayAgo, $updatesTwoDaysAgo, $updatesThreeDaysAgo, $updatesFourDaysAgo, $numFacebookUpdates, $numTwitterUpdates, $totalUpdates) {
		
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->updatesOneDayAgo = $updatesOneDayAgo;
		$this->updatesTwoDaysAgo = $updatesTwoDaysAgo;
		$this->updatesThreeDaysAgo = $updatesThreeDaysAgo;
		$this->updatesFourDaysAgo = $updatesFourDaysAgo;
		$this->numFacebookUpdates = $numFacebookUpdates;
		$this->numTwitterUpdates = $numTwitterUpdates;
		$this->totalUpdates = $totalUpdates;
		
	}
	
	
	public function getTableRow() {
		
		return '<tr><td>' .  $this->firstName . '</td><td>'	 . $this->lastName . '</td><td>' . $this->updatesOneDayAgo . '</td><td>' . $this->updatesTwoDaysAgo . '</td><td>'	 . $this->updatesThreeDaysAgo . '</td><td>'	 . $this->updatesFourDaysAgo . '</td><td>' .  $this->numFacebookUpdates	 . '</td><td>' .  $this->numTwitterUpdates . '</td><td>' .  $this->totalUpdates	 . '</td><tr>';
		
	}	
	
	
	public static function getTableHeading() {
		
		return '<tr><th>First Name</th><th>Last Name</th><th>Updates 0-1 day ago</th><th>Updates 1-2 days ago</th><th>Updates 2-3 days ago</th><th>Updates 3-4 days ago</th><th>Number of Facebook Updates</th><th>Number of Twitter Updates</th><th>Total Updates</th><tr>';
		
	}
	
}

?>