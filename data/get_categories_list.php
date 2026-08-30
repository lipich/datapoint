<?php
// получить список категорий
function GetCategoriesList($user)
{
	$arrCategories = array();
	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/datapoint/data/" . "connect_db.php");
	     
	try 
	{
		$db = connect_db();
				
		$query = $db->prepare("select id, name from (
			select t_c.id, t_c.name, count(t_s.id) as qnt_series 
			from categories t_c inner join 
				series t_s on t_s.category = t_c.id
			where t_s.user = :user or t_s.public = 1
			group by t_c.id, t_c.name) s 
			where s.qnt_series > 0 
			order by s.name");
	    $query->bindValue(':user', $user, PDO::PARAM_STR);
		$query->execute();
		
		$i = 0;
		while($data = $query->fetch(PDO::FETCH_ASSOC)) 
		{
			$arrCategories[$i][0] = $data['id'];
	        $arrCategories[$i][1] = $data['name'];
	
	        $i++;
		}		
		
	    return $arrCategories;		
	}
	catch(PDOException $ex)
	{
    	print($ex->getMessage());
		return null;
    }
}
?>