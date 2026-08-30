<?php
if(!isset($_SESSION)) session_start();
if ($_SESSION['authorized'] == true) header("location: index.php?action=user");
if ($_SERVER['REQUEST_URI'] == "/datapoint/data.php") header("location: index.php?action=data");
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
		<td>
			&nbsp;
		</td>
	</tr>
</table>
<hr />
<div id="data" name="data" class="report"></div>
<div name="divProgress" id="divProgress" class="divLoading">
<table class="loading">
	<tr><td align="center">
	<table><tr><td><?php echo $content_loading?></td><td>&nbsp;</td><td><img src="images/loading.gif" /></td></tr></table>
	</td></tr>
</table>
</div>
<input type="hidden" id="f_user" name="f_user" value="false" />
<script lang="javascript" type="text/javascript" src="scripts/user.js"></script>
<script lang="javascript" type="text/javascript" src="http://code.highcharts.com/stock/highstock.js"></script>
<script lang="javascript" type="text/javascript" src="http://code.highcharts.com/stock/modules/exporting.js"></script>