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


TODO: //google search API 'https://google-search3.p.rapidapi.com/api/v1/search/q=elon+musk'

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once("../helpers/url.php");?>
    
    
    <link rel="stylesheet" href="<?=$BASE_URL?>css/bootstrap-icons-1.8.3/bootstrap-icons.css" />

    <link rel="stylesheet" href="<?=$BASE_URL?>css/style_local.css">
    <link rel="stylesheet" href="<?=$BASE_URL?>css/bootstrap.min.css">
    <script src="<?=$BASE_URL?>pages/js/showtime.js" type="text/javascript" async></script>
   

    <title>Dashboard</title>
</head>

<body>

    <div class="dashboard-main-wrapper">
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top border-bottom border-primary">
                <a class="navbar-brand" href="">INTRANET</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false"
                    aria-label="toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collase navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <form action="<?=$BASE_URL?>pages/pesquisa.php" method="post" target="myFrame">
                        <li class="nav-item">
                            <div class="top-search-bar" id="custom-search">
                                <input type="text" class="form-control" id="search" name="search" placeholder="buscar">
                            </div>
                        </li>
                        </form>
                        <li class="font-weight-light" align="right">
                            <p>Bem vindo <?=$nome;?> <br> <span id="DisplayClock" onload="showTime()"></span> <br>
                             <?=$msg_saudacao;?>
                        </p>
                        
                        </li>
                        
                        <li class="nav-item dropdown nav-user show">
                            <a class="nav-link nav-user-img" id="navbarDropdownMenuLink2" data-toggle="dropdown"
                                aria-expanded="true" aria-haspopup="true" href="">
                                <img src="<?=$BASE_URL?>images/<?=$img_profile;?>" class="user-avatar-md rounded-circle"
                                    alt="">
                            </a>
                            
                            <!-- <div class="dropdown-menu dropdown-menu-right nav-user-dropdown">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">William</h5>
                                    <span class="ml-2">Disponivel</span>
                                </div>
                                <a href="dropdown-item">
                                    <i class="fas fa-user mr-2"></i>
                                    "Conta"
                                </a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-power-off mr-2"></i>Logout</a>

                            </div> -->
                        </li>
                    </ul>
                </div>

            </nav>
        </div>
      
        <div class="nav-left-sidebar sidebar-dark">
            <div class="slimScrollDiv">
                <div class="menu-list">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="d-xl-none d-lg-none" href="">Dashboard</a>
                        <button class="navbar-toggler collapse" type="button" data-toggle="collapse"
                            data-target="#navbarNav" aria-controls="navbarnav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="navbar-collapse collapse" id="navbarnav">
                            <ul class="navbar-nav flex-column">
                                <li class="nav-divider">Menu</li>
                                <li class="nav-item itens-menu">
                                    <a href="<?=$BASE_URL?>pages/dashboard-main.php" target="myFrame" onclick="topo();" class="nav-link active" data-toggle="collapse" data-target="#submenu-1"
                                        aria-expanded="false" aria-controls="submenu-1">
                                        <i class="bi bi-calendar4 icons-menu"></i>
                                        Dashboard
                                        <span class="badge badge-success"></span>
                                    </a>
                                </li>
                                <li class="nav-item itens-menu">
                                    <a href="<?=$BASE_URL?>pages/noticias.php" target="myFrame" onclick="topo();" class="nav-link active" data-toggle="collapse" data-target="#submenu-1"
                                        aria-expanded="false" aria-controls="submenu-1">
                                        <i class="bi bi-newspaper icons-menu"></i>
                                        Notícias
                                        <span class="badge badge-success"></span>
                                    </a>
                                </li>
                                <?php
                                if ($nivel_usuario > 2) {
                                    ?>
                                    <li class="nav-item itens-menu">
                                    <a href="<?=$BASE_URL?>pages/usuarios.php" target="myFrame" onclick="topo();" class="nav-link active" data-toggle="collapse" data-target="#submenu-1"
                                        aria-expanded="false" aria-controls="submenu-1">
                                        <i class="bi bi-person-plus-fill icons-menu"></i>
                                        Usuarios e Permissões
                                        <span class="badge badge-success"></span>
                                    </a>
                                </li>
                                <?php
                                    }
                               ?>
                                <li class="nav-item itens-menu">
                                    <a href="<?=$BASE_URL?>pages/tarefas.php" target="myFrame" onclick="topo();" class="nav-link active" data-toggle="collapse" data-target="#submenu-1"
                                        aria-expanded="false" aria-controls="submenu-1">
                                        <i class="bi bi-list-task icons-menu"></i>
                                        Tarefas
                                        <span class="badge badge-success"></span>
                                    </a>
                                </li>
                                <li class="nav-item itens-menu">
                                    <a href="<?=$BASE_URL?>pages/e-mail.php" target="myFrame" onclick="topo();" class="nav-link active" data-toggle="collapse" data-target="#submenu-1"
                                        aria-expanded="false" aria-controls="submenu-1">
                                        <i class="bi bi-envelope icons-menu"></i>
                                        Enviar Email
                                        <span class="badge badge-success"></span>
                                    </a>
                                </li>
                                <li class="nav-item itens-menu">
                                    <a href="<?=$BASE_URL?>pages/apostilas.php" target="myFrame" onclick="topo();" class="nav-link active" data-toggle="collapse" data-target="#submenu-1"
                                        aria-expanded="false" aria-controls="submenu-1">
                                        <i class="bi bi-journals icons-menu"></i>
                                        Apostilas
                                        <span class="badge badge-success ">Novo</span>
                                    </a>
                                </li>
                                <li class="nav-item itens-menu">
                                    <a href="https://bywilliams.github.io/site/" target="myFrame" onclick="topo();" class="nav-link active" data-toggle="collapse" data-target="#submenu-1"
                                        aria-expanded="false" aria-controls="submenu-1">
                                        <i class="bi bi-mouse icons-menu"></i>
                                        Website
                                        <span class="badge badge-success ">Novo</span>
                                    </a>
                                </li>
                                <li class="nav-item itens-menu">
                                    <a href="https://www.youtube.com/channel/UCYRCkASNSxbKroHvEaSLV6Q" target="myFrame" onclick="topo();" class="nav-link active" data-toggle="collapse" data-target="#submenu-1"
                                        aria-expanded="false" aria-controls="submenu-1">
                                        <i class="bi bi-youtube icons-menu"></i>
                                        Canal Youtube
                                        <span class="badge badge-success "></span>
                                    </a>
                                </li>
                                <li class="nav-item itens-menu">
                                    <a href="<?=$BASE_URL?>codandoofuturo/index.php" target="myFrame" onclick="topo();" class="nav-link active" data-toggle="collapse" data-target="#submenu-1"
                                        aria-expanded="false" aria-controls="submenu-1">
                                        <i class="bi bi-newspaper icons-menu"></i>
                                        Blog
                                        <span class="badge badge-success "></span>
                                    </a>
                                </li>
                                <li class="nav-item itens-menu">
                                    <a href="<?=$BASE_URL?>pages/projetos.php" target="myFrame" onclick="topo();" class="nav-link active" data-toggle="collapse" data-target="#submenu-1"
                                        aria-expanded="false" aria-controls="submenu-1">
                                        <i class="bi bi-kanban icons-menu"></i>
                                        Projetos em Andamento
                                        <span class="badge badge-success "></span>
                                    </a>
                                </li>
                                <li class="nav-item itens-menu">
                                    <a href="<?=$BASE_URL?>pages/info.php" target="myFrame" onclick="topo();" id="loggout" value="sair" class="nav-link active" data-toggle="collapse" data-target="#submenu-1"
                                        aria-expanded="false" aria-controls="submenu-1">
                                        <i class="bi bi-info-square icons-menu"></i>
                                        Informações
                                        <span class="badge badge-success "></span>
                                    </a>
                                </li>
                                <li class="nav-item itens-menu">
                                    <a href="?loggout" id="loggout" value="sair" onclick="sair();"  class="nav-link active" data-toggle="collapse" data-target="#submenu-1"
                                        aria-expanded="false" aria-controls="submenu-1">
                                        <i class="bi bi-box-arrow-left icons-menu"></i>
                                        Sair
                                        <span class="badge badge-success "></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>

        </div>
   

        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce" >
                <div class="container-fluid dashboard-content">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="page-header">
                          
                                <iframe src="<?=$BASE_URL?>pages/dashboard-main.php" name="myFrame" allow="fullscreen" frameborder="0"></iframe>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    
    <script>    
        // APARECE DE LOGGOUT SENDO EFETUADO
        function sair(){
        var logout = document.getElementById('loggout').value;
        alert('Saindo aguarde um instante ... ');
        }

        function topo() {
	      parent.scroll(0,0);
         }

        var convidado = document.getElementById('convidado').value;
        if (convidado != "") {
        alert('Saindo');
        }
    </script>
</body>

</html>