<?php

session_start();

if (!isset($_SESSION['testing'])) {
	header("Location: testLogin.php");
	exit();
}

$str = "";

if (isset($_POST['submitted'])) {

	include("Controller/SynchronizeManager.php");
	
	SynchronizeManager::getSynchronizeManager()->synchronizeSites();
	
	$str = "DONE";
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<form action="synchronizeSites.php" method="post">
     
    <input type="submit" name="submitted" value="Submit" />
</form>

<span style="font-size:24px"><?php echo $str ?></span>

</body>
</html>