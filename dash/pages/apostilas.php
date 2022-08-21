<?php
require_once ("../../conn/config.php");

//Iniciando a sessão:
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if($_SESSION["loggedin"] != true): 
    header("location: ./error.php");
endif;

?>



<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <?php include_once("../../helpers/url.php");?>
    <script src="../../js/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style_local.css">

</head>

<style>
    .list-group-item{
        margin-right: 4px;
    }
</style>

<body>
<div class="container-fluid dashboard-content">
    <h1>Apostilas e PDFs</h1>
    <div class="container d-flex ">

        <ul class="list-group mt-5 text-black" style="flex-direction: row;">
            <li class="list-group-item d-flex" style="width: 100%;">

                <div class="d-flex flex-row">
                <i class="fa-solid fa-folder fa-3x" style=" color: #FFCA28;"></i>
                    <div class="ml-2">
                        <h6 class="mb-0">Curso Git</h6>
                        <div class="about">
                            <span>22 Arquivos</span>
                            <span>Jan 21, 2020</span>
                        </div>
                    </div>
                </div>


            </li>

            <li class="list-group-item d-flex" style="width: 100%;">

                <div class="d-flex flex-row">
                <i class="fa-solid fa-folder fa-3x" style=" color: #FFCA28;"></i>
                    <div class="ml-2">
                        <h6 class="mb-0">Curso Bootstrap</h6>
                        <div class="about">
                            <span>62 Arquivos</span>
                            <span>Jan 22, 2020</span>
                        </div>
                    </div>
                </div>


            </li>

            <li class="list-group-item d-flex" style="width: 100%;">

                <div class="d-flex flex-row">
                <i class="fa-solid fa-folder fa-3x" style=" color: #FFCA28;"></i>
                    <div class="ml-2">
                        <h6 class="mb-0">Curso Linux</h6>
                        <div class="about">
                            <span>2 Arquivos</span>
                            <span>Jan 29, 2020</span>
                        </div>
                    </div>
                </div>


            </li>

            <li class="list-group-item d-flex" style="width: 100%;">

                <div class="d-flex flex-row">
                <i class="fa-solid fa-folder fa-3x" style=" color: #FFCA28;"></i>
                    <div class="ml-2">
                        <h6 class="mb-0">Curso Laravel</h6>
                        <div class="about">
                            <span>12 Arquivos</span>
                            <span>Jan 29, 2020</span>
                        </div>
                    </div>
                </div>


            </li>

            <li class="list-group-item d-flex" style="width: 100%;">

                <div class="d-flex flex-row">
                <i class="fa-solid fa-folder fa-3x" style=" color: #FFCA28;"></i>
                    <div class="ml-2">
                        <h6 class="mb-0">Curso React</h6>
                        <div class="about">
                            <span>2 Arquivos</span>
                            <span>Jan 29, 2020</span>
                        </div>
                    </div>
                </div>


            </li>

        </ul>

    </div>
</div>


</body>

</html>