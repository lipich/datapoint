<?php
// сделать ряд публичным
function PublicSeries($series)
{
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();

		$query = $db->prepare("update series set public = ((public - 1) * (-1)) where id in ($series)");
	    //$query->bindValue(':series', $series, PDO::PARAM_STR); // для in параметра не нужно bind	
		$query->execute();
		
	    return 0;
	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }
}
?>