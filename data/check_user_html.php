<?php
session_start();

include_once("check_user.php");

$login = $_GET['login'];

$checkuser = CheckUser($login);
echo($checkuser);
?>