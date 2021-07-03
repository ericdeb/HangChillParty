<?php

class TimeZone {
	
	private $id;
	private $region;
	private $timeZone;
	

	public function __construct() {
		
	}
	
	
	public static function fullConstructor($id, $region, $timeZone) {
		
		$time_zone = new TimeZone();
		
		$time_zone->id = $id;
		$time_zone->region = $region;
		$time_zone->timeZone = $timeZone;
		
		return $time_zone;
		
	}
	
	
	public static function limitedConstructor($region, $timeZone) {
		
		$time_zone = new TimeZone();
		
		$time_zone->region = $region;
		$time_zone->timeZone = $timeZone;
		
		return $time_zone;
		
	}
	
	
	public static function idOnlyConstructor($id) {
		
		$time_zone = new TimeZone();
		
		$time_zone->id = $id;
		
		return $time_zone;
		
	}
	
	
	public function getID() {
		
		return $this->id;
		
	}
	
	
	public function getRegion() {
		
		return $this->region;
		
	}
	
	public function getZone() {
		
		return $this->timeZone;
		
	}
	
	public function updateTimeZone() {

		$time_zone = $this->region . "/" . $this->timeZone;
		$tz = $time_zone;
		
		if ($time_zone == 'America/Arizona Time')
			$tz = 'America/Phoenix';
		else if ($time_zone == 'America/Central Time')
			$tz = 'America/Chicago';
		else if ($time_zone == 'America/Mountain Time')
			$tz = 'America/Boise';
		else if ($time_zone == 'America/West Coast Time')
			$tz = 'America/Los_Angeles';
		else if ($time_zone == 'America/East Coast Time')
			$tz = 'America/New_York';
			
		$_SESSION['time_zone'] = $tz;
	
		date_default_timezone_set($tz);
		
	}
	
	
	public static function autoUpdateTimeZone() {
		
		if (isset($_SESSION['time_zone']))
			date_default_timezone_set($_SESSION['time_zone']);
		else
			date_default_timezone_set('America/Los_Angeles');
		
	}
	
	
	private static function getTimeZones($region) {
		
		$region = Verifier::validateText($region);
		
		if (ExceptionsManager::getExceptionsManager()->areThereExceptions() == true)
			return false;
			
		$returnAR = array();
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$timeZoneQuery = "SELECT id, time_zone FROM time_zone WHERE region='" . Verifier::dbReady($region) . "' ORDER BY id ASC";
		
		if ($result = @mysqli_query($dbc, $timeZoneQuery)) {
		
			while ($timeZonesAR = mysqli_fetch_array($result)) {
				
				$timeZone = TimeZone::fullConstructor($timeZonesAR['id'], $region, $timeZonesAR['time_zone']);
				
				array_push($returnAR, $timeZone);
			}
			
		}
		
		return $returnAR;
		
	}
	
	
	public static function getTimeZonesJSON($region) {
		
		$returnAR = TimeZone::getTimeZones($region);
		
		$return_str = '"TimeZones": [';
	
		foreach($returnAR as $timeZone) {
			
			$zone = utf8_encode($timeZone->getZone());
			
			$return_str .= <<<EOD
			
					{ 
						"id": "{$timeZone->getID()}",
						"zo": "{$zone}"
					},				
EOD;

		}

		return $return_str . '],';
	
	}
	
}

?>