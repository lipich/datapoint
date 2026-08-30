<?php
// вставить ряд
function InsertSeries($user, $category, $name, $type)
{
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();
	
		$query = $db->prepare("insert into series (category, user, public, name, date_add, type)
								 values (:category, :user, 0, :name, CURDATE(), :type)");
	    $query->bindValue(':user', $user, PDO::PARAM_INT);		
	    $query->bindValue(':category', $category, PDO::PARAM_INT);		
	    $query->bindValue(':name', $name, PDO::PARAM_STR);		
	    $query->bindValue(':type', $type, PDO::PARAM_STR);		
		$query->execute();
		$id = $db->lastInsertId();
		
	    return $id;
	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }
}
?>