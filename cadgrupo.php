<?php
  require_once("_data/session.php");
  include('_data/dm.php');

  $descricao = $_POST["DESCRICAO"];
  $serie = $_POST["SERIE"];
  
  InsGrupo($descricao, $serie);
  $tabela = 'grupo';
  $cadastro = 1;
  include('mensagem.php');

?>