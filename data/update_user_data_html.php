<?php
session_start();
//if ($_SESSION['authorized'] == true) header("location: index.php?action=user");

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

include_once("update_user_data.php");
include_once("get_user_id.php");

$login = $_GET['login'];
if ($_GET['password'] != "")
	$password = md5($_GET['password']);
else
	$password = "";
$first_name = $_GET['first_name'];
$last_name = $_GET['last_name'];

$update = UpdateUserData($login, $password, $first_name, $last_name);

if ($update)
{
	$_SESSION['first_name'] = $first_name;
	$_SESSION['last_name'] = $last_name;   		 		
}
else
{
 	echo($content_update_error);
}

echo("<p class='register_text'>" . 
  	 "<br /><br />" .
	 $content_update_complete . 
	 "<br /><br /><br />" . 
	 "<a href='index.php?action=user' class='login_section_item'>" . $content_login . "</a>");
?>