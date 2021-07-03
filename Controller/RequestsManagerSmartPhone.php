<?php

abstract class RequestsManagerSmartPhone extends RequestsManagerJSON {
	
	
	public function handleRequest($action) {
		
		parent::handleRequest($action);
		
	}
	
	public function getAutoComplete() {
		
		header('Content-type: application/json');
		
		echo "{" . parent::getAutoComplete() . "}";
		
	}
	
}

?>