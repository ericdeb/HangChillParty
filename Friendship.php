<?php

class FriendRequest {
	
	private $requestID;
	private $requestFirstName;
	private $requestLastName;
	private $receiveID;
	private $receiveFirstName;
	private $receiveLastName;	
	private $status; //enum for status of friend request (Accepted, Rejected, Unknown)
	private $updateTime;
	
	
	private function __construct() {
		
	}
								
	public static function dbConstructor($requestID, $requestFirstName, $requestLastName, $receiveID, $receiveFirstName, $receiveLastName, $status, $updateTime) {
		
		$friendRequest = new FriendRequest();
		
		$friendRequest->requestID = $requestID;
		$friendRequest->requestFirstName = $requestFirstName;
		$friendRequest->requestLastName = $requestLastName;
		$friendRequest->receiveID = $receiveID;
		$friendRequest->receiveFirstName = $receiveFirstName;
		$friendRequest->receiveLastName = $receiveLastName;
		$friendRequest->status = $status;
		$friendRequest->updateTime = Time::convertToUserTimeZone($updateTime);
		
		return $friendRequest;
		
	}
	
	
	public static function limitedConstructor($requestID, $receiveID) {
		
		$friendRequest = new FriendRequest();
		
		$friendRequest->requestID = Verifier::validateNumber($requestID);
		$friendRequest->receiveID = Verifier::validateNumber($receiveID);
		
		return $friendRequest;
		
	}
	
	
	public function toFullJSONString() {
		
		return '"FriendRequest": [' . $this->toPartJSONString() . '],';
		
	}
	
	
	public function toPartJSONString() { 
	
		$requestFirstName = JSONReadyName($this->requestFirstName);
		$requestLastName = JSONReadyName($this->requestLastName);
		$receiveFirstName = JSONReadyName($this->receiveFirstName);
		$receiveLastName = JSONReadyName($this->receiveLastName);
	
		$return_str = <<<EOD

				{ 
					"id1": "{$this->userOneID}",
					"fn1": "{$userOneFirstName}",
					"ln1": "{$userOneLastName}",
					"id2": "{$this->userTwoID}",
					"fn2": "{$userTwoFirstName}",
					"ln2": "{$userTwoLastName}",
					"ti": "{$this->updateTime}"
				}, 

EOD;

		return $return_str;
	
	}
	
}

?>
