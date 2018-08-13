    <?php 
    
            $pagina = $_SERVER ['REQUEST_URI'];
            
            if (strpos($pagina, '&')) {
              $pagina = substr($pagina, 0, strpos($pagina, '&'));
            }
    
            if (!isset($_GET["rodada"])) {
       
                //rodada atual
                $ra = mysql_query("SELECT DISTINCT C.*, DATE_FORMAT(P.DATA, '%d/%m/%Y') DATAP, DATE_FORMAT(P.DATA, '%w') DIA".
                                  "  FROM partida P, confronto C".
                                  " WHERE P.CONFRONTO = C.CHAVE".
                                  "   AND P.DATA >= SYSDATE() /*DATE_FORMAT(SYSDATE(), '%d/%m/%Y')*/ ".
                                  " ORDER BY DATA " .
                                  " LIMIT 1");
                
                $ra_chave = mysql_result($ra, 0, "CHAVE");
                $ra_desc = mysql_result($ra, 0, "DESCRICAO");
                $ra_data = mysql_result($ra, 0, "DATAP");
                $ra_dia = mysql_result($ra, 0, "DIA");                 
                
                //rodada anterior 
                $data = gravaData($ra_data);
                $rant = mysql_query("SELECT DISTINCT C.CHAVE
                                       FROM partida P, confronto C
                                      WHERE P.CONFRONTO = C.CHAVE
                                        /*AND P.DATA < '$data'*/
                                        AND C.CHAVE < $ra_chave
                                      ORDER BY DATA
                                      LIMIT 1");
                if (mysql_num_rows($rant) > 0) {
                  $rant_chave = mysql_result($rant, 0, "CHAVE");
                }
                else {
                  $rant_chave = 0;  
                }
                
                //rodada posterior
                $data = gravaData($ra_data);
                $rpos = mysql_query("SELECT DISTINCT C.CHAVE
                                       FROM partida P, confronto C
                                      WHERE P.CONFRONTO = C.CHAVE
                                        AND P.DATA > '$data'
                                        AND C.CHAVE <> $ra_chave
                                      ORDER BY DATA
                                      LIMIT 1");

                if (mysql_num_rows($rpos) > 0) {
                  $rpos_chave = mysql_result($rpos, 0, "CHAVE");
                }
                else {
                    $rpos_chave = 0;
                }
                
            }
            else {
                
                $ra_chave = $_GET["rodada"];
                
                $ra = mysql_query("SELECT DISTINCT C.*, DATE_FORMAT(P.DATA, '%d/%m/%Y') DATAP, DATE_FORMAT(P.DATA, '%w') DIA
                                     FROM partida P, confronto C
                                    WHERE P.CONFRONTO = C.CHAVE
                                      AND C.CHAVE = $ra_chave
                                    ORDER BY DATA
                                    LIMIT 1");
                
                $ra_desc = mysql_result($ra, 0, "DESCRICAO");
                $ra_data = mysql_result($ra, 0, "DATAP");
                $ra_dia = mysql_result($ra, 0, "DIA");                 
                
                //rodada anterior 
                $data = gravaData($ra_data);
                $rant = mysql_query("SELECT MAX(C.CHAVE) CHAVE
                                       FROM partida P, confronto C
                                      WHERE P.CONFRONTO = C.CHAVE
                                        /*AND P.DATA < '$data'*/
                                        AND C.CHAVE < $ra_chave");
                
                if (mysql_num_rows($rant) > 0) {
                  $rant_chave = mysql_result($rant, 0, "CHAVE");
                }
                else {
                  $rant_chave = 0;  
                }                
                
                //rodada posterior
                $data = gravaData($ra_data);
                $rpos = mysql_query("SELECT MIN(C.CHAVE) CHAVE
                                       FROM partida P, confronto C
                                      WHERE P.CONFRONTO = C.CHAVE
                                        AND P.DATA > '$data'
                                        AND C.CHAVE <> $ra_chave");

                if (mysql_num_rows($rpos) > 0) {
                  $rpos_chave = mysql_result($rpos, 0, "CHAVE");
                }
                else {
                    $rpos_chave = 0;
                }
                
            }
            /*
            switch ($ra_dia) {
                case 0 : 
                    $ra_diasem = "DOMINGO";
                    break;
                case 1 : 
                    $ra_diasem = "SEGUNDA";
                    break;
                case 2 : 
                    $ra_diasem = "TERÇA";
                    break;
                case 3 : 
                    $ra_diasem = "QUARTA";
                    break;
                case 4 : 
                    $ra_diasem = "QUINTA";
                    break;
                case 5 : 
                    $ra_diasem = "SEXTA";
                    break;
                case 6 : 
                    $ra_diasem = "SÁBADO";
                    break;
            } 
             */  
            
    ?>      
      
    <div id="bg_jogos">
      <div id="topo_jogos">
        JOGOS
      </div>

        <?php 
        
            $ds_data = mysql_query("SELECT DISTINCT DATE_FORMAT(DATA, '%d/%m/%Y') DATA_RODADA, DATE_FORMAT(DATA, '%w') DIA FROM partida WHERE CONFRONTO = $ra_chave");
            $nr_data = mysql_num_rows($ds_data);
            
            for ($dr=0;$dr < $nr_data; $dr++) {

                echo "<div id='topo_rodada'>";
                
                $ra_dia = mysql_result($ds_data, $dr, "DIA");
                $ra_data = mysql_result($ds_data, $dr, "DATA_RODADA");
                
                switch ($ra_dia) {
                    case 0 : 
                        $ra_diasem = "DOMINGO";
                        break;
                    case 1 : 
                        $ra_diasem = "SEGUNDA";
                        break;
                    case 2 : 
                        $ra_diasem = "TERÇA";
                        break;
                    case 3 : 
                        $ra_diasem = "QUARTA";
                        break;
                    case 4 : 
                        $ra_diasem = "QUINTA";
                        break;
                    case 5 : 
                        $ra_diasem = "SEXTA";
                        break;
                    case 6 : 
                        $ra_diasem = "SÁBADO";
                        break;
                }           
        
                if ($rant_chave != 0) {
					
                  if (strpos($pagina, "?")) {
					  $pos = 1;	
                      echo "<a href='$pagina&rodada=$rant_chave'><div id='seta_esquerda'></div></a>";
                  }
                  else {
					  $pos = 2;	
                      echo "<a href='$pagina?rodada=$rant_chave'><div id='seta_esquerda'></div></a>";                
                  }
                }
                else {
                    echo "<div id='seta_esqueda'></div>";              
                }
                echo "$ra_desc – $ra_data – $ra_diasem";

                if ($rpos_chave != 0) {
                  if (strpos($pagina, "?")) {
                    echo "<a href='$pagina&rodada=$rpos_chave'><div id='seta_direita'></div></a>";
                  }
                  else {
                    echo "<a href='$pagina?rodada=$rpos_chave'><div id='seta_direita'></div></a>";                
                  }

                }
                else {
                  echo "<div id='seta_direita'></div>";  
                }

                
          
        ?>
        
      </div> 
      <div id="conteudo_jogo">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px solid #CCCCCC;">
          <tr>
            <td colspan="6" align="center" valign="middle" width="300">&nbsp;</td>
            <td align="center" valign="middle" width="40">Divisão</td>
          </tr>
            
          <?php

          
          
            $dsLocal = mysql_query("SELECT DISTINCT E.CHAVE, E.DESCRICAO LOCAL FROM partida P, estadio E WHERE P.ESTADIO = E.CHAVE AND P.CONFRONTO = $ra_chave AND DATE_FORMAT(P.DATA, '%d/%m/%Y') = '$ra_data'");
            $nrLocal = mysql_num_rows($dsLocal);
            
            for ($l=0;$l<$nrLocal;$l++) {
              $estadio = mysql_result($dsLocal, $l, "CHAVE");          
              $local = mysql_result($dsLocal, $l, "LOCAL");          
              
              
          ?>
            
            
          <tr height="40" >
            <td colspan="7" align="center" valign="middle" style="font-size:14px; font-weight:bolder;"><?php echo $local ?></td>
          </tr>
          
          <?php
          
                $dsJogos = mysql_query("SELECT DATE_FORMAT(P.DATA, '%H:%i') HORARIO,
                                               TM.NOME MANDANTE,
                                               P.PLACAR_MANDANTE,
                                               TV.NOME VISITANTE,
                                               P.PLACAR_VISITANTE,
                                               CONCAT_WS(' ', S.DESCRICAO, G.DESCRICAO) DIVISAO,
                                               ENCERRADA
                                          FROM partida P, time TM, time TV, grupo G, serie S
                                         WHERE P.TIME_MANDANTE = TM.CHAVE
                                           AND P.TIME_VISITANTE = TV.CHAVE
                                           AND P.GRUPO = G.CHAVE
                                           AND G.SERIE = S.CHAVE
                                           AND P.CONFRONTO = $ra_chave 
                                           AND DATE_FORMAT(P.DATA, '%d/%m/%Y') = '$ra_data'
                                           AND P.ESTADIO = '$estadio'
                                         ORDER BY HORARIO");
          
                 $nrJogos = mysql_num_rows($dsJogos);
          
                for ($p=0;$p<$nrJogos;$p++) {
                    
                    $horario = mysql_result($dsJogos, $p, "HORARIO");
                    $timeM = mysql_result($dsJogos, $p, "MANDANTE");
                    $placarM = mysql_result($dsJogos, $p, "PLACAR_MANDANTE");
                    $timeV = mysql_result($dsJogos, $p, "VISITANTE");
                    $placarV = mysql_result($dsJogos, $p, "PLACAR_VISITANTE");
                    $divisao = mysql_result($dsJogos, $p, "DIVISAO");
                    $encerrada = mysql_result($dsJogos, $p, "ENCERRADA");
                
          ?>
            
          <tr height="20" >
            <td align="center" valign="middle" width="20"><?php echo $horario; ?></td>
            <td align="center" valign="middle" width="145"><?php echo $timeM; ?></td>
            <td align="center" valign="middle" width="10"><?php if ($encerrada == "SIM") { echo $placarM; } else { echo "&nbsp;";} ?></td>
            <td align="center" valign="middle" width="10">X</td>
            <td align="center" valign="middle" width="10"><?php if ($encerrada == "SIM") { echo $placarV; } else { echo "&nbsp;";} ?></td>
            <td align="center" valign="middle" width="145"><?php echo $timeV; ?></td>
            <td align="center" valign="middle" width="40"><?php echo $divisao ?></td>
          </tr>
          
          <?php
          
                }
          
            }
            
                if ($dr == 0) {
                    echo "</table><!--</div>-->";
                }
                else {
                    echo "</table>";
                }
            }
          ?>

