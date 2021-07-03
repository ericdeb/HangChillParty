<?php

class Time {
	
	
	public static function getUserTime() {
		
		$userTime = Time::getUserOffset() + Time::getNowUnix();
		
		return gmdate('o-m-d H:i:s', $userTime);
		
	}
	
	
	public static function getUserTimeUnix() {
		
		return Time::getUserOffset() + Time::getNowUnix();
		
	}
	
	
	public static function initializeLastUpdateTimes() {
		
		$_SESSION['lastUpdateTimeAlerts'] = Time::getFiveDaysAgoUnivTime();
		$_SESSION['lastUpdateTimeUpdates'] = Time::getFiveHoursAgoUnivMicroTime();
		
	}
	
	
	public static function getUserTimeUnixJSON() {
		
		$time = Time::getUserTimeUnix();
		
		$return_str = <<<EOD
		
        	"currentTime": [
				{ 
					"of": "{$time}"
				}
				
			],
EOD;

		return $return_str;
		
	}
	
	
	public static function getNowUnivTime() {
		
		return gmdate("o-m-d H:i:s", time()); // + 111
		
	}
	
	
	public static function getNowUnivTimeMicro() {

		return microtime(true); // + 111
	}
	
	
	public static function getNowUnix() {
		
		return time(); // + 111
		
	}
	
	
	public static function getFiveHoursAgoUnivTime() {
		
		return gmdate("o-m-d H:i:s", time()-(5*60*60));
		
	}
	
	
	public static function getFiveHoursAgoUnivMicroTime() {
		
		return microtime(true) - (5*60*60);
		
	}
	
	
	public static function getFiveDaysAgoUnivTime() {
		
		return gmdate("o-m-d H:i:s", time()-(5*24*60*60));
		
	}
	
	
	public static function convertToUserTimeZone($univTime) {

		$userTimeUnix = strtotime($univTime) + Time::getUserOffset();
		$userTime = date('o-m-d H:i:s', $userTimeUnix);
		
		return $userTime;
		
	}
	
	
	public static function convertMicroToUserTimeZone($univTime) {

		$userTimeUnix = round($univTime);
		$userTime = date('o-m-d H:i:s', $userTimeUnix);
		
		return $userTime;
		
	}
	

	public static function convertToUnivTimeZone($userTime) {

		$univTimeUnix = strtotime($userTime) - Time::getUserOffset();
		$univTime = date('o-m-d H:i:s', $univTimeUnix);
		
		return $univTime;
	
	}
	

	private static function getUserOffset() {
		
		$currentTimeZone = date_default_timezone_get();
		$userDateTimeZone = new DateTimeZone($currentTimeZone);
		$univDateTimeZone = new DateTimeZone("UTC");
		$univDateTimeNow = new DateTime("now", $univDateTimeZone);
		
		return $userDateTimeZone-> getOffset($univDateTimeNow);
		
	}
	
	
	public static function compareTimes($univTimeOne, $univTimeTwo) {
		if (strtotime($univTimeOne) > strtotime($univTimeTwo))
			return 1;
		return 0;
	}
	
	
	public static function getDaysSince($insUnivDate) {

		$insDateUnix = strtotime($insUnivDate);
		
		$timeSince = Time::getNowUnix() - $insDateUnix;
		
		$daysSince = ceil($timeSince/(24*60*60));
		
		return $daysSince;
		
	}
		
}

?>