<?php
if(!isset($_SESSION)) session_start();
if ($_SESSION['authorized'] == true) header("location: index.php?action=user");
if ($_SERVER['REQUEST_URI'] == "/datapoint/login.php") header("location: index.php?action=login");
?>
<table width="100%">
<tr align="center">
<td>
<?php
include_once("data/update_user_password.php");
include_once("data/login_user.php");
include_once("data/get_user_data.php");

// todo replace with ajax
if (isset($_POST['submit_login']))
{
	$login = $_POST['login'];
	if ($login == "e-mail") $login = "";

	if (isset($_POST['forget_password'])) 
		$forget_password = $_POST['forget_password'];
	else 
		$forget_password = "off";

	if ($forget_password == "on")
	{
		$newPassword = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
		$newPasswordMD5 = md5($newPassword);
		
		$result = UpdateUserPassword($login, $newPasswordMD5); 
		
		$message = "Ваш новый пароль: " . $newPassword . "\n\nСпасибо за использование сервиса Datapoint.";
		$headers = "From: Datapoint";
		mail($_POST['login'], "Напоминание пароля от Datapoint", $message, $headers);

		$_SESSION['authorized'] = false;
		$_SESSION['login'] = "";
		$_SESSION['first_name'] = "";
		$_SESSION['last_name'] = "";   		 		
		$_SESSION['userid'] = "";	
	
		header("location: index.php?action=login");		
	}
	else
	{
		$password = md5($_POST['password']);
	
		$result = LoginUser($login, $password);
	
		if ($result)
		{
			$arrUser = GetUserData($login);
						
			$_SESSION['authorized'] = true;
			$_SESSION['login'] = $login;
			$_SESSION['first_name'] = $arrUser[1];
			$_SESSION['last_name'] = $arrUser[2];   		 		
			$_SESSION['userid'] = $arrUser[0];	
		
			header("location: index.php?action=user");
		}
		else 
		{
			$_SESSION['authorized'] = false;
			$_SESSION['login'] = "";
			$_SESSION['first_name'] = "";
			$_SESSION['last_name'] = "";   		 		
			$_SESSION['userid'] = "";	
		}
	}
}

if (isset($_POST['login']))
	$login = $_POST['login'];
else 
	$login = "e-mail";

if (($login == "") || ($login == "e-mail"))
{
	$login = "e-mail";
	$login_class = "login_field_empty";
}
else
{
	$login = $_POST['login'];
	$login_class = "login_field";
}
?>
<form id="frm_login" name="frm_login" action="index.php?action=login" method="post">
<br /><br /><br />
<table>
   <tr> 
      <td class="login_text"><?php echo($content_name)?></td>
      <td><input id="login" name="login" type="text" class="<?php echo($login_class)?>" value="<?php echo($login)?>" /></td>
   </tr>
   <tr>
      <td class="login_text"><?php echo($content_password)?></td>
      <td><input id="password" name="password" type="password" class="login_field" /></td>
   </tr>
   <tr>
      <td>&nbsp;</td>		
      <td>
      	<table width="100%" cellpadding="0" cellspacing="0">
      		<tr>
      		<td align="left" class="forget_password"><input type="checkbox" name="forget_password" id="forget_password" />
      			<?php echo($content_forget_password)?>
	  			<input type="hidden" name="content_send" id="content_send" value="<?php echo($content_send_password)?>" />
	  		</td>
      		<td align="right"><input type="submit" name="submit_login" id="submit_login" value="<?php echo($content_login)?>" />
      			<!--<a href="#" id="submit_login" name="submit_login" class="button"><?php echo($content_login)?></a>-->
	  			<input type="hidden" name="content_login" id="content_login" value="<?php echo($content_login)?>" />
      		</td>
      		</tr>
      	</table>		
      </td>
   </tr>
</table>
<br />
<div class="statistics_users"><?php echo($content_user_count)?><span id="users_count" class="statistics_users_count"></span></div>
</form>
</td>
</tr>
</table>
<script lang="javascript" type="text/javascript" src="scripts/login.js"></script>