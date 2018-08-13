<?php
  require_once("_data/session.php");
  include('_data/dm.php');

  $mandante = $_POST["TIME_MANDANTE"];
  $visitante = $_POST["TIME_VISITANTE"];
  $grupo = $_POST["GRUPO"];
  $confronto = $_POST["CONFRONTO"];
  $data = $_POST['DATA'] ;
  $estadio = $_POST['ESTADIO'];
  
  InsPartida($mandante, $visitante, $grupo, $confronto, $data, $estadio);
  $tabela = 'partida';
  $cadastro = 1;
  include('mensagem.php');

?>