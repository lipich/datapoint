<?php
// получить название категории
function GetCategoryName($category)
{
	if ($category == "") return "";
	
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();

		$query = $db->prepare("select name from categories where id = :category");
	    $query->bindValue(':category', $category, PDO::PARAM_STR);
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