<?php
  require_once("_data/session.php");
  include('_data/dm.php');

  $tabela = 'partida';
  
  $chave = $_POST["CHAVE"];
  $timeM = $_POST["TIME_MANDANTE"];
  $timeV = $_POST["TIME_VISITANTE"];  
  $grupo = $_POST["GRUPO"];  
  $confronto = $_POST["CONFRONTO"];  
  $data = $_POST["DATA"];  
  $observacao = $_POST["OBSERVACAO"];  
  $estadio = $_POST["ESTADIO"];  
  
  $dscerr = '';

  if ($dscerr != '') {
    echo "<h3>Atenção! Os campos abaixo são obrigatórios e não foram preenchidos!</h3>";
    echo $dscerr;
    echo "<br/><a href='alterar.php?tabela=$tabela&indice=$chave'>Voltar</a>";
  }
  else {
      UpdPartida($chave, $timeM, $timeV, $grupo, $confronto, $data, $observacao, $estadio);
        include('mensagem.php');
  }
?>

