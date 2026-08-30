$(document).ready(function()
{
	$("#login").focus();	
	$("#register_success").hide();

	GetUserCount();
});

// проверка соответствует ли логин почте
function ValidateEmail(email) 
{
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  
  if (!emailReg.test(email)) 
  	return false;
  else
    return true;
}

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

// проверить имя пользователя
function CheckLogin(login)
{
	if (login == "")
	{
		$("#login").val("e-mail");
		$("#login").attr("class", "register_field_empty");
		
		return false;
	}
	
	if (!ValidateEmail(login)) 
	{
		$("#login_check").text("Введите адрес почты");
		$("#login").attr("class", "register_field_error");
		//$("#message").text("Имя - это адрес почты.");
		
		return false;
	}
	
	$.get("data/check_user_html.php?login=" + login, function(data, status) 
	{
    	if (data != 0)
    	{
			$("#login_check").text("Такой пользователь уже зарегистрирован.");
			$("#login").attr("class", "register_field_error");
			//$("#message").text("Такой пользователь уже зарегистрирован.");
			
			return false;
       	}
	});
	
	return true;
}

// проверка пароля
function CheckPassword(password, passwordConfirmation)
{
	if (password == "")
	{
		$("#password_check").text("Введите пароль");
		//$("#message").text("Не указан пароль.");
		
		return false;
	}

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
function CheckUser(login, password, passwordConfirmation, firstName, lastName)
{
	if (!CheckLogin(login)) return false;
	if (!CheckPassword(password, passwordConfirmation)) return false;
	if (!CheckFirstName(firstName)) return false;
	if (!CheckLastName(lastName)) return false;

	return true;
}

// зарегистрировать пользователя
function RegisterUser(login, password, firstName, lastName)
{
	$.ajax({
		url: "data/register_user_html.php",
		data: {
			login: login,
			password: password,
			first_name: firstName,
			last_name: lastName
		}, 
		success: function(data) 
		{
			$("#register_form").hide();
			$("#register_success").html(data);
			$("#register_success").show();
			
			GetUserCount();
		}
	});	
}

// проверка логина
$("#login").keyup(function()
{
	$("#login_check").text("");
	$("#login").attr("class", "register_field");
	$("#message").text("");
});

$("#login").focusin(function()
{
	if ($("#login").val() == "e-mail")
	{
		$("#login").val("");
		$("#login").attr("class", "register_field");
	}
});

$("#login").focusout(function()
{
	CheckLogin($("#login").val());
});

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

// зарегистрировать пользователя
$("#register").click(function()
{
	if (CheckUser($("#login").val(), $("#password").val(), $("#password_confirmation").val(), $("#first_name").val(), $("#last_name").val()))
		RegisterUser($("#login").val(), $("#password").val(), $("#first_name").val(), $("#last_name").val());
});
