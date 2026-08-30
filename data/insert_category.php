<?php
// вставить категорию
function InsertCategory($name)
{
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();
	
		$query = $db->prepare("insert into categories (name) values (:name)");
	    $query->bindValue(':name', $name, PDO::PARAM_STR);		
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