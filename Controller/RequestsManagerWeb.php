<?php

class RequestsManagerWeb extends RequestsManagerJSON {
	
	
	private static $instance = false;
	
	
	private function __construct() {
		
		$instance = true;

	}
	
	
	public static function getRequestsManagerWeb() {
		
		if ($_SESSION['environment'] != "web")
			return RequestsManager::getRequestsManager();
		
		if (!RequestsManagerWeb::$instance) {
			
			RequestsManagerWeb::$instance = new RequestsManagerWeb();
			
		}
		
		return RequestsManagerWeb::$instance;
		
	}
	
	
	public function handleRequest($action) {

		$this->checkLoginStatus($action);
		
		switch ($action) {
				
			case "getNewAlertCount":
				$this->getNewAlertCount();
				break;
							
			case "updateAlertCountTime":
				$this->updateAlertCountTime();
				break;	
				
			case "setSocialNetworkSettings":
				$this->setSocialNetworkSettings();
				break;
				
			case "incrementRegisterStatistic":
				StatisticsManager::getStatisticsManager()->incrementRegisterStatistic();
				break;
				
			default:		
				parent::handleRequest($action);
				
		}
		
	}
	
	
	public function getAutoComplete() {
		
		header('Content-Type: text/html; charset=utf-8');
		
		echo parent::getAutoComplete();	
		
	}
	
	
	public function updateAlertCountTime() {
		
		AlertsManager::getAlertsManager()->updateAlertCountTime();
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
		
	}
	
	
	public function getNewAlertCount() {
		
		header('Content-type: application/json');
	
		echo "{" . AlertsManager::getAlertsManager()->getNewAlertCountJSON() . "}";
		
	}
	
	
	public function setSocialNetworkSettings() {
		
		Verifier::getOrPostCheck(array('facebookPublish', 'twitterPublish'));
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$socialNetworkSettings = SocialNetworkSettings::mainConstructor($_POST['facebookPublish'], $_POST['twitterPublish']);
		
		ExceptionsManager::getExceptionsManager()->exceptionsCheck();
		
		$socialNetworkSettings->save();
		
		header('Content-type: application/json');
		
		echo "{" . $this->getSuccessMessageJSON() . "}";
		
	}

	
	
	
}

?>