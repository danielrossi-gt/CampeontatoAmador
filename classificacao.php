<?php
  require_once("_data/session.php");
  include('_data/dm.php');
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gerenciador de Campeonato</title>
        <link href="_css/style.css" rel="stylesheet" type="text/css" />
        <script src="funcoes.js" type="text/javascript"></script> 
    </head>
    <body>
        <div id="partida">
        
        <?php
        
            $campeonato = $_GET["campeonato"];
            mysql_query("CALL CARREGAR_CLASSIFICACAO($campeonato)");
            $ds = mysql_query("SELECT * FROM classificacao ORDER BY GRUPO, PONTOS DESC, SALDO_GOLS DESC, GOLS_MARCADOS DESC, GOLS_SOFRIDOS, TIME");
            $nr = mysql_num_rows($ds);
        
            echo "<p align='right'><a href=\"principal.php\"><img src=\"_imagens/cancel.jpg\" width=\"16\" height=\"16\" border=\"0\" align='center' valing='top'></a></p>";
            echo "<h3>Tabela de Classificação do " . EscreveCampeonato($campeonato) . "</h3>";
            
            echo "<table width='100%'>";
            echo "<tr>"
                . "<th>Posição</th>"
                . "<th>Time</th>"
                . "<th>Pontos Ganhos</th>"
                . "<th>Gols Marcados</th>"                    
                . "<th>Gols Sofridos</th>"                      
                . "<th>Saldo de Gols</th>"                                          
                . "</tr>";            

            $grupoAnterior = "";
            $posicao = 0;
            
            for ($i = 0; $i < $nr; $i++) {
                
                $posicao = $posicao + 1;
                $time = EscreveTime(mysql_result($ds, $i, "TIME"));
                $grupo = mysql_result($ds, $i, "GRUPO");
                $pontos = mysql_result($ds, $i, "PONTOS");
                $golsM = mysql_result($ds, $i, "GOLS_MARCADOS");
                $golsS = mysql_result($ds, $i, "GOLS_SOFRIDOS");                
                $saldo = mysql_result($ds, $i, "SALDO_GOLS");                
                
                if ($grupo != $grupoAnterior) {

                    echo "<tr>"
                        . "<td><h3>$grupo</h3></td>"
                        . "<td></td>"
                        . "<td></td>"
                        . "<td></td>"                    
                        . "<td></td>"                      
                        . "<td></td>"                                          
                        . "</tr>";
                    
                    $grupoAnterior = $grupo;
                    $posicao = 1;
                    
                }
                
                echo "<tr>"
                    . "<td align='center'>$posicao</td>"
                    . "<td>$time</td>"
                    . "<td align='center'>$pontos</td>"
                    . "<td align='center'>$golsM</td>"                    
                    . "<td align='center'>$golsS</td>"                      
                    . "<td align='center'>$saldo</td>"                                          
                    . "</tr>";
                
            }
            
            echo "</table><br/><br/><hr/><br/>";
            
            echo "<h3>Artilharia</h3>";
            
            echo "<table width='100%'>";
            echo "<tr>"
                . "<th>Posição</th>"
                . "<th>Jogador</th>"    
                . "<th>Time</th>"
                . "<th>Gols Marcados</th>"                    
                . "</tr>";                     
        
            $ds = mysql_query("SELECT J.NOME JOGADOR, T.NOME TIME, COUNT(1) GOLS"
                             ."  FROM gol G, jogador J, time T"
                             ." WHERE G.JOGADOR = J.CHAVE"
                             ."   AND J.TIME = T.CHAVE"
                             ."   AND T.CAMPEONATO = $campeonato"
                             ."   AND G.CONTRA = 'NAO'"
                             ." GROUP BY J.NOME, T.NOME"
                             ." ORDER BY GOLS DESC, J.NOME, T.NOME", $conn);
            
            $nr = mysql_num_rows($ds);
            
            for ($i = 0; $i < $nr; $i++) {
                
                $posicao = $i + 1;
                $jogador = mysql_result($ds, $i, "JOGADOR");
                $time = mysql_result($ds, $i, "TIME");
                $gols = mysql_result($ds, $i, "GOLS");                

                echo "<tr>"
                    . "<td>$posicao</td>"
                    . "<td>$jogador</td>"    
                    . "<td>$time</td>"
                    . "<td align='center'>$gols</td>"
                    . "</tr>";                     
                
            }
            
            echo "</table><br/><br/>";   
            
            echo "<h3>Gols Contra</h3>";
            
            echo "<table width='100%'>";
            echo "<tr>"
                . "<th>Posição</th>"
                . "<th>Jogador</th>"    
                . "<th>Time</th>"
                . "<th>Gols Marcados</th>"                    
                . "</tr>";                     
        
            $ds = mysql_query("SELECT J.NOME JOGADOR, T.NOME TIME, COUNT(1) GOLS"
                             ."  FROM gol G, jogador J, time T"
                             ." WHERE G.JOGADOR = J.CHAVE"
                             ."   AND J.TIME = T.CHAVE"
                             ."   AND T.CAMPEONATO = $campeonato"
                             ."   AND G.CONTRA = 'SIM'"
                             ." GROUP BY J.NOME, T.NOME"
                             ." ORDER BY GOLS DESC, J.NOME, T.NOME", $conn);
            
            $nr = mysql_num_rows($ds);
            
            for ($i = 0; $i < $nr; $i++) {
                
                $posicao = $i + 1;
                $jogador = mysql_result($ds, $i, "JOGADOR");
                $time = mysql_result($ds, $i, "TIME");
                $gols = mysql_result($ds, $i, "GOLS");                

                echo "<tr>"
                    . "<td>$posicao</td>"
                    . "<td>$jogador</td>"    
                    . "<td>$time</td>"
                    . "<td align='center'>$gols</td>"
                    . "</tr>";                     
                
            }
            
            echo "</table><br/><br/>";            
            
        ?>
    </div>        
    </body>
</html>    

