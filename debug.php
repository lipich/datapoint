<?php
/*
if(!isset($_SESSION)) session_start();
echo("<br><br>");
echo("host=" . gethostname());
echo("<br><br>");
echo("lang=" . $_SESSION['lang'] . "<br>"); 
echo("authorized=" . $_SESSION['authorized'] . "<br>");
echo("login=" . $_SESSION['login'] . "<br>");
echo("first_name=" . $_SESSION['first_name'] . "<br>");
echo("last_name=" . $_SESSION['last_name'] . "<br>");
echo("userid=" . $_SESSION['userid'] . "<br>");
echo("root=" . $_SERVER['DOCUMENT_ROOT'] . "<br>");
*/
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Test selectable</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <!--<link rel="stylesheet" href="/resources/demos/style.css">-->
  <script src="//cdn.datatables.net/1.10.3/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.3/css/jquery.dataTables.min.css"> 
  <style>
  #selectable .ui-selecting { background: #FECA40; }
  #selectable .ui-selected { background: #F39814; color: white; }
  </style>
  <script>
  $(document).ready(function() {
    var table = $('#example').DataTable({
	    scrollY: 300,
	    paging: false,
	    processing: true,
	    columnDefs: [
			{ "visible": false, "targets": 0 }
		],
	    ajax: 'data/get_series_list_debug_json.php',
	    language: { 
		    "emptyTable":     "Нет данных",
			"info":           "Показано _START_ из _END_ (всего _TOTAL_ записей)",
		    "infoEmpty":      "Показано 0 из 0 (всего 0 записей)",
		    "lengthMenu":     "Показывать _MENU_ записей",
		    "loadingRecords": "Загрузка...",
		    "processing":     "Обработка...",
		    "search":         "Фильтр:",
		    "infoFiltered": " - отфильтровано из _MAX_ записей",
		    "zeroRecords":    "Не найдено ни одной записи"
		}
    });
 
    $('#example tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
        
		var s = '';
		$.each(table.rows('.selected').data(), function( index, value ) {
			s += value[0] + ','
		});
		s = s.substring(0, s.length - 1);
		
		alert(s);
    } );
 
    $('#button').click( function () {
        alert( table.rows('.selected').data().length +' row(s) selected' );
    } );
  } );

  /*$(function() {
    $( "#selectable" ).selectable({
      stop: function() {
        result = "";
        $( ".ui-selected", this ).each(function() {
          //alert($( "#selectable td" ).html());
          var index = $( "#selectable table" ).index( this );
          //alert(index);
          result += " #" + ( index + 1 );
        });        
        alert(result);
      }
    });  
  });*/
  </script>
</head>
<body>
<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>id</th>
                <th>category</th>
                <th>series</th>
                <th>public</th>
                <th>edit</th>
                <th>user</th>
                <th>type</th>
            </tr>
        </thead>
    </table>
<!--<div border="1px" style="width: 500px; height: 200px; overflow-y: scroll; bolder:1px; boldercolor:#000000;">
<ol id="selectable">
  <table><tr><td width="200px">Item 1</td><td width="100px">admin</td></tr></table>
  <table><tr><td width="200px">Item 123</td><td width="100px"></td></tr></table>
  <table><tr><td width="200px">Item yterue</td><td width="100px"></td></tr></table>
  <table><tr><td width="200px">Item 33</td><td width="100px">admin</td></tr></table>
  <table><tr><td width="200px">Item uyu</td><td width="100px">admin</td></tr></table>
  <table><tr><td width="200px">Item 1</td><td width="100px">admin</td></tr></table>
  <table><tr><td width="200px">Item 123</td><td width="100px"></td></tr></table>
  <table><tr><td width="200px">Item yterue</td><td width="100px"></td></tr></table>
  <table><tr><td width="200px">Item 33</td><td width="100px">admin</td></tr></table>
  <table><tr><td width="200px">Item uyu</td><td width="100px">admin</td></tr></table>
  <table><tr><td width="200px">Item 1</td><td width="100px">admin</td></tr></table>
  <table><tr><td width="200px">Item 123</td><td width="100px"></td></tr></table>
  <table><tr><td width="200px">Item yterue</td><td width="100px"></td></tr></table>
  <table><tr><td width="200px">Item 33</td><td width="100px">admin</td></tr></table>
  <table><tr><td width="200px">Item uyu</td><td width="100px">admin</td></tr></table>
  <table><tr><td width="200px">Item 1</td><td width="100px">admin</td></tr></table>
  <table><tr><td width="200px">Item 123</td><td width="100px"></td></tr></table>
  <table><tr><td width="200px">Item yterue</td><td width="100px"></td></tr></table>
  <table><tr><td width="200px">Item 33</td><td width="100px">admin</td></tr></table>
  <table><tr><td width="200px">Item uyu</td><td width="100px">admin</td></tr></table>
</ol>
</div>-->
 
 
</body>
</html>