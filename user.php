<?php
if(!isset($_SESSION)) session_start();
if ($_SESSION['authorized'] != true) header("location: index.php?action=login");
if ($_SERVER['REQUEST_URI'] == "/datapoint/user.php") header("location: index.php?action=user");
?>
<table width="100%">
	<tr>
		<td width="100%" colspan="2">
		<table id="series" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>id</th>
                <th>Категория</th>
                <th>Ряд</th>
                <th>Пользователь</th>
                <th>Публичный</th>
                <th>type</th>
            </tr>
        </thead>
    	</table>
		</td>
	</tr>
	<tr class="row_buttons">
		<td>
			<div id="show_graph" name="show_graph" class="button"><?php echo($content_show_graph)?></div>
			<div id="show_data" name="show_data" class="button"><?php echo($content_show_data)?></div>
		</td>
		<td align="right">
			<div id="upload_series" name="upload_series" class="button"><?php echo($content_data_upload)?></div>
			<div id="public_series" name="public_series" class="button"><?php echo($content_data_set_public)?></div>
			<div id="edit_series" name="edit_series" class="button"><?php echo($content_data_edit)?></div>
			<div id="delete_series" name="delete_series" class="button"><?php echo($content_data_delete)?></div>
			<div id="save" name="save" class="button"><?php echo($content_save)?></div>
			<div id="cancel" name="cancel" class="button"><?php echo($content_cancel)?></div>
		</td>
	</tr>
</table>
<!--<hr />-->
<div id="dialog_confirm"></div>
<div id="data" name="data" class="report"></div>
<div name="divProgress" id="divProgress" class="divLoading">
<table class="loading">
	<tr><td align="center">
	<table><tr><td><?php echo $content_loading?></td><td>&nbsp;</td><td><img src="images/loading.gif" /></td></tr></table>
	</td></tr>
</table>
</div>
<input type="hidden" id="f_user" name="f_user" value="true" />
<input type="hidden" id="f_update" name="f_update" />
<input type="hidden" id="f_selected_series" name="f_selected_series" value="<?php if (isset($_GET['series'])) echo($_GET['series'])?>" />
<script lang="javascript" src="scripts/user.js"></script>
<script lang="javascript" src="http://code.highcharts.com/stock/highstock.js"></script>
<script lang="javascript" src="http://code.highcharts.com/stock/modules/exporting.js"></script>