<?php

class ValidationException extends Exception {


	public function __construct($message) {
		
		parent::__construct($message);
		
	}
	
	
	public function toFullJSONString() {
		
		return '"Error": [' . $this->toPartJSONString() . '],';
		
	}
	
	
	public function toPartJSONString() { 
	
		$return_str = <<<EOD
		
				{ 
					"ms": "{$this->message}",
					"co": "{$this->code}"
				},
				
EOD;

		return $return_str;
	
	}
	
}

?>