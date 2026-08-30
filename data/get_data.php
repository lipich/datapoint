<?php
// получить данные ряда
function GetDistinctAxisX($series, $type)
{
	$arrX = array();
	
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();
	
		$select_query = "";

		if ($type == "x_date") 
			$select_query = "select distinct date_format(axis_x_date, '%d.%m.%Y') as axis_x from data where series in (:series) order by axis_x_date";
		
		if ($type == "x_number") 
			$select_query = "select distinct axis_x_number as axis_x from data where series in (:series) order by axis_x_number";
	
		$query = $db->prepare($select_query);
	    $query->bindValue(':series', $series, PDO::PARAM_STR);

		$query->execute();

		$i = 0;
		while($data = $query->fetch(PDO::FETCH_ASSOC)) 
		{
	        $arrX[$i] = $data['axis_x'];
	
	        $i++;
		}		
	
		return $arrX;
	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }	
}

// получить данные ряда
function GetData($series, $type)
{
	$arrData = array();
	
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();

		$select_query = "";
	
		if ($type == "x_date")
			$select_query = "select date_format(axis_x_date, '%d.%m.%Y') as axis_x, value from data where series in (:series) order by axis_x_date";
	
		if ($type == "x_number")
			$select_query = "select axis_x_number as axis_x, value from data where series in (:series) order by axis_x_number";
		
		$query = $db->prepare($select_query);
	    $query->bindValue(':series', $series, PDO::PARAM_STR);

		$query->execute();
	
		$i = 0;
		while ($data = $query->fetch(PDO::FETCH_ASSOC))
		{
        	$arrData[$i][0] = $data['axis_x'];
			$arrData[$i][1] = $data['value'];

			$i++;
		}
	
		return $arrData;
	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }	
}

// получить данные ряда для графика
function GetDataGraph($series, $type)
{
	$arrData = array();
	
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();
	
		if ($type == "x_date")
			$select_query = "select unix_timestamp(axis_x_date) as axis_x, value from data where series in (:series) order by axis_x_date";
	
		if ($type == "x_number")
			$select_query = "select axis_x_number as axis_x, value from data where series in (:series) order by axis_x_number";
	
		$query = $db->prepare($select_query);
	    $query->bindValue(':series', $series, PDO::PARAM_STR);

		$query->execute();
	
		$i = 0;
		while ($data = $query->fetch(PDO::FETCH_ASSOC))
		{
        	$arrData[$i][0] = (float)$data['axis_x']*1000;
			$arrData[$i][1] = (double)$data['value'];

			$i++;
		}

		return $arrData;
	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }	
}

// получить обновленные данные ряда
function GetDataUpdate($series, $type)
{
	$arrData = array();
	
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();

		if ($type == "x_date")
			$select_query = "select t2.axis_x_date as axis_x, t1.value, t2.value as value_new " .
						    "from data_temp t2 left join data t1 on t1.series = t2.series and t1.axis_x_date = t2.axis_x_date " . 
							"where t2.series = :series order by t2.axis_x_date";
	
		if ($type == "x_number")
			$select_query = "select t2.axis_x_number as axis_x, t1.value, t2.value as value_new " .
						    "from data_temp t2 left join data t1 on t1.series = t2.series and t1.axis_x_number = t2.axis_x_number " . 
							"where t2.series = :series order by t2.axis_x_number";
	
		$query = $db->prepare($select_query);
	    $query->bindValue(':series', $series, PDO::PARAM_INT);

		$query->execute();
	
		$i = 0;
		while ($data = $query->fetch(PDO::FETCH_ASSOC))
		{
        	$arrData[$i][0] = $data['axis_x'];
			$arrData[$i][1] = $data['value'];
			$arrData[$i][2] = $data['value_new'];

			$i++;
		}
	
		return $arrData;
	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }	
}
?>