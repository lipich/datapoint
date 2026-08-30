<?php if(!isset($_SESSION)) session_start();?>
<?php ob_start();?>
<?php
if (empty($_SESSION['authorized'])) $_SESSION['authorized'] = false;

// язык страницы
if (isset($_GET['lang'])) $_SESSION['lang'] = $_GET['lang'];
if (!isset($_SESSION['lang'])) $_SESSION['lang'] = "ru";

$lang = $_SESSION['lang'];

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

// действие
if (isset($_GET['action'])) 
	$action = $_GET['action'];
else 
	$action = '';
	
if ($action == 'logout')
{
	$_SESSION['authorized'] = false;
	$_SESSION['login'] = "";
	$_SESSION['first_name'] = "";
	$_SESSION['last_name'] = "";   		 		
	$_SESSION['userid'] = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $content_header?></title>
    <link rel="stylesheet" href="styles/site.css" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css"> 
    <link rel="stylesheet" href="//cdn.datatables.net/tabletools/2.2.3/css/dataTables.tableTools.css" />
    <script lang="javascript" src="http://code.jquery.com/jquery-2.1.3.js"></script>
    <script lang="javascript" src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script lang="javascript" src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
    <script lang="javascript" src="//cdn.datatables.net/tabletools/2.2.3/js/dataTables.tableTools.js"></script>
</head>
<body>    
    <div class="page">
        <div class="header">
            <div class="logo_text"><a href="index.php" class="logo_text">
            	<?php echo $content_header?>&nbsp;<img src="images/chart_stock.png" border="0" /></a>
			</div>
            <div class="menu_head">
                <div class='menu_language'>
                	<select id="language" name="language" class="language_list">
                		<option value="ru" <?php if ($lang == "ru") echo("selected");?>>Русский</option>
						<option value="en" <?php if ($lang == "en") echo("selected");?>>English</option>
					</select>
				</div>
            </div>
        </div>
        <div class="header_under">&nbsp;</div>
        <div class="menu_head_under">&nbsp;</div>
        <div style="clear: both"></div>
        <div class="login_section">
        	<table>
	        	<tr>
		        	<td><div class='login_section_item'>
		        	<?php
		        	if ($_SESSION['authorized'])
		        	{
		        		if ($action == "profile")
			        		echo($_SESSION['first_name'] . " " . $_SESSION['last_name']);	
			        	else
			        		echo("<a href='index.php?action=profile'>" . $_SESSION['first_name'] . " " . $_SESSION['last_name'] . "</a>");	
		        	}
		        	else
		        	{
		        		if ($action == "register")
							echo($content_register);
						else
							echo("<a href='index.php?action=register'>" . $content_register . "</a>");
					}
					?>
					</div></td>
					<td>&nbsp;</td>
		        	<td><div class='login_section_item'>
		        	<?php
		        	if ($_SESSION['authorized'])
		        	{
		        		echo("<a href='index.php?action=logout'>" . $content_logout . "</a>");
		        	}
		        	else
		        	{
		        		if ($action == "login")
							echo($content_login);
						else
		        			echo("<a href='index.php?action=login'>" . $content_login . "</a>");
		        	}
		        	?>
		        	</div></td>
	        	</tr>
        	</table>
        </div>
        <div style="clear: both"></div>
        <div class="main">
        <?php
        	switch($action)
        	{
	        	case "register":
	        		include("register.php");
	        		break;
				case "login":
	        		include("login.php");
					break;
				case "data":
	        		include("data.php");
					break;
				case "user":
					include("user.php");
					break;
				case "profile":
					include("profile.php");
					break;
				case "upload":
					include("upload.php");
					break;
				default:
					if ($_SESSION['authorized'])
	        		{
		        		include("user.php");
	        		}
	        		else
	        		{
	        			include("data.php");
	        		}
        	}
        ?>
        </div>
    </div>
    <!-- Yandex.Metrika counter -->
    <div style="display:none;">
    <script type="text/javascript">
    (function(w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter11455438 = new Ya.Metrika({id:11455438, enableAll: true, webvisor:true});
            }
            catch(e) { }
        });
    })(window, "yandex_metrika_callbacks");
    </script></div>
    <script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
    <noscript><div><img src="//mc.yandex.ru/watch/11455438" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
    <input type="hidden" id="mode" />
	<script lang="javascript" type="text/javascript" src="scripts/index.js"></script>
</body>
</html>
<?php ob_end_flush();?>