<?php
// получить ID пользователя
function GetUserId($login)
{
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();
	
		$query = $db->prepare("select id from users where login = :login");
	    $query->bindValue(':login', $login, PDO::PARAM_STR);		
		$query->execute();
	    $userid = $query->fetchColumn();
		
	    return $userid;
	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }
}
?>