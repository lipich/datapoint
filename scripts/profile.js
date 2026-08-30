$(document).ready(function()
{
	LoadUserData();
});

// загрузить данные пользователя
function LoadUserData()
{
	$.getJSON("data/get_user_data_json.php",
    function(data) 
    {
        $("#first_name").val(data[1]);
        $("#last_name").val(data[2]);
    });

}

// проверка пароля
function CheckPassword(password, passwordConfirmation)
{
	if (passwordConfirmation != password)
	{
		$("#password_confirmation_check").text("Пароли не совпадают");
		$("#password_confirmation").val("");
		//$("#message").text("Пароли не совпадают.");
		
		return false;
	}
	
	return true;
}

// проверка имени
function CheckFirstName(firstName)
{
	if (firstName == "")
	{
		$("#first_name_check").text("Введите имя");
		//$("#message").text("Не указано имя.");
		
		return false;
	}
	
	return true;
}

// проверка фамилии
function CheckLastName(lastName)
{
	if (lastName == "")
	{
		$("#last_name_check").text("Введите фамилию");
		//$("#message").text("Не указана фамилия.");
		
		return false;
	}
	
	return true;
}

// проверка пользователя
function CheckUser(password, passwordConfirmation, firstName, lastName)
{
	if (!CheckPassword(password, passwordConfirmation)) return false;
	if (!CheckFirstName(firstName)) return false;
	if (!CheckLastName(lastName)) return false;

	return true;
}

// обновить данные пользователя
function UpdateUser(login, password, firstName, lastName)
{
	$.ajax({
		url: "data/update_user_data_html.php",
		data: {
			login: login,
			password: password,
			first_name: firstName,
			last_name: lastName
		}, 
		success: function(data) 
		{
			$("#update_form").hide();
			$("#update_success").html(data);
			$("#update_success").show();
		}
	});	
}

// проверка совпадения паролей
$("#password").keyup(function()
{
	$("#password_check").text("");
	$("#message").text("");
});

$("#password").focusout(function()
{
	CheckPassword($("#password").val(), $("#password_confirmation").val());
});

$("#password_confirmation").keyup(function()
{
	$("#password_confirmation_check").text("");
	$("#message").text("");
});

$("#password_confirmation").focusout(function()
{
	CheckPassword($("#password").val(), $("#password_confirmation").val());
});

// ввод имени
$("#first_name").keyup(function()
{
	$("#first_name_check").text("");
	$("#message").text("");
});

$("#first_name").focusout(function()
{
	CheckFirstName($("#first_name").val());
});

// ввод фамилии
$("#last_name").keyup(function()
{
	$("#last_name_check").text("");
	$("#message").text("");
});

$("#last_name").focusout(function()
{
	CheckLastName($("#last_name").val());
});

// coхранить изменения
$("#update").click(function()
{
	if (CheckUser($("#password").val(), $("#password_confirmation").val(), $("#first_name").val(), $("#last_name").val()))
		UpdateUser($("#login").val(), $("#password").val(), $("#first_name").val(), $("#last_name").val());
});

// отменить
$("#cancel").click(function()
{
	window.location.href = "index.php";	
});