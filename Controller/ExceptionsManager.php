<?php

class ExceptionsManager {
	
	
	private static $instance = false;
	private $exceptionsAR = array();
	
	private function __construct() {
		
		$instance = true;

	}
	
	
	
	public static function getExceptionsManager() {
		
		if (!ExceptionsManager::$instance) {
			
			ExceptionsManager::$instance = new ExceptionsManager();
			
		}
		
		return ExceptionsManager::$instance;
		
	}
	
	
	
	public function handleException($newException) {
		
		$duplicate = false;
		$newCode = $newException->getCode();
		
		foreach ($this->exceptionsAR as $exception) {
			
			if ($exception->getCode() == $newCode) {
				$duplicate = true;
				break;
			}
			
		}
		
		if ($duplicate == false)
			array_push($this->exceptionsAR, $newException);
			
		
	}
	
	
	
	public function areThereExceptions() {
		
		return empty($this->exceptionsAR) ? false : true;
		
	}
	
	
	
	public function getAllExceptionsJSON() {
		
		$returnString = '{ "Errors": ['; 
		
		foreach ($this->exceptionsAR as $exception) {
			
			$returnString .= $exception->toPartJSONString();
			
		}
		
		$returnString .= '], }';
		
		return $returnString;
		
	}
	
	
	
	public function exceptionsCheck() {
		
		if ($this->areThereExceptions() == true) {
			
			if (!isset($_SESSION['environment']) || $_SESSION['environment'] == 'web' || $_SESSION['environment'] == 'android' || $_SESSION['environment'] == 'iphone')
				echo $this->getAllExceptionsJSON();

			exit();
				
		}

	}
	
}

?>