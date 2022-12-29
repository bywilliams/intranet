<?php
require_once ("conn/config.php");
require_once ("dash/pages/inc/valida_guest.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}



if ($_SESSION["loggedin"] == false) {
    header("location: index.php");
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
    header("location: index.php");
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
<!doctype html>
<html lang="en">

<head>
    <title>Intranet</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
.collapsible {
 
  
  cursor: pointer;
  padding: 18px;
 width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
}

.content {
  padding: 0 18px;
  display: none;
  overflow: hidden;
  background-color: #003865;
}
    </style>

</head>
<?php require_once ("dash/pages/inc/valida_guest.php")?>
<body>

    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                </button>
            </div>
            <div class="img bg-wrap text-center py-4" style="background-image: url(images/intranet.jpg);">
            <a class="navbar-brand" href="">
              INTRANET
            </a>
                <div class="user-logo">
                    <div class="img" style="background-image: url(dash/images/<?=$img_profile?>);"></div>
                    <p>Bem vindo <?=$nome;?> <br> <span id="DisplayClock" onload="showTime()"></span> 
                        <?=$msg_saudacao;?></p>

                </div>
            </div>
            <ul class="list-unstyled components mb-5">
                <li class="active">
                    <a href="dash/pages/dashboard-main.php" target="myFrame"><span class="fa fa-home mr-3"></span>
                        Home</a>
                </li>
                <li>
                    <a href="dash/pages/noticias.php" target="myFrame" data-toggle="tooltip" data-placement="right" title="Notícias de agora"><span class="fa-solid fa-newspaper mr-3 notif" ><small
                                class="d-flex align-items-center justify-content-center">!</small></span>Noícias</a>
                </li>
                <?php
                    if ($_SESSION["nivel"] == 3) {
                ?>
                <li>
                    <a href="dash/pages/usuarios.php" target="myFrame"><span class="fa-solid fa-users mr-3"></span> Usuários</a>
                </li>
                <?php
                    }
                ?>
                <li>
                    <a href="dash/pages/tarefas.php" data-toggle="tooltip" data-placement="right" title="Você tem 7 tarefas" target="myFrame"><span class="fa-solid fa-list-check mr-3 notif"><small
                                class="d-flex align-items-center justify-content-center">7</small></span>Tarefas</a>
                </li>
                <?php
                    if ($_SESSION["nivel"] == 3) {
                ?>
                <li>
                    <a href="dash/pages/e-mail.php" target="myFrame"><span class="fa-solid fa-envelope mr-3"></span> Enviar e-mail</a>
                </li>
                <?php
                    }
                ?>
                <li>
                    <a href="dash/pages/apostilas.php" target="myFrame"><span class="fa-solid fa-book mr-3"></span> Apostilas</a>
                </li>
                <?php
                    if ($_SESSION["nivel"] == 3) {
                ?>
                <li>
                    <a href="https://bywilliams.github.io/site/" target="myFrame"><span class="fa-solid fa-arrow-pointer mr-3"></span> Website</a>
                </li>
                <?php
                    }
                ?>
                <li>
                    <a href="dash/pages/youtube.php" target="myFrame"><span class="fa-brands fa-youtube mr-3"></span> Youtube</a>
                </li>
                <li>
                    <a type="button" class="collapsible" ><span class="fa-solid fa-blog mr-3"></span> Blog</a>
                    <div class="content">
                        <ul>
                            <li style="list-style-type: none;">
                                <a href="dash/pages/blog/index.php" target="myFrame"><span class="fa-solid fa-arrow-up-right-from-square mr-3"></span>Acessar Blog</a>
                            </li>
                            <li style="list-style-type: none;">
                                <a href="dash/pages/list_posts.php" target="myFrame"><span class="fa-solid fa-list mr-3"></span>Lista de Posts</a>
                            </li>
                            <li style="list-style-type: none;">
                                <a href="dash/pages/post_blog.php" target="myFrame"><span class="fa-solid fa-plus mr-3"></span>Criar Post</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a type="button" class="collapsible"><span class="fa-solid fa-diagram-project mr-3"></span>Projetos</a>
                    <div class="content">
                        <ul>
                            <li style="list-style-type: none;">
                                <a href="dash/pages/projetos.php" target="myFrame"><span class="fa-solid fa-boxes-packing mr-3"></span>Lista de Projetos</a>
                            </li>
                            <li style="list-style-type: none;">
                                <a href="dash/pages/projetos_create.php" target="myFrame"><span class="fa-solid fa-plus mr-3"></span>Adicionar Projeto</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="dash/pages/info.php" target="myFrame"><span class="fa-solid fa-circle-info mr-3"></span> Informações</a>
                </li>
                <li>
                    <a href="?loggout" id="loggout" onclick="sair()"><span class="fa fa-sign-out mr-3"></span> Sair</a>
                </li>
            </ul>

        </nav>

        <!-- Page Content  -->
        <div id="content" class="p-4 pt-5">
            <iframe src="dash/pages/dashboard-main.php" name="myFrame" allow="fullscreen" frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%"></iframe>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="dash/pages/js/showtime.js" type="text/javascript" async></script>
    <script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
            content.style.display = "none";
            } else {
            content.style.display = "block";
            }
        });
    }

    // APARECE DE LOGGOUT SENDO EFETUADO
    function sair() {
        let timerInterval
        Swal.fire({
        title: 'Fechando!',
        timer: 10000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading()
            const b = Swal.getHtmlContainer().querySelector('b')
            timerInterval = setInterval(() => {
            b.textContent = Swal.getTimerLeft()
            }, 10)
        },
        willClose: () => {
            clearInterval(timerInterval)
        }
        }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
        }
        })
        // alert('Saindo aguarde um instante ... ');
    }

    // retornar ao topo da página
    function topo() {
        parent.scroll(0, 0);
    }

    var convidado = document.getElementById('convidado').value;
    if (convidado != "") {
        alert('Saindo');
    }     
    </script>
    <script>
    // Tooltip menu 
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    </script>
</body>

</html>