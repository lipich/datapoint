<?php
session_start();
if ($_SESSION['authorized'] != true) echo("");

include_once("edit_series.php");

$series = $_GET['series'];
$series_name = $_GET['series_name'];
$category_name = $_GET['category_name'];

$result = EditSeries($series, $series_name, $category_name);

echo($result);
?>