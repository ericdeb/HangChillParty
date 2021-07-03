<?php

abstract class RequestsManagerJSON extends RequestsManager{
	
	
	public function handleRequest($action) {
		
		header('Content-type: application/json');
		parent::handleRequest($action);
		
	}
	
	
	public function getInitialData() {
		
		$initializeManager = InitializeManager::getInitializeManager();
		
		header('Content-type: application/json');
		echo "{" . $initializeManager->getInitialJSON() . "}";
		
	}
	
	
	public function getCurrentStatus() {
		
		header('Content-type: application/json');
		
		if (parent::getCurrentStatus() != NULL)
			echo "{" . parent::getCurrentStatus()->toFullJSONString() . "}";
		
	}
	
	
	public function getList() {
	
		header('Content-type: application/json');
		echo "{" . parent::getList()->toJSONString() . "}";
		
	}
	
	
	public function getAllSettings() {
		
		$userSettings = parent::getUserSettings();
		$alertSettings = parent::getAlertSettings();
		$socialNetworkSettings = parent::getSocialNetworkSettings();
		
		header('Content-type: application/json');
		
		echo "{" . $userSettings->toJSONString() . $alertSettings->toJSONString() . $socialNetworkSettings->toJSONString() . "}";
		
	}
	
	
	
	public function getAlertSettings() {
		
		header('Content-type: application/json');
		echo "{" . parent::getAlertSettings()->toJSONString() . "}";
		
	}
	
	
	public function getUserSettings() {
		
		header('Content-type: application/json');
		echo "{" . parent::getUserSettings()->toJSONString() . "}";
		
	}
	
	
	public function getSocialNetworkSettings() {
		
		header('Content-type: application/json');
		echo "{" . parent::getSocialNetworkSettings()->toJSONString() . "}";
		
	}
	
	
	public function getStyleSettings() {
		
		header('Content-type: application/json');
		echo "{" . parent::getStyleSettings()->toJSONString() . "}";
		
	}
	
	
	public function getNewAlerts() {
		
		header('Content-type: application/json');
		$alertsManager = AlertsManager::getAlertsManager();
		echo "{" . $alertsManager->getNewAlertsJSON() . "}";		
		
	}
	
	
	public function getNewUpdates() {
		
		header('Content-type: application/json');
		
		StatusManager::getStatusManager()->hasCurrentStatus();
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$updatesManager = UpdatesManager::getUpdatesManager();
		
		$logID = LoggingManager::getLoggingManager()->getLogID();
		
		$return_str = <<<EOD
			"logID": [
				{ 
					"id": "{$logID}"
				},	
			],			
EOD;
		echo "{" . $return_str . $updatesManager->getNewUpdatesJSON() . "}";		
		
	}
	
	
	public function findFriends() {
		
		header('Content-type: application/json');
		
		echo "{" . parent::findFriends()->getResultsJSON() . "}";
		
	}
	
	
	public function emailInviteFriendstoHangchillparty() {
		
		header('Content-type: application/json');
		
		$emailSearchObject = parent::emailInviteFriendstoHangchillparty();
		
		echo "{" . $emailSearchObject->getResultsJSON() . "}";
		
		$emailSearchObject->sendInviteEmails();
		
	}
	
	
	
