<?php
  require_once("_data/session.php");
  include('_data/dm.php');

  $tabela = 'grupo';
  $chave = $_POST["CHAVE"];
  $descricao = $_POST["DESCRICAO"];
  $serie = $_POST["SERIE"];
  
  $dscerr = '';

  //Validações
  if ($descricao == '') {
    $dscerr =  "Descrição <br/>";
  }

  if ($serie == '') {
    $dscerr =  "Série <br/>";
  }
  
  if ($dscerr != '') {
    echo "<h3>Atenção! Os campos abaixo são obrigatórios e não foram preenchidos!</h3>";
    echo $dscerr;
    echo "<br/><a href='alterar.php?tabela=$tabela&indice=$chave'>Voltar</a>";
  }
  else {
        UpdGrupo($chave, $descricao, $serie);
        include('mensagem.php');
  }
?>
