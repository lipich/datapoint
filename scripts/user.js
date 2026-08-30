$(document).ready(function()
{
	$.global = {
		seriesList : null,
    	resultType : "graph",
    	strSeriesValues : "",
    	arrSeriesValues : null,
    	strSeriesNames : "",
    	arrSeriesNames : null,
    	strSeriesTypes : "",
    	arrSeriesTypes : null
	};
	
	LoadSeriesList();
	ShowSeriesActions();
});

// показать действия с рядом
function ShowSeriesActions(mode)
{
	if (mode == "edit")
	{
    	$("#show_graph").hide();
		$("#show_data").hide();

		$("#upload_series").hide(); 
		$("#public_series").hide(); 
		$("#edit_series").hide(); 
		$("#delete_series").hide(); 

		$("#save").show();
		$("#cancel").show();
		
		return;
	}

	if (mode == "upload")
	{
    	$("#show_graph").hide();
		$("#show_data").hide();

		$("#upload_series").hide(); 
		$("#public_series").hide(); 
		$("#edit_series").hide(); 
		$("#delete_series").hide(); 

		$("#save").hide();
		$("#cancel").show();
		
		return;
	}
		
	if ($.global.seriesList.rows('.selected').data().length == 0)
	{
	    $("#show_graph").hide(); 
	    $("#show_data").hide(); 
			
		$("#upload_series").show(); 
	    $("#public_series").hide(); 
		$("#edit_series").hide(); 	
	    $("#delete_series").hide();
	}
	else
	{	
    	$("#show_graph").show(); 
		$("#show_data").show(); 

		$("#upload_series").show(); 
		$("#public_series").show(); 
		
		if ($.global.seriesList.rows('.selected').data().length == 1) 
			$("#edit_series").show(); 
		else
			$("#edit_series").hide(); 

		$("#delete_series").show();
	}
 		
	$("#save").hide();
    $("#cancel").hide();
}

// загрузить список рядов
function LoadSeriesList()
{
	$.global.strSeriesValues = "";
	$.global.strSeriesNames = "";
	$.global.strSeriesTypes = "";
	
    var table = $("#series").DataTable({
	    scrollY: 300, //$(window).height()-250,
	    paging: false,
	    processing: true,
	    stateSave: true,
		/*dom: 'T<"clear">lfrtip',
        tableTools: {
            "sRowSelect": "os",
            "aButtons": [ "select_all", "select_none" ]
        },*/
	    columnDefs: [
			{ "visible": false, "targets": 0 },
			{ "visible": false, "targets": 5 },
			{ "width": "35%", "targets": 1 },
			{ "width": "35%", "targets": 2 },
			{ "width": "20%", "targets": 3 },
			{ "width": "10%", "targets": 4 }
		],
	    ajax: 'data/get_series_list_json.php',
	    language: { 
		    // todo add dictionary
		    "emptyTable":     "Нет данных",
			"info":           "Показано _START_ из _END_ (всего _TOTAL_ рядов)",
		    "infoEmpty":      "Показано 0 из 0 (всего 0 рядов)",
		    "lengthMenu":     "Показывать _MENU_ рядов",
		    "loadingRecords": "Загрузка...",
		    "processing":     "Обработка...",
		    "search":         "Фильтр:",
		    "infoFiltered": " - отфильтровано из _MAX_ рядов",
		    "zeroRecords":    "Не найдено ни одного ряда"
		}
    });

	$.global.seriesList = table;
	
	// выбор ряда todo delete nesting
	$('#series tbody').on('click', 'tr', function () {
    	$(this).toggleClass('selected');
    
    	$.global.strSeriesValues = "";
		$.global.strSeriesNames = "";
		$.global.strSeriesTypes = "";

		$.global.arrSeriesValues = new Array;
		$.global.arrSeriesNames = new Array;
		$.global.arrSeriesTypes = new Array;
				
		if (table.rows('.selected').data().length === 0)
		{
			$("#data").hide();
			ShowSeriesActions();

			return;	
		}
		
		$.each(table.rows('.selected').data(), function( index, value ) {
			$.global.strSeriesValues += value[0] + ',';
			$.global.strSeriesNames += value[2] + ',';
			$.global.strSeriesTypes += value[5] + ',';	
			
			$.global.arrSeriesValues.push(value[0]);
			$.global.arrSeriesNames.push(value[2]);
			$.global.arrSeriesTypes.push(value[5]);		
		});
		
		$.global.strSeriesValues = $.global.strSeriesValues.substring(0, $.global.strSeriesValues.length - 1);
		$.global.strSeriesNames = $.global.strSeriesNames.substring(0, $.global.strSeriesNames.length - 1);
		$.global.strSeriesTypes = $.global.strSeriesTypes.substring(0, $.global.strSeriesTypes.length - 1);
		
		if ($.global.resultType == "data")	
			ShowData($.global.arrSeriesValues, $.global.arrSeriesTypes);
		else
			ShowGraph($.global.arrSeriesValues, $.global.arrSeriesNames, $.global.arrSeriesTypes);
		
		ShowSeriesActions();
	});
}

