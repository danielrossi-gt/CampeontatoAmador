<?php
    require_once("_data/session.php");
    require_once('_conn/conn.php');
    include('_data/dm.php');  
    
    if (isset($_GET["gol"])) {
        $jogador = $_GET["gol"];
        $partida = $_GET["partida"];
        $mandante = $_GET["mandante"];
        $contra = $_GET["contra"];
        mysql_query("CALL GOL($partida, $jogador, '$mandante', '$contra')");
        header("Location: partida.php?partida=$partida");
    }
    
    if (isset($_GET["ca"])) {
        $jogador = $_GET["ca"];
        $partida = $_GET["partida"];
        $cor = $_GET["cor"];
        mysql_query("CALL CARTAO($partida, $jogador, '$cor')");
        header("Location: partida.php?partida=$partida");
    }
    
    if (isset($_GET["cv"])) {
        $jogador = $_GET["cv"];
        $partida = $_GET["partida"];
        $cor = $_GET["cor"];
        mysql_query("CALL CARTAO($partida, $jogador, '$cor')");
        header("Location: partida.php?partida=$partida");
    }
    
    if (isset($_GET["xgol"])) {
        $gol = $_GET["xgol"];
        $partida = $_GET["partida"];
        $contra = $_GET["contra"];
        
        mysql_query("DELETE FROM gol WHERE CHAVE = $gol", $conn);
        
        if ($contra == 'NAO') {
        
            if ($_GET["mandante"] == 'SIM') {
              mysql_query("UPDATE partida SET PLACAR_MANDANTE = PLACAR_MANDANTE - 1 WHERE CHAVE = $partida");
            }
            else {
              mysql_query("UPDATE partida SET PLACAR_VISITANTE = PLACAR_VISITANTE - 1 WHERE CHAVE = $partida");            
            }
            
        }
        else {
            
            if ($_GET["mandante"] == 'SIM') {
              mysql_query("UPDATE partida SET PLACAR_VISITANTE = PLACAR_VISITANTE - 1 WHERE CHAVE = $partida");
            }
            else {
              mysql_query("UPDATE partida SET PLACAR_MANDANTE = PLACAR_MANDANTE - 1 WHERE CHAVE = $partida");            
            }
            
        }
            
        header("Location: partida.php?partida=$partida");
    }
    
    if (isset($_GET["xcartao"])) {
        $cartao = $_GET["xcartao"];
        $partida = $_GET["partida"];
        mysql_query("DELETE FROM cartao WHERE CHAVE = $cartao", $conn);
        header("Location: partida.php?partida=$partida");        
    }
    
    if (isset($_POST["sumula"])) {
        $partida = $_POST["partida"];
        $sumula = $_POST["sumula"];
        $encerrada = $_POST["chkenc"];
        
        /*
        if ($_POST["encerrada"] == "encerrada") {
            $encerrada = "SIM";
        }
        else {
            $encerrada = "NAO";
        }
         */
        
        //echo "UPDATE PARTIDA SET OBSERVACAO = $sumula WHERE CHAVE = $partida";
        mysql_query("UPDATE partida SET OBSERVACAO = '$sumula', ENCERRADA = '$encerrada' WHERE CHAVE = $partida");                    
        header("Location: partida.php?partida=$partida&confirma=SIM");                
    }
    
?>

