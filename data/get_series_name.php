<?php 
// получить название ряда
function GetSeriesName($series)
{
	if ($series == "") return "";
	
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();

		$query = $db->prepare("select name from series where id in (:series)");
	    $query->bindValue(':series', $series, PDO::PARAM_STR);
		$query->execute();
	    $series = $query->fetchColumn();
	
	    return $series;
	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }
}
?>