<?php
    
    require_once('_conn/conn.php');
    include('_data/dm.php');      
    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="estilo.css"/>
<meta name="revisit-after" content="7 days" />  
<meta name="classification" content="business" /> 
<meta name="description" content="Super Amador Limeira" />
<meta name="abstract" content="Super Amador Limeira" />
<meta name="keywords" content="Super Amador Limeira" />
<meta name="Googlebot" content="all">
<meta name="robot" content="index, follow" /> 
<meta name="rating" content="general" /> 
<meta name="distribution" content="global" />
<title>Super Amador Limeira</title>
<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<!-- INICIO FIXA TOPO -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>
function sticky_relocate() {
  var window_top = $(window).scrollTop();
  var div_top = $('#sticky-anchor').offset().top;
  if (window_top > div_top) {
    $('#sticky').addClass('stick');
  } else {
    $('#sticky').removeClass('stick');
  }
}
$(function() {
  $(window).scroll(sticky_relocate);
  sticky_relocate();
});
</script>
<!-- FIM FIXA TOPO -->
</head>
<body>
<div id="full_menu">
  <div id="bg_menu">   
    <div id="logo">
      <a href="index.php" target="_self"><img src="imgs/logo.png" border="0" width="161" height="77" title="Super Amador Limeira" alt="Super Amador Limeira" /></a>
    </div> 
    <div id="prefeitura">
      <a href="http://www.limeira.sp.gov.br" target="_self"><img src="imgs/prefeitura.png" border="0" width="155" height="77" title="Prefeitura de Limeira" alt="Prefeitura de Limeira" /></a>
    </div>        
    <!-- Menu responsive -->
    <div id="select_menu">  
      <select onchange="location=this.options[this.selectedIndex].value;" class="select">
        <option value="" selected="selected">MENU</option>
        <option value="index.php">PÁGINA INICIAL</option>
        <option value="historia.php">HISTÓRIA</option>
        <option value="classificacoes.php">CLASSIFICAÇÕES</option>
        <option value="artilharias.php">ARTILHARIAS</option>
        <option value="noticias.php">NOTÍCIAS</option>
        <option value="contato.php">CONTATO</option>                
      </select>
    </div>        
    <!-- Fecha Menu responsive -->    
    <!-- Menu padrão -->
    <div id="menu">
      <ul>
        <li><a href="index.php" target="_self">PÁGINA INICIAL</a></li>
        <li><a href="historia.php" target="_self">HISTÓRIA</a></li>
        <li><a href="classificacoes.php" target="_self" class="active">CLASSIFICAÇÕES</a></li>
        <li><a href="artilharias.php" target="_self">ARTILHARIAS</a></li>
        <li><a href="noticias.php" target="_self">NOTÍCIAS</a></li>  
        <li><a href="contato.php" target="_self">CONTATO</a></li>        
      </ul>                 
    </div>
    <!-- Fecha Menu padrão -->
  </div>     
</div>
<div id="sticky-anchor"></div>
<div id="sticky">
  <div id="full_topo">
    <div id="bg_topo">    
      SUPER AMADOR LIMEIRA 2015         
    </div>
  </div>
</div>
<div id="full_banner">
  <div id="bg_banner">    
    <div id="banner">
     Banner - 1200 x 100
    </div>    
  </div>
</div>

<div id="full_conteudo">
  <div id="bg_conteudo">
      
