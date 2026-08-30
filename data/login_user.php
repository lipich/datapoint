<?php
// аутентификация
function LoginUser($login, $password)
{
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();
	
		$query = $db->prepare("select count(*) from users where login = :login and password = :password");
	    $query->bindValue(':login', $login, PDO::PARAM_STR);
	    $query->bindValue(':password', $password, PDO::PARAM_STR);
		$query->execute();
	    $data = $query->fetchColumn();

		if ($data[0] == 0)
			$result = false;
		else 
			$result = true;
		
	    return $result;
	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }
}
?>