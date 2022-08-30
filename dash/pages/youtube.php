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

$id = $_SESSION["id"];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetos</title>
    <?php include_once("../../helpers/url.php");?>
    <script src=" css/sweetalert.min.js"></script>
    <?php include_once("../../helpers/url.php");?>
    <script src="../../js/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style_local.css">
    <link rel="stylesheet" href="../../css/style_local.css">
</head>
<style>
    #youtube{
        width: 100%;
        height: 345px;
        border-radius:15px;
        box-shadow:
       inset 0 -3em 3em rgba(0,0,0,0.1),
             0 0  0 2px rgb(255,255,255),
             0.3em 0.3em 1em rgba(0,0,0,0.3);

    }
</style>
<body>
    <h1 style="text-align: center">Vídeos</h1>
    
        <div class="row">
            <div class="col-md-4">
            <iframe id="youtube" src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>
            </div>               
            
            <!-- End -->
        </div>
    
</body>

<script>

</script>

</html>