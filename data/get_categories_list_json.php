<?php
session_start();
if ($_SESSION['authorized'] != true) 
	$user = 0;
else
	$user = $_SESSION['userid'];
	
include_once("get_categories_list.php");

$categories = GetCategoriesList($user);

echo json_encode($categories);
?>