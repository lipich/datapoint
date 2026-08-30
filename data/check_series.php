<?php
// проверить загружен ли ряд
function CheckSeries($user, $category, $name)
{
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();
	
		$query = $db->prepare("select id from series where category = :category and user = :user and name = :name");
	    $query->bindValue(':category', $category, PDO::PARAM_INT);
	    $query->bindValue(':user', $user, PDO::PARAM_STR);
	    $query->bindValue(':name', $name, PDO::PARAM_STR);		
		$query->execute();
	    $id = $query->fetchColumn();
	 	    
	    return $id;
	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }
}
?>