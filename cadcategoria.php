<?php
  require_once("_data/session.php");
  include('_data/dm.php');

  $descricao = $_POST["DESCRICAO"];
  
  InsCategoria($descricao);
  $tabela = 'categoria';
  $cadastro = 1;
  include('mensagem.php');

?>