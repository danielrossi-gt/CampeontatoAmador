<?php
    require_once("_data/session.php"); 
    require_once('_conn/conn.php');  
    include("_data/dm.php");
    
    $tabela = $_GET['tabela'];
    
?>

<html>
    <head>
        <title>Gerenciador de Campeonatos</title>
	<meta charset="UTF-8">
        <script src="funcoes.js?v=1" type="text/javascript"></script>      
        
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
        

    </head>
    <body>
	<div>
	<?php



            if (isset($_GET['filtro'])) {
                $filtro = $_GET['filtro'];
            }
            else {
                $filtro = '';
            }

            $SQL = " SELECT COLUMN_NAME, COLUMN_COMMENT, EXTRA, DATA_TYPE,             ".
                   "        CHARACTER_MAXIMUM_LENGTH, NUMERIC_PRECISION, NUMERIC_SCALE ".
                   "   FROM INFORMATION_SCHEMA.COLUMNS                                 ".
                   "  WHERE TABLE_NAME = '$tabela'                                     ".
                   "   AND TABLE_SCHEMA = '$database'                                  ".
                   " ORDER BY ORDINAL_POSITION                                         ";

            $ds = mysql_query($SQL);
            $nr = mysql_num_rows($ds);
            $descCamp = '';
            
            if (($tabela == "confronto") || ($tabela == "time") || ($tabela == "partida") || ($tabela == "grupo") || ($tabela == "historia") || ($tabela == "noticia")) {
              if (isset($_SESSION["campeonato_chave"])) {
                $descCamp = "Campeonato Ativo: " . EscreveCampeonato($_SESSION["campeonato_chave"]);		  
              }
            }            

            echo "<form id='frmCadastro' name='frmCadastro' action='cad$tabela.php' method='post' enctype='multipart/form-data'>";
            echo "<table width='100%' border='0' align='center'>";
            echo "<tr><td colspan='2'><h3>Cadastro de "; EscreveTabela($tabela); echo "</h3></td>";
            echo "<td valign='top'><a href=\"principal.php\"><img src=\"_imagens/cancel.jpg\" width=\"16\" height=\"16\" border=\"0\" align='center' valing='top'></a>";
            echo "<tr><td colspan=2><h3>$descCamp</h3></td><td></td></tr>";
            echo "</td></tr>";

            for ($i = 0; $i < $nr; $i ++) {

                $gerado = 0;

                $colnam = mysql_result($ds, $i, 'COLUMN_NAME');
                $descri = mysql_result($ds, $i, 'COLUMN_COMMENT');
                $fextra = mysql_result($ds, $i, 'EXTRA');
                $dattyp = mysql_result($ds, $i, 'DATA_TYPE');
                $chrmax = mysql_result($ds, $i, 'CHARACTER_MAXIMUM_LENGTH');
                $nummax = mysql_result($ds, $i, 'NUMERIC_PRECISION');
                $numprc = mysql_result($ds, $i, 'NUMERIC_SCALE');
                
                //Se não for campo auto-increment
                if (($fextra == '') and ($descri != 'Campeonato') and ($descri != "Texto") and ($descri != "Histórico") and
                    ($colnam != 'PLACAR_MANDANTE') and ($colnam != 'PLACAR_VISITANTE') and 
                    ($colnam != 'OBSERVACAO') and ($colnam != 'ENCERRADA')) {

                    //Label do campo
                    echo "<tr><td width=120 align='right'>$descri:</td>";

                    //Campos especiais de uma tabela
                    if ($tabela == 'grupo' && $colnam == 'SERIE' && ($gerado == 0)) {
                        $dsTab = Dataset('SERIE', '', '');
                        $nr = mysql_num_rows($dsTab);

                        echo "<td><select id='$colnam' name='$colnam'>";
                        echo "<option value='0'>Selecione</option>";
                        
                        for ($y = 0; $y < $nr; $y ++) {
                            $chave = mysql_result($dsTab, $y, "CHAVE");
                            $descricao = mysql_result($dsTab, $y, "DESCRICAO");

                            echo "<option value='$chave'>$descricao</option>";
                        }
                        
                        echo "</select></td></tr>";
                        $gerado = 1;
                    }    

                    if ($tabela == 'campeonato' && $descri == 'Categoria' && ($gerado == 0)) {
                        
                        $dsTab = Dataset('CATEGORIA', '', '');
                        $nr = mysql_num_rows($ds);

                        echo "<td><select id='$colnam' name='$colnam'>";
                        echo "<option value='0'>Selecione</option>";	
                        
                        for ($y = 0; $y < $nr; $y ++) {
                            $chave = mysql_result($dsTab, $y, "CHAVE");
                            $descricao = mysql_result($dsTab, $y, "DESCRICAO");

                            echo "<option value='$chave'>$descricao</option>";
                        }
                        
                        echo "</select></td></tr>";
                        $gerado = 1;
                    }    
                    
                    if (($tabela == 'partida') && ($colnam == 'TIME_MANDANTE' || $colnam == 'TIME_VISITANTE')) {
             
                        $dsTab = Dataset('TIME', "CAMPEONATO = " . $_SESSION["campeonato_chave"], 'NOME');
                        $nrTab = mysql_num_rows($dsTab);

                        echo "<td><select id='$colnam' name='$colnam' style=\"width: 200px;\">";
                        echo "<option value='0'>Selecione</option>";	
                        
                        for ($y = 0; $y < $nrTab; $y ++) {
                            $chave = mysql_result($dsTab, $y, "CHAVE");
                            $nome = mysql_result($dsTab, $y, "NOME");

                            echo "<option value='$chave'>$nome</option>";
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

                            
                            
                            echo "<option value='$chave'>$descricao - "; echo EscreveSerie($serie, 1) . " Divisão"; echo "</option>";
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

                            echo "<option value='$chave'>$descricao</option>";
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

                            echo "<option value='$chave'>$descricao</option>";
                        }
                        
                        echo "</select></td></tr>";
                        
                        $gerado = 1;
                    }
                    
                    /*if ($tabela == 'partida' && $colnam == 'ENCERRADA') {
                        
                        echo "<td><select id='$colnam' name='$colnam'>";
                        echo "<option value='NAO'>NÃO</option>";	
                        echo "<option value='SIM'>SIM</option>";                        
                        echo "</select></td></tr>";                        
                        
                        $gerado = 1;                            
                    }*/

                    //Campos normais
                    //Campo de Estado
                    if ($descri == 'Estado' && ($gerado == 0)) {
                        echo "<td>
                                <select name='$colnam' id='$colnam' name='$colnam'>
                                   <option>Selecione...</option>
                                   <option value='AC'>AC</option>
                                   <option value='AL'>AL</option>
                                   <option value='AP'>AP</option>
                                   <option value='AM'>AM</option>
                                   <option value='BA'>BA</option>
                                   <option value='CE'>CE</option>
                                   <option value='ES'>ES</option>
                                   <option value='DF'>DF</option>
                                   <option value='MA'>MA</option>
                                   <option value='MT'>MT</option>
                                   <option value='MS'>MS</option>
                                   <option value='MG'>MG</option>
                                   <option value='PA'>PA</option>
                                   <option value='PB'>PB</option>
                                   <option value='PR'>PR</option>
                                   <option value='PE'>PE</option>
                                   <option value='PI'>PI</option>
                                   <option value='RJ'>RJ</option>
                                   <option value='RN'>RN</option>
                                   <option value='RS'>RS</option>
                                   <option value='RO'>RO</option>
                                   <option value='RR'>RR</option>
                                   <option value='SC'>SC</option>
                                   <option value='SP'>SP</option>
                                   <option value='SE'>SE</option>
                                   <option value='TO'>TO</option>
                                </select>
                              </td>
                              </tr>";
                        $gerado = 1;
                    }

                    //Campo Varchar
                    if (($dattyp == 'varchar' || $dattyp == 'date' || $dattyp == 'datetime') && ($gerado == 0)) {

                        $maxsiz = $chrmax;
                        if ($chrmax > 50) { 
                            $maxsiz = 50; 
                        }
                        
                        if ($tabela == 'usuario' && $descri == 'E-mail') {
                            echo "<td><input type='text' id='$colnam' name='$colnam' size='50' maxlength='50' onblur=\"enviaInsere('validausuario.php', 'POST', false);\"></td></tr>";
                        } elseif (($tabela == 'usuario' && $descri == 'Senha')) {
                            echo "<td><input type='password' id='$colnam' name='$colnam' size='$maxsiz' maxlength='$chrmax'></td></tr>";                                                                                    
                        } elseif ($dattyp == 'datetime') {
                            echo "<td><input type='text' id='$colnam' name='$colnam' size='$maxsiz' maxlength='16' OnKeyUp=\"mascara_data_hora(this.value)\"></td></tr>";                                                                                    
                        } else {
                            echo "<td><input type='text' id='$colnam' name='$colnam' size='$maxsiz' maxlength='$chrmax'></td></tr>";                                                        
                        }
                    }

                    //Campo Integer
                    if (($dattyp == 'int') && ($gerado == 0)) {
                        echo "<td><input type='text' id='$colnam' name='$colnam' size='$nummax' maxlength='$nummax'></td></tr>";
                    }
                }
                
                if ($tabela == "historia" && $descri == "Texto") {

                    echo "<tr>
                                <td width=120 align='right'>Texto:</td>
                                <td><textarea name='TEXTO' cols='80' rows='8'></textarea></td>
                            </tr>"; 

                    echo "<tr>
                              <td width=120 align='right'>Imagem:</td>
                              <td><input type='file' id='imagem' name='imagem' accept='image/x-png, image/jpeg'></input></td>
                          </tr>
                          <tr>
                              <td colspan = 2>&nbsp</td>
                          </tr>";    


                }

                if ($tabela == "noticia" && $descri == "Texto") {

                    echo "<tr>
                                <td width=120 align='right'>Texto:</td>
                                <td><textarea name='TEXTO' id='TEXTO' cols='80' rows='8'></textarea></td>
                            </tr>"; 

                    echo "<tr>
                              <td width=120 align='right'>Imagem:</td>
                              <td><input type='file' id='imagem' name='imagem' accept='image/x-png, image/jpeg'></input></td>
                          </tr>
                          <tr>
                              <td colspan = 2>&nbsp</td>
                          </tr>";    

                }
				
            }
            
            if ($tabela == 'time') {

				echo "<tr>
                                <td width=120 align='right'>Histórico:</td>
                                <td><textarea name='HISTORICO' id='HISTORICO' cols='80' rows='8'></textarea></td>
                            </tr>"; 

				echo "<tr>
                          <td width=120 align='right'>Distintivo:</td>
                          <td><input type='file' id='distintivo' name='distintivo' accept='image/x-png, image/jpeg'></input></td>
                      </tr>
                      <tr>
                          <td colspan = 2>&nbsp</td>
                      </tr>";    
                
                // campos para informar jogadores
                for ($x = 0; $x < 30; $x ++) {
                    echo "<tr>
                              <td width=120 align='right'>Jogador:</td>
                              <td><input type='text' id='JOGADOR$x' name='JOGADOR$x' size='50' maxlength='50'/></td>
                          </tr>"; 
                }                
            }

            echo "<tr><td align='right' colspan='2' class='noborder'>
                  <input type='button' value='Gravar' onClick='valida$tabela()'></td></tr>";

            echo "</table>";
            echo "</form>";
				
	?>
	</div>
    </body>
</html>
