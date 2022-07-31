<?php

require_once ("../../conn/config.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once ("inc/valida_guest.php");

if($_SESSION["loggedin"] != true): 
    header("location: ./error.php");
endif;


?>

<!DOCTYPE html>
<html>
<head>
	<title>Instafeed on Your Website</title>
	<style type="text/css">
		a img{ 
			width: 25%;
		}
	</style>
</head>
<body>
	<h1 style="text-align: center">Informações sobre a Intranet</h1>
</body>
</html>