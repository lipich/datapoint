<?php
// удалить ряд
function DeleteSeries($series)
{
	require($_SERVER['DOCUMENT_ROOT'] . "/datapoint/" . "config.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();
		$db->beginTransaction();
	
		$query = $db->prepare("select max(category) from series where id in (:series)");
	    $query->bindValue(':series', $series, PDO::PARAM_STR);
		$query->execute();
	    $category = $query->fetchColumn();

		$query = $db->prepare("delete from data where series in (:series)");
	    $query->bindValue(':series', $series, PDO::PARAM_STR);
		$query->execute();

		$query = $db->prepare("delete from series where id in (:series)");
	    $query->bindValue(':series', $series, PDO::PARAM_STR);
		$query->execute();

		$query = $db->prepare("select count(*) from series where category in (:category)");
	    $query->bindValue(':category', $category, PDO::PARAM_STR);
		$query->execute();
	    $count = $query->fetchColumn();
		
		if ($count == 0)
		{
			$query = $db->prepare("delete from categories where id in (:category)");
			$query->bindValue(':category', $category, PDO::PARAM_STR);
			$query->execute();
		}
	
		$files = explode(",", $series);
	
		foreach ($files as $file) 
		{
			$file_name = $file . ".csv";
			unlink("../" . $storage . $file_name);
		}
		
		$db->commit();
		
		return $count;
    }
	catch(PDOException $ex)
	{
		$db->rollback();
		
    	print($ex->getMessage());
		return null;
    }	
}
?>