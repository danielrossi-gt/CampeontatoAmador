<?php
  require_once("_data/session.php");
  include('_data/dm.php');

  $descricao = $_POST["DESCRICAO"];
  
  InsConfronto($descricao);
  $tabela = 'confronto';
  $cadastro = 1;
  include('mensagem.php');

?>