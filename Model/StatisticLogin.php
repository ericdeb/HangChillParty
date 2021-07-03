<?php

class StatisticLogin {
	
	private $numberOfVisits;
	private $numberOfFacebookVisits;
	private $numberOfLogins;
	private $numberOfRegisterVisits;
	private $newVisitors;
	private $newVisitorsWhoClickSignUp;


	public function __construct($numberOfVisits, $numberOfFacebookVisits, $numberOfLogins, $numberOfRegisterVisits, $numberWhoActuallyRegister) {
		
		$this->numberOfVisits = $numberOfVisits;
		$this->numberOfFacebookVisits = $numberOfFacebookVisits;
		$this->numberOfLogins = $numberOfLogins;
		$this->numberOfRegisterVisits = $numberOfRegisterVisits;
		$this->newVisitors = $numberOfVisits - $numberOfLogins;
		$this->newVisitorsWhoClickSignUp = $this->newVisitors != 0 ? $numberOfRegisterVisits/$this->newVisitors : 0;
		$this->numberWhoActuallyRegister = $numberWhoActuallyRegister;
		$this->newVisitorsWhoRegister = $this->newVisitors != 0 ? $numberWhoActuallyRegister/$this->newVisitors : 0;
		
	}
	
	
	public function getTableRow() {
		
		return '<tr><td>' .  $this->numberOfVisits . '</td><td>'	 . $this->numberOfFacebookVisits . '</td><td>'	 . $this->numberOfLogins . '</td><td>' . $this->numberOfRegisterVisits . '</td><td>' . $this->newVisitors . '</td><td>'	 . $this->newVisitorsWhoClickSignUp . '</td><td>'	 . $this->numberWhoActuallyRegister . '</td><td>'	 . $this->newVisitorsWhoRegister . '</td><tr>'; 
		
	}	
	
	
	public static function getTableHeading() {
		
		return '<tr><th>Number of Visits</th><th>Number of Visits From Facebook</th><th>Number of Logins</th><th>Number of Sign Up Visits</th><th>Number of new visitors</th><th>Percentage of new Visitors who click sign up</th><th>Number who actually register</th><th>Percentage of new Visitors who register</th><tr>';
		
	}
	
}

?>