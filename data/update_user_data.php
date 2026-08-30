<?php
// обновить данные пользователя
function UpdateUserData($login, $password, $first_name, $last_name)
{
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();
	
		if ($password != "")
			$update_query = "update users set password = :password, first_name = :first_name, last_name = :last_name where login = :login";
		else
			$update_query = "update users set first_name = :first_name, last_name = :last_name where login = :login";	

		$query = $db->prepare($update_query);
	    $query->bindValue(':login', $login, PDO::PARAM_STR);		
	    $query->bindValue(':password', $password, PDO::PARAM_STR);		
	    $query->bindValue(':first_name', $first_name, PDO::PARAM_STR);		
	    $query->bindValue(':last_name', $last_name, PDO::PARAM_STR);		
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