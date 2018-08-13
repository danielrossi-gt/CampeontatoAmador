<?php
    require_once('_conn/conn.php');

    $emailUsuario = $_REQUEST["emailUsuario"];
    
    if (isset($_REQUEST["chaveUsuario"])) {
        $chaveUsuario = $_REQUEST["chaveUsuario"];
        $SQL = " SELECT * FROM USUARIO WHERE EMAIL = '".$emailUsuario."' AND CHAVE <> ".$chaveUsuario;                
    } else {
        $SQL = " SELECT * FROM USUARIO WHERE EMAIL = '".$emailUsuario."'";        
    }

    $ds = mysql_query($SQL);
    $nr = mysql_num_rows($ds); //número de registros totais    

    if($nr > 0) {
        echo true;
    } else {
        echo false;
    }	
?>