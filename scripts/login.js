$(document).ready(function()
{
	$("#login").focus();
	GetUserCount();
});

// получить количество пользователей
function GetUserCount()
{
	var result = 0;
	$.ajax({
		url: "data/get_user_count_html.php",
		success: function(data) 
		{
			$("#users_count").text(data);
		}
	});	
}

$("#forget_password").click(function() {
    if ($("#forget_password").prop("checked"))
    { 
    	$("#password").prop("disabled", true);
    	$("#submit_login").val($("#content_send").val());
	}
	else
    { 
    	$("#password").prop("disabled", false);
    	$("#submit_login").val($("#content_login").val());
	}
});

$("#login").focusin(function() {
	if ($("#login").val() == "e-mail")
	{
		$("#login").val("");
		$("#login").attr("class", "login_field");
	}
});

$("#login").focusout(function() {
	if ($("#login").val() == "")
	{
		$("#login").val("e-mail");
		$("#login").attr("class", "login_field_empty");
	}
});