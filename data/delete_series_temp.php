<?php
// удалить временные данные ряда
function DeleteSeriesTemp($series)
{
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();
	
		$query = $db->prepare("delete from data_temp where series in (:series)");
	    $query->bindValue(':series', $series, PDO::PARAM_STR);
		$query->execute();
		
		$files = explode(",", $series);	
		foreach ($files as $file) 
		{
			$file_name = $file . "_update.csv";
			unlink("../" . $storage . $file_name);
		}
		
		return 0;
	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }
}
?>