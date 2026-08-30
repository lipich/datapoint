<?php
// Получить список рядов
function GetSeriesListOld($user, $categories)
{	
	$arrDataSeries = array();
	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");
	     
	try 
	{
		$db = connect_db();
				
	
		$query = $db->prepare("select admin from users where id = :user");
	    $query->bindValue(':user', $user, PDO::PARAM_INT);
		$query->execute();
	    $admin = $query->fetchColumn();
			
		if ($user == 0)	
		{	
			// если пользователь не аутентифицирован то отображаются опубликованные ряды
			$select_query = "select id, name, public, 0 as edit, null as login, type from series where public = 1"; 
		    if (!is_null($categories)) $select_query .= " and category in (:categories)";
		}
		else
			if ($admin == 0)
			{
				
				$select_query = "select t_s.id, t_s.name, t_s.public, (select count(*) from data_temp where series = t_s.id) as edit, t_u.login, t_s.type  
								 from series t_s left join 
								      (select * from users where id != :user) t_u on t_u.id = t_s.user  
								 where t_s.user = :user";
			    
			    if (!is_null($categories)) $select_query .= " and category in (:categories)";
			}
			else
			{
				$select_query = "select t_s.id, t_s.name, t_s.public, (select count(*) from data_temp where series = t_s.id) as edit, t_u.login, t_s.type 
								 from series t_s left join 
								      (select * from users where id != :user) t_u on t_u.id = t_s.user";
	
				if (!is_null($categories)) $select_query .= " where category in (:categories)";
			}
	
		$select_query .= " order by name";

		$query = $db->prepare($select_query);
	    if ($user != 0) $query->bindValue(':user', $user, PDO::PARAM_INT);
	    if (!is_null($categories)) $query->bindValue(':categories', $categories, PDO::PARAM_STR);

		$query->execute();
		
		$i = 0;
		while($data = $query->fetch(PDO::FETCH_ASSOC)) 
		{
	        $arrDataSeries[$i][0] = $data['id'];
	        $arrDataSeries[$i][1] = $data['name'];
	        $arrDataSeries[$i][2] = $data['public'];
	        $arrDataSeries[$i][3] = $data['edit'];
	        $arrDataSeries[$i][4] = $data['login'];
	        $arrDataSeries[$i][5] = $data['type'];        
	
	        $i++;
		}		

		return $arrDataSeries;
	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }
}


// Получить список рядов
function GetSeriesList($user)
{	
	$arrDataSeries = array();
	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");
	     
	try 
	{
		$db = connect_db();
		
		$query = $db->prepare("select admin from users where id = :user");
	    $query->bindValue(':user', $user, PDO::PARAM_INT);
		$query->execute();
	    $admin = $query->fetchColumn();
	
		$select_query = "select t_s.id, t_c.name as category_name, t_s.name as series_name, t_s.public, (select count(*) from data_temp where series = t_s.id) as edit, t_u.login, t_s.type  
						 from series t_s inner join 
						 	  categories t_c on t_c.id = t_s.category inner join 
						 	  users t_u on t_u.id = t_s.user ";
		if ($user == 0) 
		{
			$select_query .= "where t_s.public = 1";
		}
		else
		{
			if ($admin == 0) $select_query .= "where t_s.user = :user"; 
		}			 	    

		$select_query .= " order by category_name, series_name";
		
		$query = $db->prepare($select_query);
	    if ($user != 0) $query->bindValue(':user', $user, PDO::PARAM_INT);
		$query->execute();
		
		$i = 0;
		while($data = $query->fetch(PDO::FETCH_ASSOC)) 
		{
	        $arrDataSeries[$i][0] = $data['id'];
	        $arrDataSeries[$i][1] = $data['category_name'];
	        $arrDataSeries[$i][2] = $data['series_name'];
	        $arrDataSeries[$i][3] = $data['login'];
	        $arrDataSeries[$i][4] = $data['public'];
	        $arrDataSeries[$i][5] = $data['type'];
	
	        $i++;
		}		

		return $arrDataSeries;
	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }
}
?>