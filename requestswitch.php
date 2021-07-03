<?php
session_start();

ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);

include("ClassLibrary.php");

GlobalSettings::getGlobalSettings()->isEnvironmentSet();
GlobalSettings::getGlobalSettings()->isSiteDown();
TimeZone::autoUpdateTimeZone();
ExceptionsManager::getExceptionsManager()->exceptionsCheck();
$requestsManager = RequestsManager::getRequestsManager();

if (isset($_GET['action']))
	$requestsManager->handleRequest($_GET['action']);

?>