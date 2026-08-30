// получить url параметр по имени
function getParameterByName(name) 
{
	name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex.exec(location.search);
	
	return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

// переключение языка
$("#language").change(function()
{
	var action = getParameterByName("action");
	
	if (action != "") 
		p_action = "action=" + action + "&"; 
	else  
		p_action = "";
	
	window.location.href = window.location.href.replace(/[\?#].*|$/, "?" + p_action + "lang=" + $("#language").val());
});	