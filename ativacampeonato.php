<?php
    include "_data/session.php";
    $_POST["campeonato"];
    $_SESSION["campeonato_chave"] = $_POST["campeonato"];
    header("Location: principal.php");
?>
