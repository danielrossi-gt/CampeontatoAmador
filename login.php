<?php

  require_once('_conn/conn.php');
  include('_data/dm.php');
  
  //Dados do login
  $email = $_POST["tEmail"];
  $senha = $_POST["tSenha"];

  $ds = Dataset("USUARIO", "EMAIL = '$email' AND SENHA = PASSWORD('$senha')", "");
  $nr = mysql_num_rows($ds);
  
  if ($nr > 0) {
    session_start();
    $_SESSION["usuario_chave"] = mysql_result($ds, 0, "CHAVE");
    $_SESSION["usuario_email"] = mysql_result($ds, 0, "EMAIL");
    $_SESSION["usuario_nome"] = mysql_result($ds, 0, "NOME");
    header("Location: principal.php");
  }
  else {
    header("Location: admin.php?msg=1");
  }

?>
    

