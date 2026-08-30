<?php
if(!isset($_SESSION)) session_start();
if ($_SESSION['authorized'] == true) header("location: index.php?action=user");
if ($_SERVER['REQUEST_URI'] == "/datapoint/register.php") header("location: index.php?action=register");
?>
<table width="100%">
<tr align="center">
  <td>
    <br /><br /><br />
    <div id="register_form" name="register_form">
    <table>
    <tr>
      <td><font class="register_text"><?php echo($content_name)?></font></td>
      <td><input type="text" id="login" name="login" class="register_field_empty" value="e-mail" /></td>
      <td><div id="login_check" name="login_check" class="field_check"></div></td>
    </tr>
    <tr>
      <td><font class="register_text"><?php echo($content_password)?></font></td>	
      <td><input type="password" id="password" name="password" class="register_field" /></td>
      <td><div id="password_check" name="password_check" class="field_check"></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="password" id="password_confirmation" name="password_confirmation" class="register_field" /></td>
      <td><div id="password_confirmation_check" name="password_confirmation_check" class="field_check"></div></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
      <td><font class="register_text"><?php echo($content_firstname)?></font></td>
      <td><input type="text" id="first_name" name="first_name" class="register_field" value="<?php echo($first_name)?>" /></td>
      <td><div id="first_name_check" name="first_name_check" class="field_check"></div></td>
    </tr>
    <tr>
      <td><font class="register_text"><?php echo($content_lastname)?></font></td>
      <td><input type="text" id="last_name" name="last_name" class="register_field" value="<?php echo($last_name)?>" /></td>
      <td><div id="last_name_check" name="last_name_check" class="field_check"></div></td>
    </tr>
    <tr><td></td></tr>
    <tr>
      <td>&nbsp;</td>	
      <td align="right">
		<div id="register" name="register" class="button"><?php echo($content_register)?></div>
      </td>
      <td>&nbsp;</td>
    </tr>
    </table>
    </div>
    <div id="register_success" name="register_success"></div>
    <br />
    <div id="message" name="message" class="field_check"></div>
    <br />
    <div class="statistics_users"><?php echo($content_user_count)?><span id="users_count" class="statistics_users_count"></span></div>
  </td>
</tr>
</table>
<script lang="javascript" type="text/javascript" src="scripts/register.js"></script>