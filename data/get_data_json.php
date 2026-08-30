<?php
session_start();
if ($_SESSION['authorized'] != true) echo("");

include_once("get_data.php");

$series = $_GET['series'];
$type = $_GET['type'];

if ($series == '') $series = null;
if ($type == '') $type = null;

$arrDataRaw = GetDataGraph($series, $type);

if ($type == "x_date") 
	$arrData = $arrDataRaw;

if ($type == "x_number")
{
	$i = 0;
	foreach ($arrDataRaw as $data)
	{
		$arrDataX[$i] = $data[0]/1000;
		$arrDataY[$i] = $data[1];
		$i++;
	}	
	
	$arrData[0] = $arrDataX;
	$arrData[1] = $arrDataY;
}

echo json_encode($arrData);
?>