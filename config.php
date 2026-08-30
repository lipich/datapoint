<?php
$server_type = "local";
//$server_type = "remote"; // for publish

// настройки базы
$db_servertype = "mysql";

if ($server_type == "local")
{
    $db_host = "localhost";
    $db_name = "datapoint";
    $db_user = "datapoint";
    $db_password = "lipich";
}
else
{
    $db_host = "a15113.mysql.mchost.ru";
    $db_name = "a15113_datapoint";
    $db_user = "a15113_datapoint";
    $db_password = "lipich";
}

// общие настройки
$storage = "files/";
$max_file_size = 32768000;
?>