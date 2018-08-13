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
    <div id="conteudo">
      <div id="topo_conteudo">
        NOTÍCIAS
      </div>
      <div id="conteudo_texto">
          
<?php

    //Registros por página
    $rp = 5;

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
    
    $ds = mysql_query("SELECT * FROM noticia ORDER BY CHAVE DESC");
    $nr = mysql_num_rows($ds);
    
    //Total de Páginas
    $tp = ceil($nr / $rp);

    $ds = mysql_query("SELECT * FROM noticia ORDER BY CHAVE DESC LIMIT $inicio, $rp");
    $nr = mysql_num_rows($ds);
    
    for ($i=0;$i<$nr;$i++) {
        
        $chave = mysql_result($ds, $i, "CHAVE");
        $titulo = mysql_result($ds, $i, "TITULO");
        $subtitulo = mysql_result($ds, $i, "SUBTITULO");
    

?>
          
        <div id="bg_noticias">
          <div id="destaque_noticia">
              <a href="<?php echo "noticia.php?noticia=$chave"; ?>" target="_self"><img src=<?php echo "_imagens/_noticias/$chave.jpg"; ?> border="0" width="323" height="228" alt="<?php echo $titulo; ?>" title="<?php echo $titulo; ?>" /></a>
          </div>
          <div id="chamada_noticia">
            <a href="<?php echo "noticia.php?noticia=$chave"; ?>" target="_self"><?php echo "$titulo <br/><div id='todas_noticias'>$subtitulo</div>"; ?></a>
          </div>
        </div>
              
<?php

    }
    
?>
          
          
<!--        <div id="todas_noticias"><a href="#" target="_self">1</a>&nbsp;&nbsp;<a href="#" target="_self">2</a>&nbsp;&nbsp;<a href="#" target="_self">3</a>&nbsp;&nbsp;<a href="#" target="_self">>></a></div> -->

<div id="todas_noticias">
    
<?php

    if ($tp > 1) {
        echo "Páginas: ";
        for ($i=1; $i<=$tp; $i++) {
          if ($pagina == $i) {
            echo $pagina . " ";
          }
          else {
            echo " <a href=\"noticias.php?pagina=$i\">$i</a> ";
          }
        }
    }
?>
    
    
</div>
      </div>
    </div>          
      
<?php

        include "inc_rodada.php";
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
