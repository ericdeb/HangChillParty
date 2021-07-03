<?php

session_start();

include("Controller/StatisticsManager.php");
include("../Model/DatabaseConnection.php");
include("Model/StatisticLogin.php");
include("Model/StatisticUpdate.php");
include("Model/StatisticUser.php");
include("Model/Time.php");


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
td, th {padding:10px; text-align:center}
span {font-size:30px; font-weight:bold;}
</style>
<title></title>
</head>
<body>

<span>Updates Per Day Table</span>
<?php echo StatisticsManager::getStatisticsManager()->getNumbersPerDayTable(); ?>

<br />
<br />
<br />

<span>Last 100 Updates</span>
<?php echo StatisticsManager::getStatisticsManager()->getLastHundredUpdatesTable(); ?>

<br />
<br />
<br />

<span>Top 50 Users</span>
<?php echo StatisticsManager::getStatisticsManager()->getTopFiftyUsersTable(); ?>

<br />
<br />
<br />

<span>Visitors Table</span>
<?php echo StatisticsManager::getStatisticsManager()->getLoginTable(); ?>

</body>
</html>