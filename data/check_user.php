<?php
// проверить есть ли такой аккаунт в базе
function CheckUser($login)
{
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();
	
		$query = $db->prepare("select count(*) from users where login = :login");
	    $query->bindValue(':login', $login, PDO::PARAM_STR);
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