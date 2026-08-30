<?php
// обновить данные ряда
function UpdateSeriesData($series, $cancel)
{
    require($_SERVER['DOCUMENT_ROOT'] . "/datapoint/" . "config.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");

	try 
	{
	    $db = connect_db();
		$db->beginTransaction();
		
		if ($cancel == 0)
		{
			$update_query = "update data t_d 
							 set t_d.value = (select t_dt.value from data_temp t_dt where t_dt.series = t_d.series and t_dt.axis_x_date = t_d.axis_x_date) 
							 where t_d.series = :series
							   and t_d.axis_x_date in (select t_dt.date from data_temp t_dt where t_dt.series = :series)";	
		
			$query = $db->prepare($update_query);
		    $query->bindValue(':series', $series, PDO::PARAM_INT);		
			$query->execute();
	
			$insert_query = "insert into data (series, axis_x_date, value)
							 select s.series, s.axis_x_date, s.value from (select t2.series, t2.axis_x_date, t2.value 
							 								               from data_temp t2 left join 
							 								  	                data t1 on t1.series = t2.series and t1.axis_x_date = t2.axis_x_date  
							 								               where t2.series = :series 
							 								                 and t1.value is null
							 							                   order by t2.axis_x_date) s";
			$query = $db->prepare($update_query);
		    $query->bindValue(':series', $series, PDO::PARAM_INT);		
			$query->execute();
		}
		
		$query = $db->prepare("delete from data_temp where series = :series");
	    $query->bindValue(':series', $series, PDO::PARAM_INT);		
		$query->execute();
	
		$file_name = $series . ".csv";
		$file_name_temp = $series . "_update.csv";
	
		if ($cancel == 0)
		{
			unlink("../" . $storage . $file_name);
			rename("../" . $storage . $file_name_temp, "../" . $storage . $file_name);
		}
		else
		{
			unlink("../" . $storage . $file_name_temp);
		}

		$db->commit();
			
	    return 0;
	}
	catch(PDOException $ex)
	{
		$db->rollback();
		
    	print($ex->getMessage());
		return null;
    }
}
?>