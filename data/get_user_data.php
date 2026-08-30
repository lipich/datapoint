<?php
// получить данные пользователя
function GetUserData($login)
{
	$arrUser = array();
	
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();
	
		$query = $db->prepare("select id, first_name, last_name from users where login = :login");
	    $query->bindValue(':login', $login, PDO::PARAM_STR);		
		$query->execute();
	    $data = $query->fetchAll(PDO::FETCH_ASSOC);

		if (count($data) > 0)		
		{
			$arrUser[0] = $data[0]['id'];
			$arrUser[1] = $data[0]['first_name'];
			$arrUser[2] = $data[0]['last_name'];
		}
		
	    return $arrUser;
	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }
}
?>