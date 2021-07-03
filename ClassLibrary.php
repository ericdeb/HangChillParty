<?php

//path to model
$ptm = "Model/";

//path to controller
$ptc = "Controller/";


//paths to Model

include($ptm . "Verifier.php");
include($ptm . "Settings.php");
include($ptm . "User.php");
include($ptm . "FullUser.php");
include($ptm . "FindFriends.php");
include($ptm . "FindFriendsSimple.php");
include($ptm . "Status.php");
include($ptm . "ValidationException.php");
include($ptm . "AlertSettings.php");
include($ptm . "AwardsAccepted.php");
include($ptm . "BasicUser.php");
include($ptm . "DatabaseConnection.php");
include($ptm . "Friend.php");
include($ptm . "FriendRequest.php");
include($ptm . "FriendsSearch.php");
include($ptm . "FriendsFromFacebook.php");
include($ptm . "FriendsEmailSearch.php");
include($ptm . "FriendsOfSearch.php");
include($ptm . "FullStatus.php");
include($ptm . "GlobalSettings.php");
include($ptm . "JoinedStatus.php");
include($ptm . "LeaderStatus.php");
include($ptm . "NewsItem.php");
include($ptm . "Party.php");
include($ptm . "SocialMeter.php");
include($ptm . "SocialNetworkSettings.php");
include($ptm . "StyleSettings.php");
include($ptm . "Time.php");
include($ptm . "TimeZone.php");
include($ptm . "Update.php");
include($ptm . "UserImage.php");
include($ptm . "UserList.php");
include($ptm . "UserSettings.php");






//paths to Controller
include($ptc . "AlertsManager.php");
include($ptc . "AutoCompleteManager.php");
include($ptc . "AwardsManager.php");
include($ptc . "CommunicationsManager.php");
include($ptc . "ExceptionsManager.php");
include($ptc . "FacebookManager.php");
include($ptc . "FriendsManager.php");
include($ptc . "InitializeManager.php");
include($ptc . "ListsManager.php");
include($ptc . "LoggingManager.php");
include($ptc . "LoginManager.php");
include($ptc . "PartyManager.php");
include($ptc . "RegistrationManager.php");
include($ptc . "RequestsManager.php");
include($ptc . "RequestsManagerJSON.php");
include($ptc . "RequestsManagerSmartPhone.php");
include($ptc . "RequestsManagerAndroid.php");
include($ptc . "RequestsManagerIphone.php");
include($ptc . "RequestsManagerWeb.php");
include($ptc . "StatusManager.php");
include($ptc . "StatisticsManager.php");
include($ptc . "TwitterManager.php");
include($ptc . "UpdatesManager.php");


//include facebook Script


?>