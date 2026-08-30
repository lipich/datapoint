<?php
session_start();
if ($_SESSION['authorized'] != true) echo("");

if (!isset($_SESSION['lang'])) 
	$_SESSION['lang'] = "ru";

$lang = $_SESSION['lang'];

// словарь в соответствии с языком
switch($lang)
{
   case "ru":
       include("../content_ru.php");
       break;
   case "en":
       include("../content_en.php");
       break;
}

include_once("get_data.php");

$series = $_GET['series'];
$type = $_GET['type'];

echo("<p>" . $content_data_update_header . "</p>");
echo("<table class='report_table'>");

$arrData = GetDataUpdate($series, $type);

echo("<tr class='head_table'><td>&nbsp</td>");
foreach ($arrData as $data) echo("<td>" . $data[0] . "</td>");

echo("</tr><tr><td class='head_row'>Старые данные</td>");
foreach ($arrData as $data)	echo("<td class='td_numeric'>" . $data[1] . "</td>");

echo("</tr><tr><td class='head_row'>Новые данные</td>");
foreach ($arrData as $data) echo("<td class='td_numeric'>" . $data[2] . "</td>");

echo("</tr></table>");
?>