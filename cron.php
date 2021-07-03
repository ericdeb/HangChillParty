<?php

include('public_html/ClassLibrary.php');






function endCanceledTimes() {

	$dbc = DatabaseConnection::getDatabaseConnection();
	
	$cronJobQuery = "DELETE sl.* FROM status_leader AS sl, status AS s 
	
		JOIN (SELECT id FROM status WHERE time_end IS NOT NULL AND TIME_FORMAT(TIMEDIFF(time_end, '" . Time::getNowUnivTime() . "'), '%m%d%k%i%s') < 0) AS s2 ON s2.id = s.id
		
	WHERE s.id = sl.status_id;";
	
	 
	$cronJobQuery .= "UPDATE status AS s, status AS s2 SET s.update_time = '" . Time::getNowUnivTimeMicro() . "', s.canceled = 1 WHERE (s.id = s2.id OR s.joined_with = s2.id) AND s2.time_end IS NOT NULL AND TIME_FORMAT(TIMEDIFF(s2.time_end, '" . Time::getNowUnivTime() . "'), '%m%d%k%i%s') < 0;";
	
	$multiResult = @mysqli_multi_query($dbc, $cronJobQuery);
		
	while (mysqli_next_result($dbc)) {};
	
}




function sendRegistrationEmails() {
	
	CommunicationsManager::getCommunicationsManager()->sendRegistrationEmails();
	
}
	 
	
	
	
	
	
	
	
		SET s.canceled = 1, s.update_time = '" . Time::getNowUnivTimeMicro() . "' 
	
	$statusManagerQuery .= "UPDATE status AS s SET s.canceled = 1, s.update_time = '" . Time::getNowUnivTimeMicro() . "' WHERE s.joined_with = " . $id . ";";
	}
			else
				$statusManagerQuery .= "UPDATE status AS s SET s.update_time = '" . Time::getNowUnivTimeMicro() . "' WHERE s.id = " . $joinedWithID . " OR s.joined_with = " . $joinedWithID . ";";
			
			$statusManagerQuery .= "UPDATE status AS s SET s.canceled = 1, s.update_time = '" . Time::getNowUnivTimeMicro() . "' WHERE s.id = " . $id . ";"; 