<?php

abstract class RequestsManager {
	
	
	private static $instance = false;

	
	public static function getRequestsManager() {
		
		if (!RequestsManager::$instance) {
			
			if ($_SESSION['environment'] == "web")
				RequestsManager::$instance =  RequestsManagerWeb::getRequestsManagerWeb();
			else if ($_SESSION['environment'] == "mobile")
				RequestsManager::$instance = RequestsManagerMobile::getRequestsManagerMobile();
			else if ($_SESSION['environment'] == "iphone")
				RequestsManager::$instance = RequestsManagerIphone::getRequestsManagerIphone();
			else if ($_SESSION['environment'] == "android")
				RequestsManager::$instance = RequestsManagerAndroid::getRequestsManagerAndroid();
			
		}
		
		return RequestsManager::$instance;
		
	}
		
	
	public function handleRequest($action) {

		$requestsManager = RequestsManager::getRequestsManager();

		switch ($action) {
		
		/************************* Done but probably has bugs ***********************************/
		
			case "tryRememberMe":
				$requestsManager->tryRememberMe();			
				break;
			
			case "getInitialData":

				$requestsManager->getInitialData();
				break;	
				
			case "getCurrentStatus":
				$requestsManager->getCurrentStatus();
				break;	
				
			case "createStatus":
			case "updateStatus":
				$requestsManager->setStatus();
				break;
				
			case "joinStatus":
			case "updateJoinedStatus":
				$requestsManager->setJoinedStatus();
				break;
				
			case "cancelStatus":
				$requestsManager->cancelStatus();
				break;	
				
			case "getList":
				$requestsManager->getList();			
				break;
				
			case "createList":
			case "updateList":
				$requestsManager->setList();			
				break;
				
			case "deleteList":
				$requestsManager->deleteList();	
				break;
				
			case "getAllSettings":
				$requestsManager->getAllSettings();	
				break;
				
			case "getAlertSettings":
				$requestsManager->getAlertSettings();	
				break;
				
			case "getUserSettings":
				$requestsManager->getUserSettings();	
				break;
				
			case "getSocialNetworkSettings":
				$requestsManager->getSocialNetworkSettings();	
				break;
				
			case "getStyleSettings":
				$requestsManager->getStyleSettings();	
				break;
				
			case "getNewAlerts":
				$requestsManager->getNewAlerts();
				break;
				
			case "getNewUpdates":
				$requestsManager->getNewUpdates();
				break;
				
			case "getUserProfile":
				$requestsManager->getUserProfile();
				break;
				
			case "loginUser":
				$requestsManager->loginUser();
				break;
				
			case "logoutUser":
				$requestsManager->logoutUser();
				break;
				
			case "setProfileSettings":
				$requestsManager->setProfileSettings();	
				break;
				
			case "setContactSettings":
				$requestsManager->setContactSettings();	
				break;
				
			case "setPasswordSettings":
				$requestsManager->setPasswordSettings();	
				break;
				
			case "setTextSettings":
				$requestsManager->setTextSettings();	
				break;
				
			case "setEmailSettings":
				$requestsManager->setEmailSettings();	
				break;
				
			case "setAlertSettings":
				$requestsManager->setAlertSettings();	
				break;
				
			case "setUserSettings":
				$requestsManager->setUserSettings();	
				break;
				
			case "setStyleSettings":
				$requestsManager->setStyleSettings();	
				break;
				
			case "registerUser":
				$requestsManager->registerUser();
				break;
				
			case "requestFriend":
				$requestsManager->requestFriend();
				break;
				
			case "respondToFriendRequest":
				$requestsManager->respondToFriendRequest();
				break;
				
			case "findFriends":
				$requestsManager->findFriends();
				break;
				
			case "deleteFriend":
				$requestsManager->deleteFriend();
				break;
				
			case "getTimeZones":
				$requestsManager->getTimeZones();
				break;
				
			case "getImage":
				$requestsManager->getImage();
				break;
				
			case "uploadImage":
				$requestsManager->uploadImage();
				break;
				
			case "synchronizeWithFacebook":
				$requestsManager->synchronizeWithFacebook();
				break;
				
			case "getFacebookFriendsOnHangchillparty":
				$requestsManager->getFacebookFriendsOnHangchillparty();
				break;
				
			case "emailInviteFriends":
				$requestsManager->emailInviteFriendstoHangchillparty();
				break;
				
			case "inviteFacebookFriends":
				$requestsManager->inviteFacebookFriends();
				break;
				
			case "getFriendsOf":
				$requestsManager->getFriendsOf();
				break;
				
			case "disconnectFromFacebook":
				$requestsManager->disconnectFromFacebook();
				break;
				
			case "disconnectFromTwitter":
				$requestsManager->disconnectFromTwitter();
				break;
				
			case "facebookLoginUser":
				$requestsManager->facebookLoginUser();
				break;
				
			case "getTermsOfService":
				$requestsManager->getTermsOfService();
				break;
				
			case "twitterDisplayLogin":
				$requestsManager->twitterDisplayLogin();
				break;
				
			case "twitterLoginUser":
				$requestsManager->twitterLoginUser();
				break;
				
			case "sendForgottenPassword":
				$requestsManager->sendForgottenPassword();
				break;
				
			case "checkIfEmailExists":
				$requestsManager->checkIfEmailExists();
				break;
				
			case "getAllFriends":
				$requestsManager->getAllFriends();
				break;
				
			case "getAutoComplete":
				$requestsManager->getAutoComplete();
				break;
				
			case "getAwardsNumbers":
				$requestsManager->getAwardsNumbers();
				break;
				
			case "getNewAwardImage":
				$requestsManager->getNewAwardImage();
				break;
				
			case "getSocialMeterAwardImage":
				$requestsManager->getSocialMeterAwardImage();
				break;
			
		}
	
	}
	
	
	public function setStatus() {
			
		$optionalInputs = array('timeStart', 'partyID', 'maxPeople', 'maxGuys', 'maxGirls', 'facebookPublish', 'twitterPublish');
		
		$this->ifNotIssetNulls($optionalInputs, "post");
		
		Verifier::getOrPostCheck(array('timeStart', 'timeEnd', 'place', 'activity', 'partyID', 'maxPeople', 'maxGuys', 'maxGirls', 'light', 'facebookPublish', 'twitterPublish'));
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$_POST['timeStart'] = Time::getUserTime();
		
		$usersToJoin = isset($_POST['usersToJoin']) ? $_POST['usersToJoin'] : NULL;
		
		if (isset($_POST['id']))
			$status = LeaderStatus::fullConstructor($_POST['id'], $_POST['timeStart'], $_POST['timeEnd'], $_POST['place'], $_POST['activity'], $_POST['partyID'], $_POST['maxPeople'], $_POST['maxGuys'], $_POST['maxGirls'], $_POST['light'], $usersToJoin, $userList, $_POST['facebookPublish'], $_POST['twitterPublish']);
		else
			$status = LeaderStatus::limitedConstructor($_POST['timeStart'], $_POST['timeEnd'], $_POST['place'], $_POST['activity'], $_POST['partyID'], $_POST['maxPeople'], $_POST['maxGuys'], $_POST['maxGirls'], $_POST['light'], $usersToJoin, $userList, $_POST['facebookPublish'], $_POST['twitterPublish']);
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		StatusManager::getStatusManager()->cancelCurrentStatus();
		
		$status->cancelJoiningUsersStatuses();
		
		$status->save();
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		if (isset($_POST['cancelUsersJoinedAR']) && isset($_POST['id']))
			$status->cancelJoinedUsers($_POST['cancelUsersJoinedAR'], $_POST['id']);
		
		return $status;	
		
	}
	
	
	public function setJoinedStatus() {
		
		$this->ifNotIssetNulls(array('timeStart'), "post");
		
		Verifier::getOrPostCheck(array('timeStart', 'timeEnd', 'joinedWithID'));
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		Verifier::verifyStatusNotCanceled($_POST['joinedWithID']);
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$_POST['timeStart'] = Time::getUserTime();
		
		if (isset($_POST['id']))
			$status = JoinedStatus::fullConstructor($_POST['id'], $_POST['timeStart'], $_POST['timeEnd'], $_POST['joinedWithID']);
		else {
			$currentStatus = StatusManager::getStatusManager()->getCurrentStatus();
			$joinedUsers = NULL;
			
			if (isset($_POST['usersAlsoJoining']))
				$joinedUsers = $_POST['usersAlsoJoining'];
			else if ($currentStatus->isLeaderStatus() == true)
				$joinedUsers = $currentStatus->getJoinedUsers();
				
			$status = JoinedStatus::limitedConstructor($_POST['timeStart'], $_POST['timeEnd'], $joinedUsers, $_POST['joinedWithID']);
		}
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		StatusManager::getStatusManager()->cancelCurrentStatus();
		
		$status->save();
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		return $status;	
		
	}
		
	
	public function getCurrentStatus() {
		
		$currentStatus = StatusManager::getStatusManager()->getCurrentStatus();
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();			
		
		return $currentStatus;
		
	}
	
	
	public function cancelStatus() {
		
		StatusManager::getStatusManager()->cancelCurrentStatus();	
		
		$_SESSION['lastUpdateTimeUpdates'] = Time::getFiveHoursAgoUnivMicroTime();
		
	}

	
	public function getList() {
	
		Verifier::getOrPostCheck(array('id'));	
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
			
		$userList = UserList::dbConstructor($_GET['id']);

		ExceptionsManager::getExceptionsManager()->exceptionsCheck();

		return $userList;
		
	}
	
	
	public function setList() {
		
		Verifier::getOrPostCheck(array('usersArray', 'valuesArray', 'name', 'type'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		if (!isset($_POST['id']))
			$userList = UserList::limitedConstructor($_POST['usersArray'], $_POST['valuesArray'], $_POST['name'], $_POST['type']);
		else
			$userList = UserList::fullConstructor($_POST['id'], $_POST['usersArray'], $_POST['valuesArray'], $_POST['name'], $_POST['type']);
		
		$userList->save();
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		return $userList;
		
	}
	
	
	public function deleteList() {
		
		Verifier::getOrPostCheck(array('id'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
			
		ListsManager::getListsManager()->deleteList($_GET['id']);
		
	}
	
	
	public function getAlertSettings() {
		
		$alertSettings = AlertSettings::dbConstructor();
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		return $alertSettings;
		
	}
	
	
	public function getUserSettings() {
		
		$userSettings = UserSettings::fullDBConstructor();
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		return $userSettings;
		
	}
	
	
	public function getSocialNetworkSettings() {
		
		$socialNetworkSettings = SocialNetworkSettings::fullDBConstructor();
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		return $socialNetworkSettings;

	}
	
	
	public function getStyleSettings() {
		
		$styleSettings = StyleSettings::fullDBConstructor();
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		return $styleSettings;
		
	}

	
	public function loginUser() {
		
		Verifier::getOrPostCheck(array('email', 'password', 'rememberMe'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		LoginManager::getLoginManager()->tryLogin($_POST['email'], $_POST['password'], $_POST['rememberMe']);
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
	}
	
	
	public function logoutUser() {
		
		LoginManager::getLoginManager()->logoutUser();
		
	}


	public function tryRememberMe() {
		
		LoginManager::getLoginManager()->tryRememberMe();
		$this->getLoginStatus();
		
	}
	
	
	public function setUserSettings() {
		
		$userSettings = $this->constructUserSettings();
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$userSettings->save();
		
	}
	
	
	public function setAlertSettings() {
		
		$alertSettings = $this->constructAlertSettings();
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$alertSettings->save();
		
	}
	
	
	public function registerUser() {
		
		$this->ifNotIssetNulls(array('facebookConnected'), $_POST);
		
		Verifier::getOrPostCheck(array('facebookConnected'));
		
		$registrationManager = new RegistrationManager($this->constructUserSettings(), $_POST['facebookConnected']);			
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$registrationManager->registerUser();
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
	}
	
	
	public function setStyleSettings() {
		
		
	}
	
	
	public function requestFriend() {
	
		Verifier::getOrPostCheck(array('receiverID'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$friendRequest = FriendRequest::limitedConstructor($_SESSION['user_id'], $_GET['receiverID'], 0);
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$friendRequest->save();
		
		
	}
	
	
	public function respondToFriendRequest() {
	
		Verifier::getOrPostCheck(array('requesterID', 'status'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		Verifier::checkForDuplicateUsers($_POST['requesterID']);
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$friendRequest = FriendRequest::responseConstructor($_POST['requesterID'], $_SESSION['user_id'], $_POST['status']);
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$friendRequest->save();
		
		
	}
	
	
	public function emailInviteFriendstoHangchillparty() {
	
		Verifier::getOrPostCheck(array('emailsToInvite', 'pageNumber', 'newSearch'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
	
		$friendsEmailSearch = new FriendsEmailSearch($_POST['pageNumber'], $_POST['newSearch'], $_POST['emailsToInvite']);
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		return $friendsEmailSearch;
		
	}
	
	
	public function deleteFriend() {
		
		Verifier::getOrPostCheck(array('id'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		FriendsManager::getFriendsManager()->deleteFriend($_GET['id']);
		
	}
	
	
	public function getImage() {
			
		Verifier::getOrPostCheck(array('userID', 'width', 'height'));
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$userImage = UserImage::getImageConstructor($_GET['userID'], $_GET['width'], $_GET['height']);

		header('Content-Type: image/jpeg');
		
		$userImage->displayImage();
		
	}
	
	
	public function uploadImage() {

		header('Content-type: text/html');

		Verifier::validateImageType();
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$userImage = UserImage::setImageConstructor($_FILES['upload']['tmp_name'], $_FILES['upload']['type']);
		
		if (isset($_GET['imageID'])) {
			$userImage->saveUploadedImage($_GET['imageID']);
			$_SESSION['imageID'] = $_GET['imageID'];
		}
		else
			$userImage->saveUploadedImage(NULL);		
		
		
		
	}
	
	
	public function setProfileSettings() {
		
		Verifier::getOrPostCheck(array('firstName', 'lastName', 'gender', 'birthday', 'blurb', 'timeZoneID', 'currentPassword'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		Verifier::validateCurrentPassword($_POST['currentPassword']);
		
		$displayFriendDist = NULL;
		
		$userSettings = UserSettings::profileConstructor($_POST['firstName'], $_POST['lastName'], $_POST['gender'], $_POST['birthday'], $_POST['blurb'], $_POST['timeZoneID']);
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$userSettings->saveProfileData();
		
		return $userSettings;
		
	}
	
	
	public function setContactSettings() {
		
		Verifier::getOrPostCheck(array('phone', 'email', 'currentPassword'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		Verifier::validateCurrentPassword($_POST['currentPassword']);
		
		$userSettings = UserSettings::contactConstructor($_POST['phone'], $_POST['email']);
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$userSettings->saveContactData();
		
		return $userSettings;
		
	}
	
	
	public function setPasswordSettings() {
		
		Verifier::getOrPostCheck(array('password', 'passwordVerified', 'currentPassword'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		Verifier::validateCurrentPassword($_POST['currentPassword']);
		
		$userSettings = UserSettings::passwordConstructor($_POST['password'], $_POST['passwordVerified']);
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$userSettings->savePasswordData();
		
		return $userSettings;
		
	}
	
	
	public function setTextSettings() {
		
		Verifier::getOrPostCheck(array('text_friend_joins', 'text_green', 'text_yellow', 'currentPassword'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		Verifier::validateCurrentPassword($_POST['currentPassword']);
		
		$alertSettings = AlertSettings::textConstructor($_POST['text_friend_joins'], $_POST['text_green'], $_POST['text_yellow']);
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$alertSettings->saveTextData();
		
		return $alertSettings;
		
	}
	
	
	public function setEmailSettings() {
		
		Verifier::getOrPostCheck(array('email_friend_joins', 'email_fri_accept_request', 'email_new_fri_request', 'email_hangchillparty_updates', 'email_green', 'email_yellow', 'currentPassword'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		Verifier::validateCurrentPassword($_POST['currentPassword']);
		
		$alertSettings = AlertSettings::emailConstructor($_POST['email_friend_joins'], $_POST['email_fri_accept_request'], $_POST['email_new_fri_request'], $_POST['email_hangchillparty_updates'], $_POST['email_green'], $_POST['email_yellow']);
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$alertSettings->saveEmailData();
		
		return $alertSettings;
		
	}
	
	
	public function facebookLoginUser() {
		
		FacebookManager::getFacebookManager()->tryLogin();		
		
	}
	
	
	public function getTermsOfService() {
		
		include('tos.php');
		
	}
	
	
	public function checkIfEmailExists() {
		
		Verifier::getOrPostCheck(array('email'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();	
		
	}
	
	
	public function sendForgottenPassword() {
		
		Verifier::getOrPostCheck(array('email'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		LoginManager::getLoginManager()->forgotPassword($_GET['email']);
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
	}
	
	
	public function synchronizeWithFacebook() {
		

		if (FacebookManager::getFacebookManager()->syncAccounts() == true) {
	
			FacebookManager::getFacebookManager()->updateFacebookImage($_SESSION['user_id'], $_SESSION['facebook_id']);
			
			ExceptionsManager::getExceptionsManager()->exceptionsCheck();
			
		}

	}
	
	
	public function tryFacebookLogin() {
		
		FacebookManager::getFacebookManager()->tryLogin();
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
	}
	
	
	public function twitterDisplayLogin() {
		
		TwitterManager::getTwitterManager()->displayLoginWindow();
				
	}
	
	
	public function twitterLoginUser() {
		
		TwitterManager::getTwitterManager()->tryLogin();
		
	}
	
	
	public function getAutoComplete() {
		
		Verifier::getOrPostCheck(array('query', 'type'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$autoCompleteManager = AutoCompleteManager::getAutoCompleteManager();
		
		if ($_GET['type'] == 'friends')
			$responseString = $autoCompleteManager->getFriends($_GET['query']);	

		return $responseString;		
		
	}
	
	public function getNewAwardImage() {
		
		header('Content-Type: image/gif');
		
		AwardsManager::getAwardsManager()->getNewAwardImage();
		
	}
	
	public function getSocialMeterAwardImage() {
		
		Verifier::getOrPostCheck(array('userID'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		header('Content-Type: image/png');
		
		AwardsManager::getAwardsManager()->getSocialMeterAwardImage($_GET['userID']);
		
	}
	
	private function constructUserSettings() {
		
		Verifier::getOrPostCheck(array('firstName', 'lastName', 'gender', 'birthday', 'phone', 'email', 'blurb', 'timeZoneID', 'password', 'passwordVerified'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$userSettings = UserSettings::fullConstructorUS($_POST['firstName'], $_POST['lastName'], $_POST['gender'], $_POST['birthday'], $_POST['phone'], $_POST['email'], $_POST['blurb'], $_POST['timeZoneID'], $_POST['password'], $_POST['passwordVerified']);
		
		
		return $userSettings;
		
	}
	
	
	private function constructAlertSettings() {
		
		Verifier::getOrPostCheck(array('text_friend_joins', 'text_green', 'text_yellow', 'email_friend_joins', 'email_fri_accept_request', 'email_new_fri_request', 'email_hangchillparty_updates', 'email_green', 'email_yellow'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$alertSettings = AlertSettings::fullConstructor($_POST['text_friend_joins'], $_POST['text_green'], $_POST['text_yellow'], $_POST['email_friend_joins'], $_POST['email_fri_accept_request'], $_POST['email_new_fri_request'], $_POST['email_hangchillparty_updates'], $_POST['email_green'], $_POST['email_yellow']);
		
		return $alertSettings;
		
	}

	
	protected function checkLoginStatus($action) {
		
		$alwaysVisibleArray = array("twitterLoginUser", "twitterDisplayLogin", "getTermsOfService", "getAutoComplete", "getTimeZones", "uploadImage");
		
		$loggedOutVisibleArray = array("loginUser", "facebookLoginUser", "registerUser", "tryRememberMe", "sendForgottenPassword", "checkIfEmailExists", "incrementRegisterStatistic");
		
		if (!in_array($action, $loggedOutVisibleArray) && !in_array($action, $alwaysVisibleArray))
			LoginManager::getLoginManager()->isUserLoggedIn();
		else if (!in_array($action, $alwaysVisibleArray))
			LoginManager::getLoginManager()->isUserLoggedOut();
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
	}
	
	
	public function convertPostNulls() {
		foreach ($_POST as $key => $value) {
			if ($value == "null")
				$_POST[$key] = NULL;
		}	
	}
	
	
	public function ifNotIssetNulls($insAR, $type) {
		for ($i = 0; $i < count($insAR); $i++) { 
			if (!isset($_GET[$insAR[$i]]) && !isset($_POST[$insAR[$i]])) {
				if ($type == "get")
					$_GET[$insAR[$i]] = "null";
				else
					$_POST[$insAR[$i]] = "null";
			}
		}
	}
		
}

?>