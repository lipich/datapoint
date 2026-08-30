<?php
// подключение к базе данных
function connect_db()
{
	require($_SERVER['DOCUMENT_ROOT'] . "/datapoint/" . "config.php");

	try 
	{
	    //$connection = new PDO("mysql:host=" . $db_host . ";dbname=" . $db_name . ";charset=utf8", $db_user, $db_password);
	    $connection = new PDO("mysql:host=" . $db_host . ";dbname=" . $db_name, $db_user, $db_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);		

	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }
    
    return $connection;
} 
?>