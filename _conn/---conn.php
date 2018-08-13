<?php 

    $hostname = "localhost";
    $database = "futebol";
    $username = "root";
    $password = "";
    $conn = mysql_pconnect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR);
    mysql_select_db($database, $conn);  
    /*
    mysql_query("SET NAMES 'utf8'");
    mysql_query('SET character_set_connection=utf8');
    mysql_query('SET character_set_client=utf8');
    mysql_query('SET character_set_results=utf8');
    */
?>