<?php
session_start();
if ($_SESSION['authorized'] == true) header("location: index.php?action=user");

$user = $_SESSION['userid'];
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

include_once("register_user.php");
include_once("get_user_id.php");

$login = $_GET['login'];
$password = md5($_GET['password']);
$first_name = $_GET['first_name'];
$last_name = $_GET['last_name'];

$register = RegisterUser($login, $password, $first_name, $last_name);

if ($register)
{
	$userid = GetUserId($login);
					
	$_SESSION['authorized'] = true;
	$_SESSION['login'] = $login;
	$_SESSION['first_name'] = $first_name;
	$_SESSION['last_name'] = $last_name;   		 		
	$_SESSION['userid'] = $userid;
}
else
{
 	echo($content_register_error);
}

// todo create separate method
$message = "Уважаемый " . $first_name . " " . $last_name . ", cпасибо за регистрацию на Datapoint.";
$headers = "From: Datapoint";
mail($login, "Регистрация на Datapoint", $message, $headers);
		
echo("<p class='register_text'>" . 
  	 "<br /><br />" .
	 $content_register_complete . 
	 "<br /><br /><br />" . 
	 "<a href='index.php?action=user' class='login_section_item'>" . $content_login . "</a>");
?>