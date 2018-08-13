<?php
    require_once("_conn/conn.php");
    require_once("_data/session.php");
    include('_data/dm.php');

    $tabela       = 'usuario';
    $chave        = $_POST["CHAVE"];
    $nome         = $_POST["NOME"];
    $email        = $_POST["EMAIL"];
    $senha        = $_POST["SENHA"];
    $novaSenha    = $_POST["novaSenha"];
    $confirmSenha = $_POST["confirmSenha"];

    $dscerr = '';

    //Validações
    if ($nome == '') {
        $dscerr =  "Nome <br/>";
    }

    if ($email == '') {
        $dscerr =  "E-mail <br/>";
    }

    if ($senha == '') {
        $dscerr =  "Senha <br/>";
    }

    if ($novaSenha == '') {
        $dscerr =  "Nova Senha <br/>";
    }

    if ($confirmSenha == '') {
        $dscerr =  "Confirmação da Nova Senha <br/>";
    }


    if ($dscerr != '') {
        
        echo "<h3>Atenção! Os campos abaixo são obrigatórios e não foram preenchidos!</h3>";
        echo $dscerr;
        echo "<br/><a href='alterar.php?tabela=$tabela&indice=$chave'>Voltar</a>";
        
    }
    else {

        // Validação da confirmação da nova senha
        if ($novaSenha != $confirmSenha) {
            
            echo "<h3>Atenção! A confirmação da nova senha está incorreta!</h3>";
            echo $dscerr;
            echo "<br/><a href='alterar.php?tabela=$tabela&indice=$chave'>Voltar</a>";
            
        } else {
            
            // Validação da senha atual
            $SQL = " SELECT * FROM usuario WHERE CHAVE = ".$chave." AND SENHA = PASSWORD('".$senha."')";        
            
            //echo " SELECT * FROM usuario WHERE CHAVE = ".$chave." AND SENHA = PASSWORD('".$senha."')";        

            $ds = mysql_query($SQL);
            $nr = mysql_num_rows($ds); //número de registros totais                
            
            if ($nr == 0) {
                
                echo "<h3>Atenção! A senha atual digitada está incorreta!</h3>";
                echo $dscerr;
                echo "<br/><a href='alterar.php?tabela=$tabela&indice=$chave'>Voltar</a>";                
                
            } else {
                
                UpdUsuario($chave, $nome, $email, $novaSenha);
                include('mensagem.php');                          
                
            }
        }
    }
?>