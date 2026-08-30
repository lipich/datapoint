<?php
if (session_id() == '') session_start();
if ($_SESSION['authorized'] != true) echo("");

include_once("delete_series.php");

$series = $_GET['series'];

$result = DeleteSeries($series);

echo($result);
?>