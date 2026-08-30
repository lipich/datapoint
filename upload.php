<?php
if(!isset($_SESSION)) session_start();
if ($_SESSION['authorized'] != true) header("location: index.php?action=login");
if ($_SERVER['REQUEST_URI'] == "/datapoint/upload.php") header("location: index.php?action=user");

$user = $_SESSION['userid'];
$lang = $_SESSION['lang'];

$repeat_link = "<p><a href='index.php?action=user' class='login_section_item'>Повторить</a></p>";
$redirect_link = "index.php?action=user&series=";
$user_link = "index.php?action=user";

// словарь в соответствии с языком
switch($lang)
{
   case "ru":
       include("content_ru.php");
       break;
   case "en":
       include("content_en.php");
       break;
}

// todo move upload to separate file
include("config.php");
include_once("data/get_category.php");
include_once("data/insert_category.php");
include_once("data/insert_series.php");
include_once("data/insert_data.php");
include_once("data/insert_data_temp.php");
include_once("data/delete_series.php");
include_once("data/delete_series_temp.php");

if (isset($_POST['submit_upload']))
{
	if ($_FILES['file_data']['name'])
	{
		if (!$_FILES['file_data']['error'])
		{			
			if ($_FILES['file_data']['size'] > $max_file_size) 
			{
				unlink($_FILES['file_data']['tmp_name']);
				die($content_file_too_large . $repeat_link);
			}
			
			$new_category = str_replace("новая категория", "", $_POST['new_category']);
			$new_series = str_replace("новый ряд", "", $_POST['new_series']);

			$x_type = $_POST['x_value'];

			$selected_category = "";
			if (isset($_POST['f_selected_categories'])) $selected_category = str_replace("null", "", $_POST['f_selected_categories']);
			$selected_series = "";
			if (isset($_POST['f_selected_series'])) $selected_series = str_replace("null", "", $_POST['f_selected_series']);
		
			if (($new_category == "") and ($selected_category == "") and ($selected_series == ""))
			{
				unlink($_FILES['file_data']['tmp_name']);
				die($content_file_param_error . " (category) - " . $selected_category . $repeat_link);
			}

			if (($new_series == "") and ($selected_series == ""))
			{
				unlink($_FILES['file_data']['tmp_name']);
				die($content_file_param_error . " (series) " . $repeat_link);
			}

			$category = "";
			if ($new_category != "") $category = InsertCategory($new_category);
			if ($category == "") $category = $selected_category;
			if ($category == "") $category = GetCategory($selected_series); 
			
			if ($category == "")
			{
				unlink($_FILES['file_data']['tmp_name']);
				die($content_file_param_error  . " (category 2) " . $repeat_link);				
			}
			
			if ($new_series == "") 
			{
				// загружаем данные ряда в буфер
				$id = $selected_series;
				
				$new_file_name = $id . "_update.csv";		
				move_uploaded_file($_FILES['file_data']['tmp_name'], $storage . $new_file_name);
			
				$handle = fopen($storage . $new_file_name, "r");
				while (($row = fgetcsv($handle, 0, ";")) != false) 
				{	
					if (count($row) != 3)
					{
						$result = DeleteSeriesTemp($id);
						unlink($storage . $new_file_name);
						die($content_file_bad_structure . $repeat_link);
					}
					
					$row = InsertDataTemp($id, $row[0], $row[1], $x_type);
				}
				
				echo($content_file_upload_success);
				header("location: " . $redirect_link . $id);
			}
			else
			{
				// загружаем данные ряда 
				$id = InsertSeries($user, $category, $new_series, $x_type);
				
				$new_file_name = $id . ".csv";
				move_uploaded_file($_FILES['file_data']['tmp_name'], $storage . $new_file_name);
				
				$handle = fopen($storage . $new_file_name, "r");
				while (($row = fgetcsv($handle, 0, ";")) != false) 
				{	
					if ((count($row) != 3) and (count($row) != 2))
					{
						$result = DeleteSeries($id);
						unlink($storage . $new_file_name);
						die($content_file_bad_structure . " (" . count($row) . ") " . $repeat_link);
					}
					
					$row = InsertData($id, $row[0], $row[1], $x_type);
				}
				
				echo($content_file_upload_success);
				header("location: " . $redirect_link . $id);
			}
		}
		else
		{
			echo($content_file_upload_error . " " . $_FILES['file_data']['error'] . $repeat_link);
		}
	}
	else
		header("location: " . $user_link);
}
?>
<form action="index.php?action=upload" method="post" enctype="multipart/form-data">
<table width="100%">
	<tr>
		<td width="50%"><input id="new_category" name="new_category" type="text" style="width:99%" class="data_field_empty" value="новая категория" /></td>
		<td width="50%"><input id="new_series" name="new_series" type="text" style="width:99%" class="data_field_empty" value="новый ряд" /></td>
	</tr>
	<tr>
		<td colspan="2">
			<table><tr>
				<td class="listbox_head"><?php echo($content_file)?></td>
				<td><input type="file" id="file_data" name="file_data" /></td>
				<td>&nbsp;&nbsp;&nbsp;</td>
				<td><input type="submit" id="submit_upload" name="submit_upload" value="Загрузить" /></td>
				<td>&nbsp;&nbsp;&nbsp;</td>
				<td><input type="radio" name="x_value" value="x_date" checked="true" /></td><td>Ось&nbsp;Х&nbsp;-&nbsp;дата</td>
				<td><input type="radio" name="x_value" value="x_number" /></td><td>Ось&nbsp;Х&nbsp;-&nbsp;числовая</td>
			</tr></table>
		</td>
	</tr>
</table>
<input type="hidden" id="f_selected_categories" name="f_selected_categories" value="<?php if (isset($_GET['categories'])) echo($_GET['categories'])?>" />
<input type="hidden" id="f_selected_series" name="f_selected_series" value="<?php if (isset($_GET['series'])) echo($_GET['series'])?>" />
</form>
<br />
<div>
	<p>Пример файла с данными</p>
	<p>
	<font color="grey">
	01.01.2000;120.5;<br />
	02.01.2000;144;<br />
	03.01.2000;23.3;<br />
	04.01.2000;123.6;<br />	
	01.02.2001;12.9;<br />
	01.04.2003;1300;<br />
	...	
	</font>
	</p>
	<p>
		- файл должен должен быть с разделителями <span class="sample">;</span><br />
		- первая колонка дата в формате <span class="sample">dd.mm.yyyy</span> или <span class="sample">mm.yyyy</span> или <span class="sample">yyyy</span><br />
		- вторая колонка значение с разделителем дробной части <span class="sample">,</span> или <span class="sample">.</span>
	</p>
</div>
<script lang="javascript" type="text/javascript" src="scripts/upload.js"></script>