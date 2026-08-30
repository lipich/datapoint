<?php
// зарегистрировать пользователя
function RegisterUser($login, $password, $first_name, $last_name)
{
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();

		$query = $db->prepare("insert into users (login, password, first_name, last_name, date_register) 
							   values (:login, :password, :first_name, :last_name, CURDATE())");
							   
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