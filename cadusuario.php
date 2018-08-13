<?php
  require_once("_data/session.php");
  include('_data/dm.php');

  $nome  = $_POST["NOME"];
  $email = $_POST["EMAIL"];
  $senha = $_POST["SENHA"];
  
  InsUsuario($nome, $email, $senha);
  $tabela = 'usuario';
  $cadastro = 1;
  include('mensagem.php');

?>