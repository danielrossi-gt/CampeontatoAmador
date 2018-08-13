<?php 

    require_once('_conn/conn.php'); 
    require_once('_lib/WideImage.php');

    //Cria um dataset básico
    function Dataset($tabela, $filtro, $ordem) {
		$tabela = strtolower($tabela);

        $SQL = 'SELECT * FROM ' . $tabela ;

        //Aplica o filtro
        if ($filtro != '') {$SQL .= ' WHERE ' . $filtro; }

        //Aplica ordenação
        if ($ordem != '') { $SQL .= ' ORDER BY ' . $ordem; }

        $ds = mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");;

        //   echo $SQL;

        return $ds;
    }
	
    function EscreveTabela($tabela) {

        if ($tabela == "categoria") {
            echo "Categoria";			
        }

        if ($tabela == "serie") {
            echo "Série";
        }

        if ($tabela == "campeonato") {
            echo "Campeonato";
        }
        
        if ($tabela == "confronto") {
            echo "Confronto";
        }
        
        if ($tabela == "time") {
            echo "Time";
        }

        if ($tabela == "partida") {
            echo "Partida";
        }

        if ($tabela == "usuario") {
            echo "Usuário";
        }       
        
        if ($tabela == "jogador") {
            echo "Jogador";
        }
        
        if ($tabela == "historia") {
            echo "História";
        }
        
        if ($tabela == "noticia") {
            echo "Notícia";
        }
        
        if ($tabela == "grupo") {
            echo "Grupo";
        }
        
        if ($tabela == "estadio") {
            echo "Estádio";
        }
        
        if ($tabela == "partida") {
            echo "Partida";
        }
        
    }
  
    //Série
    function InsSerie($descricao) {
        $SQL = "INSERT INTO serie (DESCRICAO) VALUES ('$descricao')";
        mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }
    
    function UpdSerie($chave, $descricao) {
		$SQL =  "UPDATE serie SET DESCRICAO = '$descricao' ";
		$SQL .= "WHERE CHAVE = $chave";
		mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }
  
    function DelSerie($chave) {
        $SQL = " SELECT * FROM grupo WHERE SERIE = ".$chave;
        $ds = mysql_query($SQL);
        $nr = mysql_num_rows($ds); //número de registros totais    

        if($nr > 0) {            
            die ("<b>ERRO! Série não pode ser excluída pois há grupos cadastrados com essa série! </b>");
        } else {        
            $SQL = "DELETE FROM serie WHERE CHAVE = " . $chave;
                    mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
        }
    }
    
    function EscreveSerie($value, $tipo) {
		
        if ($tipo == 1) {
            $SQL = "SELECT DESCRICAO FROM serie WHERE CHAVE = $value";
            $dss = mysql_query($SQL);
            if (mysql_num_rows($dss) > 0) {
                echo mysql_result($dss, 0, "DESCRICAO");
            }
        }
        else if ($tipo == 2) {
            $SQL = "SELECT CHAVE, DESCRICAO FROM serie";
            $dss = mysql_query($SQL);
            $nrf = mysql_num_rows($dss);
            
            for ($i = 0; $i < $nrf; $i ++) {
                $chave = mysql_result($dss, $i, "CHAVE");
                $descricao = mysql_result($dss, $i, "DESCRICAO");

                echo "<option value='$chave'";
                if ($value == $chave) { echo " selected=\"selected\" "; }
                echo ">$descricao</option>";
            }            
        }
        else {
            echo "Nenhum";
        }
		
    }
    
    //Categoria
    function InsCategoria($descricao) {
        $SQL = "INSERT INTO categoria (DESCRICAO) VALUES ('$descricao')";
        mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }
    
    function UpdCategoria($chave, $descricao) {
	$SQL =  "UPDATE categoria SET DESCRICAO = '$descricao' ";
	$SQL .= "WHERE CHAVE = $chave";
	mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }
  
    function DelCategoria($chave) {
        $SQL = " SELECT * FROM campeonato WHERE CATEGORIA = ".$chave;
        $ds = mysql_query($SQL);
        $nr = mysql_num_rows($ds); //número de registros totais    

        if($nr > 0) {            
            die ("<b>ERRO! Categoria não pode ser excluída pois há campeonatos cadastrados com essa categoria ! </b>");
        } else {        
            $SQL = "DELETE FROM categoria WHERE CHAVE = " . $chave;
            mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
        }
    }
    
    function EscreveCategoria($value, $tipo) {
		
	if ($tipo == 1) {
            $SQL = "SELECT DESCRICAO FROM categoria WHERE CHAVE = $value";
            $dsc = mysql_query($SQL);
            if (mysql_num_rows($dsc) > 0) {
		echo mysql_result($dsc, 0, "DESCRICAO");
            }
        }
        else if ($tipo == 2) {
            $SQL = "SELECT CHAVE, DESCRICAO FROM categoria";
            $dsc = mysql_query($SQL);
            $nrc = mysql_num_rows($dsc);
            
            for ($i = 0; $i < $nrc; $i ++) {
                $chave = mysql_result($dsc, $i, "CHAVE");
                $descricao = mysql_result($dsc, $i, "DESCRICAO");
                
                echo "<option value='$chave'";
                if ($value == $chave) { echo " selected=\"selected\" "; }
                echo ">$descricao</option>";
            }               
        }
        else {
            echo "Nenhum";
        }
	  
    }    
    
    //Campeonato
    function InsCampeonato($descricao, $categoria, $genero) {
        $SQL = "INSERT INTO campeonato (DESCRICAO, CATEGORIA, GENERO) VALUES ('$descricao', '$categoria', '$genero')";
        mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }
    
    function UpdCampeonato($chave, $descricao, $categoria, $genero) {
	$SQL =  "UPDATE campeonato SET DESCRICAO = '$descricao', CATEGORIA = '$categoria', GENERO = '$genero'";
	$SQL .= "WHERE CHAVE = $chave";
	mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }
  
    function DelCampeonato($chave) {
        $SQL = " SELECT * FROM confronto WHERE CAMPEONATO = ".$chave;
        $ds = mysql_query($SQL);
        $nr = mysql_num_rows($ds); //número de registros totais    

        if($nr > 0) {            
            die ("<b>ERRO! Campeonato não pode ser excluído pois há confrontos cadastrados desse campeonato ! </b>");
        } else {
            $SQL = " SELECT * FROM time WHERE CAMPEONATO = ".$chave;
            $ds = mysql_query($SQL);
            $nr = mysql_num_rows($ds); //número de registros totais    

            if($nr > 0) {            
                die ("<b>ERRO! Campeonato não pode ser excluído pois há times cadastrados desse campeonato ! </b>");
            } else {
                $SQL = " SELECT * FROM historia WHERE CAMPEONATO = ".$chave;
                $ds = mysql_query($SQL);
                $nr = mysql_num_rows($ds); //número de registros totais    

                if($nr > 0) {            
                    die ("<b>ERRO! Campeonato não pode ser excluído pois há histórias cadastradas desse campeonato ! </b>");
                } else {                
                    $SQL = " SELECT * FROM grupo WHERE CAMPEONATO = ".$chave;
                    $ds = mysql_query($SQL);
                    $nr = mysql_num_rows($ds); //número de registros totais    

                    if($nr > 0) {            
                        die ("<b>ERRO! Campeonato não pode ser excluído pois há grupos cadastrados desse campeonato ! </b>");
                    } else {                                    
                        $SQL = " SELECT * FROM noticia WHERE CAMPEONATO = ".$chave;
                        $ds = mysql_query($SQL);
                        $nr = mysql_num_rows($ds); //número de registros totais    

                        if($nr > 0) {            
                            die ("<b>ERRO! Campeonato não pode ser excluído pois há notícias cadastradas desse campeonato ! </b>");
                        } else {                        
                            $SQL = "DELETE FROM campeonato WHERE CHAVE = " . $chave;
                            mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
                        }
                    }
                }
            }
        }
    }
    
    function EscreveCampeonato($chave) {
        $dsc = Dataset("campeonato", "CHAVE = $chave", "");
        return mysql_result($dsc, 0, "DESCRICAO");
    }
    
    // Usuário
    function InsUsuario($nome, $email, $senha) {
        $SQL = "INSERT INTO usuario (NOME, EMAIL, SENHA) VALUES ('$nome', '$email', PASSWORD('$senha'))";
        mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }
    
    function UpdUsuario($chave, $nome, $email, $senha) {
	$SQL =  "UPDATE usuario SET NOME = '$nome', EMAIL = '$email', SENHA = PASSWORD('$senha') ";
	$SQL .= "WHERE CHAVE = $chave";
	mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }
  
    function DelUsuario($chave) {
        $SQL = "DELETE FROM usuario WHERE CHAVE = " . $chave;
	mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }
    
    // Confronto
    function InsConfronto($descricao) {
        $SQL = "INSERT INTO confronto (DESCRICAO, CAMPEONATO) VALUES ('$descricao', ".$_SESSION["campeonato_chave"].")";
        mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }
    
    function UpdConfronto($chave, $descricao) {
	$SQL =  "UPDATE CONFRONTO SET DESCRICAO = '$descricao' ";
	$SQL .= "WHERE CHAVE = $chave";
	mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }
  
    function DelConfronto($chave) {
        $SQL = " SELECT * FROM partida WHERE CONFRONTO = ".$chave;
        $ds = mysql_query($SQL);
        $nr = mysql_num_rows($ds); //número de registros totais    

        if($nr > 0) {            
            die ("<b>ERRO! Rodada não pode ser excluída pois há partidas cadastradas dessa rodada ! </b>");
        } else {
            $SQL = "DELETE FROM confronto WHERE CHAVE = " . $chave;
            mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
        }
    }    
    
    function EscreveConfronto($chave) {
        $SQL = "SELECT DESCRICAO FROM confronto WHERE CHAVE = $chave";
	$dst = mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
        return mysql_result($dst, 0, "DESCRICAO");        
    }
  
    // Time
    function InsTime ($nome, $campeonato, $distintivo, $pontos_perdidos, $fundador, $fundacao, $historico) {
        $SQL = "INSERT INTO time (NOME, CAMPEONATO, PONTOS_PERDIDOS, FUNDADOR, FUNDACAO, HISTORICO) VALUES ('$nome', $campeonato, $pontos_perdidos, '$fundador', '$fundacao', '$historico')";
        mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
        
        // Recuperar a chave usado no insert
        $chaveNova = mysql_insert_id();
        
        // Gravando distintivo
        if ($distintivo != '') {
            
            $img = WideImage::load($distintivo);
            $redimensionar = $img->resize(45,45,'inside');
            $redimensionar->saveToFile("_imagens/_distintivos/".$chaveNova.".png");
            
            // Apagar o arquivo original e mantém apenas o redimensionado
            unlink($distintivo);
        }
    }
    
    function UpdTime($chave, $nome, $distintivo, $pontos_perdidos, $fundador, $fundacao, $historico) {
	$SQL =  "UPDATE time SET NOME = '$nome', PONTOS_PERDIDOS = $pontos_perdidos, FUNDADOR = '$fundador', FUNDACAO = '$fundacao', HISTORICO = '$historico' ";
	$SQL .= "WHERE CHAVE = $chave";
	mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
        
        // Gravando distintivo
        if ($distintivo != '') {
            
            $img = WideImage::load($distintivo);
            $redimensionar = $img->resize(45,45,'inside');
            $redimensionar->saveToFile("_imagens/_distintivos/".$chave.".png");
            
            // Apagar o arquivo original e mantém apenas o redimensionado
            unlink($distintivo);
        }        
    }
    
    function DelTime($chave) {
        $SQL = " SELECT * FROM partida WHERE TIME_MANDANTE = ".$chave." OR TIME_VISITANTE = ".$chave;
        $ds = mysql_query($SQL);
        $nr = mysql_num_rows($ds); //número de registros totais    

        if($nr > 0) {            
            die ("<b>ERRO! Esse time não pode ser excluído pois possui partidas cadastrados! </b>");
        } else {
            $SQL = " SELECT * FROM jogador WHERE TIME = ".$chave;            
            $ds = mysql_query($SQL);
            $nr = mysql_num_rows($ds); //número de registros totais    
            
            if ($nr > 0) {
                die ("<b>ERRO! Esse time não pode ser excluído pois possui jogadores cadastrados! </b>");                                            
            } else {
                $SQL = "DELETE FROM time WHERE CHAVE = " . $chave;
                mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
                
                @unlink("_imagens/_distintivos/".$chave.".png");
            }
        }     
    }      
    
    function EscreveTime($chave) {
        $SQL = "SELECT NOME FROM time WHERE CHAVE = $chave";
	$dst = mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
        return mysql_result($dst, 0, "NOME");
    }
  
    // Passando data do banco "AAAA-MM-DD" para "DD/MM/AAAA"
    function mostraData ($data) {
        if ($data!='') {
            return (substr($data,8,2).'/'.substr($data,5,2).'/'.substr($data,0,4));
        }
        else { 
            return ''; 
        }
    }
    
    // Passando data e hora do banco "AAAA-MM-DD HH:NN:SS" para "DD/MM/AAAA HH:NN:SS"
    function mostraDataHora ($data) {
        if ($data!='') {
            return (substr($data,8,2).'/'.substr($data,5,2).'/'.substr($data,0,4).' '.
                    substr($data,11,2).':'.substr($data,14,2));
        }
        else { 
            return ''; 
        }
    }    

    // Passando data do text box "DD/MM/AAAA" para "AAAA-MM-DD"
    function gravaData ($data) {
        if ($data != '') {
            return (substr($data,6,4).'-'.substr($data,3,2).'-'.substr($data,0,2));
        }
        else { 
            return ''; 
        }
    }
    
    // Passando data e hora do text box "DD/MM/AAAA HH:NN:SS" para "AAAA-MM-DD HH:NN:SS"
    function gravaDataHora ($data) {
        if ($data != '') {
            return (substr($data,6,4).'-'.substr($data,3,2).'-'.substr($data,0,2).' '.
                    substr($data,11,2).':'.substr($data,14,2).':00');
        }
        else { 
            return ''; 
        }
    }        
    // Grupo
    function EscreveGrupo($chave) {
        $SQL = "SELECT DESCRICAO FROM grupo WHERE CHAVE = $chave";
	$dst = mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
        return mysql_result($dst, 0, "DESCRICAO");
    }
    
    // Partida
    function InsPartida($mandante, $visitante, $grupo, $confronto, $data, $estadio) {
        $SQL = "INSERT INTO partida (TIME_MANDANTE, PLACAR_MANDANTE, TIME_VISITANTE, PLACAR_VISITANTE, GRUPO, CONFRONTO, DATA, ENCERRADA, ESTADIO) ".
               "VALUES ($mandante, 0, $visitante, 0, $grupo, $confronto, '".gravaDataHora($data)."', 'NAO', $estadio)";
        mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL ."\"</i>");
    }   
                
    function UpdPartida($chave, $timeM, $timeV, $grupo, $confronto, $data, $observacao, $estadio ) {
		$SQL =  "UPDATE partida SET TIME_MANDANTE = $timeM, TIME_VISITANTE = $timeV, GRUPO = $grupo, CONFRONTO = $confronto, DATA = '".gravaDataHora($data)."', OBSERVACAO = '$observacao', ESTADIO = $estadio ";
		$SQL .= "WHERE CHAVE = $chave";
		mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }    
    
    function DelPartida($chave) {
        $SQL = " SELECT * FROM gol WHERE PARTIDA = ".$chave;
        $ds = mysql_query($SQL);
        $nr = mysql_num_rows($ds); //número de registros totais    

        if($nr > 0) {            
            die ("<b>ERRO! Partida não pode ser excluída pois há gols cadastrados dessa partida ! </b>");
        } else {        
            $SQL = " SELECT * FROM cartao WHERE PARTIDA = ".$chave;
            $ds = mysql_query($SQL);
            $nr = mysql_num_rows($ds); //número de registros totais    

            if($nr > 0) {            
                die ("<b>ERRO! Partida não pode ser excluída pois há cartões cadastrados dessa partida ! </b>");
            } else {                    
                $SQL = "DELETE FROM partida WHERE CHAVE = " . $chave;
                mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
            }
        }
    }   
    
    // Jogador
    function InsJogador($nome, $time) {
        $SQL = "INSERT INTO jogador (NOME, TIME) VALUES ('$nome', $time)";
        mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");        
    }
    
    function UpdJogador($chave, $nome) {
	$SQL =  "UPDATE jogador SET NOME = '$nome'";
	$SQL .= "WHERE CHAVE = $chave";
	mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }

    function DelJogador($chave) {
        $SQL = " SELECT * FROM cartao WHERE JOGADOR = ".$chave;
        $ds = mysql_query($SQL);
        $nr = mysql_num_rows($ds); //número de registros totais    

        if($nr > 0) {
            die ("<b>ERRO! Esse jogador não pode ser excluído pois possui cartões cadastrados! </b>");            
        } else {
            $SQL = " SELECT * FROM gol WHERE JOGADOR = ".$chave;
            $ds = mysql_query($SQL);
            $nr = mysql_num_rows($ds); //número de registros totais
            
            if ($nr > 0) {
                die ("<b>ERRO! Esse jogador não pode ser excluído pois possui gols cadastrados! </b>");                            
            } else {
                $SQL = "DELETE FROM jogador WHERE CHAVE = " . $chave;
                mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");                            
            }
        }       
    }  
  
    // Historia
    function InsHistoria ($titulo, $subtitulo, $texto, $imagem) {
        $SQL = "INSERT INTO historia (TITULO, SUBTITULO, TEXTO, CAMPEONATO) VALUES ('$titulo', '$subtitulo', '$texto', ".$_SESSION["campeonato_chave"].")";
        mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
        
        // Recuperar a chave usado no insert
        $chaveNova = mysql_insert_id();
        
        // Gravando distintivo
        if ($imagem != '') {
            
            $img = WideImage::load($imagem);
            $redimensionar = $img->resize(780,520,'inside');
            $redimensionar->saveToFile("_imagens/_noticias/".$chaveNova.".jpg");
            
            // Apagar o arquivo original e mantém apenas o redimensionado
            unlink($imagem);
        }
    }
    
    function UpdHistoria($chave, $titulo, $subtitulo, $texto, $imagem) {
	$SQL =  "UPDATE historia SET TITULO = '$titulo', SUBTITULO = '$subtitulo', TEXTO = '$texto'";
	$SQL .= "WHERE CHAVE = $chave";
	mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
        
        // Gravando distintivo
        if ($imagem != '') {
            
            $img = WideImage::load($imagem);
            $redimensionar = $img->resize(780,520,'inside');
            $redimensionar->saveToFile("_imagens/_noticias/".$chave.".jpg");
            
            // Apagar o arquivo original e mantém apenas o redimensionado
            unlink($imagem);
        }        
    }
    
    function DelHistoria($chave) {
        $SQL = "DELETE FROM historia WHERE CHAVE = " . $chave;
	mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }
    
    
    // Noticias
    function InsNoticia ($titulo, $subtitulo, $texto, $imagem) {
        $SQL = "INSERT INTO noticia (TITULO, SUBTITULO, TEXTO, CAMPEONATO) VALUES ('$titulo', '$subtitulo', '$texto', ".$_SESSION["campeonato_chave"].")";
        mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
        
        // Recuperar a chave usado no insert
        $chaveNova = mysql_insert_id();
        
        // Gravando distintivo
        if ($imagem != '') {
            
            $img = WideImage::load($imagem);
            $redimensionar = $img->resize(780,520,'inside');
            $redimensionar->saveToFile("_imagens/_noticias/".$chaveNova.".jpg");
            
            // Apagar o arquivo original e mantém apenas o redimensionado
            unlink($imagem);
        }
    }  
    
    function UpdNoticia($chave, $titulo, $subtitulo, $texto, $imagem) {
	$SQL =  "UPDATE noticia SET TITULO = '$titulo', SUBTITULO = '$subtitulo', TEXTO = '$texto'";
	$SQL .= "WHERE CHAVE = $chave";
	mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
        
        // Gravando distintivo
        if ($imagem != '') {
            
            $img = WideImage::load($imagem);
            $redimensionar = $img->resize(780,520,'inside');
            $redimensionar->saveToFile("_imagens/_noticias/".$chave.".jpg");
            
            // Apagar o arquivo original e mantém apenas o redimensionado
            unlink($imagem);
        }        
    }
    
    function DelNoticia($chave) {
        $SQL = "DELETE FROM noticia WHERE CHAVE = " . $chave;
	mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }    
  
    //Grupo
    function InsGrupo($descricao, $serie) {
        $SQL = "INSERT INTO grupo (DESCRICAO, CAMPEONATO, SERIE) VALUES ('$descricao', ".$_SESSION["campeonato_chave"].", $serie)";
        mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }
    
    function UpdGrupo($chave, $descricao, $serie) {
		$SQL =  "UPDATE grupo SET DESCRICAO = '$descricao', CAMPEONATO = ".$_SESSION["campeonato_chave"].", SERIE = $serie ";
		$SQL .= "WHERE CHAVE = $chave";
		mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }
  
    function DelGrupo($chave) {
        $SQL = " SELECT * FROM partida WHERE GRUPO = ".$chave;
        $ds = mysql_query($SQL);
        $nr = mysql_num_rows($ds); //número de registros totais    

        if($nr > 0) {            
            die ("<b>ERRO! Grupo não pode ser excluído pois há partidas cadastradas desse grupo ! </b>");
        } else {
            $SQL = "DELETE FROM grupo WHERE CHAVE = " . $chave;
                    mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
        }
    }
    
    //Estádio
    function InsEstadio($descricao) {
        $SQL = "INSERT INTO estadio (DESCRICAO) VALUES ('$descricao')";
        mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }
    
    function UpdEstadio($chave, $descricao) {
	$SQL =  "UPDATE estadio SET DESCRICAO = '$descricao' ";
	$SQL .= "WHERE CHAVE = $chave";
	mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
    }
  
    function DelEstadio($chave) {
        $SQL = " SELECT * FROM partida WHERE ESTADIO = ".$chave;
        $ds = mysql_query($SQL);
        $nr = mysql_num_rows($ds); //número de registros totais    

        if($nr > 0) {            
            die ("<b>ERRO! Estádio não pode ser excluído pois há partidas cadastradas com esse estádio! </b>");
        } else {        
            $SQL = "DELETE FROM estadio WHERE CHAVE = " . $chave;
            mysql_query($SQL) or die ("<b>ERRO! Instrução Inválida: </b><br/><i>\"" . $SQL . "\"</i>");
        }
    }
    
    
  
?>