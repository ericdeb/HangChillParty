<?php

class NewsItem {
	
	private $id;
	private $text;
	private $hyperlink;
	private $updateTime;
	
	private function __construct() {
		
	}
	
	
	public static function fullConstructor($id, $text, $hyperlink, $updateTime) {
		
		$newsItem = new NewsItem();
		
		$newsItem->id = $id;
		$newsItem->text = $text;
		$newsItem->hyperlink = $hyperlink;
		$newsItem->updateTime = Time::convertToUserTimeZone($updateTime);
		
		return $newsItem;
		
	}
	
	
	public static function fullDBConstructor($id) {
		
	}
	
	
	public function toFullJSONString() {
		
		return '"NewsItem": [' . $this->toPartJSONString() . '],';
		
	}
	
	
	public function toPartJSONString() { 
	
		$link = Verifier::JSONReadyText($this->hyperlink);
		$text = Verifier::JSONReadyText($this->text);
	
		$return_str = <<<EOD
		
				{ 
					"id": "{$this->id}",
					"li": "{$link}",
					"tx": "{$text}",
					"up": "{$this->updateTime}"
				},
				
EOD;

		return $return_str;
	
	}
	
}

?>