<?php
if (session_id() == '') session_start();
if ($_SESSION['authorized'] != true) echo("");

include_once("get_user_count.php");

$result = GetUserCount();

echo($result);
?>