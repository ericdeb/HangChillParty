<?php

class StatisticUpdate {
	
	private $firstName;
	private $lastName;
	private $canceled;
	private $activity;
	private $place;
	private $timeStart;
	private $totalUpdatesCount; 


	public function __construct($firstName, $lastName, $canceled, $activity, $place, $timeStart, $totalUpdatesCount) {
		
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->canceled = $canceled;
		$this->activity = $activity;
		$this->place = $place;
		$this->timeStart = $timeStart;
		$this->totalUpdatesCount = $totalUpdatesCount;
		
	}
	
	
	public function getTableRow() {
		
		return '<tr><td>' .  $this->firstName . '</td><td>'	 . $this->lastName . '</td><td>' . $this->activity . '</td><td>' . $this->place . '</td><td>'	 . $this->canceled . '</td><td>'	 . $this->timeStart . '</td><td>'	 . $this->totalUpdatesCount . '</td><tr>';
		
	}	
	
	
	public static function getTableHeading() {
		
		return '<tr><th>First Name</th><th>Last Name</th><th>Activity</th><th>Place</th><th>Signal Canceled</th><th>Time Start</th><th>User\'s Total Updates Count</th><tr>';
		
	}
	
}

?>