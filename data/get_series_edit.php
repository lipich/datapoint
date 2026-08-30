<?php
session_start();
if ($_SESSION['authorized'] != true) echo("");

include_once("get_series_name.php");
include_once("get_category.php");
include_once("get_category_name.php");

$series = $_GET['series'];
$seriesName = GetSeriesName($series);
$category = GetCategory($series);
$categoryName = GetCategoryName($category);

// todo remove text constants
echo("<table>");
echo("<tr>");
echo("<td><span class='login_text'>Название категории</span></td><td>&nbsp;</td>");
echo("<td><input id='new_category_name' name='new_category_name' type='text' class='login_field' value='" . $categoryName . "' size='70' /></td>");
echo("</tr>");
echo("<tr>");
echo("<td><span class='login_text'>Название ряда</span></td><td>&nbsp;</td>");
echo("<td><input id='new_series_name' name='new_series_name' type='text' class='login_field' value='" . $seriesName . "' size='70' /></td>");
echo("</tr>");
echo("</table>");
?>