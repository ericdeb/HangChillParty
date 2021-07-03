<?php

class DatabaseConnection {
	
	
	private static $instance = false;
	private $dbc;
	private $user;
	private $password;
	private $host;
	private $db_name;
	
	
	private function __construct() {
		
		$instance = true;
		$this->user = 'root';
		$this->password = 'root';
		$this->host = 'localhost';
		$this->db_name = 'weutt2';
		$this->dbc = new mysqli($this->host, $this->user, $this->password, $this->db_name);

	}
	
	
	public static function getDatabaseConnection() {
		
		if (!DatabaseConnection::$instance) {
			
			DatabaseConnection::$instance = new DatabaseConnection();
			
		}
		
		return DatabaseConnection::$instance->getDBC();
		
	}
	
	private function getDBC() {
		return $this->dbc;	
	}
	
}


?>