<?php
  require_once("_data/session.php");
  $tabela = $_GET['tabela'];  
?>

<html>
    <head>
        <title>Gerenciador de Campeonatos</title>
		<meta charset="UTF-8">

        <?php
          if ($tabela == "historia" or $tabela == "noticia" or $tabela == "time") {
              echo "<link href='_css/style_1.css' rel='stylesheet' type='text/css' />";
          }
          else {
              echo "<link href='_css/style.css' rel='stylesheet' type='text/css' />";
          }
        ?>
        <script type="text/javascript" src="tinymce/tinymce.min.js"></script> 
        <script type="text/javascript">
        tinymce.init({
            menubar : false,
            language : 'pt_BR',
            selector: "textarea"
         });
        </script>                  

        <script src="funcoes.js" type="text/javascript"></script>
        <script src="ajax.js" type="text/javascript"></script>
    </head>
    <body>
        <div>

        <?php

            require_once('_conn/conn.php');
            include('_data/dm.php');

            $indice = $_GET['indice'];

            $SQL = " SELECT COLUMN_NAME, COLUMN_COMMENT, EXTRA, DATA_TYPE,             ".
                   "        CHARACTER_MAXIMUM_LENGTH, NUMERIC_PRECISION, NUMERIC_SCALE ".
                   "   FROM INFORMATION_SCHEMA.COLUMNS                                 ".
                   "  WHERE TABLE_NAME = '$tabela'                                     ".
                   "   AND TABLE_SCHEMA = '$database'                                  ".
                   " ORDER BY ORDINAL_POSITION                                         ";

            $ds = mysql_query($SQL);
            $nr = mysql_num_rows($ds);

            echo "<form name='frmCadastro' action='upd$tabela.php' method='post' enctype='multipart/form-data'>";
            echo "<input type='hidden' id='CHAVE' name='CHAVE' value='$indice'>";
            echo "<table width='100%' border='0' align='center'>";
            echo "<tr><td colspan='2'><h3>Manutenção de "; EscreveTabela($tabela); echo "</h3></td>";
            echo "<td valign='top'><a href=\"principal.php\"><img src=\"_imagens/cancel.jpg\" width=\"16\" height=\"16\" border=\"0\" align='center' valing='top'></a>";
            echo "</td></tr>";
          
            for ($i = 1; $i < $nr; $i ++) {

                $gerado = 0;

                $colnam = mysql_result($ds, $i, 'COLUMN_NAME');
                $descri = mysql_result($ds, $i, 'COLUMN_COMMENT');
                $fextra = mysql_result($ds, $i, 'EXTRA');
                $dattyp = mysql_result($ds, $i, 'DATA_TYPE');
                $chrmax = mysql_result($ds, $i, 'CHARACTER_MAXIMUM_LENGTH');
                $nummax = mysql_result($ds, $i, 'NUMERIC_PRECISION');
                $numprc = mysql_result($ds, $i, 'NUMERIC_SCALE');

                $reg = "SELECT $colnam FROM $tabela WHERE CHAVE = $indice";
                $dsreg = mysql_query($reg);
                $value = mysql_result($dsreg, 0, 0);

                //Se não for campo auto-increment
                if (($fextra == '') && ($colnam != 'TIME') && ($colnam != 'CAMPEONATO') && ($colnam != 'TEXTO') && ($colnam != 'PLACAR_VISITANTE') && 
				    ($colnam != 'PLACAR_MANDANTE')  && ($colnam != 'ENCERRADA') && ($colnam != "HISTORICO")) {

                    //Label do campo
                    if ($tabela == 'usuario' && $descri == 'Senha') {
                        echo "<tr><td width=100 align='right'>$descri Atual:</td>";                                                
                    } elseif ($tabela == 'jogador' && $descri == 'Data Nascimento') {
                        echo "<tr><td width=100 align='right'>Data Nasc.:</td>";                        
                    } else {
                        echo "<tr><td width=100 align='right'>$descri:</td>";                        
                    }

                    //Campos específicos
                    if ($colnam == "SERIE") {

                        echo "<td><select id='$colnam' name='$colnam'>";
                        EscreveSerie($value, 2);
                        echo "</select>";                                            
                        $gerado = 1;

                    }

                    if ($descri == "Categoria") {

                        echo "<td><select id='$colnam' name='$colnam'>";
                        EscreveCategoria($value, 2);
                        echo "</select>";                                            
                        $gerado = 1;

                    }                                        

                    //Campos normais
                    //Campo de Estado
                    if ($descri == 'Estado') {
                        echo "<td>
                                  <select name='$colnam' id='$colnam' name='$colnam' value='$value'>
                                  <option>Selecione...</option>";

                        EscreveEstado('AC', $value);
                        EscreveEstado('AL', $value);
                        EscreveEstado('AP', $value);
                        EscreveEstado('AM', $value);
                        EscreveEstado('BA', $value);
                        EscreveEstado('CE', $value);
                        EscreveEstado('ES', $value);
                        EscreveEstado('DF', $value);
                        EscreveEstado('MA', $value);
                        EscreveEstado('MT', $value);
                        EscreveEstado('MS', $value);
                        EscreveEstado('MG', $value);
                        EscreveEstado('PA', $value);
                        EscreveEstado('PB', $value);
                        EscreveEstado('PR', $value);
                        EscreveEstado('PE', $value);
                        EscreveEstado('PI', $value);
                        EscreveEstado('RJ', $value);
                        EscreveEstado('RS', $value);
                        EscreveEstado('RO', $value);
                        EscreveEstado('RR', $value);
                        EscreveEstado('SC', $value);
                        EscreveEstado('SP', $value);
                        EscreveEstado('SE', $value);
                        EscreveEstado('TO', $value);

                        echo "</select>
                                  </td>
                              </tr>";
                        $gerado = 1;
                    }

                    //Campo CEP
                    if (($dattyp == 'varchar') && ($descri == 'CEP') && ($gerado == 0)) {
                        echo "<td><input type='text' id='$colnam' name='$colnam' size='$chrmax' maxlength='$chrmax' value='$value' onkeypress=\"formatar_mascara(this, '##.###-###')\"> <i>Somente números</i></td></tr>";
                        $gerado = 1;
                    }

                    //Campo Telefone
                    if (($dattyp == 'varchar') && ($descri == 'Telefone') && ($gerado == 0)) {
                        echo "<td><input type='text' id='$colnam' name='$colnam' size='$chrmax' maxlength='$chrmax' value='$value' onkeypress=\"formataTel(event)\"> <i>Somente números</i></td></tr>";
                        $gerado = 1;
                    }

                    //Campo Senha
                    if (($dattyp == 'varchar') && ($descri == 'Senha') && ($gerado == 0)) {
                        if ($tabela == 'usuario') {
                            echo "<td><input type='text' id='$colnam' name='$colnam' size='$chrmax' maxlength='$chrmax'></td></tr>";                                                        
                        } else {
                            echo "<td><input type='text' id='$colnam' name='$colnam' size='$chrmax' maxlength='$chrmax'></td></tr>";                            
                        }
                    }

                    //Campo Varchar
                    if (($dattyp == 'varchar') && ($descri != 'Senha') && ($gerado == 0)  && ($descri != 'Encerrada')) {
                        $maxsiz = $chrmax;
                        if ($chrmax > 50) { $maxsiz = 50; }
                        
                        if ($tabela == 'usuario' && $descri == 'E-mail') {
                            echo "<td><input type='text' id='$colnam' name='$colnam' size='$maxsiz' maxlength='$chrmax' value='$value' onblur=\"enviaAltera('validausuario.php', 'POST', false, ".$indice.");\"></td></tr>";                                                        
                        } else {
                            echo "<td><input type='text' id='$colnam' name='$colnam' size='$maxsiz' maxlength='$chrmax' value='$value'></td></tr>";                            
                        }
                    }

                    //Campo Date
                    if (($dattyp == 'date') && ($gerado == 0)) {

                        $maxsiz = $chrmax;
                        if ($chrmax > 50) { $maxsiz = 50; }
                        $data = date('d/m/Y', strtotime($value));

                        echo "<td><input type='text' id='$colnam' name='$colnam' size='$maxsiz' maxlength='$chrmax' value='$data' OnKeyUp=\"mascara_data_hora(this.value)\"></td></tr>";
                    }
                    
                    //Campo DateTime
                    if (($dattyp == 'datetime') && ($gerado == 0)) {

                        $maxsiz = $chrmax;
                        if ($chrmax > 50) { $maxsiz = 50; }
                        
                        $data = date('d/m/Y h:i', strtotime($value));

                        echo "<td><input type='text' id='$colnam' name='$colnam' size='$maxsiz' maxlength='$chrmax' value='$data' OnKeyUp=\"mascara_data_hora(this.value)\"></td></tr>";
                    }                    

                    //Campo Integer
                    if (($dattyp == 'int') && ($gerado == 0) && $colnam != 'ESTADIO' && $colnam != 'TIME_MANDANTE' && $colnam != 'TIME_VISITANTE' && 
                            $colnam != 'GRUPO' && $colnam != 'CONFRONTO' && ($colnam != 'PLACAR_VISITANTE') && ($colnam != 'PLACAR_MANDANTE')) {
                        echo "<td><input type='text' id='$colnam' name='$colnam' size='$nummax' maxlength='$nummax' value='$value'></td></tr>";
                    }
                }
                
                if ($tabela == "historia" && $descri == "Texto") {

                    echo "<tr>
                                <td width=120 align='right'>Texto:</td>
                                <td><textarea name='TEXTO' cols='80' rows='8'>$value</textarea></td>
                            </tr>"; 

                    echo "<tr>
                              <td width=120 align='right'>Imagem:</td>
                              <td>
                              <br/>
                                <img src='_imagens/_noticias/$indice.jpg'/ width='100%'><br/></td></tr>
                              <tr><td></td>      
                              <td>
                                <input type='file' id='imagem' name='imagem' accept='image/x-png, image/jpeg'></input></td>
                          </tr>
                          <tr>
                              <td colspan = 2>&nbsp</td>
                          </tr>";    

                }                
				
                if ($tabela == "time" && $descri == "Histórico") {

                    echo "<tr>
                                <td width=120 align='right'>Histórico:</td>
                                <td><textarea name='HISTORICO' cols='80' rows='8'>$value</textarea></td>
                            </tr>"; 
				}
                
                if ($tabela == "noticia" && $descri == "Texto") {

                    echo "<tr>
                                <td width=120 align='right'>Texto:</td>
                                <td><textarea name='TEXTO' cols='80' rows='8'>$value</textarea></td>
                            </tr>"; 

                    echo "<tr>
                              <td width=120 align='right'>Imagem:</td>
                              <td>
                              <br/>
                                <img src='_imagens/_noticias/$indice.jpg'/ width='100%'><br/></td></tr>
                              <tr><td></td>      
                              <td>
                                <input type='file' id='imagem' name='imagem' accept='image/x-png, image/jpeg'></input></td>
                          </tr>
                          <tr>
                              <td colspan = 2>&nbsp</td>
                          </tr>";    

                }    
                
                if (($tabela == 'partida') && ($colnam == 'TIME_MANDANTE' || $colnam == 'TIME_VISITANTE')) {

                    $dsTab = Dataset('time', "CAMPEONATO = " . $_SESSION["campeonato_chave"], 'NOME');
                    $nrTab = mysql_num_rows($dsTab);

                    echo "<td><select id='$colnam' name='$colnam' style=\"width: 200px;\">";
                    echo "<option value='0'>Selecione</option>";	

                    for ($y = 0; $y < $nrTab; $y ++) {
                        $chave = mysql_result($dsTab, $y, "CHAVE");
                        $nome = mysql_result($dsTab, $y, "NOME");

                        if ($chave == $value) {
                            echo "<option value='$chave' selected=\"selected\">$nome</option>";                                
                        }
                        else {
                            echo "<option value='$chave'>$nome</option>";
                        }

                    }

                    echo "</select></td></tr>";
                    $gerado = 1;                        

                }
                    
                if ($tabela == 'partida' && $colnam == 'GRUPO') {

                    $filtroTab = "CAMPEONATO = " . $_SESSION["campeonato_chave"];
                    $dsTab = Dataset('GRUPO', $filtroTab, '');
                    $nrTab = mysql_num_rows($dsTab);

                    echo "<td><select id='$colnam' name='$colnam' style=\"width: 150px;\">";
                    echo "<option value='0'>Selecione</option>";	

                    for ($y = 0; $y < $nrTab; $y ++) {
                        $chave = mysql_result($dsTab, $y, "CHAVE");
                        $descricao = mysql_result($dsTab, $y, "DESCRICAO");
                        $serie = mysql_result($dsTab, $y, "SERIE");


                        if ($chave == $value) {
                            echo "<option value='$chave' selected=\"selected\">$descricao - "; echo EscreveSerie($serie, 1) . " Divisão"; echo "</option>";                        }
                        else {
                            echo "<option value='$chave'>$descricao - "; echo EscreveSerie($serie, 1) . " Divisão"; echo "</option>";
                        }                        
                        
                        

                        
                    }

                    echo "</select></td></tr>";
                    $gerado = 1;                           

                }
                    
                if ($tabela == 'partida' && $colnam == 'CONFRONTO') {

                    $filtroTab = "CAMPEONATO = " . $_SESSION["campeonato_chave"];
                    $dsTab = Dataset('CONFRONTO', $filtroTab, '');
                    $nrTab = mysql_num_rows($dsTab);

                    echo "<td><select id='$colnam' name='$colnam' style=\"width: 150px;\">";
                    echo "<option value='0'>Selecione</option>";	

                    for ($y = 0; $y < $nrTab; $y ++) {
                        $chave = mysql_result($dsTab, $y, "CHAVE");
                        $descricao = mysql_result($dsTab, $y, "DESCRICAO");

                        if ($chave == $value) {
                            echo "<option value='$chave' selected=\"selected\">$descricao</option>";                                
                        }
                        else {
                            echo "<option value='$chave'>$descricao</option>";
                        }

                    }

                    echo "</select></td></tr>";
                    $gerado = 1;                           

                }      
                    
                if ($tabela == 'partida' && $colnam == 'ESTADIO') {

                    $dsTab = Dataset('estadio', '', '');
                    $nrTab = mysql_num_rows($dsTab);

                    echo "<td><select id='$colnam' name='$colnam' style=\"width: 150px;\">";
                    echo "<option value='0'>Selecione</option>";	

                    for ($y = 0; $y < $nrTab; $y ++) {
                        $chave = mysql_result($dsTab, $y, "CHAVE");
                        $descricao = mysql_result($dsTab, $y, "DESCRICAO");

                        if ($chave == $value) {
                            echo "<option value='$chave' selected=\"selected\">$descricao</option>";                                
                        }
                        else {
                            echo "<option value='$chave'>$descricao</option>";
                        }

                    }

                    echo "</select></td></tr>";

                    $gerado = 1;
                }
                
            }
            
            if ($tabela == 'usuario') {
                echo "<tr>
                          <td width=100 align='right'>Nova Senha:</td>
                          <td><input type='password' id='novaSenha' name='novaSenha' size='50' maxlength='50'></td>
                      </tr>
                      <tr>
                          <td width=100 align='right'>Confirmação:</td>
                          <td><input type='password' id='confirmSenha' name='confirmSenha' size='50' maxlength='50'></td>
                      </tr>";
            }
            
            if ($tabela == 'time') {
                echo "<tr>
                          <td width=100 align='right'>Distintivo:</td>
                          <td><input type='file' id='distintivo' name='distintivo' accept='image/x-png, image/jpeg'></input></td>
                      </tr>
                      <tr>
                          <td colspan = 2>&nbsp</td>
                      </tr>";    
                
                // campos para informar jogadores
                for ($x = 0; $x < 10; $x ++) {
                    echo "<tr>
                              <td width=100 align='right'>Jogador:</td>
                              <td><input type='text' id='JOGADOR$x' name='JOGADOR$x' size='50' maxlength='50'/></td>
                          </tr>"; 
                }                  
            }

            

            
            echo "<tr><td class='noborder'></td><td align='right' class='noborder'><input type='submit' value='Gravar'></td></tr>";
            echo "</table>";
            echo "</form>";
		  
        ?>
		
        </div>
    </body>
</html>

