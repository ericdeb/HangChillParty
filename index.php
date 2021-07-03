<?php

session_start();

$_SESSION['environment'] = "web";

$_SESSION['social_rating_awards'] = array();
$_SESSION['general_awards'] = array();

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

if (isset($_GET['fb']) && $_GET['fb'] == 1) {
	$_SESSION['facebookInvitesDone'] = true;
	$_SESSION['inviteFacebookFriends'] = true;
	header('Location: index.php');
}

LoginManager::getLoginManager()->tryRememberMe();

if (!isset($_SESSION['user_id'])) {
	
   if (isset($_GET['fbpost']) && $_GET['fbpost'] == true)
		StatisticsManager::getStatisticsManager()->incrementFacebookVisitStatistic();
	
   header('Location: login.php');
   exit();
}



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" style="background-color:#00003D; overflow-x:hidden">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" type="image/png" href="Images/favicon.png">
<link rel="stylesheet" type="text/css" href="Styles/compatibilityDummy.css" media="screen"/>
<script type="text/javascript" src="IncludesJS/jquery.js"></script>
<script type="text/javascript" src="IncludesJS/includeMany.js"></script>
<script type="text/javascript" src="Jquery/Universal/GlobalFunctions.js"></script>
<script type="text/javascript" src="Jquery/Universal/LoadManager.js"></script>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
var test = <?php echo $test; ?>;
</script>
<title>Hangchillparty</title>
</head>
<body style="background-color:#00003D; overflow: hidden;">
<noscript>
    <div style="background-color:#FFF; position:fixed; top:0px; left:0px; height:1000px; width: 2000px; overflow:hidden;">
    	<span style="margin-left:20px; position:relative; top:20px; font-size:18px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;">This site requires javascript.  You should be able to enable it in browser options.</span>
    </div>
</noscript>
<div id="loadingCover" style="background-color:#00003D; z-index:10; width:900px; height:2000px; overflow:hidden;"></div>
<div id="fb-root"></div>
<div id="main">
	<div id="mainTabs">
            <ul id="mainTabsHeading" class="hiddenTabs">
                <li><a href="#mainTabs-1"></a></li>
                <li><a href="#mainTabs-2"></a></li>
                <li><a href="#mainTabs-3"></a></li>
                <li><a href="#mainTabs-4"></a></li>
                <li><a href="#mainTabs-5"></a></li>
                <li><a href="#mainTabs-6"></a></li>
                <li><a href="#mainTabs-7"></a></li>
                <li><a href="#mainTabs-8"></a></li>
            </ul>
        <div id="mainTabs-1"></div>
        <div id="mainTabs-2">
        	<div id="findFriends">
                <div id="friendsSearchTabs">
                    <ul id="friendsSearchTabsHeading" class="hiddenTabs">
                        <li><a href="#friendsSearchTabs-1"></a></li>
                        <li><a href="#friendsSearchTabs-2"></a></li>
                        <li><a href="#friendsSearchTabs-3"></a></li>
                        <li><a href="#friendsSearchTabs-4"></a></li>
                    </ul>
                    <div id="friendsSearchTabs-1"></div>
                    <div id="friendsSearchTabs-2"></div>
                    <div id="friendsSearchTabs-3">
                    	<div id="facebookFriendsSuccess"></div>
                        <div id="facebookFriendSelector">
                            <fb:serverfbml>  
                                <script type="text/fbml">
                                    <fb:fbml>  
                                        <fb:request-form action="http://hangchillparty.com/index.php?fb=1" method="post" invite="true" type="Hangchillparty" content="Hangchillparty is cool.  I&#039;m using it.  Check it out.  &amp;lt;fb:req-choice url=&amp;quot;http://hangchillparty.com/index&amp;quot; label=&amp;quot;Check out the site&amp;quot; /&amp;gt;" >  
                                            <fb:multi-friend-selector actiontext="Let other cool people know about Hangchillparty." showborder="true" rows="5" cols="3" email_invite="false" bypass="false" />
                                        </fb:request-form>  
                                    </fb:fbml>  
                                </script>  
                            </fb:serverfbml>
                        </div>
                    </div>
                    <div id="friendsSearchTabs-4"></div>
                 </div>
        	</div>
        </div>
        <div id="mainTabs-3"></div>
        <div id="mainTabs-4"></div>
        <div id="mainTabs-5"></div>
        <div id="mainTabs-6"></div>
		<div id="mainTabs-7"></div>
		<div id="mainTabs-8"></div>
    </div>    
</div>                           
</body>
</html>
