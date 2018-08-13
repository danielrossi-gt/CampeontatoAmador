<?php
  require_once("_data/session.php");
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
        <?php

          require_once('_conn/conn.php');
          include('_data/dm.php');

          $tabela = $_GET['tabela'];
		  
		  $filtro = "";
		  if (($tabela == "confronto") || 
                      ($tabela == "historia") || 
                      ($tabela == "noticia") || 
                      ($tabela == "grupo") ||
                      ($tabela == "time")) {
            $filtro = "CAMPEONATO = " . $_SESSION["campeonato_chave"];
          } 
          
          if ($tabela == 'partida') {
            $filtro = "confronto IN (SELECT CHAVE FROM confronto WHERE CAMPEONATO = ". $_SESSION["campeonato_chave"] .")";  
          }

          //Registros por página
          $rp = 10;

          //Prepara paginação
          if (isset($_GET["pagina"])) {
            $pagina = $_GET["pagina"];
          }
          else {
            $pagina = '';
          }

          if (!$pagina) {
            $inicio = 0;
            $pagina = 1;
          }
          else {
            $inicio = ($pagina - 1) * $rp;
          }

          //Select com a estrutura da tabela
          $SQL = " SELECT COLUMN_NAME, COLUMN_COMMENT, EXTRA, DATA_TYPE,             ".
                 "        CHARACTER_MAXIMUM_LENGTH, NUMERIC_PRECISION, NUMERIC_SCALE ".
                 "   FROM INFORMATION_SCHEMA.COLUMNS                                 ".
                 "  WHERE TABLE_NAME = '$tabela'                                     ".
                 "   AND TABLE_SCHEMA = '$database'                                  ".
                 " ORDER BY ORDINAL_POSITION                                         ";


          $ds = mysql_query($SQL);
          $nr = mysql_num_rows($ds); //número de registros totais
          $cs = mysql_num_rows($ds) + 1; //colspan

		  /*
          echo "<table width='800' border='0' align='center'>";
          echo "<tr><td colspan='2' align='right' valign='center'>";
          echo "  <a href=\"principal.php\"><img src=\"_imagens/cancel.jpg\" width=\"16\" height=\"16\" border=\"0\" align='center'></a>";
          echo "</td>";
          echo "</tr>";
          //echo "<tr><td colspan=2><font color='white'><b><img src=\"_imagens/man_$tabela.jpg\" width=\"1000\" height=\"70\" border='0'></b></font></td></tr>";
          echo "<tr><td colspan=2><h3>Manutenção de $tabela</h3></td></tr>";
          echo "</table>";
          echo "<table width='800' border='0' align='center'>";
          echo "<tr>";
		  */

          $descCamp = "";
          if (($tabela == "confronto") || ($tabela == "time") || ($tabela == "partida") || ($tabela == "grupo") || ($tabela == "historia") || ($tabela == "noticia")) {
            if (isset($_SESSION["campeonato_chave"])) {
              $descCamp = "Campeonato Ativo: " . EscreveCampeonato($_SESSION["campeonato_chave"]);		  
            }
          }
          
          echo "<table width='800' border='0' align='center'>";
          echo "<tr><td colspan=2><h3>Manutenção de "; EscreveTabela($tabela); echo "</h3></td><td><a href=\"principal.php\"><img src=\"_imagens/cancel.jpg\" width=\"16\" height=\"16\" border=\"0\" align='right'></a></td></tr>";
          echo "<tr><td colspan=2><h3>$descCamp</h3></td><td></td></tr>";
          echo "</table>";
          echo "<table width='800' border='0' align='center'>";
          echo "<tr>";
		  

          //monta o cabeçalho da tabela
          if ($tabela == 'partida') {
              echo "<th bgcolor='silver'>Mandante</th>";
              echo "<th bgcolor='silver'>&nbsp</th>";
              echo "<th bgcolor='silver'>X</th>";
              echo "<th bgcolor='silver'>&nbsp</th>";
              echo "<th bgcolor='silver'>Visitante</th>";
              echo "<th bgcolor='silver'>Grupo</th>";
              echo "<th bgcolor='silver'>Confronto</th>";
              echo "<th bgcolor='silver'>Encerrada</th>";
              
          } else {
            for ($i = 0; $i < $nr; $i ++) {
              $colnam = mysql_result($ds, $i, 'COLUMN_NAME');
              $descri = mysql_result($ds, $i, 'COLUMN_COMMENT');
              $fextra = mysql_result($ds, $i, 'EXTRA');
              $dattyp = mysql_result($ds, $i, 'DATA_TYPE');
              $chrmax = mysql_result($ds, $i, 'CHARACTER_MAXIMUM_LENGTH');
              $nummax = mysql_result($ds, $i, 'NUMERIC_PRECISION');
              $numprc = mysql_result($ds, $i, 'NUMERIC_SCALE');

              if (($colnam != "SENHA") && ($colnam != 'CAMPEONATO') && ($colnam != 'TEXTO') && ($descri != 'Atualizado' ))  {
                  echo "<th bgcolor='silver'>$descri</th>";                
              }

            }              
          }

          echo "<th bgcolor='silver'>Operações</th>";
          echo "</tr>";

          //traz os dados
          $ds = Dataset($tabela, '', '');              
          
          $nr = mysql_num_rows($ds);

          //Total de Páginas
          $tp = ceil($nr / $rp);

          $ds = Dataset($tabela, $filtro, 'CHAVE LIMIT ' . $inicio . "," . $rp);
          $nr = mysql_num_rows($ds);

          //tabela de séries
          if ($tabela == 'serie') {
            for ($i = 0; $i < $nr; $i++) {
              $chave = mysql_result($ds, $i, 'CHAVE');
              $descricao = mysql_result($ds, $i, 'DESCRICAO');

              echo "<tr>";
              echo "<td>$chave</td>";
              echo "<td>$descricao</td>";
              echo "<td width='100' align=\"center\"><a href='deletar.php?tabela=$tabela&indice=$chave' onClick=\"return confirm('Tem certeza que deseja apagar o registro?')\"><img src='_imagens/delete.png' border='0' title='Apagar'></a>&nbsp&nbsp&nbsp<a href='alterar.php?tabela=$tabela&indice=$chave'><img src='_imagens/edit.png' border='0' alt='Editar'></a></td>";
              echo "</tr>";
            }
          }
          
          //tabela de categorias
          if ($tabela == 'categoria') {
            for ($i = 0; $i < $nr; $i++) {
              $chave = mysql_result($ds, $i, 'CHAVE');
              $descricao = mysql_result($ds, $i, 'DESCRICAO');

              echo "<tr>";
              echo "<td>$chave</td>";
              echo "<td>$descricao</td>";
              echo "<td width='100' align=\"center\"><a href='deletar.php?tabela=$tabela&indice=$chave' onClick=\"return confirm('Tem certeza que deseja apagar o registro?')\"><img src='_imagens/delete.png' border='0' title='Apagar'></a>&nbsp&nbsp&nbsp<a href='alterar.php?tabela=$tabela&indice=$chave'><img src='_imagens/edit.png' border='0' alt='Editar'></a></td>";
              echo "</tr>";
            }
          }
          
          //tabela de estádios
          if ($tabela == 'estadio') {
            for ($i = 0; $i < $nr; $i++) {
              $chave = mysql_result($ds, $i, 'CHAVE');
              $descricao = mysql_result($ds, $i, 'DESCRICAO');

              echo "<tr>";
              echo "<td>$chave</td>";
              echo "<td>$descricao</td>";
              echo "<td width='100' align=\"center\"><a href='deletar.php?tabela=$tabela&indice=$chave' onClick=\"return confirm('Tem certeza que deseja apagar o registro?')\"><img src='_imagens/delete.png' border='0' title='Apagar'></a>&nbsp&nbsp&nbsp<a href='alterar.php?tabela=$tabela&indice=$chave'><img src='_imagens/edit.png' border='0' alt='Editar'></a></td>";
              echo "</tr>";
            }
          }
          
          
          //tabela de confrontos
          if ($tabela == 'confronto') {
            for ($i = 0; $i < $nr; $i++) {
              $chave = mysql_result($ds, $i, 'CHAVE');
              $descricao = mysql_result($ds, $i, 'DESCRICAO');

              echo "<tr>";
              echo "<td>$chave</td>";
              echo "<td>$descricao</td>";
              echo "<td width='100' align=\"center\"><a href='deletar.php?tabela=$tabela&indice=$chave' onClick=\"return confirm('Tem certeza que deseja apagar o registro?')\"><img src='_imagens/delete.png' border='0' title='Apagar'></a>&nbsp&nbsp&nbsp<a href='alterar.php?tabela=$tabela&indice=$chave'><img src='_imagens/edit.png' border='0' alt='Editar'></a></td>";
              echo "</tr>";
            }
          }          
          
          //tabela de campeonatos
          if ($tabela == 'campeonato') {
            for ($i = 0; $i < $nr; $i++) {
              $chave = mysql_result($ds, $i, 'CHAVE');
              $descricao = mysql_result($ds, $i, 'DESCRICAO');
              $categoria = mysql_result($ds, $i, 'CATEGORIA');
              $genero = mysql_result($ds, $i, 'GENERO');

              echo "<tr>";
              echo "<td>$chave</td>";
              echo "<td>$descricao</td>";
              echo "<td>"; EscreveCategoria($categoria, 1); 
              echo "<td>$genero</td>";
              echo "<td width='100' align=\"center\"><a href='deletar.php?tabela=$tabela&indice=$chave' onClick=\"return confirm('Tem certeza que deseja apagar o registro?')\"><img src='_imagens/delete.png' border='0' title='Apagar'></a>&nbsp&nbsp&nbsp<a href='alterar.php?tabela=$tabela&indice=$chave'><img src='_imagens/edit.png' border='0' alt='Editar'></a></td>";
              echo "</tr>";
            }
          }          

          if ($tabela == "grupo") {
            for ($i = 0; $i < $nr; $i++) {
              $chave = mysql_result($ds, $i, 'CHAVE');
              $descricao = mysql_result($ds, $i, 'DESCRICAO');
              $serie = mysql_result($ds, $i, 'SERIE');

              echo "<tr>";
              echo "<td>$chave</td>";
              echo "<td>$descricao</td>";
              echo "<td>"; EscreveSerie($serie, 1); echo "</td>";
              echo "<td width='100' align=\"center\"><a href='deletar.php?tabela=$tabela&indice=$chave' onClick=\"return confirm('Tem certeza que deseja apagar o registro?')\"><img src='_imagens/delete.png' border='0' title='Apagar'></a>&nbsp&nbsp&nbsp<a href='alterar.php?tabela=$tabela&indice=$chave'><img src='_imagens/edit.png' border='0' alt='Editar'></a></td>";
              echo "</tr>";
            }   
          }          
          
          // tabela de usuarios
          if ($tabela == 'usuario') {
            for ($i = 0; $i < $nr; $i++) {
              $chave = mysql_result($ds, $i, 'CHAVE');
              $nome = mysql_result($ds, $i, 'NOME');
              $email = mysql_result($ds, $i, 'EMAIL');

              echo "<tr>";
              echo "<td>$chave</td>";
              echo "<td>$nome</td>";
              echo "<td>$email</td>";
              
              if ($chave == $usuario_chave) {
                echo "<td width='100' align=\"center\"><a href='alterar.php?tabela=$tabela&indice=$chave'><img src='_imagens/edit.png' border='0' alt='Editar'></a></td>";                                    
              } else {
                echo "<td width='100' align=\"center\"><a href='deletar.php?tabela=$tabela&indice=$chave' onClick=\"return confirm('Tem certeza que deseja apagar o registro?')\"><img src='_imagens/delete.png' border='0' title='Apagar'></a>&nbsp&nbsp&nbsp<a href='alterar.php?tabela=$tabela&indice=$chave'><img src='_imagens/edit.png' border='0' alt='Editar'></a></td>";                  
              }
              echo "</tr>";
            }
          }                    
          
          //tabela de times
          if ($tabela == 'time') {
            for ($i = 0; $i < $nr; $i++) {
              $chave = mysql_result($ds, $i, 'CHAVE');
              $nome = mysql_result($ds, $i, 'NOME');

              echo "<tr>";
              echo "<td>$chave</td>";
              echo "<td>$nome</td>";
              echo "<td width='100' align=\"center\"><a href='deletar.php?tabela=$tabela&indice=$chave' onClick=\"return confirm('Tem certeza que deseja apagar o registro?')\"><img src='_imagens/delete.png' border='0' title='Apagar'></a>".
                   "&nbsp&nbsp&nbsp<a href='alterar.php?tabela=$tabela&indice=$chave'><img src='_imagens/edit.png' border='0' title='Alterar' alt='Editar'></a>".
                   "&nbsp&nbsp&nbsp<a onclick=\"mostrarJogadores('time".$chave."')\" style=\"cursor: pointer;\"><img src='_imagens/users.png' border='0' width=16 height=16 title='Ver Jogadores'></a></td>";
              echo "</tr>";
              
              //tabela de jogadores
              $sqlJogador = " SELECT J.CHAVE, ".
                            "        J.NOME, ".
                            "        (SELECT COUNT(*) FROM cartao C WHERE C.JOGADOR = J.CHAVE AND COR = 'A') AS AMARELOS, ".
                            "        (SELECT COUNT(*) FROM cartao C WHERE C.JOGADOR = J.CHAVE AND COR = 'V') AS VERMELHOS, ".
                            "        (SELECT COUNT(*) FROM gol G WHERE G.JOGADOR = J.CHAVE AND CONTRA = 'NAO') AS GOLS ".
                            "   FROM jogador J ".
                            "  WHERE J.TIME = ".$chave.
                            " ORDER BY J.NOME, J.CHAVE ";  
          
              $dsJogador = mysql_query($sqlJogador);
              $nrJogador = mysql_num_rows($dsJogador); //número de registros totais
              $csJogador = mysql_num_rows($dsJogador) + 1; //colspan
              
              if ($nrJogador > 0) {
                  echo "<tr><td colspan=3 id=\"time".$chave."\" style=\"display: none;\">";
                  echo "<table width='794' border='0' bgcolor='#DDDDDD' align='right'>";
                  echo "<tr>";
                  echo "<th bgcolor='silver' width=75%></th>";
                  echo "<th bgcolor='silver'><img src='_imagens/ca.png' width='13' height='13'/></th>";
                  echo "<th bgcolor='silver'><img src='_imagens/cv.png' width='13' height='13'/></th>";
                  echo "<th bgcolor='silver'><img src='_imagens/gol.png' width='13' height='13'/></th>";
                  echo "<th bgcolor='silver'>Operações</th>";
                  echo "</tr>";
              }
              
              for ($j = 0; $j < $nrJogador; $j++) {
                $chaveJogador = mysql_result($dsJogador, $j, 'CHAVE');  
                $nomeJogador = mysql_result($dsJogador, $j, 'NOME');
                $cartoesA = mysql_result($dsJogador, $j, 'AMARELOS');
                $cartoesV = mysql_result($dsJogador, $j, 'VERMELHOS');
                $gols = mysql_result($dsJogador, $j, 'GOLS');
                
                echo "<tr>";
                echo "<td>$nomeJogador</td>";
                echo "<td width='50' align='center'>$cartoesA</td>";
                echo "<td width='50' align='center'>$cartoesV</td>";
                echo "<td width='50' align='center'>$gols</td>";
                echo "<td width='100' align=\"center\"><a href='deletar.php?tabela=jogador&indice=$chaveJogador' onClick=\"return confirm('Tem certeza que deseja apagar o registro?')\"><img src='_imagens/delete.png' border='0' title='Apagar'></a>".
                     "&nbsp&nbsp&nbsp<a href='alterar.php?tabela=jogador&indice=$chaveJogador'><img src='_imagens/edit.png' border='0' title='Alterar' alt='Editar'></a></td>";
                echo "</tr>";                
                
              }
              
              if ($nrJogador > 0) {  
                echo "</table>";  
                echo "</td></tr>";  
              }              
              
            }
          }
          
          //tabela de partida
          if ($tabela == 'partida') {
            for ($i = 0; $i < $nr; $i++) {
              $chave = mysql_result($ds, $i, 'CHAVE');
              $mandante = mysql_result($ds, $i, 'TIME_MANDANTE');
              $placarMandante = mysql_result($ds, $i, 'PLACAR_MANDANTE');              
              $visitante = mysql_result($ds, $i, 'TIME_VISITANTE');
              $placarVisitante = mysql_result($ds, $i, 'PLACAR_VISITANTE');
              $grupo = mysql_result($ds, $i, 'GRUPO');
              $confronto = mysql_result($ds, $i, 'CONFRONTO');
              $encerrada = mysql_result($ds, $i, 'ENCERRADA');

              echo "<tr>";
              echo "<td align='center'>"; echo EscreveTime($mandante); echo "</td>";
              echo "<td align='center'>$placarMandante</td>";
              echo "<td align='center'>X</td>";
              echo "<td align='center'>$placarVisitante</td>";              
              echo "<td align='center'>"; echo EscreveTime($visitante); echo "</td>";              
              echo "<td align='center'>"; echo EscreveGrupo($grupo); echo "</td>";
              echo "<td align='center'>"; echo EscreveConfronto($confronto); echo "</td>";
              
              if ($encerrada == 'NAO') {echo "<td align='center'>NÃO</td>";} 
              else {echo "<td align='center'>$encerrada</td>";}
              
              echo "<td width='100' align=\"center\"><a href='deletar.php?tabela=$tabela&indice=$chave' onClick=\"return confirm('Tem certeza que deseja apagar o registro?')\"><img src='_imagens/delete.png' border='0' title='Apagar'></a>&nbsp&nbsp&nbsp<a href='alterar.php?tabela=$tabela&indice=$chave'><img src='_imagens/edit.png' border='0' alt='Editar'></a>&nbsp&nbsp&nbsp<a href='partida.php?partida=$chave'><img src='_imagens/visualizar.jpg' border='0' alt='Editar'></a></td>";
              echo "</tr>";
            }              
          }

          //tabela de historia
          if ($tabela == 'historia') {
            for ($i = 0; $i < $nr; $i++) {
              $chave = mysql_result($ds, $i, 'CHAVE');
              $titulo = mysql_result($ds, $i, 'TITULO');
              $subtitulo = mysql_result($ds, $i, 'SUBTITULO');              

              echo "<tr>";
              echo "<td>$chave</td>";
              echo "<td>$titulo</td>";
              echo "<td>$subtitulo</td>";              
              echo "<td width='100' align=\"center\"><a href='deletar.php?tabela=$tabela&indice=$chave' onClick=\"return confirm('Tem certeza que deseja apagar o registro?')\"><img src='_imagens/delete.png' border='0' title='Apagar'></a>&nbsp&nbsp&nbsp<a href='alterar.php?tabela=$tabela&indice=$chave'><img src='_imagens/edit.png' border='0' alt='Editar'></a></td>";
              echo "</tr>";
            }
          }          
          
          //tabela de historia
          if ($tabela == 'noticia') {
            for ($i = 0; $i < $nr; $i++) {
              $chave = mysql_result($ds, $i, 'CHAVE');
              $titulo = mysql_result($ds, $i, 'TITULO');
              $subtitulo = mysql_result($ds, $i, 'SUBTITULO');              

              echo "<tr>";
              echo "<td>$chave</td>";
              echo "<td>$titulo</td>";
              echo "<td>$subtitulo</td>";              
              echo "<td width='100' align=\"center\"><a href='deletar.php?tabela=$tabela&indice=$chave' onClick=\"return confirm('Tem certeza que deseja apagar o registro?')\"><img src='_imagens/delete.png' border='0' title='Apagar'></a>&nbsp&nbsp&nbsp<a href='alterar.php?tabela=$tabela&indice=$chave'><img src='_imagens/edit.png' border='0' alt='Editar'></a></td>";
              echo "</tr>";
            }
          }             
          
          
          if ($nr < $rp) {
            $pr = $rp - $nr;
            for ($i=1; $i <= $pr; $i++) {
              echo "<tr><td colspan=$cs class='noborder'></td></tr>";
            }
          }

          echo "</table>";
          echo "<table width='800' border='0' align='center'>";
          echo "<tr><td colspan=2 class='noborder'><hr></td></tr>";
          echo "<tr><td class='noborder' colspan=2><p class='tinytext'>";

          if ($tp > 1) {
            echo "Páginas: ";
            for ($i=1; $i<=$tp; $i++) {
              if ($pagina == $i) {
                echo $pagina . " ";
              }
              else {
                echo " <a href=\"listagem.php?tabela=$tabela&pagina=$i\">$i</a> ";
              }
            }
          }

          echo "</p></td></tr>";
          echo "</table>";
          echo "</form>";
        ?>
		</div>
    </body>
</html>

