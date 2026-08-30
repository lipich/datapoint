$("#new_category").focusin(function() 
{
	if ($("#new_category").val() == "новая категория")
	{
		$("#new_category").val("");
		$("#new_category").attr("class", "data_field");
	}
});

$("#new_category").focusout(function() 
{
	if ($("#new_category").val() == "")
	{
		$("#new_category").val("новая категория");
		$("#new_category").attr("class", "data_field_empty");
	}
});

$("#new_series").focusin(function() 
{
	if ($("#new_series").val() == "новый ряд")
	{
		$("#new_series").val("");
		$("#new_series").attr("class", "data_field");
	}
});

$("#new_series").focusout(function() 
{
	if ($("#new_series").val() == "")
	{
		$("#new_series").val("новый ряд");
		$("#new_series").attr("class", "data_field_empty");
	}
});