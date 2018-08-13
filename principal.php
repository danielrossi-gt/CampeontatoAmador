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

        
        <div>
        
	<h1>Gerenciador de Campeonatos</h1>        
        
        <?php
            echo "<h3>Bem vindo $usuario_nome</h3>";
        ?>
        
        <a href="logout.php">Efetuar Logout</a><br/>
        
        
            
            <h3>Informações básicas</h3>
            
            <ul>
                <!--
                <li>Série <a href="cadastro.php?tabela=serie">Cadastrar</a> <a href="listagem.php?tabela=serie">Listagem</a></li>
		<li>Categoria <a href="cadastro.php?tabela=categoria">Cadastrar</a> <a href="listagem.php?tabela=categoria">Listagem</a></li>
                <li>Campeonato <a href="cadastro.php?tabela=campeonato">Cadastrar</a> <a href="listagem.php?tabela=campeonato">Listagem</a></li>
                <li>Usuários <a href="cadastro.php?tabela=usuario">Cadastrar</a> <a href="listagem.php?tabela=usuario">Listagem</a></li>
                -->
                
                <table width="400px">
                    <tr><td width="80px">Série</td><td><a href="cadastro.php?tabela=serie">Cadastrar</a></td><td><a href="listagem.php?tabela=serie">Listagem</a></td></tr>
                    <tr><td>Categoria</td><td><a href="cadastro.php?tabela=categoria">Cadastrar</a></td><td><a href="listagem.php?tabela=categoria">Listagem</a></td></tr>
                    <tr><td>Estádio</td><td><a href="cadastro.php?tabela=estadio">Cadastrar</a></td><td><a href="listagem.php?tabela=estadio">Listagem</a></td></tr>
                    <tr><td>Campeonato</td><td><a href="cadastro.php?tabela=campeonato">Cadastrar</a></td><td><a href="listagem.php?tabela=campeonato">Listagem</a></td></tr>
                    <tr><td>Usuários</td><td><a href="cadastro.php?tabela=usuario">Cadastrar</a></td><td><a href="listagem.php?tabela=usuario">Listagem</a></td></tr>
                </table>
            </ul>
            
            <br/>
            <h3>Campeonatos</h3>
            
            <?php
                
                $dsc = Dataset("campeonato", "", "DESCRICAO");
                $nrc = mysql_num_rows($dsc);
           
                echo "<form id='campeonato' name='campeonato' action='ativacampeonato.php' method='POST'>";
                echo "<select id='campeonato' name='campeonato' onchange='ativacampeonato()'>";
                echo "<option value='0'>Selecione um campeonato</option>";
                
                for ($i = 0; $i < $nrc; $i++) {
                    
                    $chave = mysql_result($dsc, $i, "CHAVE");
                    
                    echo "<option value='" . $chave . "'";
                    if ((isset($_SESSION["campeonato_chave"]) && $_SESSION["campeonato_chave"] != 0) && $_SESSION["campeonato_chave"] == $chave) { echo " selected=\"selected\" "; }
                    echo "'>" . mysql_result($dsc, $i, "DESCRICAO") . "</option>";
                    
                }
                
                echo "</select>";
                echo "</form>";
                echo "<br/>";
            
                if (isset($_SESSION["campeonato_chave"]) && $_SESSION["campeonato_chave"] != 0) {
                  
                    ?>
            
                        <ul>

<!--
                            <li>História <a href="cadastro.php?tabela=historia">Cadastrar</a> <a href="listagem.php?tabela=historia">Listagem</a></li>
                            <li>Notícias <a href="cadastro.php?tabela=noticia">Cadastrar</a> <a href="listagem.php?tabela=noticia">Listagem</a></li>
                            <li>Grupos <a href="cadastro.php?tabela=grupo">Cadastrar</a> <a href="listagem.php?tabela=grupo">Listagem</a></li>
                            <li>Confrontos <a href="cadastro.php?tabela=confronto">Cadastrar</a> <a href="listagem.php?tabela=confronto">Listagem</a></li>
                            <li>Times <a href="cadastro.php?tabela=time">Cadastrar</a> <a href="listagem.php?tabela=time">Listagem</a></li> 
                            <li>Partidas <a href="cadastro.php?tabela=partida">Cadastrar</a> <a href="listagem.php?tabela=partida">Listagem</a></li>
                        </ul>
                        <br/>
                        <ul>
                            <li><a href="classificacao.php?campeonato=<?php echo $_SESSION["campeonato_chave"]?>">Classificação</a></li>
                            <li><a href="proximosjogos.php?campeonato=<?php echo $_SESSION["campeonato_chave"]?>">Próximos Jogos</a></li>
                            
                            
                        </ul>
-->                        
                        <table width="400px">
                            <tr><td width="80px">História</td><td><a href="cadastro.php?tabela=historia">Cadastrar</a></td><td><a href="listagem.php?tabela=historia">Listagem</a></td></tr>
                            <tr><td>Notícia</td><td><a href="cadastro.php?tabela=noticia">Cadastrar</a></td><td><a href="listagem.php?tabela=noticia">Listagem</a></td></tr>
                            <tr><td>Grupo</td><td><a href="cadastro.php?tabela=grupo">Cadastrar</a></td><td><a href="listagem.php?tabela=grupo">Listagem</a></td></tr>
                            <tr><td>Rodada</td><td><a href="cadastro.php?tabela=confronto">Cadastrar</a></td><td><a href="listagem.php?tabela=confronto">Listagem</a></td></tr>
                            <tr><td>Time</td><td><a href="cadastro.php?tabela=time">Cadastrar</a></td><td><a href="listagem.php?tabela=time">Listagem</a></td></tr>
                            <tr><td>Partida</td><td><a href="cadastro.php?tabela=partida">Cadastrar</a></td><td><a href="listagem.php?tabela=partida">Listagem</a></td></tr>
                            <tr><td colspan="3"><hr/></td></tr>
                            <tr><td colspan="3"><a href="classificacao.php?campeonato=<?php echo $_SESSION["campeonato_chave"]?>">Classificação</a></td></tr>
                            <tr><td><a href="proximosjogos.php?campeonato=<?php echo $_SESSION["campeonato_chave"]?>">Próximos Jogos</a></td></tr>
                        </table>

                        </ul>                        
            
            
                    <?php
                    
                }
                else {
                    echo "Nenhum campeonato selecionado.";
                }
            
            
            
            
            ?>
            
        </div>
        
    </body>
</html>