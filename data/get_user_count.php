<?php
// получить количество пользователей
function GetUserCount()
{
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();
	
		$query = $db->prepare("select count(*) from users");
		$query->execute();
	    $count = $query->fetchColumn();
	 
	    return $count;
	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }
}
?>