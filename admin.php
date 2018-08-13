<?php

  if (isset($_GET["msg"])) {
    $msg = $_GET["msg"];
  }
  else {
    $msg = 0;
  }
    
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gerenciador de Campeonatos</title>
        <script src="funcoes.js" type="text/javascript"></script>
        <link href="_css/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>

        <div id="login" name="login">
		
	        <h1>Gerenciador de Campeonatos</h1>

            
            <form id="fLogin" name="fLogin" action="login.php" method="post">
                
                <fieldset id="login"><legend>Login</legend>
                    
                    E-Mail:<br/>
                    <input type="text" id="cEmail" name="tEmail" size="50" required="Informe o E-Mail" /><br/>
                    Senha:<br/>
                    <input type="password" id="cSenha" name="tSenha" size="50" required="Informe a Senha" /><br/><br/>
                    <input type="submit" name="tEnviar" value="OK"><br/><br/>
                    
                    <?php
                    
                        if ($msg == 1) {
                            echo "<b>Usuário ou Senha Inválida!</b>";
                        }

                        if ($msg == 2) {
                            echo "<b>Logout efetuado com sucesso!</b>";
                        }
                    
                    ?>
                    
                </fieldset>
                
            </form>
            
            
        </div>



    </body>
</html>
