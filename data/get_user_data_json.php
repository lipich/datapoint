<?php
session_start();
if ($_SESSION['authorized'] != true) 
	$login = 0;
else
	$login = $_SESSION['login'];
	
include_once("get_user_data.php");

$userData = GetUserData($login);

echo json_encode($userData);
?>