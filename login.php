<?php

session_start();

$_SESSION['environment'] = "web";

$test = "false";

include("ClassLibrary.php");

if (GlobalSettings::getGlobalSettings()->isLocalhost() == true)
	$test = "true";

if (strpos(getcwd(), "Test") == true) {
	
	if (!isset($_SESSION['testing'])) {
		header("Location: testLogin.php");
		exit();
	}
	
	$test = "true";
}

$startRegister = isset($_GET['register']) && $_GET['register'] == "true" ? "true" : "false";

LoginManager::getLoginManager()->tryRememberMe();

if (isset($_SESSION['user_id'])) {
   header('Location: index.php');
   exit();
}

StatisticsManager::getStatisticsManager()->incrementVisitStatistic();


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" style="background-color:#00003D; overflow-x:hidden">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="Styles/compatibilityDummy.css" media="screen"/>
<link rel="icon" type="image/png" href="Images/favicon.png">
<script type="text/javascript" src="IncludesJS/jquery.js"></script>
<script type="text/javascript" src="IncludesJS/includeMany.js"></script>
<script type="text/javascript" src="Jquery/Login/LoginFunctions.js"></script>
<script type="text/javascript" src="Jquery/Login/LoginLoadManager.js"></script>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">

var startRegister = <?php echo $startRegister; ?>;
var test = <?php echo $test; ?>;

</script>
<title>Hangchillparty</title>
</head>
<body>
<noscript>
    <div style="background-color:#FFF; position:fixed; top:0px; left:0px; height:1000px; width: 2000px; overflow:hidden;">
    	<span style="margin-left:20px; position:relative; top:20px; font-size:18px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;">This site requires javascript.  You should be able to enable it in browser options.</span>
    </div>
</noscript>
<div id="loadingCover" style="background-color:#00003D; z-index:10; width:2000px; height:1000px; overflow:hidden;"></div>
<div id="fb-root"></div>
<div id="loginMain">
	<div id="loginMainTabs">
            <ul id="loginMainTabsHeading" class="hiddenTabs">
                <li><a href="#loginMainTabs-1"></a></li>
                <li><a href="#loginMainTabs-2"></a></li>
                <li><a href="#loginMainTabs-3"></a></li>
                <li><a href="#loginMainTabs-4"></a></li>
                <li><a href="#loginMainTabs-5"></a></li>
            </ul>
        <div id="loginMainTabs-1">
        	<div id="socialLinks">
            	<div id="shareButton">
                    <fb:share-button class="meta" type="button">
                        <meta name="title" content="Hangchillparty"/>  
                        <meta name="description" content="That's the lesson 300 teaches us."/>
                        <link rel="image_src" href="http://www.hangchillparty.com/Images/facebookShareLogo.png"/>  
                        <link rel="target_url" href="http://www.hangchillparty.com/"/>                 
                    </fb:share-button>
                </div>
                <div id="diggButton"><a class="DiggThisButton DiggCompact"></a></div>
                <div id="rrt"></div>
                <div id="likeButton"><fb:like show_faces="false" width="260"></fb:like></div>
            </div>
        </div>
        <div id="loginMainTabs-2"></div>
        <div id="loginMainTabs-3"></div>
        <div id="loginMainTabs-4"></div>
        <div id="loginMainTabs-5"></div>
    </div>    
</div> 
<div style="width:300px; height:30px">
   <div style="width:100%; height:100%; background-color:#00003D; position:relative; top:0px; right:0px;"></div>
    <form id="hiddenLoginForm" action="login.php" method="POST">
        <input id="hiddenEmail" type="text" name="email" />
        <input id="hiddenPass" type="password" name="pass" />
        <input id="hiddenSubmit" type="submit" name="submit" />
    </form> 
</div> 
                
</body>
</html>