	public function getUserProfile() {
		
		header('Content-type: application/json');
		
		Verifier::getOrPostCheck(array('id'));
		
		$limited = !FriendsManager::getFriendsManager()->friendsTest($_GET['id']);
		$limited = $_GET['id'] == $_SESSION['user_id'] ? false : $limited;
		
		echo "{" . Friend::dbConstructor($_GET['id'])->toFullJSONString($limited);
		
		$updatesManager = UpdatesManager::getUpdatesManager();

		$updateString = $updatesManager->getUpdateJSON($_GET['id'], $limited);
		
		if ($updateString != NULL)
			echo $updateString;
		echo "}";		
		
	}
	
	
	public function getLoginStatus() {
		
		header('Content-type: application/json');
		
		echo "{" . LoginManager::getLoginManager()->getLoginStatusJSON() . "}";
		
	}
	
	
	public function getTimeZones() {
		
		header('Content-type: application/json');
		
		Verifier::getOrPostCheck(array('region'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		echo "{" . TimeZone::getTimeZonesJSON($_GET['region']) . "}";
		
	}
	
	
	public function cancelStatus() {
		
		parent::cancelStatus();
		
		header('Content-type: application/json');
		echo "{" . $this->getSuccessMessageJSON() . "}";
		
	}
	
	
	public function setStatus() {
		
		parent::setStatus();
		
		$this->printSuccessOrErrors();
		
	}
	
	
	public function setJoinedStatus() {
		
		parent::setJoinedStatus();
		
		$this->printSuccessOrErrors();
		
	}
	
	
	public function requestFriend() {
	
		parent::requestFriend();
		
		$this->printSuccessOrErrors();
		
	}
	
	
	public function getFacebookFriendsOnHangchillparty() {
	
		$friendsFromFacebook = parent::getFacebookFriendsOnHangchillparty();
		
		header('Content-type: application/json');
		
		echo "{" . $friendsFromFacebook->getResultsJSON() . "}";
		
	}
	
	
	public function synchronizeWithFacebook() {
		
		parent::synchronizeWithFacebook();
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
	}
	
	
	public function inviteFacebookFriends() {
		$_SESSION['inviteFacebookFriends'] = true;
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
	}
	
	
	public function respondToFriendRequest() {
		
		parent::respondToFriendRequest();
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
		
	}
	
	
	public function getFriendsOf() {
		
		header('Content-type: application/json');
		
		$friendsOfSearch = parent::getFriendsOf();
		
		echo "{" . $friendsOfSearch->getResultsJSON() . "}";
		
	}
	
	
	public function setProfileSettings() {
		
		parent::setProfileSettings();
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
		
	}
	
	
	public function setContactSettings() {
		
		parent::setContactSettings();
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
		
	}
	
	
	public function setPasswordSettings() {
		
		parent::setPasswordSettings();
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
		
	}
	
	
	public function setTextSettings() {
		
		parent::setTextSettings();
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
		
	}
	
	
	public function setEmailSettings() {
		
		parent::setEmailSettings();
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
		
	}
	
	
	public function setSocialNetworkSettings() {
		
		parent::setSocialNetworkSettings();
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
		
	}
	
	
	public function disconnectFromFacebook() {
		
		FacebookManager::getFacebookManager()->removeFacebookData();
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
		
	}
	
	public function disconnectFromTwitter() {
		
		TwitterManager::getTwitterManager()->disconnectFromTwitter();
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
		
	}
	
	
	public function registerUser() {
	
		parent::registerUser();
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
	
	}
	
	
	public function facebookLoginUser() {
	
		parent::facebookLoginUser();
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
	}
	
	
	public function loginUser() {
		
		parent::loginUser();
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
		
	}
	
	
	public function logoutUser() {
		
		parent::logoutUser();
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
		
	}
	
	
	public function sendForgottenPassword() {
		
		parent::sendForgottenPassword();
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
		
	}
	
	
	public function checkIfEmailExists() {
		
		parent::checkIfEmailExists();
		
		$result = RegistrationManager::checkIfEmailExistsJSON($_GET['email']);
		
		header('Content-type: application/json');
			echo "{" . $result . "}";
	
	}
	
	
	public function getAllFriends() {
		
		FriendsManager::getFriendsManager()->getAllFriendsJSON();
		
		header('Content-type: application/json');
			echo "{" . $this->getSuccessMessageJSON() . "}";
	
	}

	
	protected function printSuccessOrErrors() {
		
		if (ExceptionsManager::getExceptionsManager()->areThereExceptions() == false) {
		
			header('Content-type: application/json');
			echo "{" . $this->getSuccessMessageJSON() . "}";
		
		}
		else
			ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
	}
	
	
	public function getAwardsNumbers() {
		
		$result = AwardsManager::getAwardsManager()->getAwardsNumbersJSON();
		
		header('Content-type: application/json');
			echo "{" . $result . "}";
	
	}
	
	
	public function getSuccessMessageJSON() {
		
		$return_str = <<<EOD
			"Success": [
				{ 
					"ms": "{Request successfully processed!}"
				},
			 ]
EOD;

		return $return_str;
		
	}
	
	

}

?>