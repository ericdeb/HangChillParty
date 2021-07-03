<?php

class CommunicationsManager {
	
	
	private static $instance = false;
	private $friendsEmailsOnHangchillparty = array();
	private $carrierExtensionsAR = array('@vtext.com', '@txt.att.net', '@tmomail.net', '@messaging.nextel.com', '@messaging.sprintpcs.com', '@email.uscc.net', '@myboostmobile.com', '@vmobl.com', '@message.alltel.com');
	
	
	private function __construct() {
		
		$instance = true;

	}
	
	
	public static function getCommunicationsManager() {
		
		if (!CommunicationsManager::$instance) {
			
			CommunicationsManager::$instance = new CommunicationsManager();
			
		}
		
		return CommunicationsManager::$instance;
		
	}
	
	
	public function tryFriendRequestCommunication($requesterID, $receiverID, $status) {
		
		if (GlobalSettings::getGlobalSettings()->isLocalHost() == true)
			return false;
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		if ($status == 0) {
			
			$communicationsManagerQuery = "SELECT first_name, last_name, email, em_fri_new_req FROM user WHERE id = " . $receiverID;
		
			if ($result = @mysqli_query($dbc, $communicationsManagerQuery)) {

				if ($emailFriendAR = mysqli_fetch_array($result)) {
				
					if ($emailFriendAR['em_fri_new_req'] == 1) {
						
						$communicationsManagerQuery = "SELECT first_name, last_name FROM user WHERE id = " . $requesterID;
						
						if ($result = @mysqli_query($dbc, $communicationsManagerQuery)) {

							if ($emailFriendARTwo = mysqli_fetch_array($result)) {
								
								$msg = $emailFriendAR['first_name'] . ', <br><br><div style="margin-left: 40px;"> You got a new friend request on Hangchillparty from ' . $emailFriendARTwo['first_name'] . " " . $emailFriendARTwo['last_name'] . ".  <br><br><br></div>Hangchillparty Team";
								
								$msg .= $this->getSignature();
								
								$subject = $emailFriendARTwo['first_name'] . " " . $emailFriendARTwo['last_name'] . " has requested to be your friend on Hangchillparty.";
								
								mail($emailFriendAR['email'], $subject, $msg, $this->getEmailHeaders());
								
							}
							
						}
						
					}
					
				
				}
				
			}
			
		}
		
		else if ($status == 1) {
			
			$communicationsManagerQuery = "SELECT first_name, last_name, email, em_fri_acc_req FROM user WHERE id = " . $requesterID;
		
			if ($result = @mysqli_query($dbc, $communicationsManagerQuery)) {

				if ($emailFriendAR = mysqli_fetch_array($result)) {
				
					if ($emailFriendAR['em_fri_acc_req'] == 1) {
						
						$communicationsManagerQuery = "SELECT first_name, last_name FROM user WHERE id = " . $receiverID;
						
						if ($result = @mysqli_query($dbc, $communicationsManagerQuery)) {

							if ($emailFriendARTwo = mysqli_fetch_array($result)) {
								
								$msg = $emailFriendAR['first_name'] . ', <br><br><div style="margin-left: 40px;"> ' . $emailFriendARTwo['first_name'] . " " . $emailFriendARTwo['last_name'] . " accepted your friend request on Hangchillparty.  Play nice.  <br><br><br></div>Hangchillparty Team";
								
								$msg .= $this->getSignature();
								
								$subject = $emailFriendARTwo['first_name'] . " " . $emailFriendARTwo['last_name'] . " has accepted your friend request on Hangchillparty.";
								
								mail($emailFriendAR['email'], $subject, $msg, $this->getEmailHeaders());
								
							}
							
						}
						
					}
					
				
				}
			
			}
			
		}
		
	}
	
	
	public function tryUpdateCommunication($id, $place, $activity, $joinedUsers, $light) {
		
		if (GlobalSettings::getGlobalSettings()->isLocalHost() == true)
			return false;		
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		
		$communicationsManagerQuery = "SELECT u.id, u.first_name, u.last_name, u.txt_green, u.txt_yellow, u.em_green, u.em_yellow, u.email, u.phone, IF (sl.light != 0, sl.light, lv.value) AS light FROM user AS u
		
		LEFT OUTER JOIN (SELECT lv.friend_id, lv.value FROM list_value AS lv, status_leader AS sl WHERE sl.list_id = lv.list_id AND sl.status_id = " . $id . ") AS lv ON (lv.friend_id = u.id)
		
		, friend AS f, status AS s, status_leader AS sl			

		WHERE f.friend_id = u.id AND s.id = sl.status_id AND f.user_id = s.user_id AND s.id = " . $id . " AND s.user_id = " .  $_SESSION['user_id'];
		
		if ($result = @mysqli_query($dbc, $communicationsManagerQuery)) {

			while ($infoAR = mysqli_fetch_array($result)) {
				
				if (in_array($infoAR, $joinedUsers) == true)
					continue;
				
				$emailMessage = $infoAR['first_name'] . ', <br><br><div style="margin-left: 40px;"> ';
				$textMessage = "";
				
				$colorIns = $infoAR['light'] == 1 ? 'Green Light' : 'Yellow Light';
				
				$countIns = " has ";
				
				if (count($joinedUsers) == 1)
					$countIns = " and 1 friend have ";
				else if (count($joinedUsers) > 0) {
					
					$ins = count($joinedUsers);
					
					$countIns = " and " . $ins . " friends have ";
					
				}
				
				$basicUser = BasicUser::dbConstructor($_SESSION['user_id']);
				
				$emailSubject = $basicUser->getFirstName() . " " . $basicUser->getLastName() . $countIns . "signaled you a " . $colorIns . " on Hangchillparty";
				
				$genderIns = $basicUser->getGender() == 0 ? "He's" : "She's";
				
				if ($infoAR['light'] == 1) {
					
					$message = $basicUser->getFirstName() . " " . $basicUser->getLastName() . " has signaled you a green light on Hangchillparty.  " . $genderIns . " down to hang out.";
					
					$emailMessage .= $message;
				
					if ($place == NULL && $activity == NULL && count($joinedUsers) == 0)
						$textMessage .= $message;						
					
				}
				else if ($infoAR['light'] == 2) {
					
					$message = $basicUser->getFirstName() . " " . $basicUser->getLastName() . " has signaled you a yellow light on Hangchillparty.  " . $genderIns . " probably down to chill.";
					
					$emailMessage .= $message;
					
					if ($place == NULL && $activity == NULL && count($joinedUsers) == 0)
						$textMessage .= $message;
						
				}
					
				$usersString = count($joinedUsers) > 0 ? $this->getUsersJoiningMessage($joinedUsers) : '';
				
				$ins = count($joinedUsers) > 0 ? ' are' : ' is';
				
				if ($place != NULL || $activity != NULL || count($joinedUsers) > 0)
					$emailMessage .= '<br><br>' . $basicUser->getFirstName() . $usersString . $ins;
					
				if ($place != NULL || count($joinedUsers) > 0)
					$textMessage .= $basicUser->getFirstName() . " " . $basicUser->getLastName() . $usersString . $ins;
					
				if (count($joinedUsers) > 0 && $place == NULL) {
					
					$ins = count($joinedUsers) == 1 ? ' ' : ' all ';
					
					if ($activity == NULL)
						$emailMessage .= $ins . 'hanging out.';
						
					$textMessage .= $ins . 'hanging out.';
					
				}		
				
								
				if ($activity != NULL)
					$emailMessage .= ' ' . $activity;
					
				
				if ($place != NULL) {
				
					$emailMessage .= " at " . $place;
					$textMessage .= " @ " . $place;
				
				}	
					
				if ($place != NULL || $activity != NULL) {
					
					$emailMessage .= ".";
					$textMessage .= ".";					
					
				}
				
				$emailMessage .= '<br><br><br></div>Hangchillparty Team' . $this->getSignature();

				if ((($infoAR['txt_green'] == 1 && $infoAR['light'] == 1) || ($infoAR['txt_yellow'] == 1 && $infoAR['light'] == 2)) && $infoAR['phone'] != NULL) {
					
					$this->sendText($infoAR['phone'], $colorIns, $textMessage);
					
				}
				
				if (($infoAR['em_green'] == 1 && $infoAR['light'] == 1) || ($infoAR['em_yellow'] == 1 && $infoAR['light'] == 2)) {
					
					mail($infoAR['email'], $emailSubject, $emailMessage, $this->getEmailHeaders());
					
				}
					
				
			}
			
		}
		
	}
	
	
	
	
	public function tryJoinedUpdateCommunication($statusID, $usersAlsoJoining) {
		
		if (GlobalSettings::getGlobalSettings()->isLocalHost() == true)
			return false;		
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		
		//first join gets the leader status if you are joined or not.  Second join gets a count of how many people are with the update.  Overall this first query gets all the basic information that will needed to be texted to friends.
		
		$communicationsManagerQuery = "SELECT s.first_name, s.last_name, s.place, u.id, u.txt_friend_joins, u.em_friend_joins, u.email, u.phone, u.first_name AS leader_first_name FROM user AS u
		
		JOIN (SELECT s.id, s.user_id, s2.first_name, s2.last_name, s3.place FROM status AS s 
		
			JOIN(SELECT IFNULL(s.joined_with, s.id) AS status_id, u.first_name, u.last_name FROM status AS s, user AS u WHERE s.user_id = u.id AND s.canceled = 0 AND s.id = " . $statusID . " GROUP BY status_id) AS s2 ON s2.status_id = s.id
			
			LEFT OUTER JOIN(SELECT status_id, place FROM status_leader AS sl) AS s3 ON s3.status_id = s.id
			
		) AS s ON s.user_id = u.id";
		
		if ($result = @mysqli_query($dbc, $communicationsManagerQuery)) {

			if ($infoAR = mysqli_fetch_array($result)) {
				
				$textSubject = "join";
				$countIns = "";
				
				if (count($usersAlsoJoining) == 1)
					$countIns = " and 1 friend ";
				else if (count($usersAlsoJoining) > 0) {
					
					$ins = count($usersAlsoJoining);
					
					$countIns = " and " . $ins . " friends ";
					
				}
				
				$postCountIns = count($usersAlsoJoining) == 0 ? ' is ' : ' are ';
				
				$basicUser = BasicUser::dbConstructor($_SESSION['user_id']);
				
				$emailSubject = $basicUser->getFirstName() . " " . $basicUser->getLastName() . $countIns . $postCountIns . " joining you on Hangchillparty";
				
				$message = $basicUser->getFirstName() . " " . $basicUser->getLastName() . $this->getUsersJoiningMessage($usersAlsoJoining);
				
				$ins = count($usersAlsoJoining) > 0 ? ' are' : ' is';
				
				$message .= $ins . " joining you to hang out";
					
				$ins = $infoAR['place'] == NULL ? "." : " at " . $infoAR['place'];
				
				$message .= $ins;
				
				if ($infoAR['txt_friend_joins'] == 1 && $infoAR['phone'] != NULL)
					$this->sendText($infoAR['phone'], $textSubject, $message);					
				
				if ($infoAR['email'] != NULL && $infoAR['em_friend_joins'] == 1) {
					
					$message = 	$infoAR['leader_first_name'] . ', <br><br><div style="margin-left: 40px;"> ' . $message;			
					$message =  $message . '<br><br><br></div>Hangchillparty Team' . $this->getSignature();
					
					mail($infoAR['email'], $emailSubject, $message, $this->getEmailHeaders());
					
				}
				
			}
			
		}
			
	}
	
	
	