// отобразить таблицу
function ShowData(series, types)
{
	if (!series) series = "";
	type = types[0];
	if (!types) type = "";

	$("#show_data").attr("class", "button_selected");
	$("#show_graph").attr("class", "button");
	
    $("#data").show();

	$("#divProgress").show();
	$("#data").load("data/get_data_html.php?series=" + series + "&type=" + type, 
	function(response, status) 
	{
		$.global.resultType = "data";
		$("#mode").text("data");
		
    	$("#divProgress").hide();
    });
}

// отобразить график
function ShowGraph(arrValues, arrNames, arrTypes) 
{	
	$("#show_data").attr("class", "button");
	$("#show_graph").attr("class", "button_selected");

    $("#data").show();

	$.global.resultType = "graph";
	$("#mode").text("graph");
	
	var seriesOptionsDate = [],
		yAxisOptions = [],
		seriesCounter = 0,
		values = arrValues,
		types = arrTypes,
		names = arrNames,
		colors = Highcharts.getOptions().colors;

	var seriesOptionsNumber = [],
		xAxisOptions = [],
		names = arrNames;

	$.each(values, function(i, value) {
		$.getJSON("data/get_data_json.php?series=" + value + "&type=" + types[i], function(data) 
		{
			seriesOptionsDate[i] = {
				value: value,
				name: names[i],
				data: data
			};

			xAxisOptions = data[0];
			seriesOptionsNumber[i] = {
				name: names[i],
				data: data[1]
			};

			seriesCounter++;

			if (seriesCounter == values.length) {
				if (types[0] == "x_date")
					createChartStock();
				if (types[0] == "x_number")
					createChartLine();	
			}
		});
	});

	// отобразить график для оси Х с датой
	function createChartStock() {
		// todo add dictionary
		Highcharts.setOptions({
			lang: {
				contextButtonTitle: "Меню",
				decimalPoint: ".",
				downloadJPEG: "Скачать в формате JPEG",
				downloadPDF: "Скачать в формате PDF",
				downloadPNG: "Скачать в формате PNG",
				downloadSVG: "Скачать в формате SVG",
				loading: "Загрузка...",
				months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
				numericSymbols: ["k", "M", "G", "T", "P", "E"],
				printChart: "Печать графика",
				rangeSelectorFrom: "от",
				rangeSelectorTo: "до",
				rangeSelectorZoom:  "Масштаб",
				resetZoom: "Масштаб по умолчанию",
				resetZoomTitle: "Масштаб 1:1",
				shortMonths: ['Янв', 'Фев', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сент', 'Окт', 'Ноя', 'Дек'],
				thousandsSep: " ",
				weekdays: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота']
			}	
		});
		
		$("#data").highcharts('StockChart', {
		    chart: {
		    },

		    rangeSelector: {
		        selected: 5
		    },
		    
		    yAxis: {
		    },
		    
		    tooltip: {
		    	pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
		    	valueDecimals: 2
		    },

            exporting: {
            	enabled: false
			},
		    
		    series: seriesOptionsDate
		});
	}
	
	// отобразить график для оси Х с числами
	function createChartLine() {
		$('#data').highcharts({
            title: {
                text: '',
                x: -20
            },
            
            subtitle: {
                text: '',
                x: -20
			},
			
            xAxis: {
                categories: xAxisOptions
            },

            yAxis: {
            	title: {
                    text: ''
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },

		    tooltip: {
		    	pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
		    	valueDecimals: 2
		    },

            /*legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },*/
            
            exporting: {
            	enabled: false
			},
            
            series: seriesOptionsNumber
        });
	}
}

// показать загрузку ряда
function ShowUpload(categories, series)
{
	if (!categories) categories = "";
	if (!series) series = "";

    $("#data").show();
	$("#divProgress").show();

	$("#data").load("upload.php?categories=" + categories + "&series=" + series, 
	function(response, status) 
	{
		$("#divProgress").hide();
	});
	
	$("#mode").text("upload");
}

// показать обновление данных для ряда
function ShowUpdate(series)
{
	if (!series) series = "";

    $("#data").show();
	$("#divProgress").show();

	$("#data").load("data/get_data_update_html.php?series=" + series, 
	function(response, status) 
	{
		$("#divProgress").hide();
	});

	$("#mode").text("update");
}

// показать изменение параметров ряда
function ShowEdit(series)
{
	if (!series) series = "";

    $("#data").show();
	$("#divProgress").show();

	$("#data").load("data/get_series_edit.php?series=" + series, 
	function(response, status)
	{
		$("#divProgress").hide();
	});
	
	$("#mode").text("edit");
}

// удалить ряд
function DeleteSeries(series)
{
	if (!series) series = "";
		
	$.ajax({
		url: "data/delete_series_html.php?series=" + series, 
		success: function(data) 
		{
			$.global.seriesList.ajax.reload();
			$("#data").hide();
			ShowSeriesActions();
		}
	});

	$("#mode").text("delete");
}

// опубликовать/закрыть ряд
function PublicSeries(series)
{
	if (!series) series = "";
	
	$.ajax({
		url: "data/public_series_html.php?series=" + series,
		success: function(data) 
		{
			$.global.seriesList.ajax.reload();
		}
	});
}

// обновить данные ряда
function UpdateSeriesData(series, cancel)
{
	if (!series) series = "";
	if (!cancel) cancel = "";

	$.ajax({
		url: "data/update_series_data_html.php?series=" + series + "&cancel=" + cancel,
		success: function(data) 
		{
			$.global.seriesList.ajax.reload();
			
			ShowGraph($.global.arrSeriesValues, $.global.arrSeriesNames, $.global.arrSeriesTypes);
		}
	});		
}

// обновить параметры ряда
function EditSeries(series, series_name, category_name)
{
	if (!series) series = "";
	if (!series_name) series_name = "";
	if (!category_name) category_name = "";

	// todo add dictionary
	if (series_name == "") 
	{
		alert("Пустое имя ряда!");
		return;
	}

	if (category_name == "") 
	{
		alert("Пустое имя категории!");
		return;
	}
	
	$.ajax({
		url: "data/edit_series_html.php?series=" + series + "&series_name=" + series_name + "&category_name=" + category_name,
		success: function(data) 
		{
			$.global.seriesList.ajax.reload();

			ShowGraph($.global.arrSeriesValues, $.global.arrSeriesNames, $.global.arrSeriesTypes);
		}
	});		
}

// отобразить таблицу
$("#show_data").click(function()
{
	if ($.global.resultType == "graph") ShowData($.global.arrSeriesValues, $.global.arrSeriesTypes);
});

// отобразить график
$("#show_graph").click(function()
{
	if ($.global.resultType == "data") ShowGraph($.global.arrSeriesValues, $.global.arrSeriesNames, $.global.arrSeriesTypes);
});

// загрузить ряд
$("#upload_series").click(function()
{
	ShowSeriesActions("upload");
	
	$("#f_update").val("edit_data");
	if ($("#series").val() == null) $("#f_update").val("new_data");

	ShowUpload($("#categories").val(), $("#series").val());	
});

// удалить ряд
$("#delete_series").click(function()
{
	// todo add dictionary	
    $("#dialog_confirm").html("Удалить выбранный ряд?"); 
    $("#dialog_confirm").dialog({
    	resizable: false,
		height: 200,
		title: "Подтверждение",
		modal: true,
		buttons: {
        	"Да": function() {
				DeleteSeries($.global.strSeriesValues);
				$(this).dialog("close");
			},
			"Нет": function() {
        		$(this).dialog("close");
			}
		}
    });
});

// опубликовать/скрыть ряд
$("#public_series").click(function()
{
	PublicSeries($.global.strSeriesValues);
	
	$("#mode").text("public");
});

// редактировать ряд
$("#edit_series").click(function()
{
	ShowSeriesActions("edit");
		
	$("#f_update").val("edit_series");

	ShowEdit($.global.strSeriesValues);	
});

// сохранить изменения
$("#save").click(function()
{
	if ($("#f_update").val() == "update_data") UpdateSeriesData($.global.strSeriesValues, 0);
	if ($("#f_update").val() == "edit_series") EditSeries($.global.strSeriesValues, $("#new_series_name").val(), $("#new_category_name").val());
});

// отменить изменения
$("#cancel").click(function()
{
	$("#mode").text("cancel");
	
	if ($("#f_update").val() == "new_data")
	{	
		$("#cancel").hide();
		$("#data").hide();
		$("#upload_series").show();
				
		return;
	}

	if ($("#f_update").val() == "update_data") UpdateSeriesData($.global.strSeriesValues, 1);	

	if ($.global.arrSeriesValues === null)
	{
		$("#data").hide();
	}
	else
	{
		ShowGraph($.global.arrSeriesValues, $.global.arrSeriesNames, $.global.arrSeriesTypes);
	}
	
	ShowSeriesActions();
});