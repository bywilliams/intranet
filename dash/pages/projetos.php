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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../css/style_local.css">
</head>

<body>
    <div class="container-fluid dashboard-content">
        <h1 style="text-align: center">Projetos</h1>
        <br>
        <div class="px-lg-5">
            <div class="row">
                <?php

                $img_projeto =
                $title = 
                $descricao = 
                $percentual_conclusao = 
                $id_usuario = "";

                $SQL_Projeto = "SELECT * FROM projects WHERE user_id = ".$id;
                $result = $conn->query($SQL_Projeto);
                $t = 0;
                if ($result->num_rows){
                    while ($row = $result->fetch_assoc()){
                        $img_projeto = $row["file_name"];
                        $title = $row["title"];
                        $descricao = $row["description"];
                        $percentual_conclusao = $row["percent_conclusion"];
                        $id_usuario = $row["user_id"];
                    ?>

                <!-- Gallery item -->
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div class=" rounded shadow-sm" style="background-color: #F6F6F6;"><img
                            src="assets/img/portfolio/<?=$img_projeto?>" alt="" class="img-fluid card-img-top">
                        <div class="p-4">
                            <h5> <?=$title;?></h5>
                            <p class="small text-muted mb-0 my-1"><?=$descricao?></p>
                            <p>Conclusão do projeto:</p>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: <?=$percentual_conclusao?>%" aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"><?=$percentual_conclusao?>%</div>
                            </div>
                            <br>
                            <div class="edit_project" align="center">
                                <!-- <button class="btn btn-primary" title="Editar" id="btn_editar<?=$t;?>"
                                onclick="atualizar(<?=$t;?>)"><i class="bi bi-pencil-square icons-menu"
                                    id="btn_editar<?=$t;?>"></i></button> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End -->
                
<?php
                }
            }
?>

            </div>
            <div class="py-5 text-right"><a href="#" class="btn btn-dark px-5 py-3 text-uppercase">Ver mais</a></div>
        </div>
    </div>


</body>

<script>
function atualizar(i) {
    // PEGA O ELEMENTO DO MODAL DE EDICAO
    var modal_edit = document.getElementById("myModal2" + i);


    //PEGA O BOTAO QUE VAI ABRIR O MODAL
    var btn2 = document.getElementById("btn_editar" + i);



    // PEGA O ELEMENTO SPAN QUE FECHA O MODAL
    var span = document.getElementsByClassName("close-2" + i)[0];

    // QUANDO O USER CLICA NO BOTAO ABRE O MODAL
    btn2.onclick = function() {
        modal_edit.style.display = "block";
    }

    //QUANDO O USER CLICA NO X FECHA O MODAL
    span.onclick = function() {
        modal_edit.style.display = "none";
    }

}
</script>

</html>