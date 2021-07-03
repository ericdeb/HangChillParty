<?php

class RequestsManagerAndroid extends RequestsManagerSmartPhone {
	
	
	private static $instance = false;
	
	
	private function __construct() {
		
		$instance = true;

	}
	
	
	public static function getRequestsManagerAndroid() {
		
		if ($_SESSION['environment'] != "android")
			return RequestsManager::getRequestsManager();
		
		if (!RequestsManagerAndroid::$instance) {
			
			RequestsManagerAndroid::$instance = new RequestsManagerAndroid();
			
		}
		
		return RequestsManagerAndroid::$instance;
		
	}
	
	
	public function handleRequest($action) {
		
		$this->checkLoginStatus($action);
		
		parent::handleRequest($action);
		
	}
	
}

?>