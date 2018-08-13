<?php
	session_start();
	$usuario_chave = $_SESSION["usuario_chave"];
	$usuario_nome = $_SESSION["usuario_nome"];
	$usuario_email = $_SESSION["usuario_email"];

	if ($usuario_chave == '') {
		header("Location: index.php?msg=1");
	}
?>