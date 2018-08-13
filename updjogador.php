<?php
    require_once("_conn/conn.php");
    require_once("_data/session.php");
    include('_data/dm.php');

    $tabela   = 'jogador';
    $chave    = $_POST["CHAVE"];
    $nome     = $_POST["NOME"];

    $dscerr = '';

    //Validações
    if ($nome == '') {
        $dscerr =  "Nome <br/>";
    }

    if ($dscerr != '') {
        
        echo "<h3>Atenção! Os campos abaixo são obrigatórios e não foram preenchidos!</h3>";
        echo $dscerr;
        echo "<br/><a href='alterar.php?tabela=$tabela&indice=$chave'>Voltar</a>";
        
    }
    else {
        
        UpdJogador($chave, $nome);
        include('mensagem.php');                          
        
    }
?>