<?php

  $ds = mysql_query("SELECT S.CHAVE CHAVE_SERIE, S.DESCRICAO SERIE, G.CHAVE CHAVE_GRUPO, G.DESCRICAO GRUPO
                       FROM grupo G, serie S
                      WHERE G.SERIE = S.CHAVE"); 
  
  $nr = mysql_num_rows($ds);

  for ($i=0;$i<$nr;$i++) {

    $chaveSerie = mysql_result($ds, $i, "CHAVE_SERIE");
    $serie = mysql_result($ds, $i, "SERIE");
    $chaveGrupo = mysql_result($ds, $i, "CHAVE_GRUPO");
    $grupo = mysql_result($ds, $i, "GRUPO");
    
?>      
    <div id="conteudo">
      <div id="topo_conteudo" style="background-color:#00a4e0">
        <?php echo $serie; ?> DIVISÃO GRUPO <?php echo $grupo; ?>
      </div>
      <div id="conteudo_texto">
        <table width="100%" height="40" border="0" style="border-top:1px solid #dadada; border-bottom:2px solid #dadada; font-size:11px;" cellspacing="0" cellpadding="0">
          <tr>
            <td width="300">CLASSIFICAÇÃO</td>
            <td width="60" align="center">P</td>
            <td width="60" align="center">J</td>
            <td width="60" align="center">V</td>
            <td width="60" align="center">E</td>
            <td width="60" align="center">D</td>
            <td width="60" align="center">GP</td>
            <td width="60" align="center">GC</td>
            <td width="60" align="center">SG</td>              
          </tr>
        </table>

<?php
    
    $dsCamp = mysql_query("SELECT MAX(CHAVE) CHAVE FROM campeonato");
    $campeonato = mysql_result($dsCamp, 0, "CHAVE");
    mysql_query("CALL CARREGAR_CLASSIFICACAO($campeonato)");
    
    $dsClass = mysql_query("SELECT * 
                              FROM classificacao C, time T
                             WHERE C.TIME = T.CHAVE
                               AND C.GRUPO = '$grupo' 
                               AND C.SERIE = $chaveSerie 
                             ORDER BY PONTOS DESC, DESEMPATE DESC, VITORIAS DESC, SALDO_GOLS DESC, EMPATES DESC, GOLS_MARCADOS DESC");
    
    $nrClass = mysql_num_rows($dsClass);
    
    for ($c=0;$c<$nrClass;$c++) {
        
        $chaveTime = mysql_result($dsClass, $c, "TIME");
        $time = mysql_result($dsClass, $c, "NOME");
        $pontos = mysql_result($dsClass, $c, "PONTOS");        
        $jogos = mysql_result($dsClass, $c, "JOGOS");        
        $vitorias = mysql_result($dsClass, $c, "VITORIAS");        
        $empates = mysql_result($dsClass, $c, "EMPATES");
        $derrotas = mysql_result($dsClass, $c, "DERROTAS");
        $golsPro = mysql_result($dsClass, $c, "GOLS_MARCADOS");
        $golsSof = mysql_result($dsClass, $c, "GOLS_SOFRIDOS");
        $golsSaldo = mysql_result($dsClass, $c, "SALDO_GOLS");
        
?>
        <table width="100%" border="0" height="60" style="border-bottom:1px solid #CCCCCC; "cellspacing="0" cellpadding="0">
          <tr>
            <td width="60" align="left"><?php echo $c+1; ?></td>
            <td width="240" align="left"><?php echo "<a href='time.php?time=$chaveTime' style='text-decoration: none'>$time</a>"; ?></td>
            <td width="60" align="center" bgcolor="#F2F2F2"><strong><?php echo $pontos; ?></strong></td>
            <td width="60" align="center"><?php echo $jogos; ?></td>
            <td width="60" align="center" bgcolor="#F2F2F2"><?php echo $vitorias; ?></td>
            <td width="60" align="center"><?php echo $empates; ?></td>
            <td width="60" align="center" bgcolor="#F2F2F2"><?php echo $derrotas; ?></td>
            <td width="60" align="center"><?php echo $golsPro; ?></td>
            <td width="60" align="center" bgcolor="#F2F2F2"><?php echo $golsSof; ?></td>
            <td width="60" align="center"><?php echo $golsSaldo; ?></td>               
          </tr>
        </table>


<?php

    }
    if ($i == 0) {

        echo "</div></div>";
        include 'inc_rodada.php';
    
?>


          
           

        <div id="propaganda_lateral">
         <a href="http://www.construja.com.br/" target="_blank"><img src="banner/construja.jpg" border="0" width="178" height="178" alt="Construjá" title="Construjá" /></a>
       </div>
       <div id="propaganda_lateral" style="margin-left:20px;">
         <a href="http://www.garciatp.com.br/" target="_blank"><img src="banner/garcia.jpg" border="0" width="178" height="178" alt="Garcia" title="Garcia" /></a>       
       </div> 
       <div id="propaganda_lateral">
         <a href="http://www.odebrechtambiental.com/" target="_blank"><img src="banner/odebrecht.jpg" border="0" width="178" height="178" alt="Odebrecht" title="Odebrecht" /></a>       
       </div>
       <div id="propaganda_lateral" style="margin-left:20px;">
         <a href="http://www.grupobompastor.com.br/" target="_blank"><img src="banner/bompastor.jpg" border="0" width="178" height="178" alt="Bom Pastor" title="Bom Pastor" /></a>       
       </div> 
      </div>              
    </div>      

<?php

    }
  }   
  
  echo "</div></div></div></div></div>";
?>
  </div> 
</div>

          
<div id="full_rodape">
  <div id="bg_rodape">
    <div id="texto_direitos_reservados">
      <strong>Super Amador Limeira</strong> © 2015 - Todos os direitos reservados.
    </div>  
    <div id="texto_assinatura">
      Desenvolvido por <a href="http://www.nweb.com.br" target="_blank">Nweb</a>
    </div>
  </div>
</div>
</body>
</html>
