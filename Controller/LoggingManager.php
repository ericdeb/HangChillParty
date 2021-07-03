<?php

class LoggingManager {
	
	
	private static $instance = false;
	private $fileLogLocation = "log.txt";
	private $logID;


	private function __construct() {
		
		$instance = true;

	}
	
	
	public static function getLoggingManager() {
		
		if (!LoggingManager::$instance) {
			
			LoggingManager::$instance = new LoggingManager();
			
		}
		
		return LoggingManager::$instance;
		
	}
	
	
	public function writeToLog($message) {
		
		$message = $this->getLogID() . "||" . Time::getUserTime() . ": " . $message . "\r\n\r\n\r\n\r\n\r\n";
		
		$logFile = fopen($this->fileLogLocation, "a");  //mode is "a" means write only

		fwrite($logFile, $message);

		fclose($logFile);

	}
	
	
	public function clearLog() {
		
		$logFile = fopen($this->fileLogLocation, "w");  //mode is "w" means write and clear

		fwrite($logFile, "");

		fclose($logFile);
		
	}
	
	
	public function getLogID() {
		
		if ($this->logID != NULL)
			return $this->logID;
			
		$this->logID = rand(1, 100000);
		
		return $this->logID;
		
	}

	
}

?>