	public function sendForgottenPassword($email, $password) {
	
		if (GlobalSettings::getGlobalSettings()->isLocalHost() == true)
			return false;
			
		$subject = "Hangchillparty password";
		
		$msg = 'Hey, <br><br><div style="margin-left: 40px;">It looks like you forgot your password at Hangchillparty.com.  No worries, your temporary password is:<br /><br />' . $password .'.<br><br><br></div>Hangchillparty Team';
		
		mail($email, $subject, $msg, $this->getEmailHeaders());
		
	}
	
	
	
	public function tryInviteFriendsByEmailCommunication($emailsToSendToAR) {
		
		if (GlobalSettings::getGlobalSettings()->isLocalHost() == true)
			return false;
			
		$currentUser = BasicUser::dbConstructor($_SESSION['user_id']);
		
		$subject = 'Hangchillparty.com.  ' . $currentUser->getFirstName() . " " . $currentUser->getLastName() . " told us you might be interested.";
		
		$msg = 'Hey, <br><br><div style="margin-left: 40px;"> your friend ' . $currentUser->getFirstName() . " " . $currentUser->getLastName() . ' gave us your email as someone who might be interested in <a href="http://www.hangchillparty.com">hangchillparty.com</a>.  If you aren\'t, no worries, as this is the last email you will receive from us (unless someone else invites you as well), but you should at least check it out.<br><br><br></div>Hangchillparty Team';
								
		$msg .= $this->getSignature();
		
		for ($i = 0; $i < count($emailsToSendToAR); $i++) {
			mail($emailsToSendToAR[$i], $subject, $msg, $this->getEmailHeaders());
		}		
		
	}
	
	
	public function sendText($phoneNum, $subject, $message) {

		for ($i = 0; $i < count($this->carrierExtensionsAR); $i++)
			mail($phoneNum . $this->carrierExtensionsAR[$i], $subject, $message, $this->getTextHeaders());

	}
	
	
	
