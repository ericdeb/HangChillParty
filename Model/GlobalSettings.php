<?php

class GlobalSettings {
	
	
	private static $instance = false;
	private $siteDown = false;
	private $pathToImages = "UserImages/";
	
	
	private function __construct() {
		
		$instance = true;
		

	}
	
	
	public static function getGlobalSettings() {
		
		if (!GlobalSettings::$instance) {
			
			GlobalSettings::$instance = new GlobalSettings();
			
		}
		
		return GlobalSettings::$instance;
		
	}
	
	
	public function isEnvironmentSet() {

		if (!isset($_SESSION['environment']) || (isset($_GET['action']) && isset($_GET['environment']))) {
			
			try {
				
				if (isset($_GET['action']) && $_GET['action'] == "setEnvironment" && isset($_GET['environment'])) {
					
					$this->setEnvironmentType($_GET['environment']);
					
					unset($_GET['action']);
					
					header('Content-type: application/json');
					
					$return_str = <<<EOD
						"Success": [
							{ 
								"ms": "{Request successfully processed!}"
							},
						 ]
EOD;
	
					echo "{" . $return_str . "}";
					
				}
				else 
					throw new ValidationException("Environment is not set", 0);
					
			}
		
			catch (validationException $e) {
				
				ExceptionsManager::getExceptionsManager()->handleException($e);
				
			}	
				
			ExceptionsManager::getExceptionsManager()->exceptionsCheck();						
			
		}
		
	}
	
	
	
	public function isSiteDown() {
		
		try {
			
			if ($this->siteDown == true)
				throw new ValidationException("The Site is Down");

		}
				
		catch (validationException $e) {
		
			ExceptionsManager::getExceptionsManager()->handleException($e);
		
		}
		
	}
	
	
	public function setEnvironmentType($type) {
		
		switch ($type) {
			
			default:
			case "web":
				$_SESSION['environment'] = "web";
			break;

			case "mobile":
				$_SESSION['environment'] = "mobile";
			break;
			
			case "iphone":
				$_SESSION['environment'] = "iphone";
			break;
				
			case "android":
				$_SESSION['environment'] = "android";
			break;	
			
		}
				
	}	
	
	
	public function getPathToImages() {
		
		return $this->pathToImages;
		
	}
	
	
	public function isLocalhost() {
		if($_SERVER['SERVER_NAME'] == "localhost")
			return true;
		return false;
	}
	
}


?>