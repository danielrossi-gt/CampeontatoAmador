<?php
  require_once("_data/session.php");
  include('_data/dm.php');

  $tabela = 'estadio';
  $chave = $_POST["CHAVE"];
  $descricao = $_POST["DESCRICAO"];
  
  $dscerr = '';

  //Validações
  if ($descricao == '') {
    $dscerr =  "Descrição <br/>";
  }

  if ($dscerr != '') {
    echo "<h3>Atenção! Os campos abaixo são obrigatórios e não foram preenchidos!</h3>";
    echo $dscerr;
    echo "<br/><a href='alterar.php?tabela=$tabela&indice=$chave'>Voltar</a>";
  }
  else {
        UpdEstadio($chave, $descricao);
        include('mensagem.php');
  }
?>

