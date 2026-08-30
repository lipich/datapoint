<?php
// обновить пароль
function UpdateUserPassword($login, $password)
{
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();
	
		$query = $db->prepare("update users set password = :password where login = :login");
	    $query->bindValue(':login', $login, PDO::PARAM_STR);		
	    $query->bindValue(':password', $password, PDO::PARAM_STR);		
		$query->execute();
		
	    return 0;
	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }
}
?>