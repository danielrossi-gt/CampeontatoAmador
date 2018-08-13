<?php
    require_once("_data/session.php");
    include('_data/dm.php');

    $nome = $_POST["NOME"];
    $campeonato = $_SESSION["campeonato_chave"];
	$pontos_perdidos = $_POST["PONTOS_PERDIDOS"];
	$fundador = $_POST["FUNDADOR"];
	$fundacao = $_POST["FUNDACAO"]; 
	$historico = $_POST["HISTORICO"];
	
	if ($pontos_perdidos == "") {
		$pontos_perdidos = 0;
	}

    $file = $_FILES['distintivo'];
    $folder = '_imagens/_distintivos';
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
            $distintivo = '';
        } else {
            $distintivo = $folder . '/' . $novoNome;
        }
        
    } else {
        $distintivo = '';  
    }

    InsTime($nome, $campeonato, $distintivo, $pontos_perdidos, $fundador, $fundacao, $historico);
    $time = mysql_insert_id();
    $tabela = 'time';
    $cadastro = 1;
    
    // Gravar jogadores
    for ($x = 0; $x < 30; $x++) {
        
        if (isset($_POST["JOGADOR".$x])) {
            $nomeJogador = $_POST["JOGADOR".$x];
            
            if ($nomeJogador != '') {
                InsJogador($nomeJogador, $time);
            }
        }
    }
    
    include('mensagem.php');

?>