<?php
  require_once("_data/session.php");
  include('_data/dm.php');

  $descricao = $_POST["DESCRICAO"];
  
  InsEstadio($descricao);
  $tabela = 'estadio';
  $cadastro = 1;
  include('mensagem.php');

?>