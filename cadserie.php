<?php
  require_once("_data/session.php");
  include('_data/dm.php');

  $descricao = $_POST["DESCRICAO"];
  
  InsSerie($descricao);
  $tabela = 'serie';
  $cadastro = 1;
  include('mensagem.php');

?>