<?php
    require_once("_conn/conn.php");
    require_once("_data/session.php");
    include('_data/dm.php');

    $tabela   = 'noticia';
    $chave    = $_POST["CHAVE"];
    $titulo = $_POST["TITULO"];
    $subtitulo = $_POST["SUBTITULO"];
    $texto = $_POST["TEXTO"];    
    $campeonato = $_SESSION["campeonato_chave"];

    $dscerr = '';

    //Validações
    if ($titulo == '') {
        $dscerr =  "Título <br/>";
    }
    
    if ($subtitulo == '') {
        $dscerr =  "Subtítulo <br/>";
    }
    
    if ($texto == '') {
        $dscerr =  "Texto <br/>";
    }    

    if ($dscerr != '') {
        
        echo "<h3>Atenção! Os campos abaixo são obrigatórios e não foram preenchidos!</h3>";
        echo $dscerr;
        echo "<br/><a href='alterar.php?tabela=$tabela&indice=$chave'>Voltar</a>";
        
    }
    else {
        
        $file = $_FILES['imagem'];
        $folder = '_imagens/_noticias';
        $numFile = count($file['name']);

        $errorMsg	= array(
            1 => 'O arquivo no upload é maior do que o limite definido em upload_max_filesize no php.ini.',
            2 => 'O arquivo ultrapassa o limite de tamanho em MAX_FILE_SIZE que foi especificado no formulário HTML',
            3 => 'o upload do arquivo foi feito parcialmente',
            4 => 'Não foi feito o upload do arquivo'
        );    

        if ($numFile > 0) {
            $msg = '';

            $name 	= $file['name'];
            $type	= $file['type'];
            $size	= $file['size'];
            $error	= $file['error'];
            $tmp	= $file['tmp_name'];

            $extensao = @end(explode('.', $name));
            $novoNome = rand().".$extensao";

            if($error != 0) {
                $msg = "<b>$name :</b> ".$errorMsg[$error];
            } else {
                if (!move_uploaded_file($tmp, $folder.'/'.$novoNome)) {
                    $msg = "<b>$name :</b> Desculpe! Ocorreu um erro...";                
                }
            }

            if ($msg != '') {
                $imagem = '';
            } else {
                $imagem = $folder . '/' . $novoNome;
            }

        } else {
            $imagem = '';  
        }
        
        UpdNoticia($chave, $titulo, $subtitulo, $texto, $imagem);
        
        include('mensagem.php');                          
        
    }
?>