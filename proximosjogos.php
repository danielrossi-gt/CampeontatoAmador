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
            
            $ds = mysql_query("SELECT TM.NOME MANDANTE, "
                             ."       TV.NOME VISITANTE," 
                             ."       P.DATA, "
                             ."       G.DESCRICAO GRUPO"
                             ."  FROM partida P, time TM, time TV, grupo G, campeonato C"
                             ." WHERE P.TIME_MANDANTE = TM.CHAVE"
                             ."   AND P.TIME_VISITANTE = TV.CHAVE"
                             ."   AND P.GRUPO = G.CHAVE"
                             ."   AND G.CAMPEONATO = C.CHAVE"
                             ."   AND DATE(DATA) >= DATE(SYSDATE())"
                             ."   AND P.ENCERRADA = 'NAO'"
                             ."   AND C.CHAVE = $campeonato"
                             ." ORDER BY DATA, G.DESCRICAO, TM.NOME, TV.NOME", $conn);
            $nr = mysql_num_rows($ds);
            
            echo "<p align='right'><a href=\"principal.php\"><img src=\"_imagens/cancel.jpg\" width=\"16\" height=\"16\" border=\"0\" align='center' valing='top'></a></p>";
            echo "<h3>Próximos jogos do " . EscreveCampeonato($campeonato) . "</h3>";
            
            echo "<table width='100%'>";
            echo "<tr>"
                . "<th width='15%'>Data</th>"
                . "<th width='15%'>Grupo</th>"
                . "<th>Time Mandante</th>"
                . "<th>&nbsp;</th>"                    
                . "<th>Time Visitante</th>"                      
                . "</tr>";                    

            for ($i = 0; $i < $nr; $i++) {
                
                $timeM = mysql_result($ds, $i, "MANDANTE");
                $timeV = mysql_result($ds, $i, "VISITANTE");
                $data = mostraData(mysql_result($ds, $i, "DATA"));                
                $grupo = mysql_result($ds, $i, "GRUPO");                
                
                echo "<tr>"
                    . "<td>$data</td>"
                    . "<td>$grupo</td>"
                    . "<td>$timeM</td>"
                    . "<td align='center'>X</td>"                    
                    . "<td align='left'>$timeV</td>"                      
                    . "</tr>";                    
                
            }

            echo "</table>";            
            
        ?>           
            
        </div>
    </body>
</html>    
        