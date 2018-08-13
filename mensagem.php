<html>
    <head>
        <title>Gerenciador de Campeonatos</title>
        <link href="_css/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        
        <div>

        <?php

			if (isset($cadastro)) {
				$url = "cadastro.php?tabela=$tabela";
			}
			else {
				$url = "listagem.php?tabela=$tabela";
			}

			echo "<table width='500' border='0' align='center'>";
			echo "<tr><td colspan='2' align='right' valign='center'>";

			echo "<a href=\"principal.php\"><img src=\"_imagens/cancel.jpg\" width=\"16\" height=\"16\" border=\"0\" align='center'></a>";
          
			echo "</td>";
			echo "</tr>";
			echo "<tr><td colspan=2 align='center'><br/><br/><br/><br/><br/><br/><b>Operação realizada com sucesso!<br/><br/></b><br/><br/><br/><br/><br/></td></tr>";
			echo "</table>";

        ?>
        </div>
    </body>
</html>