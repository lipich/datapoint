<?php
session_start();
if ($_SESSION['authorized'] != true) echo("");

include_once("update_series_data.php");

$series = $_GET['series'];
$cancel = $_GET['cancel'];
$result = UpdateSeriesData($series, $cancel);

echo($result);
?>