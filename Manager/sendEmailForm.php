<?php

session_start();

if (!isset($_SESSION['testing'])) {
	header("Location: testLogin.php");
	exit();
}

if (isset($_POST['submitted'])) {

	include("Controller/CommunicationsManager.php");
	include("../Model/DatabaseConnection.php");
	
	CommunicationsManager::getCommunicationsManager()->sendEmailToUsers();
	
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>

<form name="sendEmails" action="sendEmailForm.php" method="post">
Send current subject and message to all users: <br /><br />
<input type="submit" value="Submit" name="submitted"/>
</form> 

</body>
</html>