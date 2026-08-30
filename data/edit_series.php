<?php
// обновить параметры ряда
function EditSeries($series, $series_name, $category_name)
{
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();
		$db->beginTransaction();

		$query = $db->prepare("update series set name = :series_name where id = :series");
	    $query->bindValue(':series_name', $series_name, PDO::PARAM_STR);
	    $query->bindValue(':series', $series, PDO::PARAM_INT);
		$query->execute();

		$query = $db->prepare("update categories set name = :category_name where id = (select category from series where id = :series)");
	    $query->bindValue(':category_name', $category_name, PDO::PARAM_STR);
	    $query->bindValue(':series', $series, PDO::PARAM_INT);
		$query->execute();		

		$db->commit();
	}
	catch(PDOException $ex)
	{
		$db->rollback();

    	print($ex->getMessage());
		return null;
    }
}
?>