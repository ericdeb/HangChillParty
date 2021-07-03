<?php

class RequestsManagerIphone extends RequestsManagerSmartPhone {
	
	
	private static $instance = false;
	
	
	private function __construct() {
		
		$instance = true;

	}
	
	
	public static function getRequestsManagerIphone() {
		
		if ($_SESSION['environment'] != "iphone")
			return RequestsManager::getRequestsManager();
		
		if (!RequestsManagerIphone::$instance) {
			
			RequestsManagerWeb::$instance = new RequestsManagerIphone();
			
		}
		
		return RequestsManagerIphone::$instance;
		
	}
	
	
	public function handleRequest($action) {
		
		$this->checkLoginStatus($action);
		
		parent::handleRequest($action);
		
	}

	
}

?>