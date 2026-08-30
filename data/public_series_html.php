<?php
session_start();
if ($_SESSION['authorized'] != true) echo("");

include_once("public_series.php");

$series = $_GET['series'];
$result = PublicSeries($series);

echo($result);
?>