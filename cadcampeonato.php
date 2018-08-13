<?php
  require_once("_data/session.php");
  include('_data/dm.php');

  $descricao = $_POST["DESCRICAO"];
  $categoria = $_POST["CATEGORIA"];
  $genero    = $_POST["GENERO"];
  
  InsCampeonato($descricao, $categoria, $genero);
  $tabela = 'campeonato';
  $cadastro = 1;
  include('mensagem.php');

?>