<?php

session_start();

if (isset($_SESSION['testing'])) {
	header("Location: index.php");
	exit();
}

$errorsStr = '';

if (isset($_POST['submitted'])) {

	include("ClassLibrary.php");
	
	if (isset($_POST['name']) && isset($_POST['pass'])) {
		
		$result = LoginManager::getLoginManager()->tryTestingLogin($_POST['name'], $_POST['pass']);
																								
		if ($result == true) {
			header("Location: index.php");
			exit();
		}
		
	}
	
	$errorsStr = 'You either did not enter a username or password or it was wrong. Try again.';
	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head class="back">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
</head>

<body>

<span style="font-size:24px">This is the test version of Hangchillparty.  Admin login required.</span>

<br />
<br />
<br />
<span style="font-size:16px">Login Here</span>
<br />

<form action="testLogin.php" method="post">

	<p>Name: <input type="text" name="name" size="15" maxlength="20" /></p>
	<p>Password: <input type="password" name="pass" size="15" maxlength="40" /></p>
    
    <input type="submit" name="submitted" value="Submit" />
</form>

<span style="color:#F00;"><?php echo $errorsStr ?> </span>
    

</body>

</html>