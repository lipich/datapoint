<?php
// получить категорию
function GetCategory($series)
{
	if ($series == "") return "";
	
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();
	
		$query = $db->prepare("select category from series where id = :series");
	    $query->bindValue(':series', $series, PDO::PARAM_INT);		
		$query->execute();

	    $category = $query->fetchColumn();

    	return $category;
    }
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }

}
?>