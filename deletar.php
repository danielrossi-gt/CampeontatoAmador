<?php

	require_once("_data/session.php");
	include('_data/dm.php');

	$tabela = $_GET["tabela"];
	$indice = $_GET["indice"];
?>
<html>
    <head>
        <title>Gerenciador de Campeonatos</title>
		<meta charset="UTF-8">
        <link href="_css/style.css" rel="stylesheet" type="text/css" />
        <script src="funcoes.js" type="text/javascript"></script>
    </head>
    <body>    
        <div>
          <table width='800' border='0' align='center'>
            <tr><td colspan=2></td><td><a href="javascript:history.go(-1)"><img src="_imagens/cancel.jpg" width="16" height="16" border="0" align='right'></a></td></tr>
            <tr><td colspan=3></td></tr>
          </table>            
            <center>
<?php
	if ($tabela == 'serie') {
            DelSerie($indice);
	}

	if ($tabela == 'categoria') {
            DelCategoria($indice);
	}  

	if ($tabela == 'campeonato') {
            DelCampeonato($indice);
	}  
	
	if ($tabela == 'confronto') {
            DelConfronto($indice);
	}
        
        if ($tabela == 'usuario') {
            DelUsuario($indice);
        }
        
        if ($tabela == 'partida') {
            DelPartida($indice);
        }
        
        if ($tabela == 'time') {
            DelTime($indice);
        }
        
        if ($tabela == 'jogador') {
            DelJogador($indice);
        }
        
        if ($tabela == 'historia') {
            DelHistoria($indice);
        }

        if ($tabela == 'noticia') {
            DelNoticia($indice);
        }        

        if ($tabela == 'grupo') {
            DelGrupo($indice);
        }
        
        if ($tabela == 'estadio') {
            DelEstadio($indice);
        }
        
	include('mensagem_exc.php');

?>        
            </center>
        </div>
    </body>
</html>