	public function sendRegistrationEmails() {
		
		$dbc = DatabaseConnection::getDatabaseConnection();		
		
		$communicationsManagerQuery = "SELECT u.email, u.first_name, u.last_name FROM user AS u WHERE TIME_FORMAT(TIMEDIFF(u.registration_date, '" . Time::getNowUnivTime() . "'), '%m%d%k%i%s') < -60000 AND u.registration_email_sent = 0";

		if ($result = @mysqli_query($dbc, $communicationsManagerQuery)) {

			while ($infoAR = mysqli_fetch_array($result)) {
				
				$subject = 'Welcome to HCP, ' . $infoAR['first_name'];
				
				$body = '<font size="4">What\'s up ' . $infoAR['first_name'] . ',<br><br>Thanks for getting a <a href="http://hangchillparty.com">Hangchillparty</a> account.<br><br>*With facebook, invite your friends to Hcp through "find friends"<br>*The more social you, are the higher your social meter.<br><br>We want to make Hcp the best socializing tool out there, so let us know if you got any questions.<br><br>-Drew<br></font>' . $this->getSignature();
				
				mail($infoAR['email'], $subject, $message, $this->getEmailHeaders());
				
			}
			
		}
		
		$communicationsManagerQuery = "UPDATE user SET registration_email_sent = 1 WHERE TIME_FORMAT(TIMEDIFF(registration_date, '" . Time::getNowUnivTime() . "'), '%m%d%k%i%s') < -60000";
		
		$result = @mysqli_query($dbc, $communicationsManagerQuery);
		
	}
	
	
	public function sendEmailToUsers() {
		
		$dbc = DatabaseConnection::getDatabaseConnection();		
		
		$communicationsManagerQuery = "SELECT u.email, u.first_name, u.last_name FROM user AS u WHERE u.em_weu_upg = 1";
	
		$subject = "Facebook signals are working again and are much less intrusive.  Login emails and passwords should now save.";
/*
		if ($result = @mysqli_query($dbc, $communicationsManagerQuery)) {

			if ($infoAR = mysqli_fetch_array($result)) {
				
				$body = 'Quick update,<br><br>The new facebook signal has been implemented, so let us know if you have any problems.  It is much more subtle.  Click the small question mark next to the signal button to get a preview if you\'d like.<br><br>Also, your browser should now save your email/password so logging in should be easier.  You may have to clear your saved password for Hangchillparty before it will work, so check your browser or email us if you have any problems.<br><br>Thanks<br>Drew' . $this->getSignature();

				mail($infoAR['email'], $subject, $body, $this->getEmailHeaders());
				
			}
			
		}
*/
	}

	
	private function getSignature() {
		
		return '<br><br><br><font color="#666666">For details on this update, visit <a href="http://www.hangchillparty.com">hangchillparty.com</a><br>If you want to unsubscribe from any form of Hangchillparty communication simply login and adjust your settings.</font>'; 
		
	}
	
	
	private function getEmailHeaders() {
		
		return "From: hangchillparty@hangchillparty.com\r\nReply-To: hangchillparty@hangchillparty.com\r\nContent-Type: text/html;";
		
	}
	
	
	private function getTextHeaders() {
		
		return "From: txt@hangchillparty.com";
		
	}

	
	private function getUsersJoiningMessage($usersAlsoJoining) {
		
		$message = ""; $ins = "";
		
		if (count($usersAlsoJoining) > 0)
			$ins = count($usersAlsoJoining) == 1 ? ' and ' : ', ';
			
		$message .= $ins;
		
		for ($i = 0; $i < 2 && $i < count($usersAlsoJoining); $i++) {
		
			$user = BasicUser::dbConstructor($usersAlsoJoining[$i]);
			
			$ins = ($i == 0 && count($usersAlsoJoining) == 2) || ($i == 1 && count($usersAlsoJoining) > 2) ? ' and ' : ', ';
			
			$message .= $user->getFirstName() . " " . $user->getLastName() . $ins;
		
		}
		
		if (count($usersAlsoJoining) > 0) {
			
			if (count($usersAlsoJoining) < 3)
				$message = substr($message, 0, strlen($message)-2);
			else {
				$ins = count($usersAlsoJoining) == 3 ? '' : 's';
				$insTwo = count($usersAlsoJoining) - 2;
				
				$message .= $insTwo . ' other friend' . $ins . ' ';
			
			}
			
		}
		
		return $message;
		
	}	
	
	
	
		/*
	private function updateCarrierToDB($userID, $carrierID) {
		
		$dbc = DatabaseConnection::getDatabaseConnection();
		
		$communicationsManagerQuery = "UPDATE user SET carrier_id = " . $carrierID . " WHERE id = " .  $userID;
				
		$result = @mysqli_query($dbc, $communicationsManagerQuery);
		
	}
	*/
		
}

?>