<?php
if(!isset($_SESSION)) session_start();
if ($_SESSION['authorized'] != true) 
	$user = 0;
else
	$user = $_SESSION['userid'];

include_once("get_series_list.php");

$series = GetSeriesList($user);

echo '{ "data": ' . json_encode($series) . ' }';
?>