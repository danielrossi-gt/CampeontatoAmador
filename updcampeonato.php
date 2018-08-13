<?php
  require_once("_data/session.php");
  include('_data/dm.php');

  $tabela = 'campeonato';
  $chave = $_POST["CHAVE"];
  $descricao = $_POST["DESCRICAO"];
  $categoria = $_POST["CATEGORIA"];
  $genero = $_POST["GENERO"];
  
  $dscerr = '';

  //Validações
  if ($descricao == '') {
    $dscerr =  "Descrição <br/>";
  }

  if ($categoria == '') {
    $dscerr =  "Categoria <br/>";
  }

  if ($genero == '') {
    $dscerr =  "Gênero <br/>";  
  }
  
  if ($dscerr != '') {
    echo "<h3>Atenção! Os campos abaixo são obrigatórios e não foram preenchidos!</h3>";
    echo $dscerr;
    echo "<br/><a href='alterar.php?tabela=$tabela&indice=$chave'>Voltar</a>";
  }
  else {
        UpdCampeonato($chave, $descricao, $categoria, $genero);
        include('mensagem.php');
  }
?>