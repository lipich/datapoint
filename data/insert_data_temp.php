<?php
// вставить данные ряда в буфер
function InsertDataTemp($series, $date, $value, $type)
{
    require($_SERVER['DOCUMENT_ROOT'] . "/datapoint/" . "config.php");

    $connect = mysql_connect($db_host, $db_user, $db_password);
    mysql_select_db($db_name, $connect) or die(mysql_error());
    mysql_query("set names utf8");
	
	if ($type == 'x_date')
	{
		// привести дату
		if (strlen($date) == 4) $date = "01.01." . $date; 
		if (strlen($date) == 7) $date = "01." . $date; 
	
		$insert_query = "insert into data_temp (series, axis_x_date, value)
								        values (" . $series . ", STR_TO_DATE('" . $date . "', '%d.%m.%Y'), " . str_replace(",", ".", $value) . ")";
	}

	if ($type == 'x_number')
		$insert_query = "insert into data_temp (series, axis_x_number, value)
								        values (" . $series . ", " . $date . ", " . str_replace(",", ".", $value) . ")";
	
    $result = mysql_query($insert_query) or die(mysql_error());
    $id = mysql_insert_id();
    
    mysql_close($connect);

    return $id;
}
?>