<html>
    <head>
        <title>Gerenciador de Campeonatos</title>
		<meta charset="UTF-8"/>
        <link href="_css/style.css" rel="stylesheet" type="text/css" />
        <script src="funcoes.js" type="text/javascript"></script>
		
        
        <?php
        
          if (isset($_GET["confirma"])) {
              
              echo "<SCRIPT LANGUAGE='JavaScript' TYPE='text/javascript'>"
                   ."alert ('Súmula gravada com sucesso.')"
                   ."</SCRIPT>";
          }
        
        ?>
        
    </head>
    <body>
        <div id="partida">
			<p align='right'><a href="principal.php"><img src="_imagens/cancel.jpg" width="16" height="16" border="0" align='center' valing='top'></a></p>
            <table width='800' border='0' align='center'>
                <tr><td colspan="5" align="center" ><h3>Manutenção de Partida</h3></td></tr>
                <tr bgcolor='silver'>
                    <th align="right" width="270">Time Mandante</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th width="270">Time Visitante</th>
                </tr>
                
                <?php
                    $partida = $_GET["partida"];
                    $dsp = Dataset("partida", "CHAVE = $partida", "");
                    
                    $timeM = mysql_result($dsp, 0, "TIME_MANDANTE");
                    $placarM = mysql_result($dsp, 0, "PLACAR_MANDANTE");
                    $timeV = mysql_result($dsp, 0, "TIME_VISITANTE");
                    $placarV = mysql_result($dsp, 0, "PLACAR_VISITANTE");
                    $observacao = mysql_result($dsp, 0, "OBSERVACAO");
                    $encerrada = mysql_result($dsp, 0, "ENCERRADA");
                    $nomeM = EscreveTime($timeM);
                    $nomeV = EscreveTime($timeV);
                
                    echo "<tr>"
                       . "<td align='center'>$nomeM</td><td align='center'>$placarM</td><td align='center'>X</td><td align='center'>$placarV</td><td align='center'>$nomeV</td>"
                       . "</tr>";
                    
                ?>
                
                <tr bgcolor='silver'><th align="right">Jogadores</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>Jogadores</th>
                </tr>            
                
                <?php
                
                    $dsm = Dataset("jogador", "TIME = $timeM", "NOME");
                    $nrm = mysql_num_rows($dsm);
                    $dsv = Dataset("jogador", "TIME = $timeV", "NOME");
                    $nrv = mysql_num_rows($dsv);
                    
                    $nr = max($nrm, $nrv);
                    
                    for ($i = 0; $i < $nr ; $i++) {
                        
                        if ($i < $nrm) {
                            $chaveJogM = mysql_result($dsm, $i, "CHAVE");
                            $jogadorM = mysql_result($dsm, $i, "NOME");
                        }
                        else {
                            $chaveJogM = 0;
                            $jogadorM = "";
                        }
                        
                        if ($i < $nrv) {
                            $chaveJogV = mysql_result($dsv, $i, "CHAVE");
                            $jogadorV = mysql_result($dsv, $i, "NOME");
                        }
                        else {
                            $jogadorV = "";
                            $chaveJogV = 0;
                        }
                        
                        if ($jogadorM != "") {
                            echo "<tr>"
                                    . "<td>$jogadorM</td><td align='center'>"
                                    . "<a href='partida.php?gol=$chaveJogM&partida=$partida&mandante=SIM&contra=NAO' onClick=\"return confirm('Confirma gol para ".$jogadorM."?')\">"
                                    . "<img src='_imagens/gol.png' width='20' height='20'/></a> "
                                    . "<a href='partida.php?gol=$chaveJogM&partida=$partida&mandante=SIM&contra=SIM' onClick=\"return confirm('Confirma gol CONTRA para ".$jogadorM."?')\">"
                                    . "<img src='_imagens/golc.png' width='20' height='20'/></a> "
                                    . "<a href='partida.php?ca=$chaveJogM&partida=$partida&cor=A' onClick=\"return confirm('Confirma cartão amarelo para ".$jogadorM."?')\">"
                                    . "<img src='_imagens/ca.png' width='20' height='20'/></a> "
                                    . "<a href='partida.php?cv=$chaveJogM&partida=$partida&cor=V' onClick=\"return confirm('Confirma cartão vermelho para ".$jogadorM."?')\">"
                                    . "<img src='_imagens/cv.png' width='20' height='20'/></a> ";
                        }
                        else {
                            echo /*"<tr>"
                                . */"<td>&nbsp;</td><td align='center'>"
                                . "&nbsp;";
                        }
                        
                        echo "</td><td align='center'>&nbsp;</td><td align='center'>";
                        
                        if ($jogadorV != "") {
                            
                            echo "<a href='partida.php?gol=$chaveJogV&partida=$partida&mandante=NAO&contra=NAO' onClick=\"return confirm('Confirma gol para ".$jogadorV."?')\">"
                                    . "<img src='_imagens/gol.png' width='20' height='20'/></a> "
                                    . "<a href='partida.php?gol=$chaveJogV&partida=$partida&mandante=NAO&contra=SIM' onClick=\"return confirm('Confirma gol CONTRA para ".$jogadorV."?')\">"
                                    . "<img src='_imagens/golc.png' width='20' height='20'/></a> "                                    
                                    . "<a href='partida.php?ca=$chaveJogV&partida=$partida&cor=A' onClick=\"return confirm('Confirma cartão amarelo para ".$jogadorV."?')\">"
                                    . "<img src='_imagens/ca.png' width='20' height='20'/></a> "
                                    . "<a href='partida.php?cv=$chaveJogV&partida=$partida&cor=V' onClick=\"return confirm('Confirma cartão vermelho para ".$jogadorV."?')\">"
                                    . "<img src='_imagens/cv.png' width='20' height='20'/></a> "
                                    . "</td><td>$jogadorV</td>";
                        }
                        else {
                            echo "</td><td>&nbsp;</td>";
                        }

                        echo "</tr>";
                        
                    }
                    
                    echo "<tr bgcolor='silver'>"
                        ."<th align='right'>Gols</th>"
                        ."<th>&nbsp;</th>"
                        ."<th>&nbsp;</th>"
                        ."<th>&nbsp;</th>"
                        ."<th>Gols</th>"
                        ."</tr>";

                    $gols = mysql_query("SELECT G.CHAVE CHAVE_GOL, J.CHAVE CHAVE_JOGADOR, G.CONTRA,"
                                       ."       J.NOME "
                                       ."  FROM gol G, jogador J"
                                       ." WHERE G.JOGADOR = J.CHAVE"
                                       ."   AND G.PARTIDA = " . $partida
                                       ."   AND J.TIME = " . $timeM, $conn);
                    
                    $numgols = mysql_num_rows($gols);
                    
                    echo "<tr><td align='left' valign='top'>";
                        
                    for ($i = 0; $i < $numgols; $i++) {
                        $jogador = mysql_result($gols, $i, "NOME");
                        $chaveGol = mysql_result($gols, $i, "CHAVE_GOL");
                        $contra = "";
                        if (mysql_result($gols, $i, "CONTRA") == 'SIM')
                        {
                            $contra = "(C)";
                        }
                        echo "$jogador $contra"; 
                        echo " <a href='partida.php?xgol=$chaveGol&partida=$partida&mandante=SIM&contra=".mysql_result($gols, $i, "CONTRA")."' onClick=\"return confirm('Confirma exclusão deste gol de ".$jogador."?')\"><img src='_imagens/menos.png' width='10' height='10'></a><br/>";
                    }
                    
                        
                    echo "</td><td>&nbsp;</td>"
                        ."<td>&nbsp;</td>"
                        ."<td>&nbsp;</td>";
                         
                    $gols = mysql_query("SELECT G.CHAVE CHAVE_GOL, J.CHAVE CHAVE_JOGADOR, G.CONTRA,"
                                       ."       J.NOME "
                                       ."  FROM gol G, jogador J"
                                       ." WHERE G.JOGADOR = J.CHAVE"
                                       ."   AND G.PARTIDA = " . $partida
                                       ."   AND J.TIME = " . $timeV, $conn);
                    
                    $numgols = mysql_num_rows($gols);
                    
                    echo "<td align='right' valign='top'>";
                        
                    for ($i = 0; $i < $numgols; $i++) {
                        $jogador = mysql_result($gols, $i, "NOME");
                        $chaveGol = mysql_result($gols, $i, "CHAVE_GOL");
                        $contra = "";
                        if (mysql_result($gols, $i, "CONTRA") == 'SIM')
                        {
                            $contra = "(C)";
                        }
                        echo "<a href='partida.php?xgol=$chaveGol&partida=$partida&mandante=NAO&contra=".mysql_result($gols, $i, "CONTRA")."' onClick=\"return confirm('Confirma exclusão deste gol de ".$jogador."?')\">";
                        echo "<img src='_imagens/menos.png' width='10' height='10'></a> $jogador $contra<br/>";
                    }
                    
                    echo "</td>"
                        ."</tr>";
                    
                    echo "<tr bgcolor='silver'>"
                        ."<th align='right'>Cartões</th>"
                        ."<th>&nbsp;</th>"
                        ."<th>&nbsp;</th>"
                        ."<th>&nbsp;</th>"
                        ."<th>Cartões</th>"
                        ."</tr>";
                    
                    $cartoes = mysql_query("SELECT C.CHAVE CHAVE_CARTAO, J.CHAVE CHAVE_JOGADOR,"
                                       ."       J.NOME,"
                                       ."       C.COR "
                                       ."  FROM cartao C, jogador J"
                                       ." WHERE C.JOGADOR = J.CHAVE"
                                       ."   AND C.PARTIDA = " . $partida
                                       ."   AND J.TIME = " . $timeM, $conn);
                    
                    $numcartoes = mysql_num_rows($cartoes);
                    
                    echo "<tr><td align='left' valign='top'>";
                        
                    for ($i = 0; $i < $numcartoes; $i++) {
                        $chaveCartao = mysql_result($cartoes, $i, "CHAVE_CARTAO");
                        $jogador = mysql_result($cartoes, $i, "NOME");
                        $cor = mysql_result($cartoes, $i, "COR");
                        echo "$jogador ($cor) ";
                        echo " <a href='partida.php?xcartao=$chaveCartao&partida=$partida' onClick=\"return confirm('Confirma exclusão deste cartão de ".$jogador."?')\"><img src='_imagens/menos.png' width='10' height='10'></a><br/>";
                    }
                        
                    echo "</td><td>&nbsp;</td>"
                        ."<td>&nbsp;</td>"
                        ."<td>&nbsp;</td>";
                         
                    $cartoes = mysql_query("SELECT C.CHAVE CHAVE_CARTAO, J.CHAVE CHAVE_JOGADOR,"
                                       ."       J.NOME,"
                                       ."       C.COR "
                                       ."  FROM cartao C, jogador J"
                                       ." WHERE C.JOGADOR = J.CHAVE"
                                       ."   AND C.PARTIDA = " . $partida
                                       ."   AND J.TIME = " . $timeV, $conn);
                    
                    $numcartoes = mysql_num_rows($cartoes);
                    
                    echo "<td align='right' valign='top'>";
                        
                    for ($i = 0; $i < $numcartoes; $i++) {
                        $chaveCartao = mysql_result($cartoes, $i, "CHAVE_CARTAO");
                        $jogador = mysql_result($cartoes, $i, "NOME");
                        $cor = mysql_result($cartoes, $i, "COR");
                        echo "<a href='partida.php?xcartao=$chaveCartao&partida=$partida' onClick=\"return confirm('Confirma exclusão deste cartão de ".$jogador."?')\"><img src='_imagens/menos.png' width='10' height='10'></a> ";
                        echo "($cor) $jogador <br/>";
                    }
                    
                    echo "</td>"
                        ."</tr>";
                    
                    
                    
                ?>
                
            </table>
            <br/><br/>
            <form name="frmSumula" method="post" action="partida.php">
                
                <input type="hidden" name="partida" value="<?php echo $partida;?>">
                
                <b>Súmula:</b><br>
                <textarea name="sumula" cols="80" rows="8" onKeyDown="contacaracter(this.form.sumula,this.form.remLen,255);" onKeyUp="contacaracter(this.form.sumula,this.form.remLen,255);"><?php echo $observacao; ?></textarea>
                <br>
                Caracteres disponíveis: &nbsp;<input readonly type=text name=remLen size=3 maxlength=3 value="<?php $tam = 255 - strlen($observacao); echo $tam; ?>"></font>
                <br/><br/>
                <input type="hidden" name="chkenc" value="NAO" />
                <input type="checkbox" name="chkenc" value="SIM" <?php if ($encerrada == 'SIM') {echo "checked";}  ?>/>Partida Encerrada
                <br/><br/>
                <input type="submit" value="Gravar">
            </form>
            
        </div>
    </body>
</html>
        