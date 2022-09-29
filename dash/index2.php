<?php
//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once ("../conn/config.php");
require_once ("pages/inc/valida_guest.php");


if ($_SESSION["loggedin"] == false) {
    header("location: ../index.php");
}

// PEGA O HORÁRIO ATUAL DE ACORDO COM O TIMEZONE DE SP 
$timezone = new DateTimeZone('America/Sao_Paulo');
$agora = new DateTime('now', $timezone);

// USADO PARA SAUDAÇÃO DE ACORDO COM HORARIO DO DIA
$hora_atual = $agora->format('H');
$msg_saudacao = "";

if($hora_atual > 0 && $hora_atual <= 12){
    $msg_saudacao = "Bom dia!";
}else if($hora_atual > 12 && $hora_atual < 18){
    $msg_saudacao = "Boa tarde!";
}else{
    $msg_saudacao = "Boa noite!";
}
// fim bloco de codigo para saudação

$id = $_SESSION["id"];
//echo $id;

$ano = date('Y');
$data = date('D'); // dia escrito ex: segunda
$mes = date('M'); // mes escrito ex: julho
$dia = date('d');
$m = date('m'); 

$h = date('H');
$i = date('i');
$s = date('s');


// FAZ LOGGOUT AO CLICAR EM SAIR DA DASHBOARD
if (isset($_GET["loggout"])) {
    unset($_SESSION["login"]);
    session_destroy();
    header("location: ../index.php");
}

$username = $_SESSION["name"];
$nome = "";

// PEGA A IMAGEM DE PERFIL DO USUARIO 
$SQL_IMG_PROFILE = "SELECT profile_img, nivel_usuario, nome FROM usuarios WHERE username = '".$username."' ";
//echo $SQL_IMG_PROFILE."<br>";
$result = $conn->query($SQL_IMG_PROFILE);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()){
        $img_profile = $row["profile_img"];
        $nome = $row["nome"];
        $nivel_usuario = $row["nivel_usuario"];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once("../helpers/url.php");?>


    <link rel="stylesheet" href="<?=$BASE_URL?>css/bootstrap-icons-1.8.3/bootstrap-icons.css" />

    <link rel="stylesheet" href="<?=$BASE_URL?>css/style_local.css">
    <link rel="stylesheet" href="<?=$BASE_URL?>css/bootstrap.min.css">
    <script src="<?=$BASE_URL?>pages/js/showtime.js" type="text/javascript" async></script>
    
    <link rel="stylesheet" href="css/new_css_dash.css">
    <title>Document</title>
</head>

<style>
    
</style>

<body class="holy-grail">
    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                </button>
            </div>
            <div class="img bg-wrap text-center py-4" style="background-image: url(images/bg_1.jpg);">
                <div class="user-logo">
                    <div class="img" style="background-image: url(images/logo.jpg);"></div>
                    <h3>Catriona Henderson</h3>
                </div>
            </div>
            <ul class="list-unstyled components mb-5">
                <li class="active">
                    <a href="#"><span class="fa fa-home mr-3"></span> Home</a>
                </li>
                <li>
                    <a href="#"><span class="fa fa-download mr-3 notif"><small
                                class="d-flex align-items-center justify-content-center">5</small></span> Download</a>
                </li>
                <li>
                    <a href="#"><span class="fa fa-gift mr-3"></span> Gift Code</a>
                </li>
                <li>
                    <a href="#"><span class="fa fa-trophy mr-3"></span> Top Review</a>
                </li>
                <li>
                    <a href="#"><span class="fa fa-cog mr-3"></span> Settings</a>
                </li>
                <li>
                    <a href="#"><span class="fa fa-support mr-3"></span> Support</a>
                </li>
                <li>
                    <a href="#"><span class="fa fa-sign-out mr-3"></span> Sign Out</a>
                </li>
            </ul>
        </nav>

        <div id="content" class="p-4 p-md-5 pt-5">
            <h2 class="mb-4">Sidebar #09</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                deserunt mollit anim id est laborum.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                deserunt mollit anim id est laborum.</p>
        </div>
    </div>
    <script src="../js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script defer
        src="https://static.cloudflareinsights.com/beacon.min.js/v652eace1692a40cfa3763df669d7439c1639079717194"
        integrity="sha512-Gi7xpJR8tSkrpF7aordPZQlW2DLtzUlZcumS8dMQjwDHEnw9I7ZLyiOj/6tZStRBGtGgN6ceN6cMH8z7etPGlw=="
        data-cf-beacon='{"rayId":"72eff6d8dacfa5f1","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2022.6.0","si":100}'
        crossorigin="anonymous"></script>

</body>

</html>