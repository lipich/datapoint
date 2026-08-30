<?php
session_start();
if ($_SESSION['authorized'] != true) echo("");

include_once("get_data.php");
include_once("get_series_name.php");

$series = $_GET['series'];
$arrSeries = explode(",", $series);
$type = $_GET['type'];

$arrX = GetDistinctAxisX($series, $type);

echo("<table class='report_table'>");
echo("<tr class='head_table'><td>&nbsp;</td>");

foreach ($arrX as $x)
{
	echo("<td>" . $x . "</td>");
}

echo("</tr>");

foreach ($arrSeries as $series)
{
	$seriesName = GetSeriesName($series);
	
	echo("<tr><td class='head_row'>" . $seriesName . "</td>");
	
	$arrData = GetData($series, $type);
	
	foreach ($arrX as $x)
	{
		$val = "&nbsp;";
		foreach ($arrData as $data)
		{
			if ($data[0] == $x) $val = $data[1];
		}		
		echo("<td class='td_numeric'>" . $val . "</td>");
	}

	echo("</tr>");
}
echo("</table>");